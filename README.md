# Apio
Minimalist, component-based, extendable library to write better PHP-built web APIs.

Apio is built on top of existing and well-known, tested and trusted solutions of the PHP open source community, and designed to provide a quick and unopinionated workflow compliant with the [12 factor app](https://www.12factor.net/) methodology.

## Hello world
```php
# index.php
<?php

use Amp\Http\Server\Request;
use Apio\Http\Response;
use Apio\Http\Server;
use Apio\Logging\Logger;
use Apio\Routing\Router;

include 'vendor/autoload.php';

// Fire up Apio components by simple instantiation
$logger = new Logger('apio');
$server = new Server;
$router = new Router();

$logger->info('Apio is easy.');

$router->get('/', function(Request $request) {
    $response = new Response;
    
    $response
        ->data(['hello world'])
        ->data(['request' => (array) $request]);

    return $response->send();
});

// Encapsulate your app under it's own HTTP server
$server
    ->listen('localhost:3000', $router, $logger)
    ->run();
```

```console
$ php index.php
```

## Why
Apio exists because Symfony and Laravel are great tools, but sometimes they are overkill and just have a large learning and working curve to develop the lightest of the applications.

Apio makes it easy for PHP developers to set up their own micro apps in no time, but also to let them be able to build a full-sized web app from the ground up with confidence that their foundation is solid and was built by them.

Moreover, it does not reinvent the wheel. Under the majority of components there are well known open source packages wrapped under a nice and convenient API that allows developers to use goodies such as logging and port binding in few lines of code, and use them in more advanced ways by using loosely coupled classes with dependency injection that can take custom made extensions of the default components.

Finally, Apio is lightly opinionated and does not take any hard stance in favour of any approach, because **design patterns are tools** and developers should be able to easily build applications using one or another without having to completely switch **the rest of their toolkit**.
