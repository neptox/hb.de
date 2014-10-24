{extends 'main-layout.php'}

{block content}

<div id="container" class="subpage defaultContentWidth onecolumn clearfix left">
<a id="kreuz" href="http://hof-biergarten.de/"></a>

  {if trim($post->content) != ""}

    <div id="content" class="mainbar entry-content" role="main">

      <h1>{$post->title}</h1>
      {!$post->content}

    </div>

  {/if}

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