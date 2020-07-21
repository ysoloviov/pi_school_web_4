import View from "/lib/View.js"

export default class HomeView extends View
{
	constructor(id, text, user)
	{
		super(id);
		this.container.textContent = text.home_page.content(user);
	}
}
