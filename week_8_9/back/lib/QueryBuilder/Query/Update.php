<?php

declare(strict_types=1);

namespace QueryBuilder\Query;

class Update extends Query
{
	use Clause\Set;
	use Clause\Where;
	use Clause\Order;
	use Clause\Limit;

	public function __toString():string
	{
		return "UPDATE $this->table SET $this->set $this->where $this->order $this->limit";
	}

	public function getParams():array
	{
		return array_merge($this->setParams, $this->whereParams, $this->limitParams);
	}
}
