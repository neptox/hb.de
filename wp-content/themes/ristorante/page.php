<?php

$latteParams['post'] = WpLatte::createPostEntity(
	$GLOBALS['wp_query']->post,
	array(
		'meta' => $GLOBALS['pageOptions'],
	)
);

$latteParams['post']->classes = implode(' ', get_post_class());


if ( ! isset( $content_width ) )
$content_width = 1024;


WPLatte::createTemplate(basename(__FILE__, '.php'), $latteParams)->render();