<?php

declare(strict_types=1);

namespace QueryBuilder\Query;

use PDO;

class Select extends Query
{
	use Clause\Where;
	use Clause\Order;
	use Clause\Limit;

	private string $columns = "*";
	private string $join = "";
	private string $groupBy = "";
	private string $noCache = "";
	private array $joinParams = [];

	public function __toString():string
	{
		return "SELECT $this->noCache $this->columns FROM $this->table "
			. "$this->join $this->where $this->groupBy $this->order $this->limit";
	}

	public function disableCache():self
	{
		$this->noCache = "SQL_NO_CACHE";

		return $this;
	}

	public function enableCache():self
	{
		$this->noCache = "";

		return $this;
	}

	public function select(...$columns):self
	{
		$this->columns = implode(", ", $columns);

		return $this;
	}

	public function joinQuery(self $query, string $column1, string $column2,
		string $alias = "temp", string $type = ""):self
	{
		$query->enableCache();
		$table = "(" . (string) $query . ")";
		$this->join($table, $column1, $column2, $alias, $type, $query->getParams());

		return $this;
	}

	public function join(string $table, string $column1, string $column2,
		?string $alias, string $type = "", array $params = []):self
	{
		if($alias)
			$table .= " AS $alias";
		else
			$alias = $table;

		$this->join .= " $type JOIN $table ON $this->table.$column1 = $alias.$column2";
		$this->joinParams = array_merge($this->joinParams, $params);

		return $this;
	}

	public function group(string $column):self
	{
		$this->groupBy .= $this->groupBy ? ", $column" : "GROUP BY $column";

		return $this;
	}

	public function limit(int $amount, int $offset = 0):self
	{
		$this->limit = "LIMIT ? OFFSET ?";
		$this->limitParams = [
			new Parameter($amount, PDO::PARAM_INT),
			new Parameter($offset, PDO::PARAM_INT),
		];

		return $this;
	}

	public function paginate(int $page, int $amount):self
	{
		$offset = $page * $amount - $amount;

		return $this->limit($amount, $offset);
	}

	public function random():self
	{
		return $this->order("RAND()");
	}

	public function getParams():array
	{
		return array_merge($this->joinParams, $this->whereParams, $this->limitParams);
	}
}
