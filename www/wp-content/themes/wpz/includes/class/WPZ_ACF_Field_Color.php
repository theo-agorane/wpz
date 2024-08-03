<?php

class WPZ_ACF_Field_Color extends acf_field_radio {

	/**
	 * @constructor
	 */
	public function __construct() {
        add_action('admin_enqueue_scripts', [$this, 'admin_scripts']);
        add_filter('acf/load_field/type=wpz-acf-field-color', [$this, 'populate_field']);
		
        parent::__construct();
	}

    /**
     * @extend acf_field__group
     * @function initialize 
     */
    public function initialize() {
        parent::initialize();

        $this->name = 'wpz-acf-field-color';
        $this->label = 'Couleur';
        $this->category = 'WPZ';
        $this->defaults['default_value'] = 'background';
    }

    /**
     * @action admin_enqueue_scripts
     * @function admin_scripts 
     */
    public function admin_scripts() {
        wp_enqueue_style('wpz-acf-field-color-style', get_stylesheet_directory_uri() . '/static/admin/acf-field-color.css');
        wp_enqueue_script('wpz-acf-field-color-js', get_stylesheet_directory_uri() . '/static/admin/acf-field-color.js', ['jquery'], null, true);
    }

    /**
     * @action acf/load_field/type=wpz-acf-field-color
     * @function admin_scripts 
     */
    public function populate_field($field) {
        $field['choices'] = class_exists('WPZ_Themes') ? WPZ_Themes::get_options_colors() : [];
        unset($field['choices']['transparent']);
        unset($field['choices']['shadow']);
        unset($field['choices']['overlay']);

        return $field;
    }

}
