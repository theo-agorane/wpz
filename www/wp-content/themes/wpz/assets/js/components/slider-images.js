import Swiper from 'swiper';
import { Navigation, Scrollbar } from 'swiper/modules';

class Slider_Images {

	constructor(el) {
		this.container = el;
		this.containerSwiper = this.container.querySelector('.Slider_Images--swiper .swiper');
		this.containerThumbs = this.container.querySelector('.Slider_Images--thumbs .swiper');
		this.buttonPrev = this.container.querySelector('[data-action="prev"]');
		this.buttonNext = this.container.querySelector('[data-action="next"]');
		this.buttonLightbox = this.container.querySelectorAll('[data-action="lightbox"]');
		this.buttonClose = this.container.querySelectorAll('[data-action="close"]');
		this.wrapper = this.container.querySelector('.Slider_Images--wrapper');
		this.lightbox = this.container.querySelector('.Slider_Images--lightbox');

		[].forEach.call(this.buttonLightbox, (btn) => {
			btn.addEventListener('click', this.openLightbox.bind(this));
		});

		[].forEach.call(this.buttonClose, (btn) => {
			btn.addEventListener('click', this.closeLightbox.bind(this));
		});

		this.container.addEventListener('slider-images:open', this.openLightbox.bind(this));

		this.initSwiper();
	}

	initSwiper() {
		this.swiperThumbs = new Swiper(this.containerThumbs, {
			spaceBetween: 8,
			watchSlidesProgress: true,
			slidesPerView: 'auto',
			centerInsufficientSlides: true,
        	breakpoints: {
        		433:  {  },
        		577:  {  },
        		769:  {  },
        		1025: {  },
        		1281: {  },
        		1481: {  },
        	},
		});
		this.swiper = new Swiper(this.containerSwiper, {
			modules: [Navigation, Thumbs],
			navigation: {
				prevEl: this.buttonPrev,
				nextEl: this.buttonNext,
				disabledClass: '__disabled',
			},
			thumbs: {
				swiper: this.swiperThumbs,
			},
		});
	}

	openLightbox() {
		this.container.classList.add('__lightbox', '__active');
		this.bindedLightboxKeypress = this.lightboxKeypress.bind(this);
		document.addEventListener('keydown', this.bindedLightboxKeypress, true);
	}

	closeLightbox() {
		this.container.classList.remove('__lightbox', '__active');
		document.removeEventListener('keydown', this.bindedLightboxKeypress, true);
	}

	lightboxKeypress(e) {
		switch (e.code) {
			case 'ArrowLeft':
				e.preventDefault();
				this.swiper.slidePrev();
			break;
			case 'ArrowRight':
				e.preventDefault();
				this.swiper.slideNext();
			break;
			case 'Escape':
				e.preventDefault();
				this.closeLightbox();
			break;
		}
	}

}

[].forEach.call(document.querySelectorAll('.Slider_Images'), (el) => {
	new Slider_Images(el);
})