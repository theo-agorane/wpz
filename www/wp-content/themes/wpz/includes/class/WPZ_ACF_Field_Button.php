<?php

class WPZ_ACF_Field_Button extends acf_field__group {

	/**
	 * @constructor
	 */
	public function __construct() {
        add_action('admin_enqueue_scripts', [$this, 'admin_scripts']);
		
        parent::__construct();
	}

    /**
     * @extend acf_field__group
     * @function initialize 
     */
    public function initialize() {
        parent::initialize();

        $this->name = 'wpz-acf-field-button';
        $this->label = 'Bouton';
        $this->category = 'WPZ';
        $this->defaults = [
            'sub_fields' => $this->get_button_fields(),
            'layout'     => 'table',
        ];
    }

    /**
     * @action admin_enqueue_scripts
     * @function admin_scripts 
     */
    public function admin_scripts() {
        wp_enqueue_style('wpz-acf-field-button-style', get_stylesheet_directory_uri() . '/static/admin/acf-field-button.css');
        wp_enqueue_script('wpz-acf-field-button-js', get_stylesheet_directory_uri() . '/static/admin/acf-field-button.js', ['jquery'], null, true);
    }

    /**
     * @function get_button_fields 
     */
    public function get_button_fields() {
        $fields = [
            // 1. Field Link
            $this->get_button_field_array(
                'link',
                'Texte et Lien',
                'link',
                [
                    'required' => 1,
                    'return_format' => 'array',
                ],
            ),

            // 2. Field type
            $this->get_button_field_array(
                'type',
                'Type',
                'radio',
                [
                    'choices' => [
                        'primary' => 'Bouton primaire',
                        'secondary' => 'Bouton secondaire',
                    ],
                    'required' => 1,
                    'return_format' => 'value',
                    'default_value' => 'primary',
                    'allow_null' => 0,
                    'other_choice' => 0,
                    'layout' => 'vertical',
                    'save_other_choice' => 0,
                ],
            ),

            // 3. Icône
            $this->get_button_field_array(
                'icon',
                'Icône',
                'wpz-acf-field-icon',
            ),
        ];

        return $fields;
    }

    /**
     * @function get_button_field_array 
     */
    public function get_button_field_array($name, $label = 'Field', $type = 'text', $data = []) {
        return array_replace([
            'key' => 'field_wpz_button__' . $name,
            'ID' => 'field_wpz_button__' . $name,
            'name' => $name,
            '_name' => $name,
            'label' => $label,
            'type' => $type,
            'aria-label' => '',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => [
                'width' => '',
                'class' => '',
                'id' => '',
            ],
        ], $data);
    }

}
