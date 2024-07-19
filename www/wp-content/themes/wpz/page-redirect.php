<?php

/* Template Name: Redirection */

$timber_post = Timber::get_post($post);

if ($timber_post->meta('redirect_url')) {
	header("Location: " . $timber_post->meta('redirect_url'));
}
else {
	wp_safe_redirect(home_url());
}

exit;
