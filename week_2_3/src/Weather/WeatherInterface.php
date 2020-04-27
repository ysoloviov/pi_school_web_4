<?php

declare(strict_types=1);

namespace Weather;

interface WeatherInterface
{
	/*
	 * Returns temperature for given time, otherwise fail.
	 *
	 * @throws Exception\WeatherException
	 */
	public function getTemp(float $long, float $lat, int $time):float;

	/*
	 * Returns dictionary of temperatures for given times,
	 * or empty array if no data found.
	 *
	 * @throws Exception\WeatherException
	 */
	public function getTemps(float $long, float $lat, array $times):array;
}
