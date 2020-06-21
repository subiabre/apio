<?php

namespace Apio\Tests\Routing;

use Apio\Routing\RoutesLoader;

class MockRoutesLoader extends RoutesLoader
{
    public function routes(): void
    {
        $this->router->get('/test', fn() => 'OK');
    }
}
