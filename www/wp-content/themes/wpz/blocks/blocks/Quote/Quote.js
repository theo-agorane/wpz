class Quote {
	
	constructor(el) {
		this.el = el;
	}

}

[].forEach.call(document.querySelectorAll('.Block_Quote'), (el) => {
	new Quote(el);
});