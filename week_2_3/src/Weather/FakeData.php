<?php

declare(strict_types=1);

namespace Weather;

use Network\NetworkManager;

class FakeData implements WeatherInterface
{
	public function __construct(NetworkManager $network, string $key, string $units)
	{
	}

	public function getTemp(float $lat, float $long, int $time):float
	{
		return 10.00;
	}

	public function getTemps(float $lat, float $long, array $times):array
	{
		$temps = [];

		foreach($times as $time) {
			$temps[$time] = 10.00;
		}

		return $temps;
	}
}
