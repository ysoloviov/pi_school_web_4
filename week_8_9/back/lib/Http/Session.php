<?php

declare(strict_types=1);

namespace Http;

class Session
{
	private int $lifetime;

	public function __construct(int $lifetime)
	{
		$this->lifetime = $lifetime;
		ini_set("session.gc_maxlifetime", (string) $lifetime);
		ini_set("session.cookie_lifetime", (string) $lifetime);
		session_start();
	}

	public function get(string $key):?string
	{
		return isset($_SESSION[$key]) ? $_SESSION[$key] : NULL;
	}

	public function has(string $key):bool
	{
		return isset($_SESSION[$key]);
	}

	public function set(string $key, string $value):self
	{
		$_SESSION[$key] = $value;

		return $this;
	}
}
