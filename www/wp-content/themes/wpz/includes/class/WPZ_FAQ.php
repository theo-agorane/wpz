<?php

class WPZ_FAQ {

	/**
	 * @constructor
	 */
	public function __construct() {
		add_action('init', [$this, 'add_custom_post_type']);
	}

	/**
	 * @action init
	 * @function add_custom_post_type
	 */
	function add_custom_post_type() {
		register_post_type('faq', [
			'label' => 'FAQ',
		 	'labels'    => [
				'name'               => 'FAQ',
				'singular_name'      => 'FAQ',
				'menu_name'          => 'FAQ',
				'name_admin_bar'     => 'FAQ',
				'add_new'            => 'Ajouter',
				'add_new_item'       => 'Ajouter une nouvelle question',
				'new_item'           => 'Nouvelle question',
				'edit_item'          => 'Editer question',
				'view_item'          => 'Voir la question',
				'all_items'          => 'Questions',
				'search_items'       => 'Chercher une question',
				'not_found'          => 'Aucune question trouvée',
				'not_found_in_trash' => 'Aucune question trouvée',
		 	],
		 	'public' => true,
		 	'has_archive' => false,
		 	'hierarchical' => false,
		 	'menu_position' => 20,
		 	'menu_icon' => 'dashicons-editor-help',
		 	'show_ui' => true,
		 	'show_in_rest' => true,
		 	'supports' => ['title'],
		 	'with_front' => false,
		]);
	}

}
