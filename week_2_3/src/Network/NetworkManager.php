<?php

declare(strict_types=1);

namespace Network;

class NetworkManager
{
	/*
	 * Returns GET Request.
	 */
	public function getRequest(string $url, array $params = []):Request
	{
		if(count($params))
			$url .= "?" . http_build_query($params);

		$options = [
			CURLOPT_URL => $url,
		];

		return new Request($options);
	}

	/*
	 * Returns POST Request.
	 */
	public function getPostRequest(string $url, array $params = []):Request
	{
		$options = [
			CURLOPT_URL => $url,
			CURLOPT_POST => 1,
			CURLOPT_POSTFIELDS => $params,
		];

		return new Request($options);
	}
}
