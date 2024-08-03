<?php

class WPZ_ACF {

	/**
	 * @constructor
	 */
	public function __construct() {
		add_filter('acf/settings/load_json', [$this, 'acf_load_json'], 100);
		add_filter('acf/settings/save_json', [$this, 'acf_save_json'], 100);
		add_filter('acf/load_field', [$this, 'populate_fields']);

		// Custom ACF Fields
        add_action('acf/include_field_types', [$this, 'create_custom_fields'], 999);
	}

	/**
	 * @filter acf/settings/load_json
	 * @function acf_load_json
	 */
	function acf_load_json($paths) {
	    unset($paths[0]);
	    $paths[] = get_stylesheet_directory() . '/acf';
	    return $paths;
	}

	/**
	 * @filter acf/settings/save_json
	 * @function acf_save_json
	 */
	function acf_save_json($path) {
	    if (!empty($_POST['acf_field_group']['key'])) {
	        $key = $_POST['acf_field_group']['key'];

	        if (strpos($key, 'group_block') === false and strpos($key, 'group_blocks') === false) {
	            $path = get_stylesheet_directory() . '/acf';
	        }
	    }

	    return $path;
	}

	/**
	 * @filter acf/load_field
	 * @function populate_fields
	 */
	function populate_fields($field) {
	    if (get_current_screen() != null && get_current_screen()->id == 'acf-field-group') {
	        if ($field['name'] == 'gallery_display') {
	        }
	        return $field;
	    }

	    switch ($field['name']) {
	    	case 'gallery_display':
	    		if (get_current_screen() != null && get_current_screen()->id == 'acf-field-group') {
		            $field['choices'] = [];

		            for ($i=1; $i<=11; $i++) {
		                $field['choices'][$i] = $i;
		            }
	    		}
	    		else {
			        $field['choices'] = [];

			        for ($i=1; $i<=11; $i++) {
			            $field['choices'][$i] = '<div class="acf-wpz-gallery-display" style="background-image: url('.BLOCKS_URL.'/Gallery/displays/display_'.$i.'.svg)"></div>';
			        }
	    		}
	    	break;
	    }

	    return $field;
	}

	/**
	 * @action acf/include_field_types
	 * @function create_custom_fields
	 */
	public function create_custom_fields() {
		// Field Icon
		require_once dirname(__FILE__) . '/WPZ_ACF_Field_Icon.php';
        new WPZ_ACF_Field_Icon();
        
		// Field Button
		require_once dirname(__FILE__) . '/WPZ_ACF_Field_Button.php';
        new WPZ_ACF_Field_Button();
        
		// Field Color
		require_once dirname(__FILE__) . '/WPZ_ACF_Field_Color.php';
        new WPZ_ACF_Field_Color();
	}

}
