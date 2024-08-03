import Lenis from 'lenis';
import Scroll_Section from './scroll-section.js';

class Scroll_Animate {

	constructor() {
		this.lenis = new Lenis({
			touchMultiplier: 0, // Disable on mobile
		});
		this.initSections();

		this.lenis.on('scroll', this.onScroll.bind(this));
		requestAnimationFrame(this.raf.bind(this));

		window.addEventListener('load', this.onScroll.bind(this));
	}

	initSections() {
		this.scrollSections = [];
		[].forEach.call(document.querySelectorAll('[data-scroll-section]'), (el) => {
			this.scrollSections.push(new Scroll_Section(el));
		});
	}

	onScroll(e) {
		this.scrollSections.forEach((section) => {
			if (!section.active && section.isInView()) {
				section.show();
			}
		});
	}

	raf(time) {
		this.lenis.raf(time);
		requestAnimationFrame(this.raf.bind(this));
	}

}

new Scroll_Animate();
