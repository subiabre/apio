<?php

namespace Apio\Tests\Routing;

use Apio\Routing\AbstractRoutesLoader;
use Apio\Routing\Response;

class RoutesLoaderMock extends AbstractRoutesLoader
{
    public function routes(): void
    {
        $this->get('/test', fn(): Response => new Response);
    }
}
