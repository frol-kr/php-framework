<?php

declare(strict_types = 1);

namespace Tests\App\MockController;

use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ResponseInterface;

class ExceptionController implements RequestHandlerInterface
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
     * @inheritdoc
     * @throws \Exception
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        throw new \Exception('Unpredicted exception occured');
    }
}
