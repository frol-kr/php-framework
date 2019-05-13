<?php // src/Controller/IndexController.php

declare(strict_type = 1);

namespace FrolKr\PhpFramework\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class IndexController
{
    /**
     * @param Request $request
     * @return Response
     */
    public function run(Request $request): Response {
        return new Response('Index page<br>');
    }
}
