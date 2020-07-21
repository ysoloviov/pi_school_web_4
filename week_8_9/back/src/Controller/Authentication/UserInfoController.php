<?php

declare(strict_types=1);

namespace App\Controller\Authentication;

use App\Repository\UserRepository;
use Http\Session;
use Http\Response;
use Http\JsonResponse;

class UserInfoController
{
	public function __invoke(Session $session, UserRepository $users):Response
	{
		if(!$session->get("user_id"))
			return new Response("", Response::HTTP_UNAUTHORIZED);

		$user = $users->getUserById((int) $session->get("user_id"));

		if(!$user)
			return new Response("", Response::HTTP_NOT_FOUND);

		return new JsonResponse($user->getFullNameAsArray());
	}
}
