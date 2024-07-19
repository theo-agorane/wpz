class Form {
	
	constructor(el) {
		this.el = el;
	}

}

[].forEach.call(document.querySelectorAll('.Block_Form'), (el) => {
	new Form(el);
});