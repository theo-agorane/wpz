<?php

class Gallery extends Block {

	public $key = 'Gallery';
	
	public function init() {
		$this->data['images'] = [];

		foreach ($this->data['rows'] as $row) {
			foreach ($row['items'] as $item) {
				if (!empty($item)) {
					$this->data['images'][] = $item;
				}
			}
		}
	}
	
}
