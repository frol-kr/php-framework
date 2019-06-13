<?php

declare(strict_types = 1);

namespace Tests;

use Nyholm\Psr7\Factory\Psr17Factory;
use Nyholm\Psr7Server\ServerRequestCreator;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class AbstractApp extends TestCase
{
    /** @var  ContainerBuilder */
    private $container;

    /**
     * @inheritdoc
     */
    public static function setUpBeforeClass()
    {
        define('APP_ROOT', dirname(__DIR__));
    }

    /**
     * @inheritdoc
     */
    public function setUp()
    {
        parent::setUp();
        $this->container = $this->createContainer();
    }

    /**
     * @return ContainerBuilder
     */
    private function createContainer(): ContainerBuilder
    {
        $fileLocator = new FileLocator([
            implode(DIRECTORY_SEPARATOR, [APP_ROOT, 'etc']),
        ]);
        $container = new ContainerBuilder();
        $loader = new YamlFileLoader($container, $fileLocator);
        $loader->load('services.yml', 'yml');

        $fileLocator = new FileLocator([
            implode(DIRECTORY_SEPARATOR, [APP_ROOT, 'tests', 'App']),
        ]);
        $containerMock = new ContainerBuilder();
        $loader = new YamlFileLoader($containerMock, $fileLocator);
        $loader->load('services.yml', 'yml');
        $container->merge($containerMock);
        return $container;
    }

    /**
     * @return ContainerBuilder
     */
    protected function getContainer(): ContainerBuilder
    {
        return $this->container;
    }

    /**
     * @param string $url
     * @param string $body
     * @param string $method
     * @return RequestInterface
     */
    protected function createRequest(string $url, string $body, string $method): RequestInterface {
        $httpFactory = new Psr17Factory();
        $server = [
            'SERVER_NAME' => 'localhost',
            'SERVER_PORT' => 80,
            'HTTP_HOST' => 'localhost',
            'REMOTE_ADDR' => '127.0.0.1',
            'SCRIPT_FILENAME' => '',
            'SERVER_PROTOCOL' => 'HTTP/1.1',
            'REQUEST_TIME' => time(),
            'PATH_INFO' => '',
            'REQUEST_METHOD' => strtoupper($method),
            'REQUEST_URI' => 'http://localhost' . $url,
        ];

        return (new ServerRequestCreator($httpFactory, $httpFactory, $httpFactory, $httpFactory))->fromArrays(
            $server,
            [
                'CONTENT_TYPE' => 'application/json',
                'ALLOW' => 'application/json'
            ],
            [],
            [],
            [],
            [],
            $body
        );
    }
}