<?php

declare(strict_types=1);

namespace QueryBuilder\Query\Clause;

trait Order
{
	protected string $order = "";

	public function order(string $column):self
	{
		$this->order = "ORDER BY $column";

		return $this;
	}

	public function reverse():self
	{
		$this->order .= " DESC";

		return $this;
	}
}
