export default class PasswordVerificationForm
{
	errors = {};

	set email(email)
	{
		if(email !== "admin@gmail.com")
			this.errors.email = "wrong_email";
	}

	set password(password)
	{
		if(password !== "123567")
			this.errors.password = "wrong_password";
	}
}
