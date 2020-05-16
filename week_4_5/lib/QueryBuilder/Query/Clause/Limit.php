<?php

declare(strict_types=1);

namespace QueryBuilder\Query\Clause;

use QueryBuilder\Query\Parameter;
use PDO;

trait Limit
{
	protected string $limit = "";
	protected array $limitParams = [];

	public function limit(int $amount):self
	{
		$this->limit = "LIMIT ?";
		$this->limitParams = [new Parameter($amount, PDO::PARAM_INT)];

		return $this;
	}
}
