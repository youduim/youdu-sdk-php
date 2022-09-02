<?php

declare(strict_types=1);
/**
 * This file is part of youduim/youdu-sdk-php.
 *
 * @link     https://github.com/youduim/youdu-sdk-php
 * @document https://github.com/youduim/youdu-sdk-php/blob/v2.0.0/README.md
 * @contact  support@xinda.im
 */
namespace YouduPhp\Youdu\Kernel\Message\Session;

class Text extends AbstractMessage
{
    /**
     * 文本消息.
     *
     * @param string $content 消息内容，支持表情
     */
    public function __construct(protected string $content = '')
    {
    }

    public function toArray(): array
    {
        return [
            'sessionId' => $this->sessionId,
            'receiver' => $this->receiver,
            'sender' => $this->sender,
            'msgType' => 'text',
            'text' => [
                'content' => $this->content,
            ],
        ];
    }
}
