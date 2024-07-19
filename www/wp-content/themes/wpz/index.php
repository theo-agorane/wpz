<?php

$context = Timber::context();
$context['post'] = Timber::get_post();
//$context['posts'] = new Timber\PostQuery();

Timber::render(['page.twig'], $context);
