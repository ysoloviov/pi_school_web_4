<?php

declare(strict_types=1);

namespace DependencyInjection;

class SingletonService extends Service
{
	private ?object $instance = NULL;

	public function getInstance(ServiceProvider $provider):object
	{
		if(!$this->instance)
			$this->instance = parent::getInstance($provider);

		return $this->instance;
	}
}
