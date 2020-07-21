<?php

declare(strict_types=1);

namespace Routing;

use Closure;

class RouteCollection
{
	const METHOD_GET = "GET";
	const METHOD_POST = "POST";
	const METHOD_DELETE = "DELETE";

	protected array $routes = [];

	public function get(string $rule, callable $controller):Route
	{
		return $this->addRoute(self::METHOD_GET, $rule, $controller);
	}

	public function post(string $rule, callable $controller):Route
	{
		return $this->addRoute(self::METHOD_POST, $rule, $controller);
	}

	public function delete(string $rule, callable $controller):Route
	{
		return $this->addRoute(self::METHOD_DELETE, $rule, $controller);
	}

	public function addRoutes(self $routes):self
	{
		$this->routes = array_merge($this->routes, $routes->getRoutes());

		return $this;
	}

	public function getRoutes():array
	{
		return $this->routes;
	}

	private function addRoute(string $method, string $rule, callable $controller):Route
	{
		$route = new Route($method, $rule, Closure::fromCallable($controller));
		$route->parse();
		$this->routes[] = $route;

		return $route;
	}
}
