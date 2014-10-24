{extends 'main-layout.php'}
{block content}

<!-- SUBPAGE -->
<div id="container" class="subpage defaultContentWidth onecolumn clearfix left">
	<!-- MAINBAR -->
	<div id="content" class="mainbar entry-content" role="main">

			{if $posts}

				{include general-content-nav.php location => 'nav-above'}

				{include snippet-item-loop.php posts => $posts}

				{include general-content-nav.php location => 'nav-below'}

			{else}

				<article id="post-0" class="post no-results not-found">

					<header class="entry-header">

						<h1 class="entry-title">Nothing Found</h1>

					</header><!-- .entry-header -->

					<div class="entry-content">

						<p>{_}Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post{/_}</p>
						{include 'general-search-form.php'}

					</div><!-- .entry-content -->

				</article><!-- #post-0 -->

			{/if}

	</div><!-- end of mainbar -->

	<!-- SIDEBAR -->
	<div class="sidebar">
		  {dynamicSidebar "blog-widgets-area"}
	</div><!-- end of sidebar -->

</div><!-- end of container -->
