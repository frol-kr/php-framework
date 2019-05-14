<?php // src/Controller/FooController.php

declare(strict_type = 1);

namespace FrolKr\PhpFramework\Controller;

use Nyholm\Psr7\Response;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

class FooController
{
    /**
     * @param ServerRequestInterface $request
     * @param array $args
     * @return ResponseInterface
     */
    public function run(ServerRequestInterface $request, array $args): ResponseInterface {
        return new Response(200, [], 'Foo page ' . htmlspecialchars($args['name']), '1.1');
    }
}
