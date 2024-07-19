<?php

function wpz_add_scripts() {
    wp_enqueue_script('bim-js', get_stylesheet_directory_uri() . '/dist/app.js');
    wp_localize_script('bim-js', 'ajaxUrl', [admin_url('admin-ajax.php')]);
    wp_localize_script('bim-js', 'iconsSvg', [get_stylesheet_directory_uri() . '/dist/all-icons.svg']);
}

function wpz_add_styles() {
    wp_enqueue_style('bim-style', get_stylesheet_directory_uri() . '/dist/style.css');
    wp_enqueue_style('bim-fonts', get_stylesheet_directory_uri() . '/style.css');
}

function wpz_admin_scripts() {
    wp_enqueue_style('wpz-admin', get_stylesheet_directory_uri() . '/static/admin.css');
}

add_action('wp_footer', 'wpz_add_scripts', 10);
add_action('wp_enqueue_scripts', 'wpz_add_styles', 80);
add_action('admin_enqueue_scripts', 'wpz_admin_scripts');

// ============================================
// Disable unneeded Wordpress scripts
// ============================================
function wpz_deregister_scripts(){
	wp_deregister_script('wp-embed');
}

function wpz_dequeue_styles(){

}

add_action('wp_footer', 'wpz_deregister_scripts');
add_action('wp_enqueue_scripts', 'wpz_dequeue_styles', 80);

remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');
remove_action('wp_head', 'wp_generator');
remove_action('wp_enqueue_scripts', 'wp_enqueue_global_styles');
remove_action('wp_footer', 'wp_enqueue_global_styles', 1);

add_filter('wpcf7_autop_or_not', '__return_false');

// Disable WPML style
define('ICL_DONT_LOAD_LANGUAGE_SELECTOR_CSS', true);


// ============================================
// Image sizes
// ============================================
add_action('init', 'wpz_add_image_sizes', 999);
function wpz_add_image_sizes() {
    add_image_size('wpz-full', 1920);
    add_image_size('wpz-large', 1280);
    add_image_size('wpz-medium', 960);
    add_image_size('wpz-little', 768);
    add_image_size('wpz-tiny', 480);

    remove_image_size('thumbnail');
    remove_image_size('medium');
    remove_image_size('medium_large');
    remove_image_size('large');
    remove_image_size('1536x1536');
    remove_image_size('2048x2048');
    remove_image_size('2560x2560');
    remove_image_size('woocommerce_thumbnail');
    remove_image_size('woocommerce_single');
    remove_image_size('woocommerce_gallery_thumbnail');
}

add_filter('intermediate_image_sizes_advanced', 'wpz_remove_default_images', 999);
function wpz_remove_default_images($sizes) {
    unset($sizes['thumbnail']);
    unset($sizes['medium']);
    unset($sizes['medium_large']);
    unset($sizes['large']);
    unset($sizes['1536x1536']);
    unset($sizes['2048x2048']);
    unset($sizes['2560x2560']);
    unset($sizes['woocommerce_thumbnail']);
    unset($sizes['woocommerce_single']);
    unset($sizes['woocommerce_gallery_thumbnail']);

    return $sizes;
}

add_filter('wp_calculate_image_srcset', '__return_false');

add_filter('woocommerce_resize_images', function() {
    return false;
});

// ============================================
// Upload SVGs
// ============================================
function cc_mime_types( $mimes ){
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');

// ---------------------------------------------------------
// Remove Woocommerce Select2 - Woocommerce 3.2.1+
// ---------------------------------------------------------
function bim_dequeue_select2() {
    if (class_exists('woocommerce')) {
        wp_dequeue_style('select2');
        wp_deregister_style('select2');

        wp_dequeue_script('selectWoo');
        wp_deregister_script('selectWoo');
    } 
}
add_action('wp_enqueue_scripts', 'bim_dequeue_select2', 100);

// ------------------------------------------------------
// Désactiver les feuilles de style Woocommerce
// ------------------------------------------------------
add_filter('woocommerce_enqueue_styles', '__return_empty_array');
