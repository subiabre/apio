<?php

namespace Apio\Routing;

/**
 * Default implementation for AbstractRouteList
 * @author Subiabre
 */
class RouteList extends AbstractRouteList
{
    /**
     * @codeCoverageIgnore
     */
    public function methodNotAllowed(\Symfony\Component\HttpFoundation\Request $request, array $methods): \Apio\Routing\Response
    {
        $response = new Response();

        $response
            ->error(['message' => 'Route request method not allowed.'])
            ->error(['methods' => $methods])
            ->send();

        return $response;
    }

    /**
     * @codeCoverageIgnore
     */
    public function routeNotFound(\Symfony\Component\HttpFoundation\Request $request): \Apio\Routing\Response
    {
        $response = new Response();

        $response
            ->error(['message' => 'Route not found.'])
            ->send();

        return $response;
    }

    public function routes(): void
    {}
}
