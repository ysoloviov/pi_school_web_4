<?php

declare(strict_types=1);

namespace App\Entity;

use Database\ORM\EntityMetadata;
use Database\ORM\StorableInterface;

class Product implements StorableInterface
{
	use Property\Id;
	use Property\Name;

	/* Entity\Category[] */
	private array $categories;

	public function getEntityMetadata():EntityMetadata
	{
		return new EntityMetadata("products");
	}

	public function setCategories(array $categories):self
	{
		$this->categories = $categories;

		return $this;
	}

	public function addCategory(Category $category):self
	{
		$this->categories[] = $category;

		return $this;
	}

	public function getCategories():array
	{
		return $this->categories;
	}
}
