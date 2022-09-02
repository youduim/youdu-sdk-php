<?php

declare(strict_types=1);
/**
 * This file is part of youduim/youdu-sdk-php.
 *
 * @link     https://github.com/youduim/youdu-sdk-php
 * @document https://github.com/youduim/youdu-sdk-php/blob/v2.0.0/README.md
 * @contact  support@xinda.im
 */
namespace YouduPhp\Youdu\Kernel\Message\App\Items;

class AbstractItem implements ItemInterface
{
    protected array $items = [];

    /**
     * 转成 array.
     */
    public function toArray(): array
    {
        return $this->items;
    }

    /**
     * 转成 json.
     * @param mixed $options
     */
    public function toJson($options = 0): string
    {
        return json_encode($this->items, $options);
    }
}
