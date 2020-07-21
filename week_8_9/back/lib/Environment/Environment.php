<?php

declare(strict_types=1);

namespace Environment;

use ArrayAccess;

class Environment implements ArrayAccess
{
	const MASK_FILES = "*.php";

	private string $dir;
	private array $variables;

	public function __construct(string $dir)
	{
		$this->dir = $dir;
	}

	public function offsetExists($offset):bool
	{
		return array_key_exists($offset, $this->variables);
	}

	public function offsetGet($offset):?string
	{
		return $this->variables[$offset] ?? NULL;
	}

	public function offsetSet($offset, $value):void
	{
		$this->variables[$offset] = $value;
	}

	public function offsetUnset($offset):void
	{
		unset($this->variables[$offset]);
	}

	public function scan():void
	{
		foreach(getenv() as $name => $value)
			$this->variables[$name] = $value;

		if(!is_dir($this->dir))
			return;

		foreach(glob($this->dir . "/" . self::MASK_FILES) as $file)
			$this->loadFile($file);
	}

	private function loadFile(string $file):void
	{
		if(!is_readable($file))
			return;

		$variables = require_once($file);

		foreach($variables as $name => $value)
			$this->variables[$name] = $value;
	}
}
