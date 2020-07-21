import backend from "/lib/Backend.js"

export default class PasswordAuthenticationForm
{
	errors = {};
	successHandler;
	errorHandler;

	submit()
	{
		backend.post("/auth/password", {
			email: this.email,
			password: this.password,
		})
			.then(response => {
				this.successHandler(response);
			})
			.catch(e => {
				this.errors.email = "wrong_email";
				this.errorHandler(this.errors);
			});
	}
}
