<?
include_once "YdApi.php";
include_once "Sha1.php";
include_once "Const.php";

$packageId = '';
$ydapi = new YdApi(AESKEY, APPID, BUIN);
$sha1 = new SHA1;
$post = json_decode(file_get_contents("php://input"));
$buin = $post->toBuin; 
$appId = $post->toApp; 
$encrypt = $post->encrypt; 

$get = $_GET;

function save($mediaId) {
    $result = '';
    global $ydapi;

    $result = $ydapi->EncryptMsg(time());
    list($errcode, $encrypt) = $ydapi->EncryptMsg($msg);
    if ($errcode == 0) {
        $result = $ydapi->GetToken(API_GET_TOKEN, $encrypt);
        if ($result == 0) {
            $result .= "获取 token 成功\n";
        } else {
            $result .= "获取 token 失败 errcode : $errcode \n";
            return $result;
        }
    }

    
    $msg = json_encode(['mediaId' => $mediaId]);

    list($errcode, $encrypt) = $ydapi->EncryptMsg($msg);
    if ($errcode === 0) {

        /*
            搜索文件
        */
        list($errcode, $rsp) = $ydapi->Send(API_SEARCH_FILE, $encrypt);
        if ($errcode === 0) {
            $result .= "搜索文件成功 文件名: ". $rsp->name ."  文件大小: ". $rsp->size ."B <br/>";
        } else {
            $result .= "搜索文件失败 errcode : $errcode <br/>";
            return $result;
        }
        /*
            保存文件
        */
        $errcode = $ydapi->DownloadFile(API_DOWNLOAD_FILE, $encrypt, SAVEPATH);
        if ($errcode === 0) {
            $result .= "下载图片成功\n";
        } else {
            $result .= "下载图片失败\n";
        }
    }else {
        $result .= "保存文件失败 errcode: $errcode \n";
    }
}


$file = fopen("debug.log", "w") or die("Unable to open file!");
$txt = '';
// 输出 url 参数
$txt .= "GET PARAMS timestamp: " .$get['timestamp']. "; \n";
$txt .= "GET PARAMS nonce: " .$get['nonce']. "; \n";
$txt .= "GET PARAMS msg_signature: " .$get['msg_signature']. "; \n";
// 输出 post 过来的参数
$txt .= "buin: $buin; \n";
$txt .= "appId: $appId; \n";
$txt .= "encrypt: $encrypt; \n";

/*
*   验证调用者的合法性
*   验证消息签名
*/
list($errcode, $sign) = $sha1->getSHA1(ACCESSTOKEN, $get['timestamp'], $get['nonce'], $encrypt);
if ($errcode == 0) {
    $txt .= "sha sign: $sign \n";
    if ($sign == $get['msg_signature']) {
        $txt .= "sha valid success \n";
    } else {
        $txt .= "msg_signature valid failed \n";
    }
} else {
    $txt .= "sha1 failed: $errcode \n";
    exit();
}

/*
*   解密消息，输出消息内容，如果是文件，直接下载文件。
*/
list($errcode, $msg) = $ydapi->DecryptMsg($encrypt);
if ($errcode == 0) {
    $txt .= "DecryptMsg: $msg \n";
    $msg = json_decode($msg);
    $txt .= "msgtype:".$msg->msgType."\n";
    $txt .= "packageId:".$msg->packageId."\n";
    $packageId = $msg->packageId;
    switch ($msg->msgType)
    {
        case 'image':
            $mediaId = $msg->image->media_id;
            $txt .= "图片mediaId: $mediaId \n";
            $txt .= save($mediaId);
        break;  
        case 'file':
            $mediaId = $msg->file->media_id;
            $txt .= "文件mediaId: $mediaId \n";
            $txt .= save($mediaId);
        break;
        default:
        break;
    }
} else {
    $txt .= "解密失败 errcode: $errcode \n";
}

fwrite($file, $txt);
fclose($file);

/*
*   企业应用接收消息后需要将消息包中的 packageId 明文返回，表示成功接收, 否则认为回调失败。
*/
echo $packageId;