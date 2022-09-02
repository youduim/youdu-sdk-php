<?php

declare(strict_types=1);
/**
 * This file is part of youduim/youdu-sdk-php.
 *
 * @link     https://github.com/youduim/youdu-sdk-php
 * @document https://github.com/youduim/youdu-sdk-php/blob/v2.0.0/README.md
 * @contact  support@xinda.im
 */
namespace YouduPhp\Youdu\Kernel\Utils\Encipher;

use Throwable;
use YouduPhp\Youdu\Kernel\Exception\ErrorCode;

class SHA1
{
    /**
     * 用SHA1算法生成安全签名.
     * @param string $token 票据
     * @param string $timestamp 时间戳
     * @param string $nonce 随机字符串
     * @param string $encrypt 密文消息
     * @param mixed $encryptMsg
     */
    public function getSHA1($token, $timestamp, $nonce, $encryptMsg)
    {
        // 排序
        try {
            $array = [$encryptMsg, $token, $timestamp, $nonce];
            sort($array, SORT_STRING);
            $str = implode($array);

            return [ErrorCode::$OK, sha1($str)];
        } catch (Throwable $e) {
            return [ErrorCode::$ComputeSignatureError, $e->getMessage()];
        }
    }
}
