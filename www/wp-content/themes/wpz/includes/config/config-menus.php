<?php

/**
 * @action after_setup_theme
 * @function wpz_register_nav_menus
 */
add_action('after_setup_theme', 'wpz_register_nav_menus', 0);
function wpz_register_nav_menus() {
	register_nav_menus([
		'menu_main' => "Menu principal",
		'menu_footer' => "Menu footer",
		'menu_footer_sub' => "Menu footer légal",
	]);
}
