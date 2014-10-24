{extends 'main-layout.php'}

{block content}

<div id="container" class="subpage defaultContentWidth onecolumn clearfix left">

	<div id="content" class="mainbar entry-content" role="main">

		{if $posts}

			<h1 class="page-title">
				{if $archive->isDay}
					Daily Archives: <span>{$posts[0]->date|date:$site->dateFormat}</span>
				{elseif $archive->isMonth}
					Monthly Archives: <span>{$posts[0]->date|date:'F Y'}</span>
				{elseif $archive->isYear}
					Yearly Archives: <span>{$posts[0]->date|date:'Y'}</span>
				{else}
					{_}Blog Archives{/_}
				{/if}
			</h1>

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