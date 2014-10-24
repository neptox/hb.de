<?php

$latteParams['bodyId'] = 'normal-page';

$latteParams['post'] = WpLatte::createPostEntity(
	$GLOBALS['wp_query']->post,
	array(
		'meta' => $GLOBALS['pageOptions'],
	)
);
$latteParams['post']->classes = implode(' ', get_post_class());

WPLatte::createTemplate(basename(__FILE__, '.php'), $latteParams)->render();