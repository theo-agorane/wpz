<?php

$context = Timber::context();
$context['post'] = WPZ_Block_Post::get_post($post);

Timber::render(['page.twig'], $context);
