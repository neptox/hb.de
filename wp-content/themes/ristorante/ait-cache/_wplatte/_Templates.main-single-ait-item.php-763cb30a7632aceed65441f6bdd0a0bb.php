<?php //netteCache[01]000490a:2:{s:4:"time";s:21:"0.02000200 1411940394";s:9:"callbacks";a:3:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:100:"/webspace/04/85842/hof-biergarten.de/wp-content/themes/ristorante/Templates/main-single-ait-item.php";i:2;i:1411927451;}i:1;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:20:"NFramework::REVISION";i:2;s:30:"eee17d5 released on 2011-08-13";}i:2;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:21:"WPLATTE_CACHE_VERSION";i:2;i:4;}}}?><?php

// source file: /webspace/04/85842/hof-biergarten.de/wp-content/themes/ristorante/Templates/main-single-ait-item.php

?><?php list($_l, $_g) = NCoreMacros::initRuntime($template, 'x1us4zylc0')
;//
// block content
//
if (!function_exists($_l->blocks['content'][] = '_lb7712ab281d_content')) { function _lb7712ab281d_content($_l, $_args) { extract($_args)
?>

<div id="container" class="subpage defaultContentWidth onecolumn clearfix left">

	<div id="content" class="mainbar entry-content" role="main">

	<h1><?php echo NTemplateHelpers::escapeHtml($post->title, ENT_NOQUOTES) ?></h1>

	<div class="postitem clear">

<?php if (!isset($post->options('post_featured_images')->hideFeatured)): ?>

<?php if ($post->thumbnailSrc != false): ?>

		<a href="<?php echo htmlSpecialChars($post->thumbnailSrc) ?>">
			<div class="entry-thumbnail">
				<img src="<?php echo htmlSpecialChars($timthumbUrl) ?>?src=<?php echo htmlSpecialChars($post->thumbnailSrc) ?>&w=660&h=274" alt="" />
			</div>
		</a>

<?php endif ?>

<?php endif ?>

	</div>

	<div class="entry-content">

		<?php echo $post->content ?>


	</div>

<?php NCoreMacros::includeTemplate('snippet-post-nav.php', array('location'=> 'nav-above') + $template->getParams(), $_l->templates['x1us4zylc0'])->render() ?>

<?php NCoreMacros::includeTemplate("snippet-comments.php", $template->getParams(), $_l->templates['x1us4zylc0'])->render() ?>

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


<?php isset($post->options('page_slider')->overrideGlobal) ? $localBackground = 'background' : $localBackground = 'asdasd' ;//
// block $localBackground
//
if (!function_exists($_l->blocks[$localBackground][] = '_lbe6de58b59c__localBackground')) { function _lbe6de58b59c__localBackground($_l, $_args) { extract($_args) ;if ($post->options('page_slider')->bgType == 'htmlBg'): if ($post->options('page_slider')->htmlBg != ""): ?>
		<img src="<?php echo htmlSpecialChars($post->options('page_slider')->htmlBg) ?>" alt="" />
<?php endif ;else: NCoreMacros::includeTemplate("snippet-custom-home-slider.php", array('slides' => $site->create('slider-creator', $post->options('page_slider')->sliderCat)) + $template->getParams(), $_l->templates['x1us4zylc0'])->render() ;endif ;}} call_user_func(reset($_l->blocks[$localBackground]), $_l, get_defined_vars()) ;
// template extending support
if ($_l->extends) {
	ob_end_clean();
	NCoreMacros::includeTemplate($_l->extends, get_defined_vars(), $template)->render();
}
