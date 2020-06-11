<?php

declare(strict_types=1);

namespace App\Controller\Authentication;

use App\Form\PasswordAuthenticationForm;
use Http\Request;
use Http\Session;
use Http\Response;
use Http\JsonResponse;

class PasswordAuthenticationController
{
	public function __invoke(Request $request, PasswordAuthenticationForm $form):Response
	{
		$form->setEmail($request->get("email"));
		$form->setPassword($request->get("password"));

		if(!$form->isValid())
			return new Response("", Response::HTTP_BAD_REQUEST);

		$user = $form->submit();

		if(!$user)
			return new Response("", Response::HTTP_UNAUTHORIZED);

		return new JsonResponse($user->getFullNameAsArray());
	}
}
