<!doctype html>
<!--[if IE 8]><html class="no-js oldie ie8" lang="{$site->language}"><![endif]-->
<!--[if IE 9]><html class="no-js newie ie9" lang="{$site->language}"><![endif]-->
<!--[if gt IE 9]><!--><html class="no-js" lang="{$site->language}"><!--<![endif]-->

<head>

	<meta charset="{$site->charset}" />
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
	<title>{title}</title>

	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="{$site->pingbackUrl}" />

	<!--[if lt IE 9]>
	<script src="http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE9.js"></script>
	<![endif]-->

	{if $themeOptions->fonts->fancyFont->type == 'google'}
	<link href="http://fonts.googleapis.com/css?family={$themeOptions->fonts->fancyFont->font}" rel="stylesheet" type="text/css" />
	{/if}

	<link id="ait-style" rel="stylesheet" type="text/css" media="all" href="{less}" />

	{head}

	<script src="http://maps.google.com/maps/api/js?v=3.2&amp;sensor=false"></script>

	<link id="responsive-style" rel="stylesheet" type="text/css" media="all" href="{$themeCssUrl}/responsive.css" />
{*
	{if isset($post) and isset($post->options('page_slider')->htmlBg) and !empty($post->options('page_slider')->htmlBg)}
	<style type="text/css">
		html { background: url('{$post->options('page_slider')->htmlBg}') no-repeat; }
	</style>
	{/if}*}
</head>

<body class="{bodyClasses $bodyClasses, ait-ristorante}" data-themeurl="{$themeUrl}">

	<div class="site">
        <div class="background clearfix">
            <div class="loader"></div>
			{block background}
				{if $themeOptions->globals->headerType == 'none'}
					{if $themeOptions->colors->htmlBg != ""}
					<img src="{$themeOptions->colors->htmlBg}" alt=""/>
					{/if}
				{else}
					{include snippet-custom-home-slider.php, slides => $site->create('slider-creator', $themeOptions->globals->sliderCat)}
				{/if}
			{/block}
		</div>

		<div class="mainpage clearfix">

			<div class="left area clearfix">

				<header id="page-header" role="banner" class="header left clearfix">

					<div class="site-info">
						<div class="logo">
							<a href="{$homeUrl}" class="logo-link"><img src="{linkTo $themeOptions->general->logo_img}" alt="logo"></a>
						</div>
						<p class="tagline">{!$themeOptions->general->logo_text}</p>
					</div>

					<div id="mainmenu-dropdown-duration" style="display: none;">{$themeOptions->globals->mainmenu_dropdown_time}</div>
					<div id="mainmenu-dropdown-easing" style="display: none;">{$themeOptions->globals->mainmenu_dropdown_animation}</div>

					{menu
						'theme_location'  => 'primary-menu',
						'fallback_cb'     => 'default_menu',
						'container'       => 'nav',
						'container_class' => 'mainmenu',
						'menu_class'      => 'menu clearfix'
					}

					{isActiveSidebar "left-sidebar"}
					<section class="widget-area clearfix left-widgets">
						{dynamicSidebar 'left-sidebar'}
					</section>
					{/isActiveSidebar}

				</header>

				{include #content}

			</div>

			<footer id="page-footer" class="right clearfix" role="contentinfo">

				<div class="icons clearfix">
				{if $themeOptions->socialIcons->displayIcons}
				{ifset $themeOptions->socialIcons->icons}
					<ul id="right-icons" class="right clearfix">
						{foreach $themeOptions->socialIcons->icons as $icon}
						<li class="icon left">
							<a href="{if !empty($icon->link)}{$icon->link}{else}#{/if}">
								<img src="{$icon->iconUrl}" height="42" width="42" alt="{$icon->title}" title="{$icon->title}">
							</a>
						</li>
						{/foreach}
						<!-- WPML plugin required -->
						{if function_exists(icl_get_languages)}
						{if icl_get_languages('skip_missing=0')}
						<li class="wpml icon left">
				    		<span class="languageicon">
				    			<span>
				    			{foreach icl_get_languages('skip_missing=0') as $lang}
				    				{if $lang['active'] == 1}{$lang['language_code']}{/if}
				    			{/foreach}
				    			</span>
				    		</span>
				    		<div id="language-bubble" class="bubble">
								<div class="bubble-box language-box">
									<ul class="clearfix">
										{foreach icl_get_languages('skip_missing=0') as $lang}
										<li>
											<a href="{$lang['url']}" class="{if $lang['active'] == 1}active{/if}">
												<img src="{$lang['country_flag_url']}" class="lang" alt="lang" />{$lang['translated_name']}
											</a>
										</li>
										{/foreach}
									</ul>
								</div>
							</div>
				        </li>
						{/if}
						{/if}
					</ul>
				{/ifset}
				{/if}

				</div> <!-- /.icons -->

				{isActiveSidebar "right-sidebar"}
				<section class="widget-area clearfix right-widgets">
					{dynamicSidebar 'right-sidebar'}
				</section>
				{/isActiveSidebar}

			</footer>

		</div> <!-- /.mainpage -->

	</div> <!-- /.site -->


{footer}

{if $themeOptions->fonts->fancyFont->type == 'cufon'}
	{cufon
		fonts,
		fancyFont,
		"$themeUrl/design/js/libs/cufon.js",
		THEME_FONTS_URL . "/{$themeOptions->fonts->fancyFont->file}",
		$themeOptions->fonts->fancyFont->font,
		false
	}
{/if}
{if isset($themeOptions->general->ga_code) && ($themeOptions->general->ga_code!="")}
<script type="text/javascript">
	var _gaq = _gaq || [];
	_gaq.push(['_setAccount', {$themeOptions->general->ga_code}]);
	_gaq.push(['_trackPageview']);

	(function() {
		var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	})();
</script>
{/if}
</body>

</html>