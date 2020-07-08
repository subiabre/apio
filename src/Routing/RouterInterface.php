<?php

namespace Apio\Routing;

/**
 * Defines the minimum Apio Router must do
 */
interface RouterInterface
{
    public function get(string $uri, callable $fn): self;
    
    public function post(string $uri, callable $fn): self;
    
    public function put(string $uri, callable $fn): self;

    public function delete(string $uri, callable $fn): self;
}
