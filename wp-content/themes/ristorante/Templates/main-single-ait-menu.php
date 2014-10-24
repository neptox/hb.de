{extends 'main-layout.php'}

{block content}

<!-- SUBPAGE -->
<div id="container" class="subpage defaultContentWidth clearfix left">
	 <!-- MAINBAR -->
    <div id="content" class="mainbar entry-content" role="main">
		<div id="content-wrapper">
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

	        <!-- tags -->
	        {if $post->tags}
	        	<div class="blog-box">
					<span class="tags information"><strong>{!$post->tags}</strong></span>
				</div>
	        {/if}

		</div>


			{include 'snippet-post-nav.php' location=> nav-above}

			{include snippet-comments.php}

		</div><!-- end of content-wrapper -->
	</div><!-- end of mainbar -->

</div><!-- end of container -->
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