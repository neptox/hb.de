{extends 'main-layout.php'}

{block content}

<div id="container" class="subpage defaultContentWidth onecolumn clearfix left">
	<div id="content" class="mainbar entry-content" role="main">

	{if !$isIndexPage}
		<h1>{$post->title}</h1>
		{!$post->content}
	{/if}

	{if $posts}

		{include general-content-nav.php location => 'nav-above'}

		{include snippet-content-loop.php posts => $posts}

		{include general-content-nav.php location => 'nav-below'}

	{else}

		<article id="post-0" class="post no-results not-found">

			<header class="entry-header">

				<h2 class="entry-title">Nothing Found</h2>

			</header><!-- .entry-header -->

			<div class="entry-content">

				<p>Sorry, but nothing matched your search criteria. Please try again with some different keywords.</p>
				{include 'general-search-form.php'}

			</div><!-- .entry-content -->

		</article><!-- #post-0 -->

	{/if}

	</div>
</div>

{/block}

{if !$isIndexPage}
{? isset($post->options('page_slider')->overrideGlobal) ? $localBackground = 'background' : $localBackground = 'asdasd'}
{define $localBackground}
	{if $post->options('page_slider')->bgType == 'htmlBg'}
		{if $post->options('page_slider')->htmlBg != ""}
		<img src="{$post->options('page_slider')->htmlBg}" alt=""/>
		{/if}
	{else}
		{include snippet-custom-home-slider.php, slides => $site->create('slider-creator', $post->options('page_slider')->sliderCat)}
	{/if}
{/define}
{/if}