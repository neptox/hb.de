{extends 'main-layout.php'}

{block content}

<div id="container" class="subpage defaultContentWidth onecolumn clearfix left">


	<div id="content" class="mainbar entry-content" role="main">

	<h1>{$post->title}</h1>

	<div class="postitem clear">

	{if !isset($post->options('post_featured_images')->hideFeatured)}

		{if $post->thumbnailSrc != false }

		<a href="{$post->thumbnailSrc}">
			<div class="entry-thumbnail">
				<img src="{$timthumbUrl}?src={$post->thumbnailSrc}&w=660&h=274" alt="" />
			</div>
		</a>

		{/if}

	{/if}

	</div>

	<div class="entry-content">

		{!$post->content}

	</div>

	{include 'snippet-post-nav.php' location=> nav-above}

	{include snippet-comments.php}

	</div>

</div>

{/block}

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