<?php

declare(strict_types=1);

namespace Http;

class JsonResponse extends Response
{
	public function __construct(array $response, int $statusCode = self::HTTP_OK)
	{
		parent::__construct(json_encode($response), $statusCode);
		$this->setContentTypeHeader("application/json");
	}
}
