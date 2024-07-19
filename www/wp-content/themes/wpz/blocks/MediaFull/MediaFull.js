class MediaFull {
	
	constructor(el) {
		this.el = el;
	}

}

[].forEach.call(document.querySelectorAll('.Block_MediaFull'), (el) => {
	new MediaFull(el);
});