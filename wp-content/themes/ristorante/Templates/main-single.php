{extends 'main-layout.php'}

{block content}

<!-- SUBPAGE -->
<div id="container" class="subpage defaultContentWidth clearfix left">
<a id="kreuz" href="http://hof-biergarten.de/"></a>
	 <!-- MAINBAR -->
    <div id="content" class="mainbar entry-content" role="main">
		{if $post->thumbnailSrc != false }
    <div id="content-wrapper">
    {else}
    <div id="content-wrapper" class="no-thumbnail">
    {/if}
			<h1>{$post->title}</h1>

      <div class="blog-box">
      {if $post->thumbnailSrc}

        <div class="entry-thumbnail">

        {if $site->isSearch}

          <a href="{$post->permalink}">
            <img src="{$timthumbUrl}?src={$post->thumbnailSrc}&amp;w=506&amp;h=150" alt=""/>
          </a>

        {else}

          <a href="{$post->permalink}">
            <img src="{$timthumbUrl}?src={$post->thumbnailSrc}&amp;w=506&amp;h=150" alt=""/>
          </a>

        {/if}

        </div> <!-- /#entry-thumbnail -->

      {/if}

        <div class="info">
        <!-- date -->
          <span class="date information">{$post->date|date:"d"}&nbsp;{$post->date|date:"M"}&nbsp;</span>
        <!-- author -->
          <span class="author information"><a class="url fn n" href="{$post->author->postsUrl}" title="View all posts by {$post->author->name}" rel="author">{$post->author->name}</a></span>
        <!-- comments -->
          <span class="comments information">{$post->commentsCount}</span>
        <!-- categories -->
        {if $post->categories}
          <span class="categories information">{!$post->categories}</span>
        {/if}
        <!-- tags -->
        {if $post->tags}
          <span class="tags information">{!$post->tags}</span>
        {/if}
        </div> <!-- /.info -->

      </div>

      </div>
			<div class="entry-content">
				{!$post->content}
			</div>

			{include 'snippet-post-nav.php' location=> nav-above}

			{include snippet-comments.php}

		</div><!-- end of content-wrapper -->
	</div><!-- end of mainbar -->
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