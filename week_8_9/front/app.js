import localization from "/src/localization/authentication.js"
import AuthenticationController from "/src/controller/AuthenticationController.js"
import AuthenticationView from "/src/view/AuthenticationView.js"

/* init application */
const view = new AuthenticationView("auth");
const text = localization.en;
const app = new AuthenticationController(
	view,
	localization,
	text,
);

/* straightforward routing */
const path = window.location.pathname;
app.loadUserInfoHandler = () => {
	if(path === "/" || path === "/auth/login")
		app.actionShowLoginForm();
	else if(path === "/auth/register")
		app.actionShowRegistrationForm();
	else if(path === "/home")
		app.actionShowHomePage();
};
