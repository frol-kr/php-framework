<?php // src/Controller/IndexController.php

declare(strict_type = 1);

namespace FrolKr\PhpFramework\Controller;

use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class IndexController implements RequestHandlerInterface
{
    /**
     * @inheritdoc
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return new Response(200, [], 'Index page<br>', '1.1');
    }
}
