<?php

/*
 * AIT WordPress Theme
 *
 * Copyright (c) 2013, Affinity Information Technology, s.r.o. (http://ait-themes.com)
 */

global $latteParams;

$post = WpLatte::createPostEntity(
	get_post(woocommerce_get_page_id('shop')),
	array(
		'meta' => $GLOBALS['pageOptions'],
	)
);

$GLOBALS['post'] = $post;
$latteParams['post'] = $post;

WpLatte::createTemplate(__FILE__, $latteParams)->render();