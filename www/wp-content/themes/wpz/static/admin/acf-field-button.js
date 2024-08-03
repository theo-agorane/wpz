// ------------------------------------------------------------
// Input Icon Field
// ------------------------------------------------------------

(function($) {
    if (typeof acf == 'undefined') return;
  
    function initialize_field(field) {
        new WPZ_ACF_Field_Button(field.$el);
    }
  
    if( typeof acf.addAction !== 'undefined' ) {
        acf.addAction('ready_field/type=wpz-acf-field-button', initialize_field);
        acf.addAction('append_field/type=wpz-acf-field-button', initialize_field);
    } else {
        $(document).on('acf/setup_fields', function(e, postbox) {
            // find all relevant fields
            $(postbox).find('.field[data-field_type="wpz-acf-field-button"]').each(function(){
                // initialize
                initialize_field( $(this) );
            });
        });
    }

})(jQuery);


(function($) {
    window.WPZ_ACF_Field_Button = function($el) { this.init($el); }

    WPZ_ACF_Field_Button.prototype.init = function($el) {
    	
    }
})(jQuery);