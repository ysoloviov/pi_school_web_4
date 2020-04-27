<?php

declare(strict_types=1);

namespace Weather;

use Network\NetworkManager;
use Weather\Exception\WeatherException;

/**
 * Abstraction layer over OpenWeather One Call API,
 * https://openweathermap.org/api/one-call-api
 */
class OpenWeatherMap implements WeatherInterface
{
	const URL = "https://api.openweathermap.org/data/2.5/onecall";

	/* api key */
	private string $key;

	private string $units;
	private NetworkManager $network;

	public function __construct(NetworkManager $network, string $key, string $units)
	{
		$this->network = $network;
		$this->key = $key;
		$this->units = $units;
	}

	public function getTemp(float $lat, float $long, int $time):float
	{
		$temps = $this->getTemps($lat, $long, [$time]);

		if(!array_key_exists($time, $temps))
			throw new WeatherException("No data for specified time");

		return $temps[$time];
	}

	public function getTemps(float $lat, float $long, array $times):array
	{
		$temps = [];
		$data = $this->getData($lat, $long);

		foreach($data["hourly"] as $hour) {
			if(in_array($hour["dt"], $times))
				$temps[$hour["dt"]] = $hour["temp"];
		}

		return $temps;
	}

	private function getData(float $lat, float $long):array
	{
		$params = [
			"appid" => $this->key,
			"units" => $this->units,
			"lat" => $lat,
			"lon" => $long,
		];
		$request = $this->network->getRequest(self::URL, $params);
		$response = $request->send();
		$data = $response->getJsonResponse();

		if($response->getStatusCode() !== 200)
			throw new WeatherException($data["message"]);

		return $data;
	}
}
