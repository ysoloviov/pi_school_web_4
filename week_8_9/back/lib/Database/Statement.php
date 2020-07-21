<?php

declare(strict_types=1);

namespace Database;

use PDOStatement;
use PDO;

class Statement extends PDOStatement
{
	private int $counter = 0;

	public function execute($params = NULL):self
	{
		parent::execute();
		$this->counter = 0;

		return $this;
	}

	public function bind($value, int $type = PDO::PARAM_STR):self
	{
		$this->bindValue(++$this->counter, $value, $type);

		return $this;
	}
}
