<?php

declare(strict_types=1);

namespace Database\ORM;

class EntityMetadata
{
	private string $table;

	public function __construct(string $table)
	{
		$this->table = $table;
	}

	public function getTable():string
	{
		return $this->table;
	}

	/* TODO: add relations */
	public function setOneToMany(string $property, string $entity):OneToMany
	{
		return new Relation\OneToMany($property, $entity);
	}
}
