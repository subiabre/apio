<?php

namespace Apio\Tests\Routing;

use Apio\Routing\Controller;

class MockController extends Controller
{
    public function routes(): void
    {
        $this->router->get('/test', fn() => 'OK');
    }
}
