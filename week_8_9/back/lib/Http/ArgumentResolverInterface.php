<?php

declare(strict_types=1);

namespace Http;

interface ArgumentResolverInterface
{
	public function getArguments(callable $fn):array;
}
