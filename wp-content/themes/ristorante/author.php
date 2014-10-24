<?php

$latteParams['bodyId'] = 'normal-page';

$latteParams['author'] = new WpLattePostAuthorEntity($GLOBALS['wp_query']->queried_object);

$latteParams['posts'] = WpLatte::createPostEntity(
	$GLOBALS['wp_query']->posts,
	array(
		'author' => $latteParams['author'] // if we have info about author inject it now
	)
);

WPLatte::createTemplate(basename(__FILE__, '.php'), $latteParams)->render();
