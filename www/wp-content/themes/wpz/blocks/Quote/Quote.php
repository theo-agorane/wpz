<?php

class Quote extends WPZ_Block {

	public $key = 'Quote';
	
	public function init() {
		// Force Black background
		$this->options['color_background'] = 'black';
	}
	
}
