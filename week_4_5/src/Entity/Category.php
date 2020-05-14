<?php

declare(strict_types=1);

namespace App\Entity;

use Database\ORM\EntityMetadata;
use Database\ORM\StorableInterface;

class Category implements StorableInterface
{
	use Property\Id;
	use Property\Name;

	public function getEntityMetadata():EntityMetadata
	{
		return new EntityMetadata("categories");
	}
}
