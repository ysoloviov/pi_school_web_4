import View from "/lib/View.js"

export default class ErrorView extends View
{
	constructor(id, error)
	{
		super(id);
		this.container.textContent = error;
	}
}
