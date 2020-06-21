<?php

namespace Apio\Tests\Routing;

use Apio\Routing\AbstractRoutesLoader;

class RoutesLoaderMock extends AbstractRoutesLoader
{
    public function routes(): void
    {
        $this->get('/test', fn() => 'OK');
    }
}
