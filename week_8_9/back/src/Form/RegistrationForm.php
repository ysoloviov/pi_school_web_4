<?php

declare(strict_types=1);

namespace App\Form;

use App\Repository\UserRepository;
use App\Model\User;
use Http\Session;

class RegistrationForm
{
	const MIN_PASSWORD_LENGTH = 6;

	private Session $session;
	private UserRepository $users;
	private string $name;
	private string $surname;
	private string $email;
	private string $password;
	private string $terms;

	public function __construct(Session $session, UserRepository $users)
	{
		$this->session = $session;
		$this->users = $users;
	}

	public function setName(string $name):void
	{
		$this->name = trim($name);
	}

	public function setSurname(string $surname):void
	{
		$this->surname = trim($surname);
	}

	public function setEmail(string $email):void
	{
		$this->email = trim($email);
	}

	public function setPassword(string $password):void
	{
		$this->password = $password;
	}

	public function setTerms(string $terms):void
	{
		$this->terms = $terms;
	}

	public function isValid():bool
	{
		if($this->isLoggedIn())
			return false;

		if(empty($this->name) || empty($this->surname))
			return false;

		if(strpos($this->email, "@") === false)
			return false;

		if(strlen($this->password) < self::MIN_PASSWORD_LENGTH)
			return false;

		if(!$this->terms)
			return false;

		return true;
	}

	public function submit():?User
	{
		if($this->isEmailExist())
			return null;

		$encryptedPassword = password_hash($this->password, PASSWORD_BCRYPT);
		$user = new User;
		$user->setName($this->name);
		$user->setSurname($this->surname);
		$user->setEmail($this->email);
		$user->setPassword($encryptedPassword);
		$this->users->addUser($user);
		$this->session->set("user_id", (string) $user->getId());

		return $user;
	}

	private function isLoggedIn():bool
	{
		return $this->session->has("user_id");
	}

	private function isEmailExist():bool
	{
		return (bool) $this->users->getUserByEmail($this->email);
	}
}
