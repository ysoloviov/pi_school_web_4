<?php

declare(strict_types=1);

namespace DependencyInjection;

class InstanceService extends Service
{
	private object $instance;

	public function __construct(string $name, object $instance)
	{
		parent::__construct($name);
		$this->instance = $instance;
	}

	public function getInstance(ServiceProvider $provider):object
	{
		return $this->instance;
	}
}
