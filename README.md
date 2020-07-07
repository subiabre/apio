# Apio
Minimalist, component-based, extendable library to write better PHP-built web APIs.

Apio is built on top of existing and well-known, tested and trusted solutions of the PHP open source community, and designed to provide a quick and unopinionated workflow based on the [12 factor app](https://www.12factor.net/) methodology.

## Hello world
```php
# index.php
<?php

use Apio\Http\Server;
use Apio\Http\Response;
use Apio\Http\Request;
use Apio\Routing\Router;

include 'vendor/autoload.php';

$server = new Server;
$router = new Router;

$router->get('/', function(Request $request, Response $response) {
    $response->data(['hello world']);

    return $response;
});

$server->listen(3000, $router);

```

## Why
Apio exists because Symfony and Laravel are great tools, but most times they are overkill and just have a large learning and working curve to develop the lightest of the applications.
