// ------------------------------------------------------------
// Input Icon Field
// ------------------------------------------------------------

(function($) {
    if (typeof acf == 'undefined') return;
  
    function initialize_field(field) {
        new WPZ_ACF_Field_Color(field.$el);
    }
  
    if( typeof acf.addAction !== 'undefined' ) {
        acf.addAction('ready_field/type=wpz-acf-field-color', initialize_field);
        acf.addAction('append_field/type=wpz-acf-field-color', initialize_field);
    } else {
        $(document).on('acf/setup_fields', function(e, postbox) {
            // find all relevant fields
            $(postbox).find('.field[data-field_type="wpz-acf-field-color"]').each(function(){
                // initialize
                initialize_field( $(this) );
            });
        });
    }

})(jQuery);


(function($) {
    window.WPZ_ACF_Field_Color = function($el) { this.init($el); }

    WPZ_ACF_Field_Color.prototype.init = function($el) {
        var $colors = $el.find('.acf-radio-list li');

        $colors.each(function() {
            var $li = $(this);
            var $input = $li.find('input');
            var colorName = $input.val();
            var varName = '--wpz-color-' + colorName;

            this.style.setProperty('--acf-field-color', 'var('+ varName +')');
        });
    }
})(jQuery);