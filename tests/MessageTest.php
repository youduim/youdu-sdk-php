<?php

declare(strict_types=1);
/**
 * This file is part of youduim/youdu-sdk-php.
 *
 * @link     https://github.com/youduim/youdu-sdk-php
 * @document https://github.com/youduim/youdu-sdk-php/blob/v2.0.0/README.md
 * @contact  support@xinda.im
 */
use YouduPhp\Youdu\Application;
use YouduPhp\Youdu\Kernel\Message\Client;

beforeEach(function () {
    $this->message = (new Application(makeConfig()))->message();
});

it('asserts message client', function () {
    expect($this->message)->toBeInstanceOf(Client::class);
});
