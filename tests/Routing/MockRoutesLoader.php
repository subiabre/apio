<?php

namespace Apio\Tests\Routing;

use Apio\Routing\RoutesLoader;

class MockRoutesLoader extends RoutesLoader
{
    public function routes(): void
    {
        $this->get('/test', fn() => 'OK');
    }
}
