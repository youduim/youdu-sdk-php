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
    $this->session = (new Application($config))->session();
});

it('assert get session info', function () {
    expect($this->session)->toBeInstanceOf(\YouduPhp\Youdu\Kernel\Session\Client::class);
});
