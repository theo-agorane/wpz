class BlockKey {
	
	constructor(el) {
		this.el = el;
	}

}

[].forEach.call(document.querySelectorAll('.Block_BlockKey'), (el) => {
	new BlockKey(el);
});