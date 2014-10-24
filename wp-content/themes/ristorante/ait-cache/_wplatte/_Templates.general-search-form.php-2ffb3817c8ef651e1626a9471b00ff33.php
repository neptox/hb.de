<?php //netteCache[01]000488a:2:{s:4:"time";s:21:"0.74584000 1412608377";s:9:"callbacks";a:3:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:99:"/webspace/04/85842/hof-biergarten.de/wp-content/themes/ristorante/Templates/general-search-form.php";i:2;i:1412606271;}i:1;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:20:"NFramework::REVISION";i:2;s:30:"eee17d5 released on 2011-08-13";}i:2;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:21:"WPLATTE_CACHE_VERSION";i:2;i:4;}}}?><?php

// source file: /webspace/04/85842/hof-biergarten.de/wp-content/themes/ristorante/Templates/general-search-form.php

?><?php list($_l, $_g) = NCoreMacros::initRuntime($template, 'pbetq1p4n5')
;
// snippets support
if (!empty($control->snippetMode)) {
	return NUIMacros::renderSnippets($control, $_l, get_defined_vars());
}

//
// main template
//
?>
<form action="<?php echo htmlSpecialChars($homeUrl) ?>" id="searchform" method="get" class="searchform">
	<div>
	   	<label class="screen-reader-text" for="s"><?php ob_start() ?>Search for:<?php echo  NTemplateHelpers::escapeHtml(__(ob_get_clean(), 'ait'), ENT_NOQUOTES) ?></label>
		<input type="text" name="s" id="s" placeholder="search..." class="s" />
		<input type="submit" name="submit" id="searchsubmit" value="Search" class="searchsubmit" />
	</div>
</form>