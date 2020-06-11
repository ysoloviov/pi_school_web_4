import backend from "/lib/Backend.js"

export default class RegistrationForm
{
	errors = {};
	successHandler;
	errorHandler;

	constructor(minPasswordLength)
	{
		this.minPasswordLength = minPasswordLength;
	}

	validate()
	{
		if(this.name.length < 1)
			this.errors.name = "invalid_name";
		if(this.surname.length < 1)
			this.errors.surname = "invalid_surname";
		if(this.email.indexOf("@") === -1)
			this.errors.email = "invalid_email";
		if(this.password.length < this.minPasswordLength)
			this.errors.password = "invalid_password";
		if(!this.terms)
			this.errors.terms = "terms_not_accepted";
	}

	submit()
	{
		if(Object.keys(this.errors).length > 0) {
			this.errorHandler(this.errors);

			return;
		}

		backend.post("/register", {
			name: this.name,
			surname: this.surname,
			email: this.email,
			password: this.password,
			terms: this.terms,
		})
			.then(response => {
				this.successHandler(response);
			})
			.catch(e => {
				this.errors.email = "email_exists";
				this.errorHandler(this.errors);
			});
	}
}
