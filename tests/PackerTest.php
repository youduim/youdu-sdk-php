<?php

declare(strict_types=1);
/**
 * This file is part of youduim/youdu-sdk-php.
 *
 * @link     https://github.com/youduim/youdu-sdk-php
 * @document https://github.com/youduim/youdu-sdk-php/blob/v2.0.0/README.md
 * @contact  support@xinda.im
 */
use YouduPhp\Youdu\Kernel\Utils\Packer\Packer;

beforeEach(function () {
    $config = makeConfig();
    $this->packer = new Packer($config);
    $this->str = 'hello';
});

it('asserts packer', function () {
    expect($packed = $this->packer->pack($this->str))->toBeString();
    expect($this->packer->unpack($packed))->toBe($this->str);
});
