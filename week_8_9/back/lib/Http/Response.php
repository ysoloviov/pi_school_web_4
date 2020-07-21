<?php

declare(strict_types=1);

namespace Http;

class Response
{
	const HTTP_OK = 200;
	const HTTP_BAD_REQUEST = 400;
	const HTTP_UNAUTHORIZED = 401;
	const HTTP_NOT_FOUND = 404;
	const HTTP_CONFLICT = 409;

	private int $statusCode;
	private array $headers = [];
	private string $response;

	public function __construct(string $response = "", $statusCode = self::HTTP_OK)
	{
		$this->response = $response;
		$this->statusCode = $statusCode;
	}

	public function __toString():string
	{
		return $this->response;
	}

	public function send():self
	{
		echo (string) $this;
		http_response_code($this->statusCode);

		foreach($this->headers as $header => $value)
			header($header . ":" . $value);

		return $this;
	}

	public function setStatusCode(int $code):self
	{
		$this->statusCode = $code;

		return $this;
	}

	public function setContentTypeHeader(string $value):self
	{
		return $this->setHeader("Content-Type", $value);
	}

	public function setHeader(string $header, string $value):self
	{
		$this->headers[$header] = $value;

		return $this;
	}
}
