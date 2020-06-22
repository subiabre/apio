<?php

namespace Apio\Tests\Routing;

use Apio\Routing\AbstractRouteList;
use Apio\Routing\Response;

class RouteListMock extends AbstractRouteList
{
    public function methodNotAllowed(\Symfony\Component\HttpFoundation\Request $request, array $methods): \Apio\Routing\Response
    {
        $response = new Response;

        $response
            ->error(['message' => 'Method not allowed'])
            ->error(['methods' => $methods]);

        return $response;
    }

    public function routeNotFound(\Symfony\Component\HttpFoundation\Request $request): \Apio\Routing\Response
    {
        $response = new Response;

        $response->error(['message' => 'Route not found']);

        return $response;
    }

    public function routes(\Symfony\Component\HttpFoundation\Request $request): void
    {
        $this->addRoute('GET', '/', function(Response $response) use ($request) {
            $response->data(['request' => $request]);

            return $response;
        });

        $this->get('/test', fn() => new Response);
        $this->post('/test', fn() => new Response);
        $this->put('/test', fn() => new Response);
        $this->delete('/test', fn() => new Response);
    }
}
