<?php

declare(strict_types=1);

namespace App\Form;

use App\Repository\UserRepository;
use App\Model\User;
use Http\Session;

class PasswordAuthenticationForm
{
	private Session $session;
	private UserRepository $users;
	private string $email;
	private string $password;

	public function __construct(Session $session, UserRepository $users)
	{
		$this->session = $session;
		$this->users = $users;
	}

	public function setEmail(string $email):void
	{
		$this->email = $email;
	}

	public function setPassword(string $password):void
	{
		$this->password = $password;
	}

	public function isValid():bool
	{
		return !$this->isLoggedIn();
	}

	public function submit():?User
	{
		$user = $this->users->getUserByEmail($this->email);

		if(!$user || !password_verify($this->password, $user->getPassword()))
			return null;

		$this->session->set("user_id", (string) $user->getId());

		return $user;
	}

	private function isLoggedIn():bool
	{
		return $this->session->has("user_id");
	}
}
