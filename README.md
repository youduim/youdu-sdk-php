# youduim/youdu-sdk-php

The php sdk of youdu.

## Installation

```shell
composer require youduim/youdu-sdk-php
```

## Usage

```php
use YouduPhp\Youdu\Application;
use YouduPhp\Youdu\Config;
use YouduPhp\Youdu\Kernel\Message\App\Text;

$config = new Config([
    'api' => 'http://10.0.0.188:7080',
    'buin' => 56565656,
    'app_id' => 'yd06AB76EC519B4130A802224B4C60F689',
    'aes_key' => 'A0aWSqDL5SV4fafQl3OavoVPUn6sx7xNnD+1hOoTeWk=',
]);

$app = new Application($config);
$msg = (new Text('hello world'))->toUser(10001);

$app->message()->send($msg);
```

## Plugins

- [Laravel](https://github.com/youduphp/laravel-youdu)
- [Hyperf](https://github.com/youduphp/hyperf-youdu)
