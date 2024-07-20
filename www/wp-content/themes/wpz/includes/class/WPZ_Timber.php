<?php

Timber\Timber::init();
Timber::$dirname = 'templates';
Timber::$autoescape = false;

class WPZ_Timber extends Timber\Site {

	/**
	 * @constructor
	 */
	public function __construct() {
		add_action('after_setup_theme', [$this, 'theme_supports']);
		add_filter('timber/context', [$this, 'add_to_context']);
		add_filter('timber/twig', [$this, 'add_to_twig']);
		parent::__construct();
	}

	/**
	 * @action after_setup_theme
	 * @function theme_supports
	 */
	public function theme_supports() {
		add_theme_support('automatic-feed-links');
		add_theme_support('title-tag');
		add_theme_support('post-thumbnails');
		add_theme_support('menus');
	}

	/**
	 * @filter timber/context
	 * @function add_to_context
	 */
	public function add_to_context($context) {
		$context['site'] = $this;
		$context['date_format'] = 'd/m/Y';
		$context['time_format'] = 'H:i';
		$context['request'] = ['GET' => $_GET, 'POST' => $_POST];

		return $context;
	}


	/**
	 * @filter timber/twig
	 * @function add_to_twig
	 */
	public function add_to_twig($twig) {
		$twig->addExtension(new Twig\Extension\StringLoaderExtension());
		$twig->addFunction(new Twig\TwigFunction('pre', [$this, 'pre']));
		$twig->addFunction(new Twig\TwigFunction('_', [$this, '_']));
		$twig->addFunction(new Twig\TwigFunction('wpz_img', [$this, 'wpz_img']));
		$twig->addFunction(new Twig\TwigFunction('wpz_static', [$this, 'wpz_static']));
		$twig->addFunction(new Twig\TwigFunction('wpz_icon', [$this, 'wpz_icon']));
		$twig->addFunction(new Twig\TwigFunction('acf_link_attrs', [$this, 'acf_link_attrs']));
		$twig->addFunction(new Twig\TwigFunction('acf_img', [$this, 'acf_img']));
		$twig->addFunction(new Twig\TwigFunction('acf_video', [$this, 'acf_video']));
		$twig->addFunction(new Twig\TwigFunction('acf_button', [$this, 'acf_button']));
		$twig->addFunction(new Twig\TwigFunction('WPZ', [$this, 'WPZ']));
		return $twig;
	}

	/**
	 * @twig_function pre
	 */
	public function pre($content, $exit = false) {
		pre($content, $exit);
	}

	/**
	 * @twig_function _
	 */
	public function _($text = '') {
		if (function_exists('pll__')) {
			return pll__($text);
		}

		return $text;
	}

	/**
	 * @twig_function wpz_img
	 */
	public function wpz_img($file) {
		return get_stylesheet_directory_uri() . '/dist/img/' . $file;
	}

	/**
	 * @twig_function wpz_static
	 */
	public function wpz_static($file) {
		return get_stylesheet_directory_uri() . '/static/' . $file;
	}

	/**
	 * @twig_function wpz_icon
	 */
	public function wpz_icon($icon) {
		return '<svg class="svg-icon" data-icon="'. $icon .'"></svg>';
	}

	/**
	 * @twig_function acf_link_attrs
	 */
	public function acf_link_attrs($link, $class = '') {
		if (!$link) return;
		$tag = 'href="'. $link['url'] .'"';

		if ($link['target']) $tag .= ' target="_blank"';
		if ($class) $tag .= ' class="'. $class .'"';

		return $tag;
	}

	/**
	 * @twig_function acf_img
	 */
	public function acf_img($img_id, $size = 'wpz-large') {
		if (!$img_id) return;
		$img = Timber::get_post($img_id);

		if ($img) {
			$img_html = '<img ';
			$img_html .= 'src="'. $img->src($size) .'"';
			//$img_html .= 'srcset="'. $img->srcset() .'"';
			// TODO: sizes
			$img_html .= 'alt="'. $img->alt() .'"';
			$img_html .= 'loading="lazy"';
			$img_html .= '>';
			return $img_html;
		}

		return null;
	}

	/**
	 * @twig_function acf_video
	 */
	public function acf_video($video) {
		if (!$video) return;

		$video_html = '<video controls>';
		$video_html .= '<source src="'. $video['link'] .'" type="'. $video['mime_type'] .'">';
		$video_html .= '</video>';
		return $video_html;
	}

	/**
	 * @twig_function acf_button
	 */
	public function acf_button($button = []) {
		$button_html = '';

		if (!empty($button)) {
			$button_html .= '<a ';
			$button_html .= $this->acf_link_attrs($button['link'], 'button __' . $button['type']);
			$button_html .= '>';
			$button_html .= $button['link']['title'];

			if (!empty($button['icon'])) {
				$button_html .= $this->wpz_icon($button['icon']);
			}

			$button_html .= '</a>';
		}

		return $button_html;
	}

	/**
	 * @twig_function WPZ
	 */
	public function WPZ() {
		return WPZ();
	}

}
