<?php

class BlocksAdmin {

	public static $admin_dir = BLOCKS_PLUGIN . '/admin';
	public $current_screen = NULL;
	public $notice;

	public function __construct() {
		add_action('admin_menu', [$this, 'add_admin_menu']);
		add_action('in_admin_header', [$this, 'render_admin_header'], 1000);
		add_action('admin_body_class', [$this, 'admin_body_class']);
		add_action('admin_enqueue_scripts', [$this, 'admin_enqueue_scripts']);
		add_action('in_admin_header', [$this, 'create_block_if_needed']);
		add_action('in_admin_header', [$this, 'delete_block_if_needed']);
		add_action('in_admin_header', [$this, 'update_blocks_if_needed']);
	}

	public function add_admin_menu() {
		add_submenu_page(
			'edit.php?post_type=acf-field-group',
			'Options des Blocks',
			'Blocks',
			'manage_options',
			'blocks',
			[$this, 'render_admin_page'],
			1000000,
		);
	}

	public function render_admin_page() {
		$blocks = Blocks::load_blocks_with_details();
		$notice = $this->notice;

		require BlocksAdmin::$admin_dir . '/admin.php';
	}

	public function render_admin_header() {
		if ($this->is_current_screen()) {
			require BlocksAdmin::$admin_dir . '/admin-header.php';
		}
	}

	public function admin_body_class($classes) {
		if ($this->is_current_screen()) {
			$classes .= ' acf-admin-page';
		}

		return $classes;
	}

	public function is_current_screen() {
		if ($this->current_screen === NULL) {
			$screen = get_current_screen();
			$this->current_screen = !!(strpos($screen->id, 'blocks') > -1);
		}

		return $this->current_screen;
	}

	public function admin_enqueue_scripts() {
		if ($this->is_current_screen()) {
			wp_enqueue_style('blocks-admin', BLOCKS_PLUGIN_URL . 'admin/admin.css');
			wp_enqueue_script('blocks-admin', BLOCKS_PLUGIN_URL . 'admin/admin.js');
		}
	}

	public function create_block_if_needed() {
		if ($this->is_current_screen() && !empty($_POST['blocks-create-key']) && !empty($_POST['blocks-create-name']) && wp_verify_nonce($_POST['_wpnonce'], 'blocks-create')) {
			$key = $_POST['blocks-create-key'];
			$name = addslashes($_POST['blocks-create-name']);
			
			$blocks = Blocks::load_blocks();
			$block_exists = (array_search($key, $blocks) !== false);

			if ($block_exists) {
				$this->notice = [
					"Le Block « <strong>". $key ."</strong> » existe déjà",
					'error'
				];
			}
			elseif (!ctype_alpha($key)) {
				$this->notice = [
					"L'ID du Block doit uniquement comporter des lettres",
					'error'
				];
			}
			else {
				$blockGenerator = new BlockGenerator($key, $name);
				$blockGenerator->create_block();

				$this->notice = [
					"Le Block « <strong>". $key ."</strong> » a été créé avec succès",
					'success'
				];
			}
		}		
	}

	public function delete_block_if_needed() {
		if ($this->is_current_screen() && !empty($_POST['blocks-delete-key']) && wp_verify_nonce($_POST['_wpnonce'], 'blocks-delete-' . $_POST['blocks-delete-key'])) {
			$key = $_POST['blocks-delete-key'];
			$blockGenerator = new BlockGenerator($key);
			$blockGenerator->delete_block();

			$this->notice = [
				"Le Block « <strong>". $key ."</strong> » a été supprimé avec succès",
				'success'
			];
		}		
	}

	public function update_blocks_if_needed() {
		if ($this->is_current_screen() && !empty($_POST['blocks-update']) && wp_verify_nonce($_POST['_wpnonce'], 'blocks-update')) {
			BlockGenerator::update_global_sass_js();

			$this->notice = [
				"Les assets ont été regénérés avec succès.",
				'success'
			];
		}		
	}

}