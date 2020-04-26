<?php

declare(strict_types=1);

namespace Task;

use DateTimeZone;
use DateTime;

class Task2 extends Task
{
	private array $times = ["08:00", "12:00", "16:00", "20:00"];

	protected function process(array $geodata, string $out):void
	{
		$timezone = new DateTimeZone($geodata["timezone"]);
		$datetime = new DateTime("tomorrow", $timezone);
		$lines = [];

		foreach($this->times as $time) {
			$datetime->modify($time);
			$temp = $this->weather->getTemp($geodata["lat"], $geodata["long"],
				$datetime->getTimestamp());
			$lines[] = $time . ": " . $temp . PHP_EOL;
		}

		file_put_contents($out, $lines);
	}
}
