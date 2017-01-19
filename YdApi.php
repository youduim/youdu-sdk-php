<?php

/**
 * 发送给企业应用的消息加解密、文件上传下载示例代码.
 *
 * @copyright Copyright (c) xinda.im
 */


include_once "Pkcs7Encoder.php";
include_once "ErrorCode.php";
include_once "HttpUtils.php";

/**
 * 1. 第三方回复加密消息给企业应用；
 * 2. 第三方收到企业应用发送的消息，验证消息的安全性，并对消息进行解密。
 * 3. 上传文件
 * 4. 下载文件
 */
class YdApi
{
	private $accessToken;
	private $aeskey;
	private $appId;
	private $buin;
	private $http;

	/**
	 * 构造函数
	 * @param $accessToken string 开发者设置的accessToken
	 * @param $encodingAesKey string 开发者设置的EncodingAESKey
	 * @param $AppId string 企业应用的AppId
	 * @param $Buin int 企业号
	 */
	public function YdApi($aeskey = '', $appId = '', $buin = 0)
	{
		if ($aeskey) {
			$this->aeskey = $aeskey;
		}
		if ($appId) {
			$this->appId = $appId;
		}
		if ($buin) {
			$this->buin = $buin;
		}
		$this->http = new HttpUtils;
	}

	/**
	 * 构造post参数
	 * @param $encrypt string 加密的消息体
	 */
	public function getParam($encrypt = '')
	{
		return ["buin" => $this->buin, "appId" => $this->appId, "encrypt" => $encrypt];
	}

	/**
	 * 构造post 的url
	 * @param $url string 应用API地址
	 */
	public function getTokenUrl($url = '')
	{
		return $url . '?accessToken='. $this->accessToken;
	}

	/**
	 * 获取 accessToken
	 * <ol>
	 *    <li>提交 curl 获取 mediaId</li>
	 * </ol>
	 *
	 * @param $url string 应用API地址
	 * @param $encrypt_msg string 加密消息体
	 *
	 * @return  array
	 * array[0] int 成功0，失败返回对应的错误码
	 */
	public function GetToken($url, $encrypt_msg)
	{
		$param = $this->getParam($encrypt_msg);
		$rsp = $this->http->Post($url, $param);
		$body = json_decode($rsp['body'], true);
		if ($body['errcode'] == 0) {
			list($errcode, $tk) = $this->DecryptMsg($body['encrypt']);
			if ($errcode !== 0) {
				return [ErrorCode::$DecryptAESError, ''];
			}
			$m = json_decode($tk);
			$this->accessToken = $m->accessToken;
			return [ErrorCode::$OK, $m->accessToken];
		}
		return [$body->errcode, $body->errmsg];
	}

	/**
	 * 发送信息
	 * <ol>
	 *    <li>提交 curl 获取 对应接口返回结果</li>
	 * </ol>
	 *
	 * @param $url string 应用API地址
	 * @param $encrypt string 加密消息体
	 * @param $encrypt_file string 加密的文件内容
	 *
	 * @return  array
	 * array[0] int 返回后台返回的错误码
	 * array[1] string 返回后台返回的错误信息
	 * array[2] object 搜索文件时，额外返回的文件信息
	 */
	public function Send($url, $param)
	{
		list($errcode, $encrypt) = $this->EncryptMsg($param);
		if ($errcode !== 0) {
			return ["errcode"=>$errcode, "errmsg"=>"加密失败"];
		}
		$p = $this->getParam($encrypt);
		$u = $this->getTokenUrl($url);
		$rsp = $this->http->Post($u, $p);
		if ($rsp['httpCode'] == 200) {
			$body = json_decode($rsp['body'], true);
			if ($url == API_SEARCH_FILE && $body['errcode'] === 0) {
				list($errcode, $m) = $this->DecryptMsg($body['encrypt']);
				if ($errcode !== 0){
					$body['decrypt'] = -1;
				} else{
					$body['decrypt'] = json_decode($m);
				}
			}
			return $body;
		} else {
			return ["errcode"=>ErrorCode::$IllegalHttpReq, "errmsg"=>"http request code ".$rsp['httpCode']];
		}
	}

	/**
	 * 上传文件，并且得到 mediaId
	 * <ol>
	 *    <li>提交 curl 获取 mediaId</li>
	 * </ol>
	 *
	 * @param $url string 下载文件API
	 * @param $encrypt string 加密的文件信息
	 * @param $encrypt_file string 加密的文件内容
	 *
	 * @return  array
	 * array[0] int 成功0，失败返回对应的错误码
	 * array[1] string 成功返回 mediaId，失败返回空字符串
	 */
	public function UploadFile($url, $encrypt, $encrypt_file)
	{
		$t = time();
		$u = $this->getTokenUrl($url);
		//保存临时文件
		$myfile = fopen($t, "w");
		fwrite($myfile, $encrypt_file);
		fclose($myfile);
		
		$param = ["file" => '@' . realpath($t) , "encrypt" => $encrypt, "buin" => $this->buin, "appId" => $this->appId];
		$rsp = $this->http->Upload($u, $param);
		//删除临时文件
		unlink($t);
		if ($rsp->errcode == 0) {
			list($errcode, $m) = $this->DecryptMsg($rsp->encrypt);
			if ($errcode != 0){
				return [$errcode, ''];
			}
			return [ErrorCode::$OK, json_decode($m)->mediaId] ;
		}
		return [$rsp->errcode, ''] ;
	}

	/**
	 * 下载文件，并保存到设定路径
	 * <ol>
	 *    <li>提交 curl 获取文件内容</li>
	 * </ol>
	 *
	 * @param $url string 下载文件API
	 * @param $encrypt string 加密的mediaId
	 * @param $savepath string 保存路径
	 *
	 * @return  int 成功0，失败返回对应的错误码
	 */
	public function DownloadFile($url, $encrypt, $savepath)
	{
		$param = $this->getParam($encrypt);
		$u = $this->getTokenUrl($url);
		$rsp = $this->http->Post($u, $param);

		$header = $this->decodeHeader($rsp['header']);
		list($rs, $fileInfo) = $this->DecryptMsg($header['Encrypt']);
		if($rs != 0) {
			// echo '[YdApi] - [DownloadFile] - 解析fileinfo失败 <br>';
		}
		$fileInfo = json_decode($fileInfo);
		list($errcode, $fileContent) = $this->DecryptMsg($rsp['body']);
		if ($errcode !== 0){
			return $errcode;
		}
		$this->SaveFile($fileContent, $savepath, $fileInfo->name);
		return $rsp->errcode == 0 ? ErrorCode::$OK : $rsp->errcode;
	}

	/**
	 * 解析 curl response 的 header 信息，解析成数组
	 * <ol>
	 *    <li>对header进行解析</li>
	 * </ol>
	 *
	 * @param $header string header信息
	 *
	 * @return array 
	 */
	public function decodeHeader($header)
	{
		$result = [];
		$hs = explode("\n", $header);
		for($i = 0; $i < count($hs); $i++){
			$t = explode(":", $hs[$i]);
			if($t[0] != '' && $t[1] != ''){
				$result[$t[0]] = $t[1];
			}
		}
		return $result;
	}
	
	/**
	 * 将 CURL RESPONSE 得到的文件内容保存成文件
	 * <ol>
	 *    <li>保存文件</li>
	 * </ol>
	 *
	 * @param $fileContent string 内容主体
	 * @param $filePath string 文件保存路径
	 * @param $fileName string 文件名称
	 *
	 */
	public function SaveFile($fileContent, $filePath, $fileName)
	{
		$file = fopen(iconv("UTF-8", "GBK", $filePath.$fileName), "w") or die("Unable to open file!");
		fwrite($file, $fileContent);
		fclose($file);
	}


	
	/**
	 * 将企业应用回复用户的消息加密打包.
	 * <ol>
	 *    <li>对要发送的消息进行AES-CBC加密</li>
	 * </ol>
	 *
	 * @param $msg string 企业应用待回复用户的消息
	 *
	 * @return array 
	 * array[0] int 成功0，失败返回对应的错误码
	 * array[1] string 成功返回明文，失败返回空字符串
	 */
	public function EncryptMsg($msg)
	{
		$pc = new Prpcrypt($this->aeskey);
		$result = $pc->encrypt($msg, $this->appId);
		if ($result[0] != 0) {
			return array($result[0], $result[1]);
		}
		return array(ErrorCode::$OK, $result[1]);
	}


	/**
	 * <ol>
	 *    <li>对消息进行解密</li>
	 * </ol>
	 *
	 * @param $encrypt 密文
	 *
	 * @return array 
	 * array[0] int 成功0，失败返回对应的错误码
	 * array[1] string 成功返回明文，失败返回空字符串
	 */
	public function DecryptMsg($encrypt)
	{
		if (strlen($this->aeskey) != 44) {
			return ErrorCode::$IllegalAesKey;
		}

		$pc = new Prpcrypt($this->aeskey);
		$result = $pc->decrypt($encrypt, $this->appId);
		if ($result[0] != 0) {
			return array($result[0], '');
		}

		return array(ErrorCode::$OK, $result[1]);
	}

}
