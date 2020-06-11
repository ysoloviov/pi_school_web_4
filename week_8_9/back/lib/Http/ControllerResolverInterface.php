<?php

declare(strict_types=1);

namespace Http;

interface ControllerResolverInterface
{
	public function getController():?callable;
}
