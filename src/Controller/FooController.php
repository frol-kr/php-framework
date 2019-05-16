<?php // src/Controller/FooController.php

declare(strict_types = 1);

namespace FrolKr\PhpFramework\Controller;

use Nyholm\Psr7\Response;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;

class FooController implements RequestHandlerInterface
{
    /**
     * @param ServerRequestInterface $request
     * @inheritdoc
     */
    public function handle(ServerRequestInterface $request, array $args = []): ResponseInterface
    {
        return new Response(200, [], 'Foo page ' . htmlspecialchars($args['name']), '1.1');
    }
}
