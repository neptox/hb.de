{if $slides}
<div class="slider-container">
    <div id="slider-delay" style="display:none">{$themeOptions->globals->sliderDelay}</div>
    <div id="slider-animTime" style="display:none">{$themeOptions->globals->sliderAnimTime}</div>

    <ul id="slider" class="slide clear clearfix">
        {foreach $slides as $slide}
            <li>
                {ifset $slide->options->topImage}
                <img src="{$slide->options->topImage}" alt="slide" />
                {/ifset}

            </li>
        {/foreach}
    </ul>
</div>
{/if}