<?php //netteCache[01]000477a:2:{s:4:"time";s:21:"0.67123300 1412608377";s:9:"callbacks";a:3:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:88:"/webspace/04/85842/hof-biergarten.de/wp-content/themes/ristorante/Templates/main-404.php";i:2;i:1412606272;}i:1;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:20:"NFramework::REVISION";i:2;s:30:"eee17d5 released on 2011-08-13";}i:2;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:21:"WPLATTE_CACHE_VERSION";i:2;i:4;}}}?><?php

// source file: /webspace/04/85842/hof-biergarten.de/wp-content/themes/ristorante/Templates/main-404.php

?><?php list($_l, $_g) = NCoreMacros::initRuntime($template, 'vg5ojf25mv')
;//
// block content
//
if (!function_exists($_l->blocks['content'][] = '_lb6431deaa1d_content')) { function _lb6431deaa1d_content($_l, $_args) { extract($_args)
?>

<div id="container" class="subpage defaultContentWidth onecolumn clearfix left">

	<div id="content" class="mainbar entry-content" role="main">
	
		<h1><?php ob_start() ?>Entweder die Seite ist verschwunden oder Sie haben sich vertippt.<?php echo  NTemplateHelpers::escapeHtml(__(ob_get_clean(), 'ait'), ENT_NOQUOTES) ?></h1>

<!--	<h1><?php ob_start() ?>This is somewhat embarrassing, isn't it?<?php echo  NTemplateHelpers::escapeHtmlComment(__(ob_get_clean(), 'ait')) ?></h1>

		<p><?php ob_start() ?>Apologies, but the page you requested could not be found. Perhaps searching will help.<?php echo  NTemplateHelpers::escapeHtmlComment(__(ob_get_clean(), 'ait')) ?></p>

<?php NCoreMacros::includeTemplate("general-search-form.php", $template->getParams(), $_l->templates['vg5ojf25mv'])->render() ?>
-->

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
$_l->extends = 'main-layout.php' ;  
// template extending support
if ($_l->extends) {
	ob_end_clean();
	NCoreMacros::includeTemplate($_l->extends, get_defined_vars(), $template)->render();
}
