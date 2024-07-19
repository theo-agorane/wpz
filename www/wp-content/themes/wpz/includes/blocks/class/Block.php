<?php

class Block {

	public $data;
	public $options;

	public function __construct($data = [], $options = []) {
		$this->data = $data;
		$this->options = $options;

		$this->init();
		$this->class = $this->get_class();
	}

	public function init() {}

	public function render() {
		$context = Timber::context();
		$context['this'] = $this;
		$template = $this->key . '.twig';

		echo Timber::compile([$template], $context);
	}

	public function get_class() {
		$class = [];

		if (!empty($this->options['theme'])) {
			$class[] = '__theme_' . $this->options['theme'];
		}

		if (!empty($this->options['spacing']['top'])) {
			$class[] = '__spacing_top_' . $this->options['spacing']['top'];
		}

		if (!empty($this->options['spacing']['bottom'])) {
			$class[] = '__spacing_bottom_' . $this->options['spacing']['bottom'];
		}

		return implode(' ', $class);
	}
	
}