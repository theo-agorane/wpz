<?php

if (!defined('ABSPATH')) exit;

class AgoACFIcon {

    var $icons = [];
    var $all_icons_file = '/dist/all-icons.svg';
    var $icons_dir = '/dist/icons/';

    /*
    *  __construct
    *
    *  @type    function
    *  @param   N/A
    *  @return  N/A
    */
    function __construct() {
        $this->load_theme_icons();

        add_action('wp_enqueue_scripts', [$this, 'load_assets']);
        add_action('admin_enqueue_scripts', [$this, 'load_assets']);
        add_action('wp_enqueue_scripts', [$this, 'add_inline_script']);
        add_action('admin_enqueue_scripts', [$this, 'add_inline_script']);
        add_action('acf/include_field_types', [$this, 'create_field_type']);
    }

    /*
    *  load_assets
    *
    *  @type    function
    *  @param   N/A
    *  @return  N/A
    */
    public function load_assets() {
        wp_enqueue_style(
            AGOACFICON_BASENAME,
            AGOACFICON_PLUGIN_URL . '/assets/style.css',
            [],
            AGOACFICON_VERSION
        );

        wp_enqueue_script(
            AGOACFICON_BASENAME,
            AGOACFICON_PLUGIN_URL . '/assets/scripts.js',
            ['jquery'],
            AGOACFICON_VERSION,
            true
        );
    }

    /*
    *  add_inline_script
    *
    *  @type    function
    *  @param   N/A
    *  @return  N/A
    */
    function add_inline_script() {
        echo '<script type="text/javascript">';
        echo 'var iconsSvg = "'. get_template_directory_uri() . $this->icons_dir .'";';
        echo '</script>';
    }

    /*
    *  load_theme_icons
    *
    *  @type    function
    *  @param   N/A
    *  @return  N/A
    */
    function load_theme_icons() {
        $iconFiles = scandir(get_template_directory() . '' . $this->icons_dir);
        $this->icons = [];

        foreach ($iconFiles as $icon) {
            if (str_contains($icon, '.svg')) {
                $this->icons[] = str_replace('.svg', '', $icon);
            }
        }
    }

    /*
    *  create_field_type
    *
    *  @type    function
    *  @param   N/A
    *  @return  N/A
    */
    function create_field_type() {
        new AcfFieldSelectIcon($this->icons, get_template_directory_uri() . $this->all_icons_file);
    }

}
