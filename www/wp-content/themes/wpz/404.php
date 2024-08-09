<?php

$context = Timber::context();
$context['post'] = Timber::get_post($post);

WPZ()->render_template('404.twig', $context);
