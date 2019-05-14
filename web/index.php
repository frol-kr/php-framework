<?php // web/index.php

declare(strict_type = 1);

use FrolKr\PhpFramework\Controller\FooController;
use FrolKr\PhpFramework\Controller\IndexController;

use Nyholm\Psr7\Factory\Psr17Factory;
use Symfony\Bridge\PsrHttpMessage\Factory\PsrHttpFactory;

require __DIR__.'/../vendor/autoload.php';

$psr17Factory = new Psr17Factory();
$httpFactory = new PsrHttpFactory($psr17Factory, $psr17Factory, $psr17Factory, $psr17Factory);

$symfonyRequest = Symfony\Component\HttpFoundation\Request::createFromGlobals();
$request = $httpFactory->createRequest($symfonyRequest);

if ($symfonyRequest->get('page') === 'foo') {
    $response = (new FooController())->run($request);
} else {
    $response = (new IndexController())->run($request);
}

echo $response->getBody();
