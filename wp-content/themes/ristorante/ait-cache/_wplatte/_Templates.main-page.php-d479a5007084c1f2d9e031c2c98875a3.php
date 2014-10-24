<?php //netteCache[01]000478a:2:{s:4:"time";s:21:"0.48895100 1412808621";s:9:"callbacks";a:3:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:89:"/webspace/04/85842/hof-biergarten.de/wp-content/themes/ristorante/Templates/main-page.php";i:2;i:1412808617;}i:1;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:20:"NFramework::REVISION";i:2;s:30:"eee17d5 released on 2011-08-13";}i:2;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:21:"WPLATTE_CACHE_VERSION";i:2;i:4;}}}?><?php

// source file: /webspace/04/85842/hof-biergarten.de/wp-content/themes/ristorante/Templates/main-page.php

?><?php list($_l, $_g) = NCoreMacros::initRuntime($template, 'u495gq8981')
;//
// block content
//
if (!function_exists($_l->blocks['content'][] = '_lb1e426edb7e_content')) { function _lb1e426edb7e_content($_l, $_args) { extract($_args)
?>

<div id="container" class="subpage defaultContentWidth onecolumn clearfix left">
<a id="kreuz" href="http://hof-biergarten.de/"></a>

<?php if (trim($post->content) != ""): ?>

    <div id="content" class="mainbar entry-content" role="main">

      <h1><?php echo NTemplateHelpers::escapeHtml($post->title, ENT_NOQUOTES) ?></h1>
      <?php echo $post->content ?>


    </div>

<?php endif ?>

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
if (!function_exists($_l->blocks[$localBackground][] = '_lbb0171cc183__localBackground')) { function _lbb0171cc183__localBackground($_l, $_args) { extract($_args) ;if ($post->options('page_slider')->bgType == 'htmlBg'): if ($post->options('page_slider')->htmlBg != ""): ?>
		<img src="<?php echo htmlSpecialChars($post->options('page_slider')->htmlBg) ?>" alt="" />
<?php endif ;else: NCoreMacros::includeTemplate("snippet-custom-home-slider.php", array('slides' => $site->create('slider-creator', $post->options('page_slider')->sliderCat)) + $template->getParams(), $_l->templates['u495gq8981'])->render() ;endif ;}} call_user_func(reset($_l->blocks[$localBackground]), $_l, get_defined_vars()) ;
// template extending support
if ($_l->extends) {
	ob_end_clean();
	NCoreMacros::includeTemplate($_l->extends, get_defined_vars(), $template)->render();
}
