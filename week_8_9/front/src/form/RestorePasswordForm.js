export default class RestorePasswordForm
{
	errors = {};

	set email(email)
	{
		if(email.indexOf("@") === -1)
			this.errors.email = "invalid_email";
	}
}
