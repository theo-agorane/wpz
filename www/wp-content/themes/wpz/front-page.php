<?php

$context = Timber::context();
$context['post'] = Timber::get_post($post);

Timber::render(['index.twig'], $context);
