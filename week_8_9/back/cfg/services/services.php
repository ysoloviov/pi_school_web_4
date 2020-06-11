<?php

declare(strict_types=1);

use DependencyInjection\ServiceCollection;
use DependencyInjection\Reference;
use Environment\Environment;
use Database\Database;
use Http\Session;

$sc = new ServiceCollection;

/* environment */
$env = new Environment(__DIR__ . "/../../env");
$env->scan();
$sc->addInstance(Environment::class, $env);

/* session */
$lifetime = 86400 * 2;
$sc->addSingleton(Session::class)->setArguments([
	$lifetime,
]);

/* prepared statements */
$sc->addSingleton(Database::class)->setArguments([
	$env["DB_DRIVER"],
	$env["DB_HOST"],
	$env["DB_NAME"],
	$env["DB_USER"],
	$env["DB_PASSWORD"],
]);
$sc->addAlias(PDO::class, Database::class);

return $sc;
