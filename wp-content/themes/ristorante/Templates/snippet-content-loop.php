<section>

{foreach $posts as $post}

{if $post->thumbnailSrc}

	<article id="post-{$post->id}" class="{$post->htmlClasses} thumbnail clearfix">

{else}

	<article id="post-{$post->id}" class="{$post->htmlClasses} no-thumbnail clearfix">

{/if}

		<header class="entry-header">
			<!-- article heading -->
			<h2 class="entry-title no-thumbnail"><a href="{$post->permalink}" title="Permalink to {$post->title}" rel="bookmark">{$post->title}</a></h2>

			<div class="blog-box">
			{if $post->thumbnailSrc}

				<div class="entry-thumbnail">

				{if $site->isSearch}

					<a href="{$post->permalink}">
						<img src="{$timthumbUrl}?src={$post->thumbnailSrc}&w=506&h=150" alt=""/>
					</a>

				{else}

					<a href="{$post->permalink}">
						<img src="{$timthumbUrl}?src={$post->thumbnailSrc}&w=506&h=150" alt=""/>
					</a>

				{/if}

				</div> <!-- /#entry-thumbnail -->

			{/if}

				<div class="info">
				<!-- date -->
					<span class="date information"><a href="{dayLink $post->date}">{$post->date|date:"d"}&nbsp;{$post->date|date:"M"}&nbsp;</a></span>
				<!-- author -->
					<span class="author information"><a class="url fn n" href="{$post->author->postsUrl}" title="View all posts by {$post->author->name}" rel="author">{$post->author->name}</a></span>
				<!-- comments -->
					<span class="comments information">{$post->commentsCount}</span>
				</div> <!-- /.info -->

			</div>

		</header> <!-- /.entry-header -->

		{if $site->isSearch}
			<div class="entry-summary">
				{!$post->excerpt}
			</div><!-- .entry-summary -->
		{else}
		  {if $post->thumbnailSrc}
			<div class="entry-content thumbnail">
		  {else}
			<div class="entry-content no-thumbnail">
		  {/if}
			{!$post->content}
			{postContentPager}
			</div><!-- .entry-content -->
		{/if}

		{editPostLink $post->id}

	</article> <!-- /#post -->

{/foreach} <!-- /loop -->

</section>