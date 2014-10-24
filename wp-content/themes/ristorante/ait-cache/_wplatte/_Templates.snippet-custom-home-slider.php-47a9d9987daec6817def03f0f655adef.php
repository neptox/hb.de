<?php //netteCache[01]000496a:2:{s:4:"time";s:21:"0.70129600 1412607809";s:9:"callbacks";a:3:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:106:"/webspace/04/85842/hof-biergarten.de/wp-content/themes/ristorante/Templates/snippet-custom-home-slider.php";i:2;i:1412606273;}i:1;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:20:"NFramework::REVISION";i:2;s:30:"eee17d5 released on 2011-08-13";}i:2;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:21:"WPLATTE_CACHE_VERSION";i:2;i:4;}}}?><?php

// source file: /webspace/04/85842/hof-biergarten.de/wp-content/themes/ristorante/Templates/snippet-custom-home-slider.php

?><?php list($_l, $_g) = NCoreMacros::initRuntime($template, 'x877vt5wbh')
;
// snippets support
if (!empty($control->snippetMode)) {
	return NUIMacros::renderSnippets($control, $_l, get_defined_vars());
}

//
// main template
//
if ($slides): ?>
<div class="slider-container">
    <div id="slider-delay" style="display:none"><?php echo NTemplateHelpers::escapeHtml($themeOptions->globals->sliderDelay, ENT_NOQUOTES) ?></div>
    <div id="slider-animTime" style="display:none"><?php echo NTemplateHelpers::escapeHtml($themeOptions->globals->sliderAnimTime, ENT_NOQUOTES) ?></div>

    <ul id="slider" class="slide clear clearfix">
<?php $iterations = 0; foreach ($iterator = $_l->its[] = new NSmartCachingIterator($slides) as $slide): ?>
            <li>
<?php if (isset($slide->options->topImage)): ?>
                <img src="<?php echo htmlSpecialChars($slide->options->topImage) ?>" alt="slide" />
<?php endif ?>

            </li>
<?php $iterations++; endforeach; array_pop($_l->its); $iterator = end($_l->its) ?>
    </ul>
</div>
<?php endif ;
