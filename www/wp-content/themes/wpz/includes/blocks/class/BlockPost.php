<?php

class BlockPost extends Timber\Post {

	static function get_post($post) {
		if (is_a($post, 'WP_Post')) {
			return BlockPost::build($post);
		}
		elseif (is_a($post, 'Timber\Post')) {
			return BlockPost::build($post->__get('wp_object'));
		}
		elseif (is_int($post) || is_string($post)) {
			return BlockPost::build(get_post($post));
		}

		return $post;
	}

	static function get_posts($query = null) {
		return Timber::get_posts($query, 'BlockPost');
	}

	public function render_content() {
		$blocks = $this->meta('blocks');

		if (empty($blocks)) {
			return $this->content();
		}
		else {
			$this->render_blocks($blocks);
		}
	}

	private function render_blocks($blocks) {
		foreach ($blocks as $block) {
			$layout = $block['acf_fc_layout'];
			$data = $block['data'];
			$options = !empty($data['options']) ? $data['options'] : null;
			unset($data['options']);

			if (class_exists($layout)) {
				$b = new $layout($data, $options);
				$b->render();
			}
		}
	}

	public function get_taxonomy_attr($taxonomy) {
		if ($taxonomy) {
			$terms = $this->get_terms($taxonomy);

			foreach ($terms as &$term) {
				$term = $term->slug;
			}

			return '||' . implode('||', $terms) . '||';
		}

		return '';
	}
	
}