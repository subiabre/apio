<?php

namespace Apio\Tests\Routing;

use Apio\Routing\RoutesLoader;

class RoutesLoaderMock extends RoutesLoader
{
    public function routes(): void
    {
        $this->get('/test', fn() => 'OK');
    }
}
