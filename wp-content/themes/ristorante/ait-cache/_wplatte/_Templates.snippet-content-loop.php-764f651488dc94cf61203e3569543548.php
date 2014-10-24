<?php //netteCache[01]000490a:2:{s:4:"time";s:21:"0.62633500 1412609690";s:9:"callbacks";a:3:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:100:"/webspace/04/85842/hof-biergarten.de/wp-content/themes/ristorante/Templates/snippet-content-loop.php";i:2;i:1412606273;}i:1;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:20:"NFramework::REVISION";i:2;s:30:"eee17d5 released on 2011-08-13";}i:2;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:10:"checkConst";}i:1;s:21:"WPLATTE_CACHE_VERSION";i:2;i:4;}}}?><?php

// source file: /webspace/04/85842/hof-biergarten.de/wp-content/themes/ristorante/Templates/snippet-content-loop.php

?><?php list($_l, $_g) = NCoreMacros::initRuntime($template, '7tqmykmomf')
;
// snippets support
if (!empty($control->snippetMode)) {
	return NUIMacros::renderSnippets($control, $_l, get_defined_vars());
}

//
// main template
//
?>
<section>

<?php $iterations = 0; foreach ($iterator = $_l->its[] = new NSmartCachingIterator($posts) as $post): ?>

<?php if ($post->thumbnailSrc): ?>

	<article id="post-<?php echo htmlSpecialChars($post->id) ?>" class="<?php echo htmlSpecialChars($post->htmlClasses) ?> thumbnail clearfix">

<?php else: ?>

	<article id="post-<?php echo htmlSpecialChars($post->id) ?>" class="<?php echo htmlSpecialChars($post->htmlClasses) ?> no-thumbnail clearfix">

<?php endif ?>

		<header class="entry-header">
			<!-- article heading -->
			<h2 class="entry-title no-thumbnail"><a href="<?php echo htmlSpecialChars($post->permalink) ?>
" title="Permalink to <?php echo htmlSpecialChars($post->title) ?>" rel="bookmark"><?php echo NTemplateHelpers::escapeHtml($post->title, ENT_NOQUOTES) ?></a></h2>

			<div class="blog-box">
<?php if ($post->thumbnailSrc): ?>

				<div class="entry-thumbnail">

<?php if ($site->isSearch): ?>

					<a href="<?php echo htmlSpecialChars($post->permalink) ?>">
						<img src="<?php echo htmlSpecialChars($timthumbUrl) ?>?src=<?php echo htmlSpecialChars($post->thumbnailSrc) ?>&w=506&h=150" alt="" />
					</a>

<?php else: ?>

					<a href="<?php echo htmlSpecialChars($post->permalink) ?>">
						<img src="<?php echo htmlSpecialChars($timthumbUrl) ?>?src=<?php echo htmlSpecialChars($post->thumbnailSrc) ?>&w=506&h=150" alt="" />
					</a>

<?php endif ?>

				</div> <!-- /#entry-thumbnail -->

<?php endif ?>

				<div class="info">
				<!-- date -->
					<span class="date information"><a href="<?php echo WpLatteFunctions::getDayLink($post->date) ?>
"><?php echo NTemplateHelpers::escapeHtml($template->date($post->date, "d"), ENT_NOQUOTES) ?>
&nbsp;<?php echo NTemplateHelpers::escapeHtml($template->date($post->date, "M"), ENT_NOQUOTES) ?>&nbsp;</a></span>
				<!-- author -->
					<span class="author information"><a class="url fn n" href="<?php echo htmlSpecialChars($post->author->postsUrl) ?>
" title="View all posts by <?php echo htmlSpecialChars($post->author->name) ?>" rel="author"><?php echo NTemplateHelpers::escapeHtml($post->author->name, ENT_NOQUOTES) ?></a></span>
				<!-- comments -->
					<span class="comments information"><?php echo NTemplateHelpers::escapeHtml($post->commentsCount, ENT_NOQUOTES) ?></span>
				</div> <!-- /.info -->

			</div>

		</header> <!-- /.entry-header -->

<?php if ($site->isSearch): ?>
			<div class="entry-summary">
				<?php echo $post->excerpt ?>

			</div><!-- .entry-summary -->
<?php else: if ($post->thumbnailSrc): ?>
			<div class="entry-content thumbnail">
<?php else: ?>
			<div class="entry-content no-thumbnail">
<?php endif ?>
			<?php echo $post->content ?>

<?php 
			$a = array();
			if(empty($a)){
				wp_link_pages(array(
					"before" => "<div class=\"page-link\"><span>" . __("Pages:", "ait") . "</span>",
					"after" => "</div>"
				));
			}else{
				wp_link_pages(array(
					"before" => $a[1] . "<span>" . $a[0] . "</span>",
					"after" => $a[2]
				));
			}
			unset($a) ?>
			</div><!-- .entry-content -->
<?php endif ?>

<?php edit_post_link(__("Edit", "ait"), "<span class=\"edit-link\">", "</span>", $post->id) ?>

	</article> <!-- /#post -->

<?php $iterations++; endforeach; array_pop($_l->its); $iterator = end($_l->its) ?> <!-- /loop -->

</section>