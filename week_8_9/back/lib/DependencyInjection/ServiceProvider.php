<?php

declare(strict_types=1);

namespace DependencyInjection;

use DependencyInjection\Exception\ArgumentNotResolvedException;
use ReflectionMethod;
use ReflectionFunction;
use ReflectionFunctionAbstract;
use ReflectionParameter;
use Closure;

class ServiceProvider extends ServiceCollection
{
	public function getCallableArguments(callable $fn, array $userArgs = []):array
	{
		$closure = Closure::fromCallable($fn);

		return $this->getArguments(new ReflectionFunction($closure), $userArgs);
	}

	public function getArguments(ReflectionFunctionAbstract $fn, array $userArgs = []):array
	{
		$args = [];

		foreach($fn->getParameters() as $param)
			$args[] = $this->getArgument($param, $userArgs);

		return $args;
	}

	private function getArgument(ReflectionParameter $param, array &$userArgs = [])
	{
		$class = $param->getClass();

		if($class)
			return $this->get($class->getName());

		$name = $param->getName();

		if(isset($userArgs[$name]))
			return $this->getResolvedArgument($userArgs[$name]);

		if(isset($userArgs[0]))
			return $this->getResolvedArgument(array_shift($userArgs));

		if($param->isDefaultValueAvailable())
			return $param->getDefaultValue();

		throw new ArgumentNotResolvedException($name);
	}

	private function getResolvedArgument($arg)
	{
		if($arg instanceof Reference)
			return $this->get($arg->getId());

		return $arg;
	}

	public function get(string $id):object
	{
		$service = $this->services[$id] ?? new Service($id);

		return $service->getInstance($this);
	}

	public function has(string $id):bool
	{
		return isset($this->services[$id]);
	}
}
