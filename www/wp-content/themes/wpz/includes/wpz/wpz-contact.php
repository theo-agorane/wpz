<?php

/**
 * @action init
 * @function wpz_add_post_type_contact
 * Custom post type Contact
 */
add_action('init', 'wpz_add_post_type_contact');
function wpz_add_post_type_contact() {
	register_post_type('contact', [
		'label' => 'Contact',
	 	'labels'    => [
			'name'               => 'Demandes de contact',
			'singular_name'      => 'Demande de contact',
			'menu_name'          => 'Contact',
			'name_admin_bar'     => 'Contact',
			'add_new'            => 'Ajouter',
			'add_new_item'       => 'Ajouter une nouvelle demande de contact',
			'new_item'           => 'Nouvelle demande de contact',
			'edit_item'          => 'Editer demande de contact',
			'view_item'          => 'Voir la demande de contact',
			'all_items'          => 'Demandes de contact',
			'search_items'       => 'Chercher une demande de contact',
			'not_found'          => 'Aucune demande de contact trouvée',
			'not_found_in_trash' => 'Aucune demande de contact trouvée',
	 	],
	 	'public' => true,
	 	'has_archive' => false,
	 	'hierarchical' => false,
	 	'menu_position' => 30,
	 	'menu_icon' => 'dashicons-email',
	 	'show_ui' => true,
	 	'show_in_rest' => true,
	 	'supports' => ['title'],
	 	'with_front' => false,
	]);
}
