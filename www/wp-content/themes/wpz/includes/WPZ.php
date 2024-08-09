<?php

class WPZ_Class {

	public $config;
	//public $pll;

	/**
	 * @constructor
	 */
	public function __construct() {
		// Site Configuration
		$this->config = new WPZ_Config();
		new WPZ_Timber();
		new WPZ_Forms();
		new WPZ_FAQ();
		new WPZ_ACF();
		new WPZ_Themes();
		//$this->pll = new WPZ_Polylang();

		// Front Configuration
		add_action('wp_footer', [$this, 'add_scripts'], 10);
		add_action('wp_enqueue_scripts', [$this, 'add_styles'], 80);
		add_action('admin_enqueue_scripts', [$this, 'admin_scripts']);
		add_action('after_setup_theme', [$this, 'register_nav_menus']);
		add_action('after_setup_theme', [$this, 'remove_admin_bar']);
		add_filter('upload_mimes', [$this, 'accepted_mime_types']);
		add_action('init', [$this, 'add_image_sizes'], 999);
		add_filter('intermediate_image_sizes_advanced', [$this, 'remove_image_sizes'], 999);
		$this->clean_wp_scripts_styles();
	}

	/**
	 * @action after_setup_theme
	 * @function register_nav_menus 
	 */
	public function register_nav_menus() {
		register_nav_menus([
			'menu_main' => "Menu principal",
			'menu_footer' => "Menu footer",
			'menu_footer_sub' => "Menu footer légal",
		]);
	}

	/**
	 * @action init
	 * @function add_image_sizes 
	 */
	public function add_image_sizes() {
	    add_image_size('wpz-full', 1920);
	    add_image_size('wpz-large', 1280);
	    add_image_size('wpz-medium', 960);
	    add_image_size('wpz-little', 768);
	    add_image_size('wpz-tiny', 480);

	    foreach (WP_IMAGE_SIZES as $size) {
	    	remove_image_size($size);
	    }
	}

	/**
	 * @filter intermediate_image_sizes_advanced
	 * @function remove_image_sizes 
	 */
	public function remove_image_sizes($sizes) {
	    foreach (WP_IMAGE_SIZES as $size) {
	    	unset($sizes[$size]);
	    }

		return $sizes;
	}

	/**
	 * @action wp_footer
	 * @function add_scripts 
	 */
	public function add_scripts() {
	    wp_enqueue_script('wpz-js', get_stylesheet_directory_uri() . '/dist/app.js');
	    wp_localize_script('wpz-js', 'ajaxUrl', [admin_url('admin-ajax.php')]);
	    wp_localize_script('wpz-js', 'iconsSvg', [get_stylesheet_directory_uri() . '/dist/all-icons.svg' . WPZ()->get_cache_key()]);

	    wp_deregister_script('wp-embed');
	}

	/**
	 * @action wp_enqueue_scripts
	 * @function add_styles 
	 */
	public function add_styles() {
	    wp_enqueue_style('wpz-style', get_stylesheet_directory_uri() . '/dist/style.css');
	    wp_enqueue_style('wpz-fonts', get_stylesheet_directory_uri() . '/style.css');

        wp_dequeue_style('select2');
        wp_deregister_style('select2');
        wp_dequeue_script('selectWoo');
        wp_deregister_script('selectWoo');
	}

	/**
	 * @action admin_enqueue_scripts
	 * @function admin_scripts 
	 */
	public function admin_scripts() {
	    wp_enqueue_style('wpz-admin-style', get_stylesheet_directory_uri() . '/static/admin/admin.css');
	    wp_enqueue_script('wpz-admin-js', get_stylesheet_directory_uri() . '/static/admin/admin.js');
	}

	/**
	 * @action after_setup_theme
	 * @function remove_admin_bar 
	 */
	public function remove_admin_bar() {
		//if (!current_user_can('administrator') && !is_admin()) {
			show_admin_bar(false);
		//}
	}

	/**
	 * @function clean_wp_scripts_styles 
	 */
	public function clean_wp_scripts_styles() {
		remove_action('wp_head', 'print_emoji_detection_script', 7);
		remove_action('wp_print_styles', 'print_emoji_styles');
		remove_action('wp_head', 'wp_generator');
		remove_action('wp_enqueue_scripts', 'wp_enqueue_global_styles');
		remove_action('wp_footer', 'wp_enqueue_global_styles', 1);
		add_filter('wpcf7_autop_or_not', '__return_false');
		add_filter('wp_calculate_image_srcset', '__return_false');
		add_filter('woocommerce_resize_images', '__return_false');
		add_filter('woocommerce_enqueue_styles', '__return_empty_array');
	}

	/**
	 * @filter upload_mimes
	 * @function accepted_mime_types 
	 */
	public function accepted_mime_types($mimes) {
	    $mimes['svg'] = 'image/svg+xml';
	    return $mimes;
	}

	/**
	 * @function get_cache_key 
	 */
	public function get_cache_key() {
	    if (defined('WPZ_CACHE') && WPZ_CACHE) {
	    	return '?' . WPZ_CACHE;
	    }

	    return '';
	}
	/**
	 * @function render_template 
	 */
	public function render_template($template, $context = []) {
		if ($this->config->maintenance['active']) {
			Timber::render('maintenance.twig', $context);
		}
		else {
			Timber::render($template, $context);
		}
	}
}

/**
 * WPZ instanciation
 */
$WPZ = null;

function WPZ() {
	global $WPZ;
	$WPZ = empty($WPZ) ? new WPZ_Class() : $WPZ;
	return $WPZ;
}

WPZ();