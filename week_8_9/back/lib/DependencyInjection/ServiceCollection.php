<?php

declare(strict_types=1);

namespace DependencyInjection;

class ServiceCollection
{
	protected array $services = [];

	public function add(string $id):Service
	{
		return $this->addService($id, new Service($id));
	}

	public function addSingleton(string $id):Service
	{
		return $this->addService($id, new SingletonService($id));
	}

	public function addInstance(string $id, object $instance):Service
	{
		return $this->addService($id, new InstanceService($id, $instance));
	}

	public function addAlias(string $alias, string $id):self
	{
		if(isset($this->services[$id]))
			$this->services[$alias] = $this->services[$id];

		return $this;
	}

	public function addServices(self $services):self
	{
		$this->services = array_merge($this->services, $services->getServices());

		return $this;
	}

	public function getServices():array
	{
		return $this->services;
	}

	private function addService(string $id, Service $service):Service
	{
		$this->services[$id] = $service;

		return $service;
	}
}
