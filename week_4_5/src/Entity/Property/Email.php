<?php

declare(strict_types=1);

namespace App\Entity\Property;

trait Email
{
	private string $email;

	public function setEmail(string $email):self
	{
		$this->email = $email;

		return $this;
	}

	public function getEmail():string
	{
		return $this->email;
	}
}
