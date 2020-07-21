<?php

declare(strict_types=1);

namespace Routing;

use Closure;

class Route {
	const SEPARATOR = "#/#";
	const PARAM_MASK_LEFT = "{";
	const PARAM_MASK_RIGHT = "}";
	const PARAM_OPTIONAL = "?";

	private int $pathAmount;
	private int $requiredAmount = 0;
	private int $requiredParamsAmount = 0;
	private int $partsAmount = 0;
	private string $method;
	private string $rule;
	private Closure $controller;
	private array $path = [];
	private array $middleware = [];
	private array $params = [];
	private array $routeParams = [];

	public function __construct(string $method, string $rule, Closure $controller)
	{
		$this->method = $method;
		$this->rule = $rule;
		$this->controller = $controller;
	}

	public function getController():Closure
	{
		return $this->controller;
	}

	public function hasParam(string $param):bool
	{
		return isset($this->params[$param]);
	}

	public function where(string $param, string $regex):self
	{
		$this->params[$param]->setRegex($regex);

		return $this;
	}

	public function addMiddleware(Closure $middleware):self
	{
		$this->middleware[] = $middleware;

		return $this;
	}

	public function getPathAmount():int
	{
		return $this->pathAmount;
	}

	public function isMatched(string $method, string $path):bool
	{
		if($method !== $this->method)
			return false;

		$requestParts = $this->splitPath($path);
		$partsAmount = count($requestParts);

		if($this->requiredAmount > $partsAmount || $partsAmount > $this->partsAmount)
			return false;

		foreach($this->path as $pathPart) {
			$requestPart = array_splice($requestParts, 0, 1)[0];
			
			if($pathPart !== $requestPart)
				return false;
		}

		foreach($this->middleware as $fn) {
			if(!$fn())
				return false;
		}

		$i = 0;

		foreach($this->params as $name => $param) {
			if(!isset($requestParts[$i]))
				return !$param->isRequired();

			if(!$param->isMatched($requestParts[$i]))
				return false;

			$this->routeParams[$name] = $requestParts[$i];
			$i++;
		}

		return true;
	}

	public function parse():void
	{
		$parts = $this->splitPath($this->rule);
		$this->partsAmount = count($parts);
		
		foreach($parts as $part) {
			if($part[0] === self::PARAM_MASK_LEFT) {
				$param = $this->getParameter($part);
				$this->params[$param->getName()] = $param;

				if($param->isRequired())
					$this->requiredParamsAmount++;
			}
			else {
				$this->path[] = $part;
			}
		}

		$this->pathAmount = count($this->path);
		$this->requiredAmount = $this->pathAmount + $this->requiredParamsAmount;
	}

	private function getParameter(string $part):Parameter
	{
		$name = trim($part, self::PARAM_MASK_LEFT .
			self::PARAM_MASK_RIGHT . self::PARAM_OPTIONAL);
		$optionalSignOffset = strlen(self::PARAM_MASK_RIGHT) * -1 - 1;
		$required = substr($part, $optionalSignOffset, 1) !== self::PARAM_OPTIONAL;

		return new Parameter($name, $required);
	}

	private function splitPath(string $path):array
	{
		return preg_split(self::SEPARATOR, $path, -1, PREG_SPLIT_NO_EMPTY);
	}
}
