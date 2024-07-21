<?php

class WPZ_ACF_Field_Icon extends acf_field {

    var $icons = [],
        $all_icons_file = '/dist/all-icons.svg?240720001',
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
        echo 'var iconsSvg = "'. get_template_directory_uri() . $this->icons_dir .'";';
        echo '</script>';
	}

	/**
	 * @function load_theme_icons 
	 */
	public function load_theme_icons() {
        $iconFiles = scandir(get_template_directory() . '' . $this->icons_dir);
        $this->icons = [];
        $this->symbols = get_template_directory_uri() . '' . $this->all_icons_file;

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
        $value_icon = null;
        ?>
        <div class="<?php echo $this->name; ?>">
            <span class="toggle-indicator"></span>
            <div class="overlay"></div>
            <div class="dropdown">
                <?php 
                    echo '<div class="option" data-value="">';
                    echo '  <span class="svg">x</span>';
                    echo '  <span>Aucun</span>';
                    echo '</div>';

                    foreach ($this->icons as $icon) {
                        if ($field['value'] == $icon) {
                            $value_icon = $icon;
                        }

                        echo '<div class="option" data-value="'. $icon .'">';
                        echo '  <svg><use href="'. $this->symbols .'#'. $icon .'"></use></svg>';
                        echo '  <span>'. $icon .'</span>';
                        echo '</div>';
                    }
                ?>
            </div>
            <div class="value">
                <?php 
                if ($value_icon) {
                    echo '<svg><use href="'. $this->symbols .'#'. $value_icon .'"></use></svg> ';
                    echo '<span>'. $value_icon .'</span>';
                }
                else {
                    echo '<span class="svg">x</span>';
                    echo '<span>Aucun</span>';
                }
                ?>
            </div>
        </div>
        <input type="hidden" name="<?php echo esc_attr($field['name']) ?>" value="<?php echo esc_attr($field['value']) ?>" >
        <?php
    }

}