<?php

namespace Apio\Tests\Routing;

use Apio\Routing\AbstractController;

class ControllerMock extends AbstractController
{
    public function routes(): void
    {
        $this->get('/test', function() {
            return $this->serializer;
        });
    }
}
