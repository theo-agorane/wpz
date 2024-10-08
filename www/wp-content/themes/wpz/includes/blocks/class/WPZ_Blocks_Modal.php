<?php

class WPZ_Blocks_Modal {

	public function __construct() {
		add_action('acf/input/admin_enqueue_scripts', [$this, 'enqueue_scripts'], 10000);
	}

	public function enqueue_scripts() {
		wp_enqueue_style('blocks-modal', BLOCKS_PLUGIN_URL . 'admin/modal.css');
		wp_enqueue_script('blocks-modal', BLOCKS_PLUGIN_URL . 'admin/modal.js');
		$this->setBlockImagesInModal();
	}

	public function setBlockImagesInModal() {
		$blocks = WPZ_Blocks::load_blocks();

		echo '<style>';

		foreach ($blocks as $block) {
			$url = BLOCKS_URL . '/' . $block . '/' . $block . '.jpg';
			echo '.acf-fc-popup a[data-layout="'. $block .'"]:after { background-image: url('. $url .') !important; }';
		}

		echo '</style>';
	}
	
}