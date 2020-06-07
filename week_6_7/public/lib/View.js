export default class View
{
	constructor(id)
	{
		this.id = id;
		this.container = this.createElement("div");
		this.container.id = id;
	}

	createElement(node, classNames, html)
	{
		const elem = document.createElement(node);

		if(classNames) {
			classNames
				.split(" ")
				.filter(name => name !== "")
				.forEach(c => elem.classList.add(this.id + "-" + c));
		}

		if(html)
			elem.innerHTML = html;

		return elem;
	}

	createForm(classNames = "")
	{
		const elem = this.createElement("form", "form " + classNames);

		return elem;
	}

	createFormLabel(id, html)
	{
		const elem = this.createElement("div", "form-label");
		const label = this.createElement("label");
		label.innerHTML = html;
		label.htmlFor = this.id + "-form-" + id;
		elem.append(label);

		return elem;
	}

	createFormInput(type, name, id, classNames = "")
	{
		const input = this.createElement("input", "form-input " + classNames);
		input.type = type;
		input.name = name;
		input.id = this.id + "-form-" + (id ?? name);
		input.required = 1;

		return input;
	}

	createFormCheckbox(name, checked, id, classNames = "")
	{
		const checkbox = this.createFormInput("checkbox", name, id, classNames);

		if(checked)
			checkbox.checked = checked;

		return checkbox;
	}

	createFormTextInput(type, name, value, id, placeholder, classNames = "")
	{
		const input = this.createFormInput(type, name, id, classNames);

		if(typeof value !== "undefined")
			input.value = value;

		if(typeof placeholder !== "undefined")
			input.placeholder = placeholder;

		return input;
	}

	createFormSubmitButton(text, classNames = "")
	{
		const button = this.createElement("button", "form-submit " + classNames, text);
		button.type = "submit";

		return button;
	}

	createFormError(error, classNames = "")
	{
		const elem = this.createElement("div", "form-error " + classNames, error);

		return elem;
	}

	createLink(url, text, classNames = "")
	{
		const elem = this.createElement("a", "link " + classNames);
		elem.href = url;
		elem.textContent = text;

		return elem;
	}

	createPopup(title, closeHandler, classNames = "")
	{
		const overlay = this.createElement("div", "overlay");
		const popup = this.createElement("div", "popup " + classNames);
		const header = this.createElement("header", "popup-header");
		const h6 = this.createElement("h6", "popup-title", title);
		const closeButton = this.createElement("span", "popup-close", "x");
		closeButton.addEventListener("click", e => {
			if(closeHandler)
				closeHandler();

			overlay.remove();
			popup.remove();
		});
		header.append(h6, closeButton);
		popup.append(header);
		popup.before = overlay;

		return popup;
	}

	createList(classNames = "")
	{
		const elem = this.createElement("select", "list " + classNames);

		return elem;
	}

	createListItem(value, text, classNames = "")
	{
		const elem = this.createElement("option", "list-item " + classNames, text);
		elem.value = value;

		return elem;
	}

	createParagraph(text, classNames = "")
	{
		const elem = this.createElement("p", classNames, text);

		return elem;
	}

	createImage(src, classNames = "")
	{
		const elem = this.createElement("img", classNames);
		elem.src = src;

		return elem;
	}

	render()
	{
		document.body.append(this.container);
	}

	remove()
	{
		this.container.remove();
	}
}
