<?php

declare(strict_types = 1);

namespace FrolKr\PhpFramework;

use Nyholm\Psr7\Factory\Psr17Factory;
use Symfony\Bridge\PsrHttpMessage\Factory\HttpFoundationFactory;
use Symfony\Bridge\PsrHttpMessage\Factory\PsrHttpFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Router;

class App
{
    /** @var string */
    private $appRoot;

    /** @var Router */
    private $router;

    /** @var PsrHttpFactory */
    private $psrHttpFactory;

    /**
     * @param string $appRoot
     * @param Router $router
     */
    public function __construct(string $appRoot, Router $router)
    {
        $this->appRoot = $appRoot;
        $this->router = $router;
        $psrFactory = new Psr17Factory();
        $this->psrHttpFactory = new PsrHttpFactory($psrFactory, $psrFactory, $psrFactory, $psrFactory);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function handle(Request $request): Response {
        $this->router->setContext((new RequestContext())->fromRequest($request));

        try {
            $handlerMeta = $this->router->matchRequest($request);

            /** @var string $controller */
            $controller = $handlerMeta['_controller'];
            /** @var string $controller */
            $action = $handlerMeta['_action'];

            $psrResponse = (new $controller)->$action($this->psrHttpFactory->createRequest($request), $handlerMeta);
            $response = (new HttpFoundationFactory)->createResponse($psrResponse);
        } catch (ResourceNotFoundException $e) {
            $response = new Response('Handler not found', Response::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            $response = new Response('Internal server error', Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $response;
    }
}