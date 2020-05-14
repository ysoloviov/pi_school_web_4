<?php

declare(strict_types=1);

namespace QueryBuilder\Query;

use PDO;

class Parameter
{
	private $value;
	private int $type;

	public function __construct($value, int $type = PDO::PARAM_STR)
	{
		$this->value = $value;
		$this->type = $type;
	}

	public function getValue()
	{
		return $this->value;
	}

	public function getType():int
	{
		return $this->type;
	}
}
