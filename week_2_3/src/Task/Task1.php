<?php

declare(strict_types=1);

namespace Task;

use DateTimeInterface;
use DateTimeZone;
use DateTime;

class Task1 extends Task
{
	const TIMEZONE = "Europe/Kiev";
	const DATETIME = "tomorrow 22:00";

	protected function process(array $geodata, string $out):void
	{
		$timezone = new DateTimeZone(self::TIMEZONE);
		$datetime = new DateTime(self::DATETIME, $timezone);
		$header = $column = "";

		foreach($geodata as $city) {
			$header .= "," . $city["name"];
			$column .= "," . $this->weather->getTemp($city["lat"], $city["long"],
				$datetime->getTimestamp());
		}

		$utc = new DateTimeZone("UTC");
		$datetime->setTimezone($utc);
		$date = $datetime->format(DateTimeInterface::ATOM);
		$lines = is_readable($out) ? file($out) : [];

		/* skip empty lines at the end of the file */
		for($i = count($lines) - 1; $i >= 0 && $lines[$i] === ""; $i--);

		/* file is empty, write header */
		if($i < 0) {
			$lines[0] = "Date" . $header . PHP_EOL;
			$i = 1;
		}
		/* check whether file contains a column for given datetime */
		else if(strpos($lines[$i], $date) !== 0) {
			$i++;
		}

		$lines[$i] = $date . $column . PHP_EOL;
		file_put_contents($out, $lines);
	}
}
