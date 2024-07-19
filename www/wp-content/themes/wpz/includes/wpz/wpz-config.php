<?php

class Config_Class {

	/**
	 * @constructor
	 */
	public function __construct() {
		$this->get_current_lang();
		$this->get_config_for_current_lang();
		$this->get_menus_for_current_lang();
	}

	/**
	 * @function get_current_lang
	 */
	function get_current_lang() {
		if (function_exists('pll_current_language')) {
			$this->lang = pll_current_language();
		}
		else {
			$this->lang = 'fr';
		}
	}

	/**
	 * @function get_config_for_current_lang
	 */
	function get_config_for_current_lang() {
		$config = [];
		// $lang = TODO: polylang current lang

		$query = Timber::get_posts([
			'post_type' => 'config',
			'post_status' => 'publish',
			'limit' => 1,
			//'lang' => $lang,
		]);

		$posts = $query->to_array();

		if (!empty($posts[0])) {
			$data = $posts[0]->meta('config');

			if (is_array($data)) {
				foreach ($data as $key => $value) {
					if ($key) {
						$this->$key = $value;
					}
				}
			}
		}
	}

	/**
	 * @function get_menus_for_current_lang
	 */
	function get_menus_for_current_lang() {
		//$lang_ext = ($this->lang == 'fr') ? '' : '___'.$this->lang;
		$lang_ext = '';
		
		$this->menus = [
			'main' => Timber::get_menu('menu_main' . $lang_ext),
			'footer' => Timber::get_menu('menu_footer' . $lang_ext),
			'footer_sub' => Timber::get_menu('menu_footer_sub' . $lang_ext),
		];
	}

}

/**
 * @action init
 * @function wpz_post_type_config
 * Custom post type Configuration
 */
add_action('init', 'wpz_add_post_type_config');
function wpz_add_post_type_config() {
	register_post_type('config', [
		'label' => 'Configuration',
	 	'labels'    => [
			'name'               => 'Configuration',
			'singular_name'      => 'Configuration',
			'menu_name'          => 'Configuration',
			'name_admin_bar'     => 'Configuration',
			'add_new'            => 'Ajouter',
			'add_new_item'       => 'Ajouter une nouvelle configuration',
			'new_item'           => 'Nouvelle configuration',
			'edit_item'          => 'Editer configuration',
			'view_item'          => 'Voir la configuration',
			'all_items'          => 'Configuration',
			'search_items'       => 'Chercher une configuration',
			'not_found'          => 'Aucune configuration trouvée',
			'not_found_in_trash' => 'Aucune configuration trouvée',
	 	],
	 	'public' => true,
	 	'has_archive' => false,
	 	'hierarchical' => false,
	 	'menu_position' => 25,
	 	'menu_icon' => 'dashicons-admin-generic',
	 	'show_ui' => true,
	 	'show_in_rest' => true,
	 	'supports' => ['title'],
	 	'with_front' => false,
	]);
}

/**
 * Singleton instanciation
 */

$Config_Obj = null;
function Config() {
	global $Config_Obj;

	if (empty($Config_Obj)) {
		$Config_Obj = new Config_Class();
	}

	return $Config_Obj;
}
