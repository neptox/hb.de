<!DOCTYPE html>
<html>
    <head>
        <title><?php echo_h($img->alttext)?></title>
        <meta property="og:image" content="<?php echo esc_attr($img->url)?>"/>
        <meta property="og:image:url" content="<?php echo esc_attr($img->url)?>"/>
        <meta property="og:image:width" content="<?php echo esc_attr($img->width); ?>"/>
        <meta property="og:image:height" content="<?php echo esc_attr($img->height); ?>"/>
        <meta property="og:title" content="<?php echo esc_attr($img->alttext)?>"/>
        <meta property='og:description' content='<?php echo esc_attr($img->description? $img->description : $img->alttext) ?>'/>
        <meta property="og:url" content="<?php echo $routed_url; ?>"/>
        <meta property="og:site_name" content="<?php echo esc_attr($blog_name) ?>"/>
        <meta property="og:type" content="blog"/>
        <style type="text/css">
            body {visibility: hidden; overflow: hidden}
        </style>
    </head>
    <body>
        <h1><?php echo_h($img->alttext)?></h1>
        <img
            src="<?php echo esc_attr($img->url)?>"
            alttext="<?php echo esc_attr($img->alttext)?>"
            title="<?php echo esc_attr($img->description? $img->description : $img->alttext) ?>"
            width="<?php echo esc_attr($img->width) ?>"
            height="<?php echo esc_attr($img->height) ?>"
        />
        <?php if ($img->description): ?>
        <p>
            <?php echo_h($img->description) ?>
        </p>
        <?php endif ?>
        <script type="text/javascript">window.location.href = '<?php echo $lightbox_url; ?>';</script>
    </body>
</html>