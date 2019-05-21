<?php

declare(strict_types = 1);

namespace FrolKr\PhpFramework\Middleware;

use FrolKr\PhpFramework\Controller\NotFoundController;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Symfony\Bridge\PsrHttpMessage\Factory\HttpFoundationFactory;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Router;

class SymfonyRouting implements MiddlewareInterface
{
    /** @var Router */
    private $routing;

    /** @var ContainerInterface */
    private $container;

    /**
     * @param Router $routing
     * @param ContainerInterface $container
     */
    public function __construct(Router $routing, ContainerInterface $container)
    {
        $this->routing = $routing;
        $this->container = $container;
    }

    /**
     * @inheritdoc
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $symfonyRequest = (new HttpFoundationFactory())->createRequest($request);
        $this->routing->setContext((new RequestContext())->fromRequest($symfonyRequest));

        try {
            $handlerMeta = $this->routing->matchRequest($symfonyRequest);
        } catch (ResourceNotFoundException $e) {
            /** @uses NotFoundController::handle() */
            $handlerMeta = ['_controller' => NotFoundController::class, '_action' => 'handle'];
        }

        /** @var string $controller */
        $controller = $handlerMeta['_controller'];
        /** @var string $controller */
        $action = $handlerMeta['_action'];

        /** @var RequestHandlerInterface $controllerInstance */
        $controllerInstance = $this->container->get($controller);

        return $controllerInstance->$action($request, $handlerMeta);
    }
}
