<?php

declare(strict_types=1);

namespace Http;

class Request
{
	private string $path;

	public function __construct(string $path)
	{
		$this->path = $path;
	}

	public function getPostVariable(string $var):?string
	{
		return isset($_POST[$var]) ? $_POST[$var] : null;
	}

	public function getUrlVariable(string $var):?string
	{
		return isset($_GET[$var]) ? $_GET[$var] : null;
	}

	public function getPath():string
	{
		return $this->path;
	}

	public function get(string $var):?string
	{
		if(($value = $this->getPostVariable($var)))
			return $value;
		if(($value = $this->getUrlVariable($var)))
			return $value;
		else
			return null;
	}

	public function getMethod():string
	{
		return $_SERVER["REQUEST_METHOD"];
	}
}
