<?php

declare(strict_types=1);

namespace QueryBuilder\Query;

use Database\Database;
use Database\Statement;

abstract class Query
{
	protected Database $database;
	protected string $table;

	/* SQL representation of the query */
	abstract public function __toString():string;

	/* SQL properties to be binded */
	abstract public function getParams():array;

	public function __construct(Database $database, string $table)
	{
		$this->database = $database;
		$this->table = $table;
	}

	public function execute():Statement
	{
		return $this->getStatement()->execute();
	}

	public function getStatement():Statement
	{
		$statement = $this->database->prepare((string) $this);

		foreach($this->getParams() as $param)
			$statement->bind($param->getValue(), $param->getType());

		return $statement;
	}
}
