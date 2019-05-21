<?php // web/index.php

declare(strict_types = 1);

use FrolKr\PhpFramework\App;

use Nyholm\Psr7Server\ServerRequestCreatorInterface;
use Symfony\Bridge\PsrHttpMessage\Factory\HttpFoundationFactory;

require __DIR__.'/../vendor/autoload.php';

define('APP_ROOT', dirname(__DIR__));

$isDebug = getenv('DEBUG') === 'true' ? true : false;

$container = \FrolKr\PhpFramework\ContainerFactory::create(APP_ROOT, $isDebug);

/** @var ServerRequestCreatorInterface $httpRequestFactory */
$httpRequestFactory = $container->get(ServerRequestCreatorInterface::class);
$response = (new App($container, $isDebug))->handle($httpRequestFactory->fromGlobals());

$container->get(HttpFoundationFactory::class)
    ->createResponse($response)
    ->send();
