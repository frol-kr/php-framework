<?php // web/index.php

declare(strict_type = 1);

use FrolKr\PhpFramework\Controller\FooController;
use FrolKr\PhpFramework\Controller\IndexController;

require __DIR__.'/../vendor/autoload.php';

$request = Symfony\Component\HttpFoundation\Request::createFromGlobals();

if ($request->get('page') === 'foo') {
    $response = (new FooController())->run($request);
} else {
    $response = (new IndexController())->run($request);
}

echo $response->getContent();
