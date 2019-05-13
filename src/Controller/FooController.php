<?php // src/Controller/FooController.php

declare(strict_type = 1);

namespace FrolKr\PhpFramework\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class FooController
{
    /**
     * @param Request $request
     * @return Response
     */
    public function run(Request $request): Response {
        return new Response('Foo page<br>');
    }
}
