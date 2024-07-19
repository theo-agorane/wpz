<?php

// Composer libraries
require_once 'vendor/autoload.php';

// Helper functions
require_once 'includes/helpers.php';

// Configuration globale
require_once 'includes/config/config-acf.php';
require_once 'includes/config/config-timber.php';
require_once 'includes/config/config-front.php';
require_once 'includes/config/config-menus.php';

// Hoscar
require_once 'includes/wpz/wpz-config.php';
require_once 'includes/wpz/wpz-contact.php';

// Blocks
require_once 'includes/blocks/blocks.php';

// DEV: Disable admin bar
add_action('after_setup_theme', 'remove_admin_bar');
function remove_admin_bar() {
	//if (!current_user_can('administrator') && !is_admin()) {
		show_admin_bar(false);
	//}
}
