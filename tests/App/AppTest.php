<?php

declare(strict_types = 1);

namespace Tests\App;

use FrolKr\PhpFramework\App;

class AppTest extends \Tests\AbstractApp
{
    /**
     * @param string $url
     * @param string $body
     * @param string $method
     * @param int $expectedCode
     * @param string $expectedContent
     *
     * @dataProvider dataForTestApp
     */
    public function testApp(string $url, string $body, string $method, int $expectedCode, string $expectedContent)
    {

        $app = new App($this->getContainer(), true);
        $this->getContainer()->compile();
        $response = $app->handle($this->createRequest($url, $body, $method));

        $this->assertEquals($expectedCode, $response->getStatusCode());
        $this->assertEquals($expectedContent, (string) $response->getBody());
    }

    /**
     * @return array
     */
    public function dataForTestApp(): array
    {
       return [
            ['/', '', 'GET', 200, 'Test index page'],
            ['/not/existing/route', '', 'GET', 404, 'Handler not found'],
            ['/exception/route', '', 'GET', 500, 'Internal server error'],
       ];
    }
}
