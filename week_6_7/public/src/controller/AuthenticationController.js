import ErrorView from "/src/view/ErrorView.js"
import HomeView from "/src/view/HomeView.js"
import PasswordVerificationForm from "/src/model/PasswordVerificationForm.js"
import MobileVerificationForm from "/src/model/MobileVerificationForm.js"
import RestorePasswordForm from "/src/model/RestorePasswordForm.js"
import RegistrationForm from "/src/model/RegistrationForm.js"

export default class AuthenticationController
{
	minPasswordLength = 6;
	phoneNumberLength = 10;

	constructor(view, localization, text)
	{
		this.view = view;
		this.view.localization = this.localization = localization;
		this.view.text = this.text = text;
		this.view.minPasswordLength = this.minPasswordLength;
		window.document.title = this.text.title;

		/* register handlers */
		this.view.changeLanguageHandler = this.actionChangeLanguage.bind(this);
		this.view.navLoginButtonHandler = this.actionShowLoginForm.bind(this);
		this.view.navRegistrationButtonHandler = this.actionShowRegistrationForm.bind(this);
		this.view.registrationFormHandler = this.actionRegister.bind(this);
		this.view.restorePasswordFormHandler = this.actionRestorePassword.bind(this);
		this.view.passwordVerificationFormHandler = this.actionPasswordVerification.bind(this);
		this.view.mobileVerificationFormHandler = this.actionMobileVerification.bind(this);
		this.view.render();
	}

	actionChangeLanguage(code)
	{
		if(!this.localization[code])
			return;

		this.view.text = this.text = this.localization[code];
		this.view.update();
		window.document.title = this.text.title;
	}

	actionShowLoginForm()
	{
		this.view.isLoginForm = true;
		this.view.update();
		history.pushState({}, this.text.login, "/auth/login");
	}

	actionShowRegistrationForm()
	{
		this.view.isLoginForm = false;
		this.view.update();
		history.pushState({}, this.text.signup, "/auth/register");
	}

	actionPasswordVerification(email, password)
	{
		const form = new PasswordVerificationForm;
		form.email = email;
		form.password = password;
		this.view.passwordVerificationFormState.errors = form.errors;

		if(Object.keys(form.errors).length > 0)
			this.view.update();
		else
			this.actionShowHomePage(email);
	}

	actionMobileVerification(phone_number)
	{
		const form = new MobileVerificationForm(this.phoneNumberLength);
		form.phone_number = phone_number;
		this.view.mobileVerificationFormState.errors = form.errors;

		if(Object.keys(form.errors).length > 0) {
			this.view.update();

			return;
		}

		this.view.update();
		alert(this.text.mobile_verification.success_message);
	}

	actionRestorePassword(email)
	{
		const form = new RestorePasswordForm;
		form.email = email;
		this.view.restorePasswordFormState.errors = form.errors;

		if(Object.keys(form.errors).length > 0) {
			this.view.update();

			return;
		}

		this.view.isRestorePasswordForm = false;
		this.view.update();
		alert(this.text.restore_password.success_message);
	}

	actionRegister(name, surname, email, password, terms)
	{
		const form = new RegistrationForm(this.minPasswordLength);
		form.name = name;
		form.surname = surname;
		form.email = email;
		form.password = password;
		form.terms = terms;
		this.view.registrationFormState.errors = form.errors;

		if(Object.keys(form.errors).length > 0)
			this.view.update();
		else
			this.actionShowHomePage(name + " " + surname);
	}

	actionShowErrorPage(error)
	{
		this.view.remove();
		const view = new ErrorView("error", error);
		view.render();
	}

	actionShowHomePage(user)
	{
		this.view.remove();
		history.pushState({}, this.text.home_page.title, "/home");
		const view = new HomeView("home", this.text, user);
		view.render();
	}
}
