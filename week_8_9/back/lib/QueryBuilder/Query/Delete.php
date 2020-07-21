<?php

declare(strict_types=1);

namespace QueryBuilder\Query;

class Delete extends Query
{
	use Clause\Where;
	use Clause\Order;
	use Clause\Limit;

	public function __toString():string
	{
		return "DELETE FROM $this->table $this->where $this->order $this->limit";
	}

	public function getParams():array
	{
		return array_merge($this->whereParams, $this->limitParams);
	}
}
