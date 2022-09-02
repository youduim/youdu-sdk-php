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
    $this->media = (new Application($config))->media();
});

it('assert get media info', function () {
    expect($this->media)->toBeInstanceOf(\YouduPhp\Youdu\Kernel\Media\Client::class);
    // $mediaId = '43ceeb1bd9fed1fde4983e5b3fb91aba-4';
});
