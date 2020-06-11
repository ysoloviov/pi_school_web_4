<?php

declare(strict_types=1);

namespace QueryBuilder;

use QueryBuilder\Query\Select;
use QueryBuilder\Query\Insert;
use QueryBuilder\Query\Update;
use QueryBuilder\Query\Delete;
use PDO;

class QueryBuilder
{
	private PDO $pdo;

	public function __construct(PDO $pdo)
	{
		$this->pdo = $pdo;
	}

	public function from(string $table):Select
	{
		$select = new Select($this->pdo, $table);

		return $select;
	}

	public function to(string $table):Insert
	{
		return new Insert($this->pdo, $table);
	}

	public function update(string $table):Update
	{
		return new Update($this->pdo, $table);
	}

	public function delete(string $table):Delete
	{
		return new Delete($this->pdo, $table);
	}
}
