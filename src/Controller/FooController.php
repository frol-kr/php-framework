<?php

declare(strict_types = 1);

namespace FrolKr\PhpFramework\Controller;

use Nyholm\Psr7\Stream;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;

class FooController implements RequestHandlerInterface
{
    /** @var ResponseFactoryInterface */
    private $responseFactory;

    /**
     * @param ResponseFactoryInterface $responseFactory
     */
    public function __construct(ResponseFactoryInterface $responseFactory)
    {
        $this->responseFactory = $responseFactory;
    }

    /**
     * @param ServerRequestInterface $request
     * @inheritdoc
     */
    public function handle(ServerRequestInterface $request, array $args = []): ResponseInterface
    {
        $response = $this->responseFactory->createResponse(200);
        $response = $response->withBody(Stream::create('Foo page ' . htmlspecialchars($args['name'])));
        return $response;
    }
}
