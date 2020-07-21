<?php

declare(strict_types=1);

namespace Database\ORM;

interface StorableInterface
{
	public function getEntityMetadata():EntityMetadata;
}
