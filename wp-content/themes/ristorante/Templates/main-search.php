{extends 'main-layout.php'}

{block content}

<div id="container" class="subpage defaultContentWidth onecolumn clearfix left">

	<div id="content" class="mainbar entry-content" role="main">

	{if $posts}

			<h1 class="page-title">
				{_}Search Results for: {/_}<span>{$site->searchQuery}</span>
			</h1>

		{include general-content-nav.php location => 'nav-above'}

		{include snippet-content-loop.php posts => $posts}

		{include general-content-nav.php location => 'nav-below'}

	{else}

		<article id="post-0" class="post no-results not-found">

			<header class="entry-header">

				<h1 class="entry-title">{_}Nothing Found{/_}</h1>

			</header><!-- .entry-header -->

			<div class="entry-content">

				<p>{_}Sorry, but nothing matched your search criteria. Please try again with some different keywords.{/_}</p>
				{include 'general-search-form.php'}

			</div><!-- .entry-content -->

		</article><!-- #post-0 -->

	{/if}

	</div>

</div>

{/block}