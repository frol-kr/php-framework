<?php // src/Controller/IndexController.php

declare(strict_type = 1);

namespace FrolKr\PhpFramework\Controller;

use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class IndexController
{
    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function run(ServerRequestInterface $request): ResponseInterface {
        return new Response(200, [], 'Index page<br>', '1.1');
    }
}
