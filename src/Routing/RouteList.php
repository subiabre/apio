<?php declare(strict_types=1);

namespace Apio\Routing;

/**
 * Default implementation for AbstractRouteList
 * @author Subiabre
 */
class RouteList extends AbstractRouteList
{
    public function methodNotAllowed(\Symfony\Component\HttpFoundation\Request $request, array $methods): \Apio\Routing\Response
    {
        $response = new Response();

        $response
            ->error(['message' => 'Route request method not allowed.'])
            ->error(['methods' => $methods]);

        return $response;
    }

    public function routeNotFound(\Symfony\Component\HttpFoundation\Request $request): \Apio\Routing\Response
    {
        $response = new Response();

        $response
            ->error(['message' => 'Route not found.']);

        return $response;
    }

    public function routes(): void
    {}
}
