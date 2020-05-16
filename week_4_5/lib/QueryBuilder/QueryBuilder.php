<?php

declare(strict_types=1);

namespace QueryBuilder;

use QueryBuilder\Query\Select;
use QueryBuilder\Query\Insert;
use QueryBuilder\Query\Update;
use QueryBuilder\Query\Delete;
use Database\Database;

class QueryBuilder
{
	private Database $database;

	public function __construct(Database $database)
	{
		$this->database = $database;
	}

	public function from(string $table):Select
	{
		$select = new Select($this->database, $table);

		return $select;
	}

	public function to(string $table):Insert
	{
		return new Insert($this->database, $table);
	}

	public function update(string $table):Update
	{
		return new Update($this->database, $table);
	}

	public function delete(string $table):Delete
	{
		return new Delete($this->database, $table);
	}

	public function truncate(string $table):QueryBuilder
	{
		$this->database->prepare("TRUNCATE TABLE $table")->execute();

		return $this;
	}
}
