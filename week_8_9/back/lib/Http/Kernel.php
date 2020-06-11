<?php

declare(strict_types=1);

namespace Http;

class Kernel
{
	private ControllerResolverInterface $controllerResolver;
	private ArgumentResolverInterface $argumentResolver;

	public function __construct(ControllerResolverInterface $controllerResolver,
		ArgumentResolverInterface $argumentResolver)
	{
		$this->controllerResolver = $controllerResolver;
		$this->argumentResolver = $argumentResolver;
	}

	public function handle(Request $request):Response
	{
		$controller = $this->controllerResolver->getController();

		if(!$controller)
			return new Response("", Response::HTTP_NOT_FOUND);

		$args = $this->argumentResolver->getArguments($controller);
		$response = $controller(...$args);

		return $response;
	}
}
