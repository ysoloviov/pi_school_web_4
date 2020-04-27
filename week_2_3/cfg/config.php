<?php

return [
	"weather" => Weather\OpenWeatherMap::class,
	/* "weather" => Weather\FakeData::class, */
	"task1" => [
		"file" => "forecastHistory.csv",
	],
	"task2" => [
		"file" => "php://stdout",
	],
	"open_weather" => [
		"key" => "44e5c74fa78f406660f80964145bf7cd",
		"units" => "metric",
	],
];
