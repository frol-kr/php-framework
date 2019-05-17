<?php // web/index.php

declare(strict_types = 1);

use FrolKr\PhpFramework\App;

use Nyholm\Psr7\Factory\Psr17Factory;
use Nyholm\Psr7Server\ServerRequestCreator;
use Symfony\Bridge\PsrHttpMessage\Factory\HttpFoundationFactory;
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

$psrHttpFactory = new Psr17Factory();
$request = (new ServerRequestCreator(
    $psrHttpFactory,
    $psrHttpFactory,
    $psrHttpFactory,
    $psrHttpFactory
))->fromGlobals();

$app = (new App($router, new Relay\RelayBuilder(), $psrHttpFactory));

$response = $app->handle($request);

(new HttpFoundationFactory)
    ->createResponse($response)
    ->send();
