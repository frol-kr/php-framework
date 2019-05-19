<?php

declare(strict_types = 1);

namespace FrolKr\PhpFramework\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Symfony\Bridge\PsrHttpMessage\Factory\HttpFoundationFactory;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Router;

class SymfonyRouting implements MiddlewareInterface
{
    /** @var Router */
    private $routing;

    /**
     * @param Router $routing
     */
    public function __construct(Router $routing)
    {
        $this->routing = $routing;
    }

    /**
     * @inheritdoc
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $response = $handler->handle($request);
        if ($response->getStatusCode() >= 300 && $response->getStatusCode() < 400) {
            return $response;
        }

        $symfonyRequest = (new HttpFoundationFactory())->createRequest($request);
        $this->routing->setContext((new RequestContext())->fromRequest($symfonyRequest));
        $handlerMeta = $this->routing->matchRequest($symfonyRequest);

        /** @var string $controller */
        $controller = $handlerMeta['_controller'];
        /** @var string $controller */
        $action = $handlerMeta['_action'];

        /** @var RequestHandlerInterface $controllerInstance */
        $controllerInstance = new $controller();

        return $controllerInstance->$action($request, $handlerMeta);
    }
}
