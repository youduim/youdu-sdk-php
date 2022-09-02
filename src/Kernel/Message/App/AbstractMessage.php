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

use YouduPhp\Youdu\Kernel\Utils\Traits\Conditionable;

use function YouduPhp\Youdu\Kernel\Utils\tap;

abstract class AbstractMessage implements MessageInterface
{
    use Conditionable;

    protected ?string $toUser = null;

    protected ?string $toDept = null;

    /**
     * 发送至用户.
     */
    public function toUser(string $toUser): self
    {
        // 兼容用,隔开
        return tap($this, fn () => $this->toUser = strtr($toUser, ',', '|'));
    }

    /**
     * 发送至部门.
     */
    public function toDept(string $toDept): self
    {
        // 兼容用,隔开
        return tap($this, fn () => $this->toDept = strtr($toDept, ',', '|'));
    }

    /**
     * 转成 json.
     * @param int $options
     * @return false|string
     */
    public function toJson($options = JSON_UNESCAPED_UNICODE)
    {
        return json_encode($this->jsonSerialize(), $options);
    }

    /**
     * json 序列化.
     */
    public function jsonSerialize(): array
    {
        $data = $this->toArray();

        if (is_null($this->toUser)) {
            unset($data['toUser']);
        }

        if (is_null($this->toDept)) {
            unset($data['toDept']);
        }

        return $data;
    }
}
