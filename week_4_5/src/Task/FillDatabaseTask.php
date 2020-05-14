<?php

declare(strict_types=1);

namespace App\Task;

use App\Entity\Category;
use App\Entity\Product;
use App\Entity\Purchase;
use App\Entity\Shop;
use App\Entity\User;
use Database\Database;
use Database\ORM\StorableInterface;
use QueryBuilder\QueryBuilder;
use PDOException;

class FillDatabaseTask
{
	const INTEGRITY_CONSTRAINT_VIOLATION = 23000;
	const PER_TRANSACTION = 1000;
	const DATE_FORMAT = "Y-m-d H:i:s";

	private Database $database;
	private QueryBuilder $builder;

	public function __construct(Database $database, QueryBuilder $builder)
	{
		$this->database = $database;
		$this->builder = $builder;
	}

	/**
	 * @param Purchase[] $purchases
	 */
	public function __invoke(iterable $purchases):void
	{
		$i = 0;
		$this->database->beginTransaction();

		foreach($purchases as $purchase) {
			try {
				$this->addPurchase($purchase);
			}
			/* ignore duplicate entries */
			catch(PDOException $e) {
				if((int) $e->getCode() !== self::INTEGRITY_CONSTRAINT_VIOLATION)
					throw $e;
			}
			catch(Exception $e) {
				echo $e->getMessage() . PHP_EOL;
				die;
			}

			if(++$i === self::PER_TRANSACTION) {
				$this->database->commit();
				$this->database->beginTransaction();
				$i = 0;
			}
		}

		$this->database->commit();
	}

	private function addPurchase(Purchase $purchase):int
	{
		foreach($purchase->getProducts() as $product) {
			foreach($product->getCategories() as $category)
				$this->setCategoryId($category);

			$this->setProductId($product);
		}

		$this->setUserId($purchase->getUser());
		$this->setShopId($purchase->getShop());
		$this->builder->to("purchases")
				->setProperty("shop_id", $purchase->getShop()->getId())
				->setProperty("user_id", $purchase->getUser()->getId())
				->setProperty("sum", $purchase->getSum())
				->setProperty("date", $purchase->getDate()->format(self::DATE_FORMAT))
				->execute();
		$id = (int) $this->database->lastInsertId();

		foreach($purchase->getProducts() as $product) {
			$this->builder->to("purchase_product")
				->setProperty("purchase_id", $id)
				->setProperty("product_id", $product->getId())
				->execute();
		}

		return $id;
	}

	private function addCategory(Category $category):int
	{
		return $this->addEntity($category, [
			"name" => $category->getName(),
		]);
	}

	private function addProduct(Product $product):int
	{
		$id = $this->addEntity($product, [
			"name" => $product->getName(),
		]);

		foreach($product->getCategories() as $category) {
			$this->builder->to("product_category")
				 ->setProperty("product_id", $id)
				 ->setProperty("category_id", $category->getId())
				 ->execute();
		}

		return $id;
	}

	private function addShop(Shop $shop):int
	{
		return $this->addEntity($shop, [
			"name" => $shop->getName(),
			"domain" => $shop->getDomain(),
		]);
	}

	private function addUser(User $user):int
	{
		return $this->addEntity($user, [
			"name" => $user->getName(),
			"surname" => $user->getSurname(),
			"email" => $user->getEmail(),
		]);
	}

	private function addEntity(StorableInterface $entity, array $properties):int
	{
		$table = $entity->getEntityMetadata()->getTable();
		$this->builder->to($table)
				->setProperties($properties)
				->execute();

		return (int) $this->database->lastInsertId();
	}

	private function setCategoryId(Category $category):Category
	{
		$id = $this->getIdByName($category, $category->getName());
		$category->setId($id ?? $this->addCategory($category));

		return $category;
	}

	private function setProductId(Product $product):Product
	{
		$id = $this->getIdByName($product, $product->getName());
		$product->setId($id ?? $this->addProduct($product));

		return $product;
	}

	private function setShopId(Shop $shop):Shop
	{
		$id = $this->getIdByName($shop, $shop->getName());
		$shop->setId($id ?? $this->addShop($shop));

		return $shop;
	}

	private function setUserId(User $user):User
	{
		$id = $this->getIdByName($user, $user->getName());
		$user->setId($id ?? $this->addUser($user));

		return $user;
	}

	private function getIdByName(StorableInterface $entity, $name):?int
	{
		$table = $entity->getEntityMetadata()->getTable();
		$id = $this->builder->from($table)
				->select('id')
				->whereEqual("name", $name)
				->execute()
				->fetchColumn();

		return $id === false ? NULL : (int) $id;
	}
}
