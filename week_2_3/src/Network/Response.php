<?php

declare(strict_types=1);

namespace Network;

class Response
{
	/* curl handle */
	private $handle;

	private string $response;

	/**
	 * @param resource $handle Curl handle
	 */
	public function __construct(string $response, $handle)
	{
		$this->response = $response;
		$this->handle = $handle;
	}

	public function getResponse():string
	{
		return $this->response;
	}

	public function getJsonResponse():array
	{
		return json_decode($this->response, true);
	}

	public function getStatusCode():int
	{
		return curl_getinfo($this->handle, CURLINFO_HTTP_CODE);
	}
}
