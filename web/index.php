<?php // web/index.php

declare(strict_type = 1);

use FrolKr\PhpFramework\App;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\Routing\Loader\YamlFileLoader;
use Symfony\Component\Routing\Router;

require __DIR__.'/../vendor/autoload.php';

$appRoot = dirname(__DIR__);

$router = new Router(
    new YamlFileLoader(new FileLocator([$appRoot . '/etc'])),
    'routes.yml',
    ['cache_dir' => $appRoot . '/var/cache']
);

$request = Symfony\Component\HttpFoundation\Request::createFromGlobals();
$response = (new App($appRoot, $router))->handle($request);
$response->send();
