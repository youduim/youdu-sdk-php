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

class Image extends AbstractMessage
{
    /**
     * 图片消息.
     *
     * @param string $mediaId 图片素材文件id。通过上传素材文件接口获取
     */
    public function __construct(protected string $mediaId = '')
    {
    }

    public function toArray(): array
    {
        return [
            'sessionId' => $this->sessionId,
            'receiver' => $this->receiver,
            'sender' => $this->sender,
            'msgType' => 'image',
            'image' => [
                'media_id' => $this->mediaId,
            ],
        ];
    }
}
