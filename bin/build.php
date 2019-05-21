#!/usr/bin/env php
<?php

declare(strict_types = 1);

/** @var \Composer\Autoload\ClassLoader $loader */

use Symfony\Component\Routing\Router;

require __DIR__.'/../vendor/autoload.php';

define('APP_ROOT', dirname(__DIR__));

/** @var Psr\Container\ContainerInterface $container */
$container = \FrolKr\PhpFramework\ContainerFactory::create(APP_ROOT, true);
echo 'Container has been built' . PHP_EOL;
/** @var Router $router */
$router = $container->get(Router::class);
$router->getMatcher()->match('/');
echo 'Router has been built' . PHP_EOL;
