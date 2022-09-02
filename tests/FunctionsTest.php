<?php

declare(strict_types=1);
/**
 * This file is part of youduim/youdu-sdk-php.
 *
 * @link     https://github.com/youduim/youdu-sdk-php
 * @document https://github.com/youduim/youdu-sdk-php/blob/v2.0.0/README.md
 * @contact  support@xinda.im
 */
use function YouduPhp\Youdu\Kernel\Utils\array_get;

it('assert array_get', function () {
    expect(array_get(['a' => 'b'], 'a'))->toBe('b');
    expect(array_get(['a' => ['b' => 'c']], 'a'))->toBe(['b' => 'c']);
    expect(array_get(['a' => ['b' => 'c']], 'a.b'))->toBe('c');
    expect(array_get(['a' => ['b' => 'c']], 'a.c'))->toBe(null);
    expect(array_get(['a' => ['b' => 'c']], 'a.c', 'd'))->toBe('d');
});
