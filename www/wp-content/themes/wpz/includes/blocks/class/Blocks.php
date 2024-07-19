<?php

class Blocks {

	private $blocks;
	public static $blocks_dir = BLOCKS_DIR . '/blocks';
	public static $acf_dir = BLOCKS_DIR . '/acf';
	private $admin;

	public function __construct() {
		$this->load_blocks_classes();
		$this->setup_acf();

		if (is_admin()) {
			new BlocksAdmin();
			new BlocksModal();
		}
	}

	public function get_blocks() {
		if ($this->blocks == NULL) {
			$this->blocks = Blocks::load_blocks();
		}

		return $this->blocks;
	}

	public static function load_blocks() {
		if (is_dir(Blocks::$blocks_dir)) {
			return array_diff(scandir(Blocks::$blocks_dir), ['.', '..']);
		}

		return [];
	}

	public static function load_blocks_with_details() {
		$blocks_key = Blocks::load_blocks();
		$blocks = [];

		foreach ($blocks_key as $key) {
			$blocks[$key] = [
				'created' => filectime(Blocks::$blocks_dir . '/' . $key),
				'modified' => filemtime(Blocks::$blocks_dir . '/' . $key),
			];
		}

		/*
		uasort($blocks, function($a, $b) {
			return ($a['created'] < $b['created']) ? 1 : -1;
		});
		*/

		return $blocks;
	}

	private function load_blocks_classes() {
		Timber::$locations = [];

		foreach ($this->get_blocks() as $block) {
			$dir = Blocks::$blocks_dir . '/' . $block;
			$file = $dir . '/' . $block . '.php';

			if (file_exists($file)) {
				Timber::$locations[] = $dir;
				require_once $file;
			}
		}
	}

	public function setup_acf() {
		//add_action('acf/init', [$this, 'acf_sync_json'], 999);
		add_filter('acf/settings/load_json', [$this, 'acf_load_json'], 999);
		add_filter('acf/settings/save_json', [$this, 'acf_save_json'], 999);
		add_filter('acf/load_field/name=blocks', [$this, 'acf_populate_flexible'], 999);
	}
	
	public function acf_load_json($path) {
		// On charge les JSON dans tous les dossiers de Block
		// (wp-content/blocks/blocks/*)
		foreach ($this->get_blocks() as $block) {
			$path[] = Blocks::$blocks_dir . '/' . $block;
		}

		// On charge les JSON dans le dossier "acf"
		// (wp-content/blocks/acf/*)
		$path[] = Blocks::$acf_dir;

		return $path;
	}

	public function acf_save_json($path) {
		if (!empty($_POST['acf_field_group']['key'])) {
			$key = $_POST['acf_field_group']['key'];
			$block = $this->get_block_id_by_acf_group_key($key);

			// Si c'est un Block, on sauvegarde le JSON dans le dossier du Block
			// (wp-content/bim-blocks/blocks/*)
			if ($block) {
				$path = Blocks::$blocks_dir . '/' . $block;
			}

			// Si c'est un groupe  Blocks ou options, on sauvegarde le JSON dans le dossier "acf"
			// (wp-content/bim-blocks/acf/*)
			if (strpos($key, 'group_flexibleblocks') > -1) {
				$path = Blocks::$acf_dir;
			}
		}

		return $path;
	}

	public function acf_sync_json() {
		$groups = acf_get_field_groups();

		$sync = [];

		if (!empty($groups)) {
			foreach ($groups as $group) {
				$local = acf_maybe_get($group, 'local', false);
				$modified = acf_maybe_get($group, 'modified', 0);
				$private = acf_maybe_get($group, 'private', false);

				if ($local == 'json' && !$private) {
					if (!$group['ID']) {
						$sync[$group['key']] = $group;
					}
				}
			}

			if (!empty($sync)) {
				$i = 0;
				foreach ($sync as $key => $group) {
					$group['modified'] = time();

					$result = acf_import_field_group($group);
				}
			}
		}
	}

	public function acf_populate_flexible($field) {
		$field['layouts'] = [];

		if (get_current_screen() != null && get_current_screen()->id == 'acf-field-group') {
			return $field;
		}
		
		$groups = acf_get_field_groups();
		$blocks = [];
		$options_subfields = [];

		if (!empty($groups)) {
			foreach ($groups as $group) {
				if (strpos($group['key'], 'group_block') > -1) {
					$blocks[] = $group;
				}
				elseif ($group['key'] == 'group_blocksoptions') {
					$options_subfields = acf_get_fields($group);
				}
			}
		}

		foreach ($blocks as $block) {
			$key = $this->get_block_id_by_acf_group_key($block['key']);
			$layout_key = Blocks::get_acf_layout_key_by_block_id($key);
			$subfields = acf_get_fields($block['ID']);

			$field['layouts'][$layout_key] = [
				'key' => $layout_key,
				'name' => $key,
				'label' => $block['title'],
				'display' => 'block',
				'sub_fields' => [
					/*
					[
						'ID' => 1,
						'key' => 'field_tabdata' . strtolower($key),
						'label' => 'Contenu',
						'name' => '',
						'aria-label' => '',
						'type' => 'tab',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => [
							'width' => '',
							'class' => '',
							'id' => ''
						],
						'placement' => 'top',
						'endpoint' => 0,
					],
					*/
					[
						'ID' => 2,
						'key' => 'field_data' . strtolower($key),
						'label' => 'Contenu',
						'name' => 'data',
						'_name' => 'data',
						'aria-label' => '',
						'type' => 'group',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => [
							'width' => '',
							'class' => '',
							'id' => ''
						],
						'sub_fields' => $subfields,
						'layout' => 'row',
					],
					/*
					[
						'ID' => 3,
						'key' => 'field_taboptions' . strtolower($key),
						'label' => 'Options',
						'name' => '',
						'aria-label' => '',
						'type' => 'tab',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => [
							'width' => '',
							'class' => '',
							'id' => ''
						],
						'placement' => 'top',
						'endpoint' => 0,
					],
					[
						'ID' => 4,
						'key' => 'field_options' . strtolower($key),
						'label' => 'Options',
						'name' => 'options',
						'_name' => 'options',
						'aria-label' => '',
						'type' => 'group',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => [
							'width' => '',
							'class' => '',
							'id' => ''
						],
						'sub_fields' => $options_subfields,
						'layout' => 'row',
					],
					*/
				],
				'min' => '',
				'max' => '',
			];
		}

		return $field;
	}

	function acf_update_flexible($field) {
		pre($field);
		exit;

		return $field;
	}

	function acf_on_update_field($field) {
		$field['layouts'] = [];

		return $field;
	}

	public function get_block_id_by_acf_group_key($key) {
		if (strpos($key, 'group_block') > -1) {
			foreach ($this->get_blocks() as $block) {
				if (str_replace('group_block', '', $key) == strtolower($block)) {
					return $block;
				}
			}
		}

		return NULL;
	}

	public static function get_acf_group_key_by_block_id($block) {
		return 'group_block' . strtolower($block);
	}
	
	public static function get_acf_layout_key_by_block_id($block) {
		return 'layout_blocks' . strtolower($block);
	}
	
}