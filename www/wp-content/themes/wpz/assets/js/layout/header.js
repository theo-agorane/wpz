[].forEach.call(document.querySelectorAll('.Header'), (header) => {
	const headerMain = header.querySelector('.Header_Main');
	const menuToggle = header.querySelector('.Header_Main--toggle');
	const menuOverlay = header.querySelector('.Menu_Main--overlay');
	let isScrolledTrigger = false;
	let mainMenuOpen = false;

	const init = () => {
		window.addEventListener('scroll', onScrollUpdate);
		menuToggle.addEventListener('click', toggleMainMenu);
		menuOverlay.addEventListener('click', closeMainMenu);
		window.addEventListener('resize', updateHeaderHeightVariable);

		updateHeaderHeightVariable();
		onScrollUpdate();
		scrollToHashOnLoad();
	}

	const updateHeaderHeightVariable = () => {
		const root = document.querySelector(':root');
		root.style.setProperty('--wpz-header-height', `${headerMain.offsetHeight}px`);
	}

	const onScrollUpdate = () => {
		const scrollTop = document.querySelector('html').scrollTop;
		const scrollTrigger = 20;

		if (scrollTop > scrollTrigger && !isScrolledTrigger) {
			isScrolledTrigger = true;
			header.classList.add('__scrolled');
		}
		else if (scrollTop <= scrollTrigger && isScrolledTrigger) {
			isScrolledTrigger = false;
			header.classList.remove('__scrolled');
		}
	}

	const toggleMainMenu = () => {
		if (mainMenuOpen) {
			closeMainMenu();
		}
		else {
			openMainMenu();
		}
	}

	const closeMainMenu = () => {
		mainMenuOpen = false;
		header.classList.remove('__menu_main_open');

		if (window.innerWidth <= 768) {
			onScrollUpdate();
		}
	}

	const openMainMenu = () => {
		mainMenuOpen = true;
		header.classList.add('__menu_main_open');

		if (window.innerWidth <= 768) {
			isScrolledTrigger = true;
			header.classList.add('__scrolled');
		}
	}

	const scrollTo = (el) => {
		if (!el) return;

		const block = el.closest('.Block');

		let top = - document.body.getBoundingClientRect().top;
		top += (block) ? block.getBoundingClientRect().top : el.getBoundingClientRect().top;
		top -= headerMain.offsetHeight;

		window.scrollTo(0, top);
	}

	const scrollToHashOnLoad = () => {
		window.addEventListener('load', () => {
			setTimeout(() => {
				window.scrollTo(0, 0);
				if (window.location.hash && document.querySelector(window.location.hash)) {
					scrollTo(document.querySelector(window.location.hash));
				}
			}, 1);
		})
	}
	
	init();
});