<?php

declare(strict_types=1);

namespace App\Repository;

use App\Model\User;
use QueryBuilder\QueryBuilder;
use PDO;
use StdClass;

class UserRepository
{
	const TABLE = "users";

	private PDO $pdo;
	private QueryBuilder $builder;

	public function __construct(PDO $pdo, QueryBuilder $builder)
	{
		$this->pdo = $pdo;
		$this->builder = $builder;
	}

	public function addUser(User $user):User
	{
		$this->builder
			->to(self::TABLE)
			->setProperty("name", $user->getName())
			->setProperty("surname", $user->getSurname())
			->setProperty("email", $user->getEmail())
			->setProperty("password", $user->getPassword())
			->getStatement()
			->execute();
		$user->setId((int) $this->pdo->lastInsertId());

		return $user;
	}

	public function getUserByEmail(string $email):?User
	{
		return $this->getUserByColumn("email", $email);
	}

	public function getUserById(int $id):?User
	{
		return $this->getUserByColumn("id", (string) $id);
	}

	public function getUserByColumn(string $column, string $value):?User
	{
		$raw = $this->builder
			->from(self::TABLE)
			->whereEqual($column, $value)
			->getStatement()
			->execute()
			->fetchObject();

		if(!$raw)
			return NULL;

		return $this->getUserByRaw($raw);
	}

	private function getUserByRaw(StdClass $raw):User
	{
		$user = new User;
		$user->setId((int) $raw->id);
		$user->setName($raw->name);
		$user->setSurname($raw->surname);
		$user->setEmail($raw->email);
		$user->setPassword($raw->password);

		return $user;
	}
}
