import Swiper, { Navigation, Scrollbar } from 'swiper';

class Features {
	
	constructor(el) {
		this.container = el;
        this.swiperContainer = this.container.querySelector('.swiper');
        this.scrollbar = this.container.querySelector('.swiper-navigation-scrollbar');
        this.prev = this.container.querySelector('.swiper-navigation-prev');
        this.next = this.container.querySelector('.swiper-navigation-next');
        this.slides = this.container.querySelectorAll('.swiper-slide');

        this.swiper = new Swiper(this.swiperContainer, {
			modules: [Navigation, Scrollbar],
			slidesPerView: 2,
			spaceBetween: 24,
			centerInsufficientSlides: true,
        	breakpoints: {
        		433:  { slidesPerView: Math.min(2, this.slides.length) },
        		577:  { slidesPerView: Math.min(3, this.slides.length), },
        		769:  { slidesPerView: Math.min(3, this.slides.length), },
        		1025: { slidesPerView: Math.max(3, Math.min(5, this.slides.length)), },
        		1281: { slidesPerView: Math.max(3, Math.min(5, this.slides.length)), spaceBetween: 32, },
        		1481: { slidesPerView: Math.max(3, Math.min(5, this.slides.length)), spaceBetween: 32, },
        	},
        	scrollbar: {
        		el: this.scrollbar,
        		draggable: true,
        		snapOnRelease: true,
        	},
        	navigation: {
        		prevEl: this.prev,
        		nextEl: this.next,
        	}
        });
	}

}

[].forEach.call(document.querySelectorAll('.Block_Features'), (el) => {
	new Features(el);
});