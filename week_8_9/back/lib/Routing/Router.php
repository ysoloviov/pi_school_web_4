<?php

declare(strict_types=1);

namespace Routing;

use Closure;

class Router extends RouteCollection
{
	private string $method;
	private string $uri;
	private array $globalParams = [];
	private ?Closure $expander = null;

	public function __construct(string $method, string $uri)
	{
		$this->method = $method;
		$this->uri = $uri;
	}

	public function where(string $param, string $regex):self
	{
		$this->globalParams[$param] = $regex;

		return $this;
	}

	public function expand(Closure $expander):self
	{
		$this->expander = $expander;

		return $this;
	}

	public function getMatchedRoute():?Route
	{
		$matchedRoute = null;

		foreach($this->routes as $route) {
			foreach($this->globalParams as $param => $regex) {
				if($route->hasParam($param))
					$route->where($param, $regex);
			}

			if(!$route->isMatched($this->method, $this->uri))
				continue;

			if($matchedRoute && $matchedRoute->getPathAmount() > $route->getPathAmount())
				continue;

			$matchedRoute = $route;
		}

		if(!$matchedRoute)
			return null;

		if($this->expander)
			($this->expander)($matchedRoute);

		return $matchedRoute;
	}
}
