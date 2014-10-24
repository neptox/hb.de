<?php

$latteParams['bodyId'] = 'normal-page';

$latteParams['archive'] = new WpLatteArchiveEntity();

$latteParams['posts'] = WpLatte::createPostEntity($GLOBALS['wp_query']->posts);

WPLatte::createTemplate(basename(__FILE__, '.php'), $latteParams)->render();