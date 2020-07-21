import View from "/lib/View.js"

export default class AuthenticationView extends View
{
	minPasswordLength;
	localization;
	text;

	/* nav */
	isLoginForm = true;
	isRestorePasswordForm = false;
	navActiveClass = "nav-item__active";

	/* handlers */
	changeLanguageHandler;
	navLoginButtonHandler;
	navRegistrationButtonHandler;
	passwordAuthenticationFormHandler;
	mobileAuthenticationFormHandler;
	registrationFormHandler;
	restorePasswordFormHandler;

	/* form state */
	passwordAuthenticationFormState = {input: {}, errors: {}};
	mobileAuthenticationFormState = {input: {}, errors: {}};
	registrationFormState = {input: {}, errors: {}};
	restorePasswordFormState = {input: {}, errors: {}};

	constructor(id)
	{
		super(id);
		const image = this.createImage("/img/bg.jpg", "image");
		this.aside = this.createElement("aside", "aside");
		this.container.append(image, this.aside);
	}

	render()
	{
		if(!this.isRendered)
			super.render();

		const header = this.createHeader();
		const nav = this.createNavigation();
		const content = this.createElement("div", "content");
		const footer = this.createFooter();

		if(this.isLoginForm) {
			const passwordAuthenticationForm = this.createPasswordAuthenticationForm();
			const mobileAuthenticationForm = this.createMobileAuthenticationForm();
			content.append(passwordAuthenticationForm, mobileAuthenticationForm);
		}
		else {
			const registrationForm = this.createRegistrationForm();
			content.append(registrationForm);
		}

		this.aside.innerHTML = "";
		this.aside.append(header, nav, content, footer);

		if(this.isRestorePasswordForm) {
			const restorePasswordPopup = this.createRestorePasswordPopup();
			this.aside.append(restorePasswordPopup.before, restorePasswordPopup);
		}
	}

	createHeader()
	{
		const header = this.createElement("div", "header");
		const lang = this.createList("lang");
		const title = this.createElement("h1", "title", this.text.title);
		lang.addEventListener("change", e => {
			this.changeLanguageHandler(e.target.value);
		});

		for(const code in this.localization) {
			const option = this.createListItem(code, this.localization[code].lang);
			lang.append(option);

			if(code === this.text.code)
				option.selected = true;
		}

		header.append(lang, title);

		return header;
	}

	createNavigation()
	{
		const nav = this.createElement("ul", "nav");
		const loginButton = this.createElement("li", "nav-item", this.text.login);
		const registrationButton = this.createElement("li", "nav-item", this.text.signup);
		const activeButton = this.isLoginForm ? loginButton : registrationButton;
		loginButton.addEventListener("click", e => {
			if(!this.isLoginForm)
				this.navLoginButtonHandler();
		});
		registrationButton.addEventListener("click", e => {
			if(this.isLoginForm)
				this.navRegistrationButtonHandler();
		});
		activeButton.classList.add(this.id + "-" + this.navActiveClass);
		nav.append(registrationButton, loginButton);

		return nav;
	}

	createFooter()
	{
		const footer = this.createElement("div", "footer");
		const link = this.createLink("#", this.text.contact_us, "link-contact");
		footer.append(link);

		return footer;
	}

	createPasswordAuthenticationForm()
	{
		const form = this.createForm();
		const state = this.passwordAuthenticationFormState;
		const passwordLabel = this.createFormLabel("password", this.text.password_verification.password);
		const restorePasswordLink = this.createLink("#", this.text.password_verification.restore_password_link);
		restorePasswordLink.addEventListener("click", e => {
			e.preventDefault();
			this.isRestorePasswordForm = true;
			this.render();
		});
		passwordLabel.append(restorePasswordLink);
		form.append(
			this.createFormLabel("email", this.text.email),
			this.createFormTextInput("email", "email", state.input.email, null),
			passwordLabel,
			this.createFormTextInput("password", "password", state.input.password, null),
			this.createLocalizedFormError(state.errors.email ?? state.errors.password),
			this.createFormSubmitButton(this.text.password_verification.submit_button),
		);
		this.setFormInputListeners(form, state.input);
		this.setFormHandler(form, input => {
			this.passwordAuthenticationFormHandler(
				input.email.value,
				input.password.value,
			);
		});

		return form;
	}

	createMobileAuthenticationForm()
	{
		const form = this.createForm();
		const state = this.mobileAuthenticationFormState;
		form.append(
			this.createElement("span", "mobile_verification-title",
				this.text.mobile_verification.title),
			this.createElement("p", "text", this.text.mobile_verification.info),
			this.createFormTextInput("text", "phone_number", state.input.phone_number,
				null, this.text.mobile_verification.phone_number_placeholder),
			this.createLocalizedFormError(state.errors.phone_number),
			this.createFormSubmitButton(this.text.mobile_verification.submit_button),
		);
		this.setFormInputListeners(form, state.input);
		this.setFormHandler(form, input => {
			this.mobileAuthenticationFormHandler(input.phone_number.value);
		});

		return form;
	}

	createRestorePasswordForm()
	{
		const form = this.createForm();
		const state = this.restorePasswordFormState;
		const id = "restore_password-";
		form.append(
			this.createParagraph(this.text.restore_password.info),
			this.createFormLabel(id + "email", this.text.email),
			this.createFormTextInput("email", "email", state.input.email, id + "email"),
			this.createLocalizedFormError(state.errors.email),
			this.createFormSubmitButton(this.text.restore_password.submit_button),
		);
		this.setFormInputListeners(form, state.input);
		this.setFormHandler(form, input => {
			this.restorePasswordFormHandler(
				input.email.value,
			);
		});

		return form;
	}

	createRegistrationForm()
	{
		const form = this.createForm();
		const state = this.registrationFormState;
		const terms = this.createElement("div", "terms");
		const termsContent = this.text.registration.terms_of_use_checkbox(
			this.createLink("#", this.text.registration.privacy_policy).outerHTML,
			this.createLink("#", this.text.registration.terms_of_use).outerHTML,
		);
		terms.append(
			this.createFormCheckbox("terms", state.input.terms, null, "terms-checkbox"),
			this.createFormLabel("terms", termsContent),
		);
		form.append(
			this.createFormLabel("name", this.text.registration.first_name),
			this.createFormStateTextInput("text", "name", state),
			this.createLocalizedFormError(state.errors.name),
			this.createFormLabel("surname", this.text.registration.last_name),
			this.createFormStateTextInput("text", "surname", state),
			this.createLocalizedFormError(state.errors.surname),
			this.createFormLabel("email", this.text.email),
			this.createFormStateTextInput("email", "email", state),
			this.createLocalizedFormError(state.errors.email),
			this.createFormLabel("password", this.text.registration.password(this.minPasswordLength)),
			this.createFormStateTextInput("password", "password", state),
			this.createLocalizedFormError(state.errors.password),
			terms,
			this.createLocalizedFormError(state.errors.terms),
			this.createFormSubmitButton(this.text.registration.submit_button),
		);
		this.setFormInputListeners(form, state.input);
		this.setFormHandler(form, input => {
			this.registrationFormHandler(
				input.name.value,
				input.surname.value,
				input.email.value,
				input.password.value,
				input.terms.checked,
			);
		});

		return form;
	}

	createRestorePasswordPopup()
	{
		const popup = this.createPopup(this.text.restore_password.title, e => {
			this.isRestorePasswordForm = 0;
		});
		const form = this.createRestorePasswordForm();
		popup.append(form);

		return popup;
	}

	createFormStateTextInput(type, name, state, id, placeholder, classNames = "")
	{
		if(state.errors[name])
			classNames += " form-input-error";

		return this.createFormTextInput(type, name, state.input[name], id,
			placeholder, classNames);
	}

	createLocalizedFormError(key, classNames = "")
	{
		if(!key)
			return "";

		return this.createFormError(this.text.errors[key], classNames);
	}

	setFormHandler(form, handler)
	{
		form.addEventListener("submit", e => {
			e.preventDefault();
			handler(e.target.elements);
		});
	}

	setFormInputListeners(form, storage)
	{
		for(const e of form.elements) {
			e.addEventListener("change", event => {
				storage[e.name] = e.type === "checkbox" ? e.checked : e.value;
			});
		}
	}
}
