<?php

declare(strict_types = 1);

namespace FrolKr\PhpFramework;

use FrolKr\PhpFramework\Middleware\ErrorHandler;
use FrolKr\PhpFramework\Middleware\ResponseFactory;
use FrolKr\PhpFramework\Middleware\SymfonyRouting;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Relay\RelayBuilder;

class App implements RequestHandlerInterface
{
    /** @var ContainerInterface */
    private $container;

    /** @var bool */
    private $isDebug;

    /**
     * @param ContainerInterface $container
     * @param bool $isDebug
     */
    public function __construct(ContainerInterface $container, bool $isDebug) {
        $this->container = $container;
        $this->isDebug = $isDebug;
    }

    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function handle(ServerRequestInterface $request): ResponseInterface {
        $dispatcher = (new RelayBuilder())->newInstance(
            [
                $this->container->get(ErrorHandler::class),
                $this->container->get(SymfonyRouting::class),
                $this->container->get(ResponseFactory::class),
            ]
        );
        return $dispatcher->handle($request);
    }
}
