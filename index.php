<?php

use Apio\Routing\Response;
use Apio\Routing\Router;
use Apio\Tests\Routing\RouteListMock;
use Symfony\Component\HttpFoundation\Request;

include 'vendor/autoload.php';

$router = new Router();

$router->post('/Later', function(Request $request) {
    $response = new Response;

    $response
        ->data(['request' => $request])
        ->send();

    return $response;
});

$router->use(new RouteListMock);

$router->listen()->send();
