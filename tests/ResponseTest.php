<?php

declare(strict_types=1);
/**
 * This file is part of youduim/youdu-sdk-php.
 *
 * @link     https://github.com/youduim/youdu-sdk-php
 * @document https://github.com/youduim/youdu-sdk-php/blob/v2.0.0/README.md
 * @contact  support@xinda.im
 */
use YouduPhp\Youdu\Kernel\HttpClient\Response;
use YouduPhp\Youdu\Kernel\Utils\Packer\Packer;

beforeEach(function () {
    $config = makeConfig();
    $this->packer = new Packer($config);
});
it('assert response', function () {
    $body = [
        'errcode' => 0,
        'errmsg' => '',
        'encrypt' => $this->packer->pack(json_encode(['foo' => 'bar', 'bar' => ['baz' => 'qux']])),
    ];
    $psrResponse = new \GuzzleHttp\Psr7\Response(200, [], json_encode($body));

    $response = new Response($psrResponse, $this->packer);

    expect($response->json())->toBeArray();
    expect($response->json('foo'))->toBe('bar');
    expect($response->json('bar.baz'))->toBe('qux');
});
