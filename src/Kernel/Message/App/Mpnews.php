<?php

declare(strict_types=1);
/**
 * This file is part of youduim/youdu-sdk-php.
 *
 * @link     https://github.com/youduim/youdu-sdk-php
 * @document https://github.com/youduim/youdu-sdk-php/blob/v2.0.0/README.md
 * @contact  support@xinda.im
 */
namespace YouduPhp\Youdu\Kernel\Message\App;

class Mpnews extends AbstractMessage
{
    /**
     * 图文消息.
     *
     * @param Items\Mpnews $mpnews 消息内容，支持表情，最长不超过600个字符，超出部分将自动截取
     */
    public function __construct(protected Items\Mpnews $mpnews)
    {
    }

    /**
     * 转成 array.
     */
    public function toArray(): array
    {
        return [
            'toUser' => $this->toUser,
            'toDept' => $this->toDept,
            'msgType' => 'mpnews',
            'mpnews' => $this->mpnews->toArray(),
        ];
    }
}
