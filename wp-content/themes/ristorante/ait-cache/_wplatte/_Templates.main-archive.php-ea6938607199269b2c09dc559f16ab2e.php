<?php //netteCache[01]000481a:2:{s:4:"time";s:21:"0.79879100 1412869117";s:9:"callbacks";a:3:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:92:"/webspace/04/85842/hof-biergarten.de/wp-content/themes/ristorante/Templates/main-archive.php";i:2;i:1412852261;}i:1;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:20:"NFramework::REVISION";i:2;s:30:"eee17d5 released on 2011-08-13";}i:2;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:21:"WPLATTE_CACHE_VERSION";i:2;i:4;}}}?><?php

// source file: /webspace/04/85842/hof-biergarten.de/wp-content/themes/ristorante/Templates/main-archive.php

?><?php list($_l, $_g) = NCoreMacros::initRuntime($template, '01lji2077c')
;//
// block content
//
if (!function_exists($_l->blocks['content'][] = '_lb59da200ef0_content')) { function _lb59da200ef0_content($_l, $_args) { extract($_args)
?>

<div id="container" class="subpage defaultContentWidth onecolumn clearfix left">

	<div id="content" class="mainbar entry-content" role="main">

<?php if ($posts): ?>

			<h1 class="page-title">
<?php if ($archive->isDay): ?>
					Daily Archives: <span><?php echo NTemplateHelpers::escapeHtml($template->date($posts[0]->date, $site->dateFormat), ENT_NOQUOTES) ?></span>
<?php elseif ($archive->isMonth): ?>
					Monthly Archives: <span><?php echo NTemplateHelpers::escapeHtml($template->date($posts[0]->date, 'F Y'), ENT_NOQUOTES) ?></span>
<?php elseif ($archive->isYear): ?>
					Yearly Archives: <span><?php echo NTemplateHelpers::escapeHtml($template->date($posts[0]->date, 'Y'), ENT_NOQUOTES) ?></span>
<?php else: ?>
					<?php ob_start() ?>Blog Archives<?php echo  NTemplateHelpers::escapeHtml(__(ob_get_clean(), 'ait'), ENT_NOQUOTES) ?>

<?php endif ?>
			</h1>

<?php NCoreMacros::includeTemplate("general-content-nav.php", array('location' => 'nav-above') + $template->getParams(), $_l->templates['01lji2077c'])->render() ?>

<?php NCoreMacros::includeTemplate("snippet-content-loop.php", array('posts' => $posts) + $template->getParams(), $_l->templates['01lji2077c'])->render() ?>

<?php NCoreMacros::includeTemplate("general-content-nav.php", array('location' => 'nav-below') + $template->getParams(), $_l->templates['01lji2077c'])->render() ?>

<?php else: ?>

			<article id="post-0" class="post no-results not-found">

				<header class="entry-header">
					<h2 class="entry-title">Nothing Found</h2>
				</header><!-- .entry-header -->

				<div class="entry-content">

					<p>Sorry, but nothing matched your search criteria. Please try again with some different keywords.</p>
<?php NCoreMacros::includeTemplate('general-search-form.php', $template->getParams(), $_l->templates['01lji2077c'])->render() ?>

				</div><!-- .entry-content -->

			</article><!-- #post-0 -->

<?php endif ?>

	</div>

</div>

<?php
}}

//
// end of blocks
//

// template extending and snippets support

$_l->extends = true; unset($_extends, $template->_extends);


if ($_l->extends) {
	ob_start();
} elseif (!empty($control->snippetMode)) {
	return NUIMacros::renderSnippets($control, $_l, get_defined_vars());
}

//
// main template
//
$_l->extends = 'main-layout.php' ?>

<?php 
// template extending support
if ($_l->extends) {
	ob_end_clean();
	NCoreMacros::includeTemplate($_l->extends, get_defined_vars(), $template)->render();
}
