<?php // web/index.php

declare(strict_type = 1);

use Symfony\Component\HttpFoundation\Response;

require __DIR__.'/../vendor/autoload.php';

$request = Symfony\Component\HttpFoundation\Request::createFromGlobals();

if ($request->get('page') === 'foo') {
    $response = new Response('Foo page<br>');
} else {
    $response = new Response('Index page<br>');
}

echo $response->getContent();
