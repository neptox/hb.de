<?php //netteCache[01]000479a:2:{s:4:"time";s:21:"0.39035100 1412625656";s:9:"callbacks";a:3:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:90:"/webspace/04/85842/hof-biergarten.de/wp-content/themes/ristorante/Templates/main-index.php";i:2;i:1412606272;}i:1;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:20:"NFramework::REVISION";i:2;s:30:"eee17d5 released on 2011-08-13";}i:2;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:21:"WPLATTE_CACHE_VERSION";i:2;i:4;}}}?><?php

// source file: /webspace/04/85842/hof-biergarten.de/wp-content/themes/ristorante/Templates/main-index.php

?><?php list($_l, $_g) = NCoreMacros::initRuntime($template, 'c0a5o824f8')
;//
// block content
//
if (!function_exists($_l->blocks['content'][] = '_lbe3239b6465_content')) { function _lbe3239b6465_content($_l, $_args) { extract($_args)
?>

<div id="container" class="subpage defaultContentWidth onecolumn clearfix left">
	<div id="content" class="mainbar entry-content" role="main">

<?php if (!$isIndexPage): ?>
		<h1><?php echo NTemplateHelpers::escapeHtml($post->title, ENT_NOQUOTES) ?></h1>
		<?php echo $post->content ?>

<?php endif ?>

<?php if ($posts): ?>

<?php NCoreMacros::includeTemplate("general-content-nav.php", array('location' => 'nav-above') + $template->getParams(), $_l->templates['c0a5o824f8'])->render() ?>

<?php NCoreMacros::includeTemplate("snippet-content-loop.php", array('posts' => $posts) + $template->getParams(), $_l->templates['c0a5o824f8'])->render() ?>

<?php NCoreMacros::includeTemplate("general-content-nav.php", array('location' => 'nav-below') + $template->getParams(), $_l->templates['c0a5o824f8'])->render() ?>

<?php else: ?>

		<article id="post-0" class="post no-results not-found">

			<header class="entry-header">

				<h2 class="entry-title">Nothing Found</h2>

			</header><!-- .entry-header -->

			<div class="entry-content">

				<p>Sorry, but nothing matched your search criteria. Please try again with some different keywords.</p>
<?php NCoreMacros::includeTemplate('general-search-form.php', $template->getParams(), $_l->templates['c0a5o824f8'])->render() ?>

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


<?php if (!$isIndexPage): isset($post->options('page_slider')->overrideGlobal) ? $localBackground = 'background' : $localBackground = 'asdasd' ;//
// block $localBackground
//
if (!function_exists($_l->blocks[$localBackground][] = '_lbf5aea25ba0__localBackground')) { function _lbf5aea25ba0__localBackground($_l, $_args) { extract($_args) ;if ($post->options('page_slider')->bgType == 'htmlBg'): if ($post->options('page_slider')->htmlBg != ""): ?>
		<img src="<?php echo htmlSpecialChars($post->options('page_slider')->htmlBg) ?>" alt="" />
<?php endif ;else: NCoreMacros::includeTemplate("snippet-custom-home-slider.php", array('slides' => $site->create('slider-creator', $post->options('page_slider')->sliderCat)) + $template->getParams(), $_l->templates['c0a5o824f8'])->render() ;endif ;}} call_user_func(reset($_l->blocks[$localBackground]), $_l, get_defined_vars()) ;endif ;
// template extending support
if ($_l->extends) {
	ob_end_clean();
	NCoreMacros::includeTemplate($_l->extends, get_defined_vars(), $template)->render();
}
