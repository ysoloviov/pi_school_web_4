<?php

declare(strict_types=1);

namespace DependencyInjection;

use ReflectionClass;

class Service
{
	protected string $name;
	protected array $args = [];

	public function __construct(string $name)
	{
		$this->name = $name;
	}

	public function getName():string
	{
		return $this->name;
	}

	public function setArguments(array $args):self
	{
		$this->args = $args;

		return $this;
	}

	public function getArguments():array
	{
		return $this->args;
	}

	public function getInstance(ServiceProvider $provider):object
	{
		$class = new ReflectionClass($this->name);
		$constructor = $class->getConstructor();
		$args = $constructor
			? $provider->getArguments($constructor, $this->args)
			: [];

		return $class->newInstanceArgs($args);
	}
}
