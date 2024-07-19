<?php

/**
 * @action init
 * @function wpz_pll_custom_strings
 */
add_action('init', 'wpz_pll_custom_strings');
function wpz_pll_custom_strings() {
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
 * @function wpz_add_cpt_to_pll
 */
add_filter('pll_get_post_types', 'wpz_add_cpt_to_pll', 10, 2);
function wpz_add_cpt_to_pll($post_types, $is_settings) {
    $post_types['config'] = 'config';

    return $post_types;
}

/**
 * @function wpz_get_pll_lang_switcher
 */
function wpz_get_pll_lang_switcher() {
	if (function_exists('pll_the_languages')) {
		return pll_the_languages([
			'echo' => 0,
			'show_names' => 1,
			'display_names_as' => 'slug',
			'show_flags' => 0,
		]);
	}
}