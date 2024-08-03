// ------------------------------------------------------------
// Input Icon Field
// ------------------------------------------------------------

(function($) {
    if (typeof acf == 'undefined') return;

    function initialize_field(field) {
        new WPZ_ACF_Field_Icon(field.$el);
    }
  
    if( typeof acf.addAction !== 'undefined' ) {
        acf.addAction('ready_field/type=wpz-acf-field-icon', initialize_field);
        acf.addAction('append_field/type=wpz-acf-field-icon', initialize_field);
    } else {
        $(document).on('acf/setup_fields', function(e, postbox) {
            // find all relevant fields
            $(postbox).find('.field[data-field_type="wpz-acf-field-icon"]').each(function(){
                // initialize
                initialize_field( $(this) );
            });
        });
    }

})(jQuery);


(function($) {
    window.WPZ_ACF_Field_Icon = function($el) { this.init($el); }

    WPZ_ACF_Field_Icon.prototype.index = 0;
    WPZ_ACF_Field_Icon.prototype.init = function($el) {
        if (!!$el.attr('wpz-acf-field-icon--initialized')) return;

        // Variables
        this.$container = $el.find('.acf-input');
        this.$input = this.$container.find('input');
        this.$select = this.$container.find('.wpz-acf-field-icon');
        this.$dropdown = this.$select.find('.dropdown');
        this.$overlay = this.$select.find('.overlay');
        this.$value = this.$select.find('.value');
        this.$options = this.$dropdown.find('.option');
        this.value = this.$input.val();

        $el.attr('wpz-acf-field-icon--initialized', 1);

        // Actions
        this.setEventListeners();

        $el.addClass('wpz-acf-field-icon--selector');
    }

    WPZ_ACF_Field_Icon.prototype.setEventListeners = function() {
        // Event Listeners
        var _this = this;

        this.$value.on('click', function() {
              _this.$select.toggleClass('active');
        });

        this.$options.on('click', function() {
            var content = this.innerHTML,
              value = this.attributes['data-value'].value;

            _this.$value.html(content);
            _this.$input.val(value);
            _this.$select.removeClass('active');
        });

        this.$overlay.on('click', function() {
            _this.$select.removeClass('active');
        });
    }

})(jQuery);

// ------------------------------------------------------------
// Input Select Field
// ------------------------------------------------------------

(function($) {

	if (typeof acf == 'undefined') return;

	function initialize_field(field) {
		new WPZ_ACF_Field_Icon(field.$el);
	}

	function initialize_option_field(field) {
		var $wrap = field.$el.find('.acf-input'),
			icon = field.$el.find('input').val(),
			$preview = $('<div class="icon-preview"></div>'),
			$svg = $('<svg><use href="'+svgSymbolsUrl+'#'+icon+'"></use></svg>');

		$wrap.addClass('icon-preview-wrapper');
		$preview.append($svg);
		$wrap.append($preview);

		$wrap.find('input').on('input', function() {
			var $input = $(this),
				$icon = $input.parent().siblings('.icon-preview'),
				$use = $icon.find('svg use');

			$use.attr('href', svgSymbolsUrl+'#'+$input.val());
		});
	}
	
	if( typeof acf.addAction !== 'undefined' ) {
		acf.addAction('ready_field/type=wpz-acf-field-icon', initialize_field);
		acf.addAction('append_field/type=wpz-acf-field-icon', initialize_field);

		//acf.addAction('ready_field/name=ago-icon-slug', initialize_option_field);
		//acf.addAction('append_field/name=ago-icon-slug', initialize_option_field);

	} else {
		$(document).on('acf/setup_fields', function(e, postbox) {
			
			// find all relevant fields
			$(postbox).find('.field[data-field_type="wpz-acf-field-icon"]').each(function(){
				// initialize
				initialize_field( $(this) );
			});
		
		});
	}

})(jQuery);


(function($) {
	// ============================================
	// Color select custom
	// ============================================
	window.WPZ_ACF_Field_Icon = function($el) { this.init($el); }

	WPZ_ACF_Field_Icon.prototype.index = 0;
	WPZ_ACF_Field_Icon.prototype.init = function($el) {
		if (!!$el.attr('wpz-acf-field-icon--initialized')) return;

		// Variables
		this.$container = $el.find('.acf-input');
		this.$input = this.$container.find('input');
		this.$select = this.$container.find('.wpz-acf-field-icon');
		this.$dropdown = this.$select.find('.dropdown');
		this.$overlay = this.$select.find('.overlay');
		this.$value = this.$select.find('.value');
		this.$options = this.$dropdown.find('.option');
		this.value = this.$input.val();

		$el.attr('wpz-acf-field-icon--initialized', 1);

		// Actions
		this.setEventListeners();

		$el.addClass('wpz-acf-field-icon--selector');
	}

	WPZ_ACF_Field_Icon.prototype.setEventListeners = function() {
		// Event Listeners
		var _this = this;

		this.$value.on('click', function() {
			_this.$select.toggleClass('active');
		});

		this.$options.on('click', function() {
			var content = this.innerHTML,
				value = this.attributes['data-value'].value;

			_this.$value.html(content);
			_this.$input.val(value);
			_this.$select.removeClass('active');
		});

		this.$overlay.on('click', function() {
			_this.$select.removeClass('active');
		});
	}

})(jQuery);