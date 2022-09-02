<?php

declare(strict_types=1);
/**
 * This file is part of youduim/youdu-sdk-php.
 *
 * @link     https://github.com/youduim/youdu-sdk-php
 * @document https://github.com/youduim/youdu-sdk-php/blob/v2.0.0/README.md
 * @contact  support@xinda.im
 */
namespace YouduPhp\Youdu;

class Config
{
    public function __construct(protected array $config = [])
    {
    }

    public function getApi(): string
    {
        return $this->config['api'] ?? '';
    }

    public function getTimeout(): int|float
    {
        return $this->config['timeout'] ?? 5;
    }

    public function getBuin(): int
    {
        return (int) $this->config['buin'] ?? 0;
    }

    public function getAppId(): string
    {
        return $this->config['app_id'] ?? '';
    }

    public function getAesKey(): string
    {
        return $this->config['aes_key'] ?? '';
    }

    public function getTmpPath(): string
    {
        return $this->config['tmp_path'] ?? '/tmp';
    }
}
