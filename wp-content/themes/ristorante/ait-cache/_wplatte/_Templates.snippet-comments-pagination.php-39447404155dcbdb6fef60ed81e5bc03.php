<?php //netteCache[01]000497a:2:{s:4:"time";s:21:"0.55194800 1412612519";s:9:"callbacks";a:3:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:107:"/webspace/04/85842/hof-biergarten.de/wp-content/themes/ristorante/Templates/snippet-comments-pagination.php";i:2;i:1412606273;}i:1;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:20:"NFramework::REVISION";i:2;s:30:"eee17d5 released on 2011-08-13";}i:2;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:21:"WPLATTE_CACHE_VERSION";i:2;i:4;}}}?><?php

// source file: /webspace/04/85842/hof-biergarten.de/wp-content/themes/ristorante/Templates/snippet-comments-pagination.php

?><?php list($_l, $_g) = NCoreMacros::initRuntime($template, '0whi8d4l5w')
;
// snippets support
if (!empty($control->snippetMode)) {
	return NUIMacros::renderSnippets($control, $_l, get_defined_vars());
}

//
// main template
//
if ($post->willCommentsPaginate): ?>
<nav id="comment-nav-<?php echo htmlSpecialChars($location) ?>">
	<div class="nav-previous"><?php previous_comments_link('&larr; Older Comments') ?></div>
	<div class="nav-next"><?php next_comments_link('Newer Comments &rarr;') ?></div>
</nav>
<?php endif ;
