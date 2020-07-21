<?php

declare(strict_types=1);

namespace Routing;

class Parameter
{
	const NUMBER = "^\d+$";

	private string $name;
	private string $regex = "";
	private bool $required;

	public function __construct(string $name, bool $required = true)
	{
		$this->name = $name;
		$this->required = $required;
	}

	public function getName():string
	{
		return $this->name;
	}

	public function setRegex(string $regex):void
	{
		$this->regex = "/$regex/";
	}

	public function isRequired():bool
	{
		return $this->required;
	}

	public function isMatched(string $value):bool
	{
		return $this->regex ? (bool) preg_match($this->regex, $value) : true;
	}
}
