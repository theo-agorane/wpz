<?php

class WPZ_ACF_Field_Icon extends acf_field {

    var $icons = [],
        $all_icons_file = '/dist/all-icons.svg',
        $icons_dir = '/dist/icons/',
        $symbols = '';

	/**
	 * @constructor
	 */
	public function __construct() {
        $this->load_theme_icons();

		add_action('admin_enqueue_scripts', [$this, 'admin_scripts']);

		parent::__construct();
	}

    /**
     * @extend acf_field
     * @function initialize 
     */
    public function initialize() {
        parent::initialize();

        $this->name = 'wpz-acf-field-icon';
        $this->label = 'Icône';
        $this->category = 'WPZ';
        $this->defaults = [];
    }

	/**
	 * @action admin_enqueue_scripts
	 * @function admin_scripts 
	 */
	public function admin_scripts() {
	    wp_enqueue_style('wpz-acf-field-icon-style', get_stylesheet_directory_uri() . '/static/admin/acf-field-icon.css');
	    wp_enqueue_script('wpz-acf-field-icon-js', get_stylesheet_directory_uri() . '/static/admin/acf-field-icon.js', ['jquery'], null, true);

        echo '<script type="text/javascript">';
        echo 'var acfIconsSvg = "'. $this->symbols .'";';
        echo 'var acfIconsList = '. json_encode($this->icons) .';';
        echo '</script>';
	}

	/**
	 * @function load_theme_icons 
	 */
	public function load_theme_icons() {
        $iconFiles = scandir(get_template_directory() . '' . $this->icons_dir);
        $this->icons = [];
        $this->symbols = get_template_directory_uri() . '' . $this->all_icons_file . WPZ()->get_cache_key();

        foreach ($iconFiles as $icon) {
            if (str_contains($icon, '.svg')) {
                $this->icons[] = str_replace('.svg', '', $icon);
            }
        }
	}


    /**
    * @function render_field
    */
    function render_field($field) {
        ?>
        <div class="<?php echo $this->name; ?>">
            <span class="toggle-indicator"></span>
            <div class="value"></div>
        </div>
        <input type="hidden" name="<?php echo esc_attr($field['name']) ?>" value="<?php echo esc_attr($field['value']) ?>" >
        <?php
    }

}