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

use JsonSerializable;

interface MessageInterface extends JsonSerializable
{
    public function toUser(string $toUser): self;

    public function toDept(string $toDept): self;

    public function toArray(): array;

    public function toJson($options = 0);
}
