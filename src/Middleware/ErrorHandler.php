<?php

declare(strict_type = 1);

namespace FrolKr\PhpFramework\Middleware;

use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

class ErrorHandler implements MiddlewareInterface
{
    /**
     * @inheritdoc
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            $response = $handler->handle($request);
        } catch (ResourceNotFoundException $e) {
            $response = new Response(404, [], 'Handler not found', '1.1');
        } catch (\Exception $e) {
            $response = new Response(500, [], 'Internal server error', '1.1');
        }

        return $response;
    }
}
