<?php

declare(strict_types=1);

namespace App\Entity;

use Database\ORM\EntityMetadata;
use Database\ORM\StorableInterface;

class User implements StorableInterface
{
	use Property\Id;
	use Property\Name;
	use Property\Email;

	private string $surname;

	public function getEntityMetadata():EntityMetadata
	{
		return new EntityMetadata("users");
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
}
