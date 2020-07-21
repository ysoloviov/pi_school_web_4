<?php

declare(strict_types=1);

namespace App\Http;

use Routing\Router;
use Http\ControllerResolverInterface;

class ControllerResolver implements ControllerResolverInterface
{
	const MASK_FILES = "*.php";

	private Router $router;
	private string $path;

	public function __construct(Router $router, string $path)
	{
		$this->router = $router;
		$this->path = $path;
	}

	public function getController():?callable
	{
		$this->loadRoutes();
		$route = $this->router->getMatchedRoute();

		return $route ? $route->getController() : null;
	}

	private function loadRoutes():void
	{
		foreach(glob($this->path . "/" . self::MASK_FILES) as $file) {
			$routes = require_once($file);
			$this->router->addRoutes($routes);
		}
	}
}
