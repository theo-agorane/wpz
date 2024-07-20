<?php

class WPZ_Polylang {

	/**
	 * @constructor
	 */
	public function __construct() {
		add_action('init', [$this, 'pll_custom_strings']);
		add_filter('pll_get_post_types', [$this, 'add_post_types_to_pll'], 10, 2);
	}

	/**
	 * @action init
	 * @function pll_custom_strings
	 */
	function pll_custom_strings() {
		$strings = [
			'wpz-test' => "Test",
		];

		if (function_exists('pll_register_string')) {
			foreach ($strings as $name => $string) {
				pll_register_string($name, $string, 'wpz');
			}
		}
	}

	/**
	 * @filter pll_get_post_types
	 * @function add_post_types_to_pll
	 */
	function add_post_types_to_pll($post_types, $is_settings) {
	    $post_types['config'] = 'config';

	    return $post_types;
	}

	/**
	 * @function get_lang_switcher
	 */
	function get_lang_switcher() {
		if (function_exists('pll_the_languages')) {
			return pll_the_languages([
				'echo' => 0,
				'show_names' => 1,
				'display_names_as' => 'slug',
				'show_flags' => 0,
			]);
		}
	}
	
}
