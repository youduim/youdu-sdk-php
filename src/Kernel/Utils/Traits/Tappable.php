<?php

declare(strict_types=1);
/**
 * This file is part of youduim/youdu-sdk-php.
 *
 * @link     https://github.com/youduim/youdu-sdk-php
 * @document https://github.com/youduim/youdu-sdk-php/blob/v2.0.0/README.md
 * @contact  support@xinda.im
 */
namespace YouduPhp\Youdu\Kernel\Utils\Traits;

use YouduPhp\Youdu\Kernel\Utils\HigherOrderTapProxy;

use function YouduPhp\Youdu\Kernel\Utils\tap;

trait Tappable
{
    /**
     * Call the given Closure with this instance then return the instance.
     *
     * @param null|callable $callback
     * @return $this|HigherOrderTapProxy
     */
    public function tap($callback = null)
    {
        return tap($this, $callback);
    }
}
