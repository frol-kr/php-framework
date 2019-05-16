<?php

declare(strict_types = 1);

namespace FrolKr\PhpFramework\Middleware;

use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ResponseFactory implements MiddlewareInterface
{
    /** @var ResponseFactoryInterface */
    private $httpResponseFactory;

    /**
     * @param ResponseFactoryInterface $httpResponseFactory
     */
    public function __construct(ResponseFactoryInterface $httpResponseFactory)
    {
        $this->httpResponseFactory = $httpResponseFactory;
    }

    /**
     * @inheritdoc
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        return $this->httpResponseFactory->createResponse();
    }
}
