<?php

// if this is "Blog" page get the right template
if($GLOBALS['wp_query']->is_home && $GLOBALS['wp_query']->is_posts_page){
	$template = get_page_template();
	if($template = apply_filters('template_include', $template)){
		if(substr($template, -8, 8) != 'page.php'){
			require_once $template;
			return; // ends executing this script
		}
	}
}

$latteParams['posts'] = WpLatte::createPostEntity($GLOBALS['wp_query']->posts);

// no page was selected for "Posts page" from WP Admin in Settings->Reading
$latteParams['isIndexPage'] = true;

if(isset($GLOBALS['wp_query']->queried_object)){

	$latteParams['post'] = WpLatte::createPostEntity(
		$GLOBALS['wp_query']->queried_object,
		array(
			'meta' => $GLOBALS['pageOptions'],
	));

	$latteParams['isIndexPage'] = false;
}

WPLatte::createTemplate(basename(__FILE__, '.php'), $latteParams)->render();

