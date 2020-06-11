<?php

declare(strict_types=1);

require_once __DIR__ . "/vendor/autoload.php";

use App\Http\ControllerResolver;
use App\Http\ArgumentResolver;
use Http\Request;
use Http\Kernel;
use Routing\Router;
use DependencyInjection\ServiceProvider;

$request = new Request($_GET["uri"]);
$serviceProvider = new ServiceProvider;
$serviceProvider->addInstance(Request::class, $request);
$router = new Router($request->getMethod(), $request->getPath());
$controllerResolver = new ControllerResolver($router, __DIR__ . "/cfg/routes");
$argumentResolver = new ArgumentResolver($serviceProvider, __DIR__ . "/cfg/services");
$kernel = new Kernel($controllerResolver, $argumentResolver);
$response = $kernel->handle($request);
$response->send();
