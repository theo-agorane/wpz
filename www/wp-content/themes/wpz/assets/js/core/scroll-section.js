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
		this.container.addEventListener('animationend', this.afterAnimation.bind(this));

		[].forEach.call(this.items, (item, i) => {
			item.classList.add('__scroll_active');
			item.addEventListener('animationend', this.afterAnimation.bind(this));
		});
	}

	afterAnimation(e) {
		e.currentTarget.removeAttribute('data-scroll-item');
		e.currentTarget.removeAttribute('data-scroll-section');
		e.currentTarget.style.animationDelay = '';
		e.currentTarget.classList.remove('__scroll_active');
	}
}
