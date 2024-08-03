export default class Scroll_Section {
	static ITEM_DELAY = 0.15;
	static WINDOW_PERCENT_TRIGGER = 0.3;
	active = false;

	constructor(el) {
		this.container = el;
		this.items = this.container.querySelectorAll('[data-scroll-item]');

		[].forEach.call(this.items, (item, i) => {
			item.style.animationDelay = `${(i+1)*Scroll_Section.ITEM_DELAY}s`;
		});
	}

	isInView() {
		const rect = this.container.getBoundingClientRect();

		return (rect.top - window.innerHeight < -Scroll_Section.WINDOW_PERCENT_TRIGGER*window.innerHeight);
	}

	show() {
		this.active = true;
		this.container.classList.add('__scroll_active');

		[].forEach.call(this.items, (item, i) => {
			item.classList.add('__scroll_active');
		});
	}
}
