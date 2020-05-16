<?php

declare(strict_types=1);

namespace App\Entity;

use Database\ORM\EntityMetadata;
use Database\ORM\StorableInterface;
use DateTime;

class Purchase implements StorableInterface
{
	use Property\Id;

	private User $user;
	private Shop $shop;
	private int $sum;
	private DateTime $date;

	/* Entity\Product[] */
	private array $products = [];

	public function getEntityMetadata():EntityMetadata
	{
		return new EntityMetadata("purchases");
	}

	public function setUser(User $user):self
	{
		$this->user = $user;

		return $this;
	}

	public function getUser():User
	{
		return $this->user;
	}

	public function setShop(Shop $shop):self
	{
		$this->shop = $shop;

		return $this;
	}

	public function getShop():Shop
	{
		return $this->shop;
	}

	public function setSum(int $sum):self
	{
		$this->sum = $sum;

		return $this;
	}

	public function getSum():int
	{
		return $this->sum;
	}

	public function setDate(DateTime $date):self
	{
		$this->date = $date;

		return $this;
	}

	public function getDate():DateTime
	{
		return $this->date;
	}

	public function setProducts(array $products):self
	{
		$this->products = $products;

		return $this;
	}

	public function addProduct(Product $product):self
	{
		$this->products[] = $product;

		return $this;
	}

	public function getProducts():array
	{
		return $this->products;
	}
}
