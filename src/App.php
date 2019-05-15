<?php

declare(strict_types = 1);

namespace FrolKr\PhpFramework;

use FrolKr\PhpFramework\Middleware\ErrorHandler;
use FrolKr\PhpFramework\Middleware\SymfonyRouting;
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

    /**
     * @param Router $router
     * @param $relayBuilder
     */
    public function __construct(Router $router, RelayBuilder $relayBuilder)
    {
        $this->router = $router;
        $this->relayBuilder = $relayBuilder;
    }

    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function handle(ServerRequestInterface $request): ResponseInterface {
        $relay = $this->relayBuilder->newInstance([
            new ErrorHandler(),
            new SymfonyRouting($this->router)
        ]);
        return $relay->handle($request);
    }
}
