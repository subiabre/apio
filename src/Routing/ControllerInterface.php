<?php

namespace Apio\Routing;

interface ControllerInterface
{
    public function getRouter(): Router;
    public function routes(): void;
}
