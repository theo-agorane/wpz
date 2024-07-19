class Columns {
	
	constructor(el) {
		this.el = el;
	}

}

[].forEach.call(document.querySelectorAll('.Block_Columns'), (el) => {
	new Columns(el);
});