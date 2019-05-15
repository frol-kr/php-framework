<?php

declare(strict_types = 1);

namespace FrolKr\PhpFramework;

use FrolKr\PhpFramework\Middleware\ErrorHandler;
use FrolKr\PhpFramework\Middleware\ResponseFactory;
use FrolKr\PhpFramework\Middleware\SymfonyRouting;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Relay\RelayBuilder;
use Symfony\Component\Routing\Router;

class App implements RequestHandlerInterface
{
    /** @var Router */
    private $router;

    /** @var RelayBuilder  */
    private $relayBuilder;

    /** @var ResponseFactoryInterface */
    private $httpResponseFactory;

    /**
     * @param Router $router
     * @param RelayBuilder $relayBuilder
     * @param ResponseFactoryInterface $httpResponseFactory
     */
    public function __construct(
        Router $router,
        RelayBuilder $relayBuilder,
        ResponseFactoryInterface $httpResponseFactory
    ) {
        $this->router = $router;
        $this->relayBuilder = $relayBuilder;
        $this->httpResponseFactory = $httpResponseFactory;
    }

    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function handle(ServerRequestInterface $request): ResponseInterface {
        $relay = $this->relayBuilder->newInstance([
            new ErrorHandler(),
            new SymfonyRouting($this->router),
            new ResponseFactory($this->httpResponseFactory)
        ]);
        return $relay->handle($request);
    }
}
