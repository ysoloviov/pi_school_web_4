<?php

declare(strict_types=1);

namespace QueryBuilder\Query;

class Insert extends Query
{
	use Clause\Set;

	public function __toString():string
	{
		return "INSERT INTO $this->table SET $this->set";
	}

	public function getParams():array
	{
		return array_merge($this->setParams);
	}
}
