import ErrorView from "/src/view/ErrorView.js"
import HomeView from "/src/view/HomeView.js"
import PasswordAuthenticationForm from "/src/form/PasswordAuthenticationForm.js"
import MobileAuthenticationForm from "/src/form/MobileAuthenticationForm.js"
import RestorePasswordForm from "/src/form/RestorePasswordForm.js"
import RegistrationForm from "/src/form/RegistrationForm.js"
import backend from "/lib/Backend.js"

export default class AuthenticationController
{
	name;
	surname;
	minPasswordLength = 6;
	phoneNumberLength = 10;
	loadUserInfoHandler;

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
		this.view.passwordAuthenticationFormHandler = this.actionPasswordAuthentication.bind(this);
		this.view.mobileAuthenticationFormHandler = this.actionMobileAuthentication.bind(this);
		this.setUserInfo();
	}

	actionChangeLanguage(code)
	{
		if(!this.localization[code])
			return;

		this.view.text = this.text = this.localization[code];
		this.view.render();
		window.document.title = this.text.title;
	}

	actionShowLoginForm()
	{
		if(this.name) {
			this.actionShowHomePage();

			return;
		}

		this.view.isLoginForm = true;
		this.view.render();
		history.pushState({}, this.text.login, "/auth/login");
	}

	actionShowRegistrationForm()
	{
		if(this.name) {
			this.actionShowHomePage();

			return;
		}

		this.view.isLoginForm = false;
		this.view.render();
		history.pushState({}, this.text.signup, "/auth/register");
	}

	actionPasswordAuthentication(email, password)
	{
		const form = new PasswordAuthenticationForm;
		form.email = email;
		form.password = password;
		form.successHandler = response => {
			this.name = response.data.name;
			this.surname = response.data.surname;
			this.actionShowHomePage();
		};
		form.errorHandler = errors => {
			this.view.passwordAuthenticationFormState.errors = errors;
			this.view.render();
		};
		form.submit();
	}

	actionMobileAuthentication(phone_number)
	{
		const form = new MobileAuthenticationForm(this.phoneNumberLength);
		form.phone_number = phone_number;
		this.view.mobileAuthenticationFormState.errors = form.errors;

		if(Object.keys(form.errors).length > 0) {
			this.view.render();

			return;
		}

		this.view.render();
		alert(this.text.mobile_verification.success_message);
	}

	actionRestorePassword(email)
	{
		const form = new RestorePasswordForm;
		form.email = email;
		this.view.restorePasswordFormState.errors = form.errors;

		if(Object.keys(form.errors).length > 0) {
			this.view.render();

			return;
		}

		this.view.isRestorePasswordForm = false;
		this.view.render();
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
		form.successHandler = response => {
			this.name = response.data.name;
			this.surname = response.data.surname;
			this.actionShowHomePage();
		};
		form.errorHandler = errors => {
			this.view.registrationFormState.errors = errors;
			this.view.render();
		};
		form.validate();
		form.submit();
	}

	actionShowErrorPage(error)
	{
		this.view.remove();
		const view = new ErrorView("error", error);
		view.render();
	}

	actionShowHomePage()
	{
		if(!this.name) {
			this.actionShowErrorPage(this.text.errors.page_not_found);

			return;
		}

		this.view.remove();
		history.pushState({}, this.text.home_page.title, "/home");
		const view = new HomeView("home", this.text, this.name + " " + this.surname);
		view.render();
	}

	setUserInfo()
	{
		backend.get("/auth/info")
			.then(response => {
				this.name = response.data.name;
				this.surname = response.data.surname;
			})
			.catch(e => {
			})
			.then(() => {
				this.loadUserInfoHandler();
			});
	}
}
