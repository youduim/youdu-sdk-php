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
    $this->group = (new Application($config))->group();
});

it('assert get group info', function () {
    expect($this->group)->toBeInstanceOf(\YouduPhp\Youdu\Kernel\Group\Client::class);
});
