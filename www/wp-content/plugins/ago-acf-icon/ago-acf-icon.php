<?php
/**
 * Plugin Name: ACF Input Icon
 * Description: Sélecteur d'icône pour ACF by Agorane 
 * Version: 1.0.1
 * Author: Théo Champanhet
 * License: GPLv2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 */

if (!defined('ABSPATH')) exit;

if (!class_exists('AgoACFIcon')) :

define('AGOACFICON_BASENAME',     'ago-acf-icon');
define('AGOACFICON_NICENAME',     'ACF Input Icon');
define('AGOACFICON_VERSION',      '1.0.1');
define('AGOACFICON_PLUGIN_URL',   substr(plugin_dir_url(__FILE__), 0, -1));
define('AGOACFICON_PLUGIN_PATH',  dirname(__FILE__));

require dirname(__FILE__) . '/class/input-icon.php';
require dirname(__FILE__) . '/class/plugin.php';

new AgoACFIcon();

endif;
	
?>