// ------------------------------------------------------------
// Input Icon Field
// ------------------------------------------------------------
class WPZ_ACF_Field_Icon {
	
	constructor(field) {
		this.el = field.$el[0];
		this.input = this.el.querySelector('input');
		this.elValue = this.el.querySelector('.value');

		this.el.addEventListener('click', this.openSelector.bind(this));

		this.setValue(this.input.value);
	}

	openSelector() {
		acfIconSelector.open(this);
	}

	setValue(icon) {
		this.input.value = icon;

		if (icon) {
			this.elValue.innerHTML = '';
			
			const svg = acfIconSelector.createSvg(icon);
			this.elValue.appendChild(svg);

			const span = document.createElement('span');
			span.innerHTML = icon;
			this.elValue.appendChild(span);
		}
		else {
			this.elValue.innerHTML = '<span class="svg">-</span> <span>Aucun</span>';
		}
	}

}

// ------------------------------------------------------------
// Input Icon Field
// ------------------------------------------------------------
class WPZ_ACF_Field_Icon_Selector {

	constructor() {
		this.buildHtml();
		this.buildIcons();

		this.elOverlay.addEventListener('click', this.close.bind(this));
		this.inputSearch.addEventListener('input', this.updateSearch.bind(this));
		this.elClose.addEventListener('click', () => {
			this.selectIcon();
		});

		[].forEach.call(this.icons, (icon) => {
			icon.addEventListener('click', () => {
				this.selectIcon(icon.dataset.icon);
			});
		});
	}

	buildHtml() {
		this.el = document.createElement('div');
		this.el.classList.add('wpz-acf-icon-selector');
		document.body.appendChild(this.el);

		this.elOverlay = document.createElement('div');
		this.elOverlay.classList.add('overlay');
		this.el.appendChild(this.elOverlay);

		this.elWrapper = document.createElement('div');
		this.elWrapper.classList.add('wrapper');
		this.el.appendChild(this.elWrapper);

		this.elHeader = document.createElement('div');
		this.elHeader.classList.add('header');
		this.elWrapper.appendChild(this.elHeader);

		this.elSearch = document.createElement('div');
		this.elSearch.classList.add('search');
		this.elHeader.appendChild(this.elSearch);

		this.inputSearch = document.createElement('input');
		this.inputSearch.type = 'search';
		this.inputSearch.placeholder = 'Rechercher...';
		this.elSearch.appendChild(this.inputSearch);

		this.elClose = document.createElement('div');
		this.elClose.classList.add('close');
		this.elHeader.appendChild(this.elClose);

		this.elList = document.createElement('div');
		this.elList.classList.add('list');
		this.elWrapper.appendChild(this.elList);
	}

	createSvg(icon) {
		const iconPath = acfIconsSvg + '#' + icon;
		const svg = document.createElementNS("http://www.w3.org/2000/svg", "svg");
	    svg.setAttributeNS("http://www.w3.org/2000/xmlns/", "xmlns:xlink", "http://www.w3.org/1999/xlink");

		const use = document.createElementNS('http://www.w3.org/2000/svg', 'use');
		use.setAttributeNS('http://www.w3.org/1999/xlink', 'xlink:href', iconPath);
		svg.appendChild(use);

		return svg;
	}

	buildIcons() {
		[].forEach.call(acfIconsList, (icon) => {
			const el = document.createElement('div');
			el.classList.add('icon');
			el.dataset.icon = icon;

			const svg = this.createSvg(icon);
			el.appendChild(svg);

			this.elList.appendChild(el);
		});

		this.icons = this.elList.querySelectorAll('.icon');
	}

	updateSearch() {
		[].forEach.call(this.icons, (icon) => {
			if (this.inputSearch.value == '' || icon.dataset.icon.indexOf(this.inputSearch.value.toLowerCase()) > -1) {
				icon.classList.remove('__hidden');
			}
			else {
				icon.classList.add('__hidden');
			}
		});
	}

	setActive(value) {
		[].forEach.call(this.icons, (icon) => {
			if (value && value == icon.dataset.icon) {
				icon.classList.add('__active');
			}
			else {
				icon.classList.remove('__active');
			}
		});
	}

	selectIcon(icon = '') {
		if (this.field) {
			this.field.setValue(icon);
			this.close();
		}
	}

	open(field) {
		this.field = field;
		this.setActive(field.input.value);

		this.inputSearch.value = '';
		this.updateSearch();

		this.el.classList.add('__open');
		this.bindedKeypress = this.onKeypress.bind(this);
		document.addEventListener('keydown', this.bindedKeypress, true);
	}

	close() {
		this.el.classList.remove('__open');
		document.removeEventListener('keydown', this.bindedKeypress, true);
	}

	onKeypress(e) {
		if (e.code == 'Escape') {
			e.preventDefault();
			this.close();
		}
	}

}

// ------------------------------------------------------------
// ACF instanciation
// ------------------------------------------------------------

(function($) {
    if (typeof acf == 'undefined') return;

    function initialize_field(field) {
    	if (!window.acfIconSelector) {
		    window.acfIconSelector = new WPZ_ACF_Field_Icon_Selector();
    	}

        new WPZ_ACF_Field_Icon(field);
    }
  
    if (typeof acf.addAction !== 'undefined') {
        acf.addAction('ready_field/type=wpz-acf-field-icon', initialize_field);
        acf.addAction('append_field/type=wpz-acf-field-icon', initialize_field);
    }
    else {
        $(document).on('acf/setup_fields', function(e, postbox) {
            $(postbox).find('.field[data-field_type="wpz-acf-field-icon"]').each(function() {
                initialize_field($(this));
            });
        });
    }
})(jQuery);
