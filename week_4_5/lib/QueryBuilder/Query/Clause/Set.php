<?php

declare(strict_types=1);

namespace QueryBuilder\Query\Clause;

use QueryBuilder\Query\Parameter;

trait Set
{
	protected string $set = "";
	protected array $setParams = [];

	public function setProperties(array $properties):self
	{
		foreach($properties as $property => $value)
			$this->setProperty($property, $value);

		return $this;
	}

	public function setProperty(string $property, $value):self
	{
		$this->set .= $this->set ? ", $property = ?" : "$property = ?";
		$this->setParams[] = new Parameter($value);

		return $this;
	}
}
