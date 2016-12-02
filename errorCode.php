<?php

/**
 * error code 说明.
 * <ul>
 *    <li>-40001: 签名验证错误</li>
 *    <li>-40002: sha加密生成签名失败</li>
 *    <li>-40003: encodingAesKey 非法</li>
 *    <li>-40004: appId 校验错误</li>
 *    <li>-40005: aes 加密失败</li>
 *    <li>-40006: aes 解密失败</li>
 *    <li>-40007: 解密后得到的buffer非法</li>
 * </ul>
 */
class ErrorCode
{
	public static $OK = 0;
	public static $ValidateSignatureError = -40001;
	public static $ComputeSignatureError = -40002;
	public static $IllegalAesKey = -40003;
	public static $ValidateAppIdError = -40004;
	public static $EncryptAESError = -40005;
	public static $DecryptAESError = -40006;
	public static $IllegalBuffer = -40007;
}

?>