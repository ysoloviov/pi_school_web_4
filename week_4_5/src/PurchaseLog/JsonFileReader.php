<?php

declare(strict_types=1);

namespace App\PurchaseLog;

use App\Entity\Category;
use App\Entity\Product;
use App\Entity\Purchase;
use App\Entity\Shop;
use App\Entity\User;
use IteratorAggregate;
use Traversable;
use Exception;
use DateTime;

class JsonFileReader implements IteratorAggregate
{
	const JSON_DEPTH = 64;

	private string $file;

	public function __construct(string $file)
	{
		$this->file = $file;
	}

	public function getIterator():Traversable
	{
		$fp = fopen($this->file, "r");

		if(!$fp)
			throw new Exception("Cannot open file for reading \"$this->file\"");

		while(($line = fgets($fp)) !== false)
			yield $this->getPurchase($line);

		fclose($fp);
	}

	private function getPurchase(string $json):Purchase
	{
		$data = json_decode($json, false, self::JSON_DEPTH, JSON_THROW_ON_ERROR);
		$user = new User;
		$user->setName($data->user_first_name);
		$user->setSurname($data->user_last_name);
		$user->setEmail($data->user_email);
		$shop = new Shop;
		$shop->setName($data->shop_name);
		$shop->setDomain($data->shop_domain);
		$purchase = new Purchase;
		$purchase->setSum((int) $data->sum);
		$purchase->setDate(new DateTime($data->date));
		$purchase->setShop($shop);
		$purchase->setUser($user);

		foreach($data->products as $product) {
			$p = new Product;
			$p->setName($product->name);
			$categories = explode(",", $product->product_categories);
			$purchase->addProduct($p);

			foreach($categories as $category) {
				$c = new Category;
				$c->setName($category);
				$p->addCategory($c);
			}
		}

		return $purchase;
	}
}
