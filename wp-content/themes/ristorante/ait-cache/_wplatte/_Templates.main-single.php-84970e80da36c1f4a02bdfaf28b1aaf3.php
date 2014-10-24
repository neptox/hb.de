<?php //netteCache[01]000480a:2:{s:4:"time";s:21:"0.17586600 1412852517";s:9:"callbacks";a:3:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:91:"/webspace/04/85842/hof-biergarten.de/wp-content/themes/ristorante/Templates/main-single.php";i:2;i:1412852509;}i:1;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:20:"NFramework::REVISION";i:2;s:30:"eee17d5 released on 2011-08-13";}i:2;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:21:"WPLATTE_CACHE_VERSION";i:2;i:4;}}}?><?php

// source file: /webspace/04/85842/hof-biergarten.de/wp-content/themes/ristorante/Templates/main-single.php

?><?php list($_l, $_g) = NCoreMacros::initRuntime($template, 'wa7uumaod7')
;//
// block content
//
if (!function_exists($_l->blocks['content'][] = '_lb687e7d2ed7_content')) { function _lb687e7d2ed7_content($_l, $_args) { extract($_args)
?>

<!-- SUBPAGE -->
<div id="container" class="subpage defaultContentWidth clearfix left">
<a id="kreuz" href="http://hof-biergarten.de/"></a>
	 <!-- MAINBAR -->
    <div id="content" class="mainbar entry-content" role="main">
<?php if ($post->thumbnailSrc != false): ?>
    <div id="content-wrapper">
<?php else: ?>
    <div id="content-wrapper" class="no-thumbnail">
<?php endif ?>
			<h1><?php echo NTemplateHelpers::escapeHtml($post->title, ENT_NOQUOTES) ?></h1>

      <div class="blog-box">
<?php if ($post->thumbnailSrc): ?>

        <div class="entry-thumbnail">

<?php if ($site->isSearch): ?>

          <a href="<?php echo htmlSpecialChars($post->permalink) ?>">
            <img src="<?php echo htmlSpecialChars($timthumbUrl) ?>?src=<?php echo htmlSpecialChars($post->thumbnailSrc) ?>&amp;w=506&amp;h=150" alt="" />
          </a>

<?php else: ?>

          <a href="<?php echo htmlSpecialChars($post->permalink) ?>">
            <img src="<?php echo htmlSpecialChars($timthumbUrl) ?>?src=<?php echo htmlSpecialChars($post->thumbnailSrc) ?>&amp;w=506&amp;h=150" alt="" />
          </a>

<?php endif ?>

        </div> <!-- /#entry-thumbnail -->

<?php endif ?>

        <div class="info">
        <!-- date -->
          <span class="date information"><?php echo NTemplateHelpers::escapeHtml($template->date($post->date, "d"), ENT_NOQUOTES) ?>
&nbsp;<?php echo NTemplateHelpers::escapeHtml($template->date($post->date, "M"), ENT_NOQUOTES) ?>&nbsp;</span>
        <!-- author -->
          <span class="author information"><a class="url fn n" href="<?php echo htmlSpecialChars($post->author->postsUrl) ?>
" title="View all posts by <?php echo htmlSpecialChars($post->author->name) ?>" rel="author"><?php echo NTemplateHelpers::escapeHtml($post->author->name, ENT_NOQUOTES) ?></a></span>
        <!-- comments -->
          <span class="comments information"><?php echo NTemplateHelpers::escapeHtml($post->commentsCount, ENT_NOQUOTES) ?></span>
        <!-- categories -->
<?php if ($post->categories): ?>
          <span class="categories information"><?php echo $post->categories ?></span>
<?php endif ?>
        <!-- tags -->
<?php if ($post->tags): ?>
          <span class="tags information"><?php echo $post->tags ?></span>
<?php endif ?>
        </div> <!-- /.info -->

      </div>

      </div>
			<div class="entry-content">
				<?php echo $post->content ?>

			</div>

<?php NCoreMacros::includeTemplate('snippet-post-nav.php', array('location'=> 'nav-above') + $template->getParams(), $_l->templates['wa7uumaod7'])->render() ?>

<?php NCoreMacros::includeTemplate("snippet-comments.php", $template->getParams(), $_l->templates['wa7uumaod7'])->render() ?>

		</div><!-- end of content-wrapper -->
	</div><!-- end of mainbar -->
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
if (!function_exists($_l->blocks[$localBackground][] = '_lb768e039211__localBackground')) { function _lb768e039211__localBackground($_l, $_args) { extract($_args) ;if ($post->options('page_slider')->bgType == 'htmlBg'): if ($post->options('page_slider')->htmlBg != ""): ?>
    <img src="<?php echo htmlSpecialChars($post->options('page_slider')->htmlBg) ?>" alt="" />
<?php endif ;else: NCoreMacros::includeTemplate("snippet-custom-home-slider.php", array('slides' => $site->create('slider-creator', $post->options('page_slider')->sliderCat)) + $template->getParams(), $_l->templates['wa7uumaod7'])->render() ;endif ;}} call_user_func(reset($_l->blocks[$localBackground]), $_l, get_defined_vars()) ;
// template extending support
if ($_l->extends) {
	ob_end_clean();
	NCoreMacros::includeTemplate($_l->extends, get_defined_vars(), $template)->render();
}
