<?php

$context = Timber::context();
$context['post'] = WPZ_Block_Post::get_post($post);

WPZ()->render_template('single.twig', $context);
