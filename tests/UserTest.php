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

beforeEach(function () {
    $config = makeConfig();
    $this->user = (new Application($config))->user();
});

it('assert get user info', function () {
    expect($this->user)->toBeInstanceOf(\YouduPhp\Youdu\Kernel\User\Client::class);
});
