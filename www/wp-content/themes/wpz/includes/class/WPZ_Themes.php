<?php

class WPZ_Themes {

	/**
	 * @constructor
	 */
	public function __construct() {
		add_action('init', [$this, 'create_options_pages']);
		add_action('wp_head', [$this, 'add_css_variables_inline_style']);
		add_action('admin_head', [$this, 'add_css_variables_inline_style']);
		add_filter('acf/load_field/name=wpz_theme', [$this, 'populate_block_options_field']);
	}

	/**
	 * @action init
	 * @function create_options_pages
	 */
	function create_options_pages() {
		if (function_exists('acf_add_options_sub_page')) {
			acf_add_options_sub_page([
				'page_title' => 'Couleurs',
				'menu_title' => 'Couleurs',
				'parent_slug' => 'wpz-config',
			]);

			acf_add_options_sub_page([
				'page_title' => 'Thèmes',
				'menu_title' => 'Thèmes',
				'parent_slug' => 'wpz-config',
			]);
		}
	}
	
	/**
	 * @action wp_head
	 * @function add_css_variables_inline_style
	 */
	function add_css_variables_inline_style() {
		echo '<style>';
		echo $this->get_colors_css();
		echo $this->get_themes_css();
		echo '</style>';
	}
	
	/**
	 * @function get_colors_css
	 */
	public function get_colors_css() {
		$colors = WPZ_Themes::get_options_colors();
		$style = '';

		foreach ($colors as $key => $value) {
			$style .= '--wpz-color-'. $key .': '. $value .';';
		}

		return ':root {'. $style . '}';

	}
	
	/**
	 * @function get_themes_css
	 */
	public function get_themes_css() {
		$themes = WPZ_Themes::get_options_themes();
		$style = '';

		foreach ($themes as $theme_key => $theme_colors) {
			$theme_class = '.__theme_' . sanitize_title($theme_key);

			$style .= $theme_class . '{';
			$style .= '--block-color-background: var(--wpz-color-'. $theme_colors['background'] .');';
			$style .= '--block-color-text: var(--wpz-color-'. $theme_colors['text'] .');';
			$style .= '--block-color-highlight: var(--wpz-color-'. $theme_colors['highlight'] .');';
			$style .= '}';

			// Button primary
			$style .= $theme_class . ' .button.__primary{';
			foreach ($theme_colors['button_primary'] as $button_color_key => $button_color) {
				$style .= '--btn-'. $button_color_key .': var(--wpz-color-'. $button_color .');';
			}
			$style .= '}';

			// Button secondary
			$style .= $theme_class . ' .button.__secondary{';
			foreach ($theme_colors['button_secondary'] as $button_color_key => $button_color) {
				$style .= '--btn-'. $button_color_key .': var(--wpz-color-'. $button_color .');';
			}
			$style .= '}';
		}

		return $style;

	}
	
	/**
	 * @static get_options_colors
	 */
	public static function get_options_colors() {
		$color_background = get_field('wpz_color_background', 'option');
		$color_text = get_field('wpz_color_text', 'option');
		$colors_custom = get_field('wpz_colors_custom', 'option');

		$colors = [
			'background' => $color_background,
			'text' => $color_text,
			'overlay' => $color_text . 'AA',
			'shadow' => $color_text . '33',
			'transparent' => $color_text . '00',
		];

		if (is_array($colors_custom)) {
			foreach ($colors_custom as $color) {
				$colors[sanitize_title($color['name'])] = $color['color'];
			}
		}

		return $colors;
	}
	
	/**
	 * @static get_options_themes
	 */
	public static function get_options_themes() {
		$theme_default = get_field('wpz_theme_colors', 'option');
		$themes_custom = get_field('wpz_themes', 'option');

		$themes = [
			'default' => $theme_default,
		];

		$themes['default']['background'] = get_field('wpz_color_background', 'option');
		$themes['default']['text'] = get_field('wpz_color_text', 'option');

		if (is_array($themes_custom)) {
			foreach ($themes_custom as $theme) {
				$themes[sanitize_title($theme['name'])] = $theme['colors'];
			}
		}

		return $themes;
	}

	/**
	 * @filter acf/load_field/name=wpz_theme
	 * @function populate_block_options_field
	 */
	public function populate_block_options_field($field) {
		$themes = WPZ_Themes::get_options_themes();

		$field['choices'] = [];
		foreach ($themes as $theme_key => $theme_colors) {
			$field['choices'][$theme_key] = '<div class="acf-wpz-color" style="--acf-wpz-color: var(--wpz-color-'. $theme_colors['background'] .');"></div> <span class="acf-wpz-color-text">'. $theme_key .'</span>';
		}

	    return $field;
	}

}
