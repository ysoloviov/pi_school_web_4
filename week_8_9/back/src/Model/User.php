<?php

declare(strict_types=1);

namespace App\Model;

class User
{
	private int $id;
	private string $name;
	private string $surname;
	private string $email;
	private string $password;

	public function setId(int $id):self
	{
		$this->id = $id;

		return $this;
	}

	public function getId():int
	{
		return $this->id;
	}

	public function setName(string $name):self
	{
		$this->name = $name;

		return $this;
	}

	public function getName():string
	{
		return $this->name;
	}

	public function setSurname(string $surname):self
	{
		$this->surname = $surname;

		return $this;
	}

	public function getSurname():string
	{
		return $this->surname;
	}

	public function setEmail(string $email):self
	{
		$this->email = $email;

		return $this;
	}

	public function getEmail():string
	{
		return $this->email;
	}

	public function setPassword(string $password):self
	{
		$this->password = $password;

		return $this;
	}

	public function getPassword():string
	{
		return $this->password;
	}

	public function getFullNameAsArray():array
	{
		return [
			"name" => $this->name,
			"surname" => $this->surname,
		];
	}
}
