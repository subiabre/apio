# Apio
Minimalist, component-based, extendable library to write better PHP-built web APIs.

Apio is built on top of existing and well-known, tested and trusted solutions of the PHP open source community, and designed to provide a quick and unopinionated workflow.

## Hello world
```php
# index.php
<?php

use Apio\Routing\Router;
use Apio\Routing\Response;
use Symfony\Component\HttpFoundation\Request;

include 'vendor/autoload.php';

$router = new Router;

$router->get('/', function(Request $request, Response $response) {
    $response->data(['hello world']);

    return $response;
});

$response = $router->dispatch();
$response->send();

```

## Why
Apio exists because Symfony and Laravel are great tools, but most times they are overkill and just have a large learning and working curve to develop the lightest of the applications.
