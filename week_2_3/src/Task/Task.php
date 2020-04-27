<?php

declare(strict_types=1);

namespace Task;

use Weather\WeatherInterface;
use Exception;

abstract class Task
{
	protected WeatherInterface $weather;

	public function __construct(WeatherInterface $weather)
	{
		$this->weather = $weather;
	}

	/**
	 * Writes forecast to file.
	 *
	 * $geodata requires name, lat, long and timezone keys to be set.
	 * $out is regular file or php://stdout
	 */
	public function __invoke(array $geodata, string $out):void
	{
		try {
			$this->process($geodata, $out);
		}
		catch(Exception $e) {
			echo $e->getMessage() . PHP_EOL;
		}
	}

	abstract protected function process(array $geodata, string $out);
}
