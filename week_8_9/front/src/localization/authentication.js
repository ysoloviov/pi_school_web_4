export default {
	en: {
		code: "en",
		lang: "English",
		contact_us: "Contact Us",
		email: "Email",
		login: "Log In",
		signup: "Sign Up",
		title: "Test auth page",
		password_verification: {
			password: "Password",
			restore_password_link: "Forgot password?",
			submit_button: "Log In",
		},
		mobile_verification: {
			title: "- OR -",
			info: "Sign in with your phone number. We will send you a 6-digit code to ensure that only you have access to your care team.",
			phone_number_placeholder: "Your phone number",
			submit_button: "Send verification code",
			success_message: "The verification code has been sent",
		},
		restore_password: {
			title: "Restore password",
			info: "Please enter your email address. We will send you a link to change the password.",
			submit_button: "Send",
			success_message: "The email was sent",
		},
		registration: {
			first_name: "First Name",
			last_name: "Last Name",
			password: (minLength) => `Password (min. ${minLength} characters)`,
			privacy_policy: "Privacy Policy",
			terms_of_use: "Terms of Use",
			terms_of_use_checkbox: (privacyPolicy, termsOfUse) => `I agree to ${privacyPolicy} & ${termsOfUse}`,
			submit_button: "Get Started!",
		},
		home_page: {
			title: "Home",
			content: user => `Hello, ${user}!`,
		},
		errors: {
			wrong_email: "Invalid email/password",
			wrong_password: "Invalid email/password",
			invalid_phone_number: "Invalid phone number",
			invalid_email: "Email should include @ sign",
			invalid_password: "Invalid password",
			invalid_name: "First Name should be minimum 1 character long",
			invalid_surname: "Last Name should be minimum 1 character long",
			terms_not_accepted: "You should accept terms of use",
			page_not_found: "Page not found",
			email_exists: "This email is already in use",
		},
	},
	ua: {
		code: "ua",
		lang: "Українська",
		contact_us: "Зв'яжіться з нами",
		email: "Електронна пошта",
		login: "Увійти",
		signup: "Зареєструватися",
		title: "Тестова сторінка аутентифікації",
		password_verification: {
			password: "Пароль",
			restore_password_link: "Забули пароль?",
			submit_button: "Увійти",
		},
		mobile_verification: {
			title: "- АБО -",
			info: "Увійдіть за допомогою свого номера телефону. Ми надішлемо вам 6-значний код, щоб переконатися, що тільки у вас є доступ до вашої команди з догляду.",
			phone_number_placeholder: "Ваш номер телефону",
			submit_button: "Надіслати код підтвердження",
			success_message: "Код підтвердження надіслано",
		},
		restore_password: {
			title: "Відновити пароль",
			info: "Введіть, будь ласка, свою електронну адресу. Ми надішлемо вам посилання для зміни пароля.",
			submit_button: "Надіслати",
			success_message: "Електронний лист надіслано",
		},
		registration: {
			first_name: "Ім'я",
			last_name: "Прізвище",
			password: (minLength) => `Пароль (мін. ${minLength} символів)`,
			privacy_policy: "Політикою конфіденційності",
			terms_of_use: "Умовами використання",
			terms_of_use_checkbox: (privacyPolicy, termsOfUse) => `Я погоджуюся з ${privacyPolicy} та ${termsOfUse}`,
			submit_button: "Почати!",
		},
		home_page: {
			title: "Домашня сторінка",
			content: user => `Привіт, ${user}!`,
		},
		errors: {
			wrong_email: "Недійсний електронний лист / пароль",
			wrong_password: "Недійсний електронний лист / пароль",
			invalid_phone_number: "Недійсний номер телефону",
			invalid_email: "Електронний лист повинен містити знак @",
			invalid_password: "Недійсний пароль",
			invalid_name: "Ім'я має бути не менше 1 символу",
			invalid_surname: "Прізвище має бути не менше 1 символу",
			terms_not_accepted: "Ви повинні прийняти умови використання",
			page_not_found: "Сторінку не знайдено",
			email_exists: "Ця адреса електронної пошти вже використовується",
		},
	},
};
