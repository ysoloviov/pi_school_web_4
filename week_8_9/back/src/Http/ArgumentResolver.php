<?php

declare(strict_types=1);

namespace App\Http;

use Http\ArgumentResolverInterface;
use DependencyInjection\ServiceProvider;

class ArgumentResolver implements ArgumentResolverInterface
{
	const MASK_FILES = "*.php";

	private ServiceProvider $provider;
	private string $path;

	public function __construct(ServiceProvider $provider, string $path)
	{
		$this->provider = $provider;
		$this->path = $path;
	}

	public function getArguments(callable $fn):array
	{
		$this->loadServices();

		return $this->provider->getCallableArguments($fn);
	}

	private function loadServices():void
	{
		foreach(glob($this->path . "/" . self::MASK_FILES) as $file) {
			$services = require_once($file);
			$this->provider->addServices($services);
		}
	}
}
