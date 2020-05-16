<?php

declare(strict_types=1);

namespace App\Entity;

use Database\ORM\EntityMetadata;
use Database\ORM\StorableInterface;

class Shop implements StorableInterface
{
	use Property\Id;
	use Property\Name;

	private string $domain;

	public function getEntityMetadata():EntityMetadata
	{
		return new EntityMetadata("shops");
	}

	public function setDomain(string $domain):self
	{
		$this->domain = $domain;

		return $this;
	}

	public function getDomain():string
	{
		return $this->domain;
	}
}
