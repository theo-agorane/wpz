<?php

class WPZ_ACF {

	/**
	 * @constructor
	 */
	public function __construct() {
		add_filter('acf/settings/load_json', [$this, 'acf_load_json'], 100);
		add_filter('acf/settings/save_json', [$this, 'acf_save_json'], 100);
		add_filter('acf/load_field', [$this, 'populate_fields']);
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
	    	case 'theme':
		        $field['choices'] = [
		            'white' => '<div class="acf-wpz-color" style="background: #FFFFFF; border: solid 1px #ebebeb;"></div> Blanc',
		            'black' => '<div class="acf-wpz-color" style="background: #000000;"></div> Noir',
		        ];
	    	break;
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

}
