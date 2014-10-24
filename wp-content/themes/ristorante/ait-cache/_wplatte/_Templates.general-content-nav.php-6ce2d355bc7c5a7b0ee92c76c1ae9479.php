<?php //netteCache[01]000488a:2:{s:4:"time";s:21:"0.60031700 1412609690";s:9:"callbacks";a:3:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:99:"/webspace/04/85842/hof-biergarten.de/wp-content/themes/ristorante/Templates/general-content-nav.php";i:2;i:1412606271;}i:1;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:20:"NFramework::REVISION";i:2;s:30:"eee17d5 released on 2011-08-13";}i:2;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:21:"WPLATTE_CACHE_VERSION";i:2;i:4;}}}?><?php

// source file: /webspace/04/85842/hof-biergarten.de/wp-content/themes/ristorante/Templates/general-content-nav.php

?><?php list($_l, $_g) = NCoreMacros::initRuntime($template, 'q7xk4ar6py')
;
// snippets support
if (!empty($control->snippetMode)) {
	return NUIMacros::renderSnippets($control, $_l, get_defined_vars());
}

//
// main template
//
if($GLOBALS["wp_query"]->max_num_pages > 1): ?>
	<nav id="<?php echo htmlSpecialChars($location) ?>">
		<div class="nav-previous"><?php previous_posts_link('<span class="meta-nav">&larr;</span>') ?></div>
		<div class="nav-next"><?php next_posts_link('<span class="meta-nav">&rarr;</span>') ?></div>
	</nav>
<?php endif; 
