<?php

define('PAGE_HOME', 6);

Timber\Timber::init();
Timber::$dirname = 'templates';
Timber::$autoescape = false;

class WPZ_Timber extends Timber\Site {
	public function __construct() {
		add_action('after_setup_theme', [$this, 'theme_supports']);
		add_filter('timber/context', [$this, 'add_to_context']);
		add_filter('timber/twig', [$this, 'add_to_twig']);
		parent::__construct();
	}

	public function add_to_context($context) {
		$context['site'] = $this;
		$context['date_format'] = 'd/m/Y';
		$context['time_format'] = 'H:i';
		$context['request'] = ['GET' => $_GET, 'POST' => $_POST];

		return $context;
	}

	public function theme_supports() {
		add_theme_support('automatic-feed-links');
		add_theme_support('title-tag');
		add_theme_support('post-thumbnails');
		add_theme_support('menus');
		//add_theme_support('html5', []);		
	}

	public function pre($content, $exit = false) {
		pre($content, $exit);
	}

	public function _($text = '') {
		if (function_exists('pll__')) {
			return pll__($text);
		}

		return $text;
	}

	public function json_decode($string = '', $as_array = true) {
		return json_decode($string, $as_array);
	}

	public function wpz_img($file) {
		return get_stylesheet_directory_uri() . '/dist/img/' . $file;
	}

	public function wpz_static($file) {
		return get_stylesheet_directory_uri() . '/static/' . $file;
	}

	public function wpz_icon($icon) {
		return '<svg class="svg-icon" data-icon="'. $icon .'"></svg>';
	}

	public function acf_link_attrs($link, $class = '') {
		if (!$link) return;
		$tag = 'href="'. $link['url'] .'"';

		if ($link['target']) $tag .= ' target="_blank"';
		if ($class) $tag .= ' class="'. $class .'"';

		return $tag;
	}

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

	public function acf_video($video) {
		if (!$video) return;

		$video_html = '<video controls>';
		$video_html .= '<source src="'. $video['link'] .'" type="'. $video['mime_type'] .'">';
		$video_html .= '</video>';
		return $video_html;
	}

	public function format_price($price, $after = '') {
		return wpz_format_price($price, $after);
	}

	public function BlockPost($post) {
		return BlockPost::get_post($post);
	}

	public function Config() {
		return Config();
	}

	public function add_to_twig($twig) {
		$twig->addExtension(new Twig\Extension\StringLoaderExtension());
		$twig->addFunction(new Twig\TwigFunction('pre', [$this, 'pre']));
		$twig->addFunction(new Twig\TwigFunction('_', [$this, '_']));
		$twig->addFunction(new Twig\TwigFunction('json_decode', [$this, 'json_decode']));
		$twig->addFunction(new Twig\TwigFunction('wpz_img', [$this, 'wpz_img']));
		$twig->addFunction(new Twig\TwigFunction('wpz_static', [$this, 'wpz_static']));
		$twig->addFunction(new Twig\TwigFunction('wpz_icon', [$this, 'wpz_icon']));
		$twig->addFunction(new Twig\TwigFunction('acf_link_attrs', [$this, 'acf_link_attrs']));
		$twig->addFunction(new Twig\TwigFunction('acf_img', [$this, 'acf_img']));
		$twig->addFunction(new Twig\TwigFunction('acf_video', [$this, 'acf_video']));
		$twig->addFunction(new Twig\TwigFunction('format_price', [$this, 'format_price']));
		$twig->addFunction(new Twig\TwigFunction('BlockPost', [$this, 'BlockPost']));
		$twig->addFunction(new Twig\TwigFunction('Config', [$this, 'Config']));
		return $twig;
	}

}

new WPZ_Timber();
