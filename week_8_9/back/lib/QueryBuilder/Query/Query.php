<?php

declare(strict_types=1);

namespace QueryBuilder\Query;

use PDO;
use PDOStatement;

abstract class Query
{
	protected PDO $pdo;
	protected string $table;

	/* SQL representation of the query */
	abstract public function __toString():string;

	/* SQL properties to be binded */
	abstract public function getParams():array;

	public function __construct(PDO $pdo, string $table)
	{
		$this->pdo = $pdo;
		$this->table = $table;
	}

	public function getStatement():PDOStatement
	{
		$statement = $this->pdo->prepare((string) $this);

		foreach($this->getParams() as $param)
			$statement->bind($param->getValue(), $param->getType());

		return $statement;
	}
}
