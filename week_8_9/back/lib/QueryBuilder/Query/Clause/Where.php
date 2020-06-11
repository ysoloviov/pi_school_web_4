<?php

declare(strict_types=1);

namespace QueryBuilder\Query\Clause;

use QueryBuilder\Query\Parameter;

trait Where
{
	protected string $where = "";
	protected array $whereParams = [];

	public function where(string $condition, ...$params):self
	{
		$this->where .= $this->where ? " AND $condition" : "WHERE $condition";
		
		foreach($params as $param)
			$this->whereParams[] = new Parameter($param);

		return $this;
	}

	public function whereEqual(string $column, $value):self
	{
		return $this->where("$column = ?", $value);
	}

	public function whereNotEqual(string $column, $value):self
	{
		return $this->where("$column != ?", $value);
	}

	public function whereColumnIn(string $column, array $values):self
	{
		$placeholders = implode(",", array_fill(0, count($values), "?"));
		$condition = "$column IN($placeholders)";

		return $this->where($condition, ...$values);
	}

	public function whereNull(string $column):self
	{
		return $this->where("$column IS NULL");
	}

	public function whereNotNull(string $column):self
	{
		return $this->where("$column IS NOT NULL");
	}

	public function orWhere(string $condition, ...$params):self
	{
		$this->where .= " OR $condition";

		foreach($params as $param)
			$this->whereParams[] = new Parameter($param);

		return $this;
	}
}
