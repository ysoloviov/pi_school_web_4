export default class RegistrationForm
{
	errors = {};

	constructor(minPasswordLength)
	{
		this.minPasswordLength = minPasswordLength;
	}

	set name(name)
	{
		if(name.length < 1)
			this.errors.name = "invalid_name";
	}

	set surname(surname)
	{
		if(surname.length < 1)
			this.errors.surname = "invalid_surname";
	}

	set email(email)
	{
		if(email.indexOf("@") === -1)
			this.errors.email = "invalid_email";
	}

	set password(password)
	{
		if(password.length < this.minPasswordLength)
			this.errors.password = "invalid_password";
	}

	set terms(terms)
	{
		if(!terms)
			this.errors.terms = "terms_not_accepted";
	}
}
