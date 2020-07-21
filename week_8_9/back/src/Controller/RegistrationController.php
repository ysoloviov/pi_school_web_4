<?php

declare(strict_types=1);

namespace App\Controller;

use App\Form\RegistrationForm;
use Http\Request;
use Http\Response;
use Http\JsonResponse;

class RegistrationController
{
	public function __invoke(Request $request, RegistrationForm $form):Response
	{
		$form->setName($request->get("name"));
		$form->setSurname($request->get("surname"));
		$form->setEmail($request->get("email"));
		$form->setPassword($request->get("password"));
		$form->setTerms($request->get("terms"));

		if(!$form->isValid())
			return new Response("", Response::HTTP_BAD_REQUEST);

		$user = $form->submit();

		if(!$user)
			return new Response("", Response::HTTP_CONFLICT);

		return new JsonResponse($user->getFullNameAsArray());
	}
}
