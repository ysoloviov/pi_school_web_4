<?php

declare(strict_types=1);

namespace Network;

use Network\Exception\NetworkException;

class Request
{
	/* curl handle */
	private $handle;

	/* default options */
	private array $options = [
		CURLOPT_RETURNTRANSFER => true
	];

	public function __construct(array $options)
	{
		/* override default options */
		foreach($options as $key => $option)
			$this->options[$key] = $option;

		$this->handle = curl_init();
		curl_setopt_array($this->handle, $this->options);
	}

	public function __destruct()
	{
		curl_close($this->handle);
	}

	/**
	 * Returns response of a request.
	 *
	 * @throws NetworkException
	 */
	public function send():Response
	{
		$response = curl_exec($this->handle);

		if(!is_string($response))
			throw new NetworkException(curl_error($this->handle));

		return new Response($response, $this->handle);
	}
}
