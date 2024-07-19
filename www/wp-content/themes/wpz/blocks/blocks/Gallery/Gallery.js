class Gallery {
	
	constructor(el) {
		this.el = el;
		this.lightbox = this.el.querySelector('.Slider_Images');
		this.items = this.el.querySelectorAll('.Block_Gallery--item');

		if (this.lightbox) {
			[].forEach.call(this.items, (item) => {
				item.addEventListener('click', (e) => {
					e.preventDefault();

					const swiper = this.lightbox.querySelector('.swiper').swiper;
					const index = Array.prototype.indexOf.call(this.items, item);
					const event = new Event('slider-images:open');
					
					swiper && swiper.slideTo(index, 0);

					this.lightbox.dispatchEvent(event);
				});
			});
		}
	}

}

[].forEach.call(document.querySelectorAll('.Block_Gallery'), (el) => {
	new Gallery(el);
});