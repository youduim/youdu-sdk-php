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

use JsonSerializable;

interface MessageInterface extends JsonSerializable
{
    public function sender(string $sender): self;

    public function receiver(string $receiver): self;

    public function session(string $sessionId): self;

    public function toArray(): array;

    public function toJson($options = 0): string;
}
