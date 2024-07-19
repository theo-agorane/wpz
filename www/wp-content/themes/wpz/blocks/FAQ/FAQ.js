import gsap from 'gsap';

const DURATION = 1.2;
const EASING = "power2.out";

const IS_TOUCH_DEVICE = ('ontouchstart' in window) || (navigator.maxTouchPoints > 0) || (navigator.msMaxTouchPoints > 0);

class FAQ {
	
	constructor(el) {
		this.el = el;
		this.wrapper = this.el.querySelector('.Block_FAQ--wrapper');
		this.items = this.el.querySelectorAll('.Block_FAQ--item');
		this.categories = this.el.querySelectorAll('.Block_FAQ--category');
		this.active = null;

		this.setEvents();
		this.handleLoadMore();
	}

	setEvents() {
		if (IS_TOUCH_DEVICE) {
			document.body.addEventListener('touchstart', (e) => {
				let item = null;

				if (e.target.classList.contains('Block_FAQ--item')) {
					item = e.target;
				}
				else if (e.target.closest('.Block_FAQ--item')) {
					item = e.target.closest('.Block_FAQ--item');
				}

				if (item) {
					this.setActive(item);
				}
				else {
					this.reset();
				}
			});
		}
		else {
			[].forEach.call(this.items, (item) => {
				item.addEventListener('click', this.toggleItem.bind(this));
			});
		}
	}

	toggleItem(e) {
		if (e.currentTarget.classList.contains('Block_FAQ--item--active')) {
			this.reset();
		}
		else {
			this.setActive(e.currentTarget);
		}
	}

	reset() {
		this.active = null;

		[].forEach.call(this.items, (item) => {
			item.classList.remove('Block_FAQ--item--active');
			item.querySelector('.Block_FAQ--item-answer').style.height = 0;
		})
	}

	setActive(active) {
		if (this.active != active) {
			this.active = active;

			[].forEach.call(this.items, (item) => {
				if (item == active) {
					item.classList.add('Block_FAQ--item--active');
					
					item.querySelector('.Block_FAQ--item-answer').style.height = item.querySelector('.Block_FAQ--item-answer-wrapper').offsetHeight + 'px';

				}
				else {
					item.classList.remove('Block_FAQ--item--active');
					item.querySelector('.Block_FAQ--item-answer').style.height = 0;
				}
			});
		}
	}

	handleLoadMore() {
		[].forEach.call(this.categories, (category) => {
			const items = category.querySelectorAll('.Block_FAQ--item');
			const loadMore = category.querySelector('.Block_FAQ--load-more');

			if (loadMore) {
				[].forEach.call(items, (item, i) => {
					if (i > 1) {
						item.classList.add('__hidden');
					}
				});

				loadMore.addEventListener('click', () => {
					loadMore.classList.add('__hidden');
					[].forEach.call(items, (item, i) => {
						item.classList.remove('__hidden');
					});
				});
			}
		});
	}

}

[].forEach.call(document.querySelectorAll('.Block_FAQ'), (el) => {
	new FAQ(el);
});