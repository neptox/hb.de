<?php //netteCache[01]000480a:2:{s:4:"time";s:21:"0.74130800 1412607809";s:9:"callbacks";a:3:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:91:"/webspace/04/85842/hof-biergarten.de/wp-content/themes/ristorante/Templates/main-layout.php";i:2;i:1412606272;}i:1;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:20:"NFramework::REVISION";i:2;s:30:"eee17d5 released on 2011-08-13";}i:2;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:21:"WPLATTE_CACHE_VERSION";i:2;i:4;}}}?><?php

// source file: /webspace/04/85842/hof-biergarten.de/wp-content/themes/ristorante/Templates/main-layout.php

?><?php list($_l, $_g) = NCoreMacros::initRuntime($template, '98ep0n0id9')
;//
// block background
//
if (!function_exists($_l->blocks['background'][] = '_lbb4873ae3bf_background')) { function _lbb4873ae3bf_background($_l, $_args) { extract($_args)
;if ($themeOptions->globals->headerType == 'none'): if ($themeOptions->colors->htmlBg != ""): ?>
					<img src="<?php echo htmlSpecialChars($themeOptions->colors->htmlBg) ?>" alt="" />
<?php endif ;else: NCoreMacros::includeTemplate("snippet-custom-home-slider.php", array('slides' => $site->create('slider-creator', $themeOptions->globals->sliderCat)) + $template->getParams(), $_l->templates['98ep0n0id9'])->render() ;endif ;
}}

//
// end of blocks
//

// template extending and snippets support

$_l->extends = empty($template->_extends) ? FALSE : $template->_extends; unset($_extends, $template->_extends);


if ($_l->extends) {
	ob_start();
} elseif (!empty($control->snippetMode)) {
	return NUIMacros::renderSnippets($control, $_l, get_defined_vars());
}

//
// main template
//
?>
<!doctype html>
<!--[if IE 8]><html class="no-js oldie ie8" lang="<?php echo NTemplateHelpers::escapeHtmlComment($site->language) ?>"><![endif]-->
<!--[if IE 9]><html class="no-js newie ie9" lang="<?php echo NTemplateHelpers::escapeHtmlComment($site->language) ?>"><![endif]-->
<!--[if gt IE 9]><!--><html class="no-js" lang="<?php echo htmlSpecialChars($site->language) ?>"><!--<![endif]-->

<head>

	<meta charset="<?php echo htmlSpecialChars($site->charset) ?>" />
	<script type="text/javascript">
	var ua = navigator.userAgent;
	if(ua.toLowerCase().indexOf("mobile") > -1){
		var meta = document.createElement('meta');
		//alert('mobile');
		if(ua.toLowerCase().indexOf("ipad") > -1){
			//alert('ipad');
			meta.name = 'viewport';
			meta.content = 'width=device-width, initial-scale=1';
		} else {
			meta.name = 'viewport';
			meta.content = 'target-densitydpi=device-dpi, width=480';
		}
		var m = document.getElementsByTagName('meta')[0];
		m.parentNode.insertBefore(meta,m);
	}
	</script>
	<title><?php echo WpLatteFunctions::getTitle() ?></title>

	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php echo htmlSpecialChars($site->pingbackUrl) ?>" />

	<!--[if lt IE 9]>
	<script src="http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE9.js"></script>
	<![endif]-->

<?php if ($themeOptions->fonts->fancyFont->type == 'google'): ?>
	<link href="http://fonts.googleapis.com/css?family=<?php echo htmlSpecialChars($themeOptions->fonts->fancyFont->font) ?>" rel="stylesheet" type="text/css" />
<?php endif ?>

	<link id="ait-style" rel="stylesheet" type="text/css" media="all" href="<?php echo WpLatteFunctions::lessify() ?>" />

<?php if(is_singular() && get_option("thread_comments")){wp_enqueue_script("comment-reply");}wp_head() ?>

	<script src="http://maps.google.com/maps/api/js?v=3.2&amp;sensor=false"></script>

	<link id="responsive-style" rel="stylesheet" type="text/css" media="all" href="<?php echo htmlSpecialChars($themeCssUrl) ?>/responsive.css" />
</head>

<body class="<?php echo join(' ', get_body_class()) . ' ' . join(' ', array($bodyClasses, 'ait-ristorante')) ?>
" data-themeurl="<?php echo htmlSpecialChars($themeUrl) ?>">

	<div class="site">
        <div class="background clearfix">
            <div class="loader"></div>
<?php if (!$_l->extends) { call_user_func(reset($_l->blocks['background']), $_l, get_defined_vars()); } ?>
		</div>

		<div class="mainpage clearfix">

			<div class="left area clearfix">

				<header id="page-header" role="banner" class="header left clearfix">

					<div class="site-info">
						<div class="logo">
							<a href="<?php echo htmlSpecialChars($homeUrl) ?>" class="logo-link"><img src="<?php echo WpLatteFunctions::linkTo($themeOptions->general->logo_img) ?>" alt="logo" /></a>
						</div>
						<p class="tagline"><?php echo $themeOptions->general->logo_text ?></p>
					</div>

					<div id="mainmenu-dropdown-duration" style="display: none;"><?php echo NTemplateHelpers::escapeHtml($themeOptions->globals->mainmenu_dropdown_time, ENT_NOQUOTES) ?></div>
					<div id="mainmenu-dropdown-easing" style="display: none;"><?php echo NTemplateHelpers::escapeHtml($themeOptions->globals->mainmenu_dropdown_animation, ENT_NOQUOTES) ?></div>

<?php wp_nav_menu(array('theme_location'  => 'primary-menu',
						'fallback_cb'     => 'default_menu',
						'container'       => 'nav',
						'container_class' => 'mainmenu',
						'menu_class'      => 'menu clearfix')) ?>

<?php if(is_active_sidebar("left-sidebar")): ?>
					<section class="widget-area clearfix left-widgets">
<?php dynamic_sidebar('left-sidebar') ?>
					</section>
<?php endif ?>

				</header>

<?php NUIMacros::callBlock($_l, 'content', $template->getParams()) ?>

			</div>

			<footer id="page-footer" class="right clearfix" role="contentinfo">

				<div class="icons clearfix">
<?php if ($themeOptions->socialIcons->displayIcons): if (isset($themeOptions->socialIcons->icons)): ?>
					<ul id="right-icons" class="right clearfix">
<?php $iterations = 0; foreach ($iterator = $_l->its[] = new NSmartCachingIterator($themeOptions->socialIcons->icons) as $icon): ?>
						<li class="icon left">
							<a href="<?php if (!empty($icon->link)): echo htmlSpecialChars($icon->link) ;else: ?>
#<?php endif ?>">
								<img src="<?php echo htmlSpecialChars($icon->iconUrl) ?>" height="42" width="42" alt="<?php echo htmlSpecialChars($icon->title) ?>
" title="<?php echo htmlSpecialChars($icon->title) ?>" />
							</a>
						</li>
<?php $iterations++; endforeach; array_pop($_l->its); $iterator = end($_l->its) ?>
						<!-- WPML plugin required -->
<?php if (function_exists('icl_get_languages')): if (icl_get_languages('skip_missing=0')): ?>
						<li class="wpml icon left">
				    		<span class="languageicon">
				    			<span>
<?php $iterations = 0; foreach ($iterator = $_l->its[] = new NSmartCachingIterator(icl_get_languages('skip_missing=0')) as $lang): ?>
				    				<?php if ($lang['active'] == 1): echo NTemplateHelpers::escapeHtml($lang['language_code'], ENT_NOQUOTES) ;endif ?>

<?php $iterations++; endforeach; array_pop($_l->its); $iterator = end($_l->its) ?>
				    			</span>
				    		</span>
				    		<div id="language-bubble" class="bubble">
								<div class="bubble-box language-box">
									<ul class="clearfix">
<?php $iterations = 0; foreach ($iterator = $_l->its[] = new NSmartCachingIterator(icl_get_languages('skip_missing=0')) as $lang): ?>
										<li>
											<a href="<?php echo htmlSpecialChars($lang['url']) ?>" class="<?php if ($lang['active'] == 1): ?>
active<?php endif ?>">
												<img src="<?php echo htmlSpecialChars($lang['country_flag_url']) ?>" class="lang" alt="lang" /><?php echo NTemplateHelpers::escapeHtml($lang['translated_name'], ENT_NOQUOTES) ?>

											</a>
										</li>
<?php $iterations++; endforeach; array_pop($_l->its); $iterator = end($_l->its) ?>
									</ul>
								</div>
							</div>
				        </li>
<?php endif ;endif ?>
					</ul>
<?php endif ;endif ?>

				</div> <!-- /.icons -->

<?php if(is_active_sidebar("right-sidebar")): ?>
				<section class="widget-area clearfix right-widgets">
<?php dynamic_sidebar('right-sidebar') ?>
				</section>
<?php endif ?>

			</footer>

		</div> <!-- /.mainpage -->

	</div> <!-- /.site -->


<?php wp_footer() ?>

<?php if ($themeOptions->fonts->fancyFont->type == 'cufon'): 
			$__cufon = array('fonts',
		'fancyFont',
		"$themeUrl/design/js/libs/cufon.js",
		THEME_FONTS_URL . "/{$themeOptions->fonts->fancyFont->file}",
		$themeOptions->fonts->fancyFont->font,
		false) ?>
			<script id="ait-cufon-script" src="<?php echo $__cufon[2] ?>"></script>
			<?php
			$__tbCookie = @strstr($_COOKIE['aitThemeBox-' .THEME_CODE_NAME], 'Type\":\"google\"');
			if($__tbCookie === false and substr($__cufon[3], -3, 3) == '.js'): ?>
			<script id="ait-cufon-font-script" src="<?php echo $__cufon[3] ?>"></script>
			<?php endif ?>

			<script id="ait-cufon-font-replace">
				<?php if($__cufon[5]): ?>
				var isCookie = false;
				try{
					var type = Cookies.get('<?php echo $__cufon[0] . ucfirst($__cufon[1]) . 'Type'?>');
					if(type == undefined || (type != undefined && type == 'cufon'))
						isCookie = true;
				}catch(e){
					isCookie = true;
				}

				if(isCookie != false){
				<?php endif ?>
					<?php $__font = WpLatteFunctions::getCssFontSelectors($__cufon[1])?>
					Cufon.now();
					<?php foreach($__font as $selectors => $values): ?>
					Cufon.replace('<?php echo $selectors ?>', {
						fontFamily: "<?php echo $__cufon[4]?>".replace(/\+/g, ' ')
						<?php if(isset($values['text-shadow'])): ?>, textShadow: '<?php echo $values['text-shadow'] ?>
'<?php endif ?>
						<?php if(isset($values['hover'])): ?>, hover: {<?php if(isset($values['hover']['color'])): ?>
color: '<?php echo $values['hover']['color'] ?>'<?php endif; if(isset($values['hover']['text-shadow'])): ?>
,textShadow: '<?php echo $values['hover']['text-shadow'] ?>'<?php endif ?>}
						<?php endif ?>
					});
					<?php endforeach ?>
				<?php if($__cufon[5]): ?>}<?php endif ?>
			</script><?php endif ;if (isset($themeOptions->general->ga_code) && ($themeOptions->general->ga_code!="")): ?>
<script type="text/javascript">
	var _gaq = _gaq || [];
	_gaq.push(['_setAccount', <?php echo NTemplateHelpers::escapeJs($themeOptions->general->ga_code) ?>]);
	_gaq.push(['_trackPageview']);

	(function() {
		var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	})();
</script>
<?php endif ?>
</body>

</html><?php 
// template extending support
if ($_l->extends) {
	ob_end_clean();
	NCoreMacros::includeTemplate($_l->extends, get_defined_vars(), $template)->render();
}
