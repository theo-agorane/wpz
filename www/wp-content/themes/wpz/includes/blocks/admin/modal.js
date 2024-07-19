(function($) {
	if (typeof acf === 'undefined') return;

	class FlexibleLayoutModal {

		modals = [];

		constructor() {
			acf.addAction('load_field/type=flexible_content', this.onLoadField.bind(this));
			acf.addAction('after_duplicate', this.onAfterDuplicate.bind(this));
			acf.addAction('append', this.onAppend.bind(this));
			acf.addAction('invalid_field', this.onInvalidField.bind(this));
			acf.addAction('valid_field', this.onValidField.bind(this));

			$(document).keyup(((e) => {
				if (e.keyCode == 27 && $('body').hasClass('acf-modal-open')) {
					this.close();
				}
			}).bind(this));
		}

		// ------------------------------------------------------------
		// Actions
		// ------------------------------------------------------------
		onLoadField(field) {
			field.$el.find('.acf-flexible-content:first > .values > .layout:not(.fc-modal)').each(((i, el) => {
				this.addModal($(el));
			}).bind(this));

			field.$el.find('.button[data-name="add-layout"]').on('click', this.openAddLayoutModal.bind(this));
		}

		onAfterDuplicate($clone, $el) {
			if ($el.is('.layout')) {
				this.addModal($el, $el.hasClass('fc-modal'));
			}
		}

		onAppend($el) {
			if ($el.is('.layout')) {
				$el.find('> .acf-fc-layout-controls a.-pencil').trigger('click');
			}
		}

		onInvalidField(field) {
			this.invalidField(field.$el);
		}

		onValidField(field) {
			this.validField(field.$el);
		}

		// ------------------------------------------------------------
		// Functions
		// ------------------------------------------------------------
		addModal($layout, duplicate) {
			$layout.addClass('fc-modal');
			$layout.removeClass('-collapsed');
			
			$layout.find('> .acf-fc-layout-handle').off('click');
			$layout.find('> .acf-fc-layout-controls > a.-collapse').remove();
			
			$layout.find('> .acf-fc-layout-handle').on('click', this.open.bind(this));
			$layout.find('> .acf-fc-layout-controls > a[data-name="add-layout"]').on('click', this.openAddLayoutModal.bind(this));

			if (!duplicate) {
				var edit = $('<a class="acf-icon -pencil small light" href="#" data-event="edit-layout" title="Edit layout" />');
				edit.on('click', this.open.bind(this));
				$layout.find('> .acf-fc-layout-controls').append(edit);
				
				$layout.prepend('<div class="acf-fc-modal-title" />');			
				$layout.find('> .acf-fields, > .acf-table').wrapAll('<div class="acf-fc-modal-content" />');
			}
			else {
				$layout.find('[data-event="edit-layout"]').on('click', this.open.bind(this));
			}
		}

		open(e) {
			var $layout = $(e.currentTarget).parents('.layout:first');
			
			var caption = $layout.find('> .acf-fc-layout-handle').html();
			var a = $('<a class="dashicons dashicons-no -cancel" />').on('click', this.close.bind(this));
			
			$layout.find('> .acf-fc-modal-title').html(caption).append(a);
			$layout.addClass('-modal');
			
			this.modals.push($layout);
			
			this.overlay(true);
		}

		close() {
			var $layout = this.modals.pop();

			if ($layout) {
				var fc = $layout.parents('.acf-field-flexible-content:first');
				var field = acf.getInstance(fc);
				field.closeLayout(field.$layout($layout.index()));

				$layout.find('> .acf-fc-modal-title').html(' ');
				$layout.removeClass('-modal').css('visibility', '');
				$layout.addClass('-highlight-closed');

				setTimeout(function() {
					$layout.removeClass('-highlight-closed');				
				}, 750);
			}
						
			this.overlay(false);
		}

		overlay(show) {
			if (show === true && !$('body').hasClass('acf-modal-open')) {
				var overlay = $('<div id="acf-flexible-content-modal-overlay" />').on('click', this.close.bind(this));
				$('body').addClass('acf-modal-open').append(overlay);
			}
			else if (show === false && this.modals.length == 0) {
				$('#acf-flexible-content-modal-overlay').remove();
				$('body').removeClass('acf-modal-open');
				$('.acf-fc-popup').remove();
			}
			
			this.refresh();
		}

		refresh() {
			$.each(this.modals, function() {
				$(this).css('visibility', 'hidden').removeClass('-animate');
			});
			
			var index = this.modals.length - 1;
			
			if (index in this.modals) {
				this.modals[index].css('visibility', 'visible').addClass('-animate');
			}
		}

		invalidField($el) {
			$el.parents('.layout').addClass('layout-error-messages'); 
		}

		validField($el) {
			$el.parents('.layout').each(function() {
				var $layout = $(this);
				if ($layout.find('.acf-error').length == 0) {
					$layout.removeClass('layout-error-messages');
				}
			});
		}

		openAddLayoutModal() {
			this.overlay(true);
		}

	}

	new FlexibleLayoutModal();

})(jQuery);
