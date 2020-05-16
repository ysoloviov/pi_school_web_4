<?php

declare(strict_types=1);

namespace Database;

use PDO;

class Database extends PDO
{
	const DSN = "%s:host=%s;dbname=%s;charset=UTF8";

	private int $transactionLevel = 0;

	public function __construct(string $driver, string $host, string $database,
		string $user, string $password)
	{
		$dsn = sprintf(self::DSN, $driver, $host, $database);
		parent::__construct($dsn, $user, $password);
		$this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$this->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
		$this->setAttribute(PDO::ATTR_STATEMENT_CLASS, [Statement::class]);
	}

	public function beginTransaction():self
	{
		if($this->transactionLevel++ === 0)
			parent::beginTransaction();

		return $this;
	}

	public function rollBack():self
	{
		if(--$this->transactionLevel === 0)
			parent::rollBack();

		return $this;
	}

	public function commit():self
	{
		if(--$this->transactionLevel === 0)
			parent::commit();

		return $this;
	}
}
