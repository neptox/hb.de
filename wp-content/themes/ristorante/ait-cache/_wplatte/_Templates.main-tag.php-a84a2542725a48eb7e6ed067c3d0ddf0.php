<?php //netteCache[01]000477a:2:{s:4:"time";s:21:"0.88223100 1412612003";s:9:"callbacks";a:3:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:88:"/webspace/04/85842/hof-biergarten.de/wp-content/themes/ristorante/Templates/main-tag.php";i:2;i:1412606272;}i:1;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:20:"NFramework::REVISION";i:2;s:30:"eee17d5 released on 2011-08-13";}i:2;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:21:"WPLATTE_CACHE_VERSION";i:2;i:4;}}}?><?php

// source file: /webspace/04/85842/hof-biergarten.de/wp-content/themes/ristorante/Templates/main-tag.php

?><?php list($_l, $_g) = NCoreMacros::initRuntime($template, 'lefg92rzbr')
;//
// block content
//
if (!function_exists($_l->blocks['content'][] = '_lb220e9d212c_content')) { function _lb220e9d212c_content($_l, $_args) { extract($_args)
?>

<div id="container" class="subpage defaultContentWidth onecolumn clearfix left">

	<div id="content" class="mainbar entry-content" role="main">

<?php if ($posts): ?>

		<h1 class="page-title">
			<?php ob_start() ?>Search Results for: <?php echo  NTemplateHelpers::escapeHtml(__(ob_get_clean(), 'ait'), ENT_NOQUOTES) ?>
<span><?php echo NTemplateHelpers::escapeHtml($site->searchQuery, ENT_NOQUOTES) ?></span>
		</h1>

<?php NCoreMacros::includeTemplate("general-content-nav.php", array('location' => 'nav-above') + $template->getParams(), $_l->templates['lefg92rzbr'])->render() ?>

<?php NCoreMacros::includeTemplate("snippet-content-loop.php", array('posts' => $posts) + $template->getParams(), $_l->templates['lefg92rzbr'])->render() ?>

<?php NCoreMacros::includeTemplate("general-content-nav.php", array('location' => 'nav-below') + $template->getParams(), $_l->templates['lefg92rzbr'])->render() ?>

<?php else: ?>

		<article id="post-0" class="post no-results not-found">

			<header class="entry-header">

				<h1 class="entry-title">Nothing Found</h1>

			</header><!-- .entry-header -->

			<div class="entry-content">

				<p><?php ob_start() ?>Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post<?php echo  NTemplateHelpers::escapeHtml(__(ob_get_clean(), 'ait'), ENT_NOQUOTES) ?></p>
<?php NCoreMacros::includeTemplate('general-search-form.php', $template->getParams(), $_l->templates['lefg92rzbr'])->render() ?>

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
