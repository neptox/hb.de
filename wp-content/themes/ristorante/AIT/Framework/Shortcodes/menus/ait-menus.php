<?php
function get_custom_menu( $params ) {
    extract( shortcode_atts( array (
        'id' => '',
		'excerpt' => 290,
		'closed' => '',
    'display' => '1',
		'readmore' => 'no',
		'readmoretext' => 'Read more'
    ), $params ) );
    if ($id) {
        $latest_post['0'] = get_post($id);
    }
    else {
        $latest_post = query_posts( 'post_type=ait-menu&p=' . $id );
    }

        $author = get_the_author_meta('nickname', $latest_post['0']->post_author );
        $post_link = get_permalink( $latest_post['0']->ID );
        $date = mysql2date(get_option('date_format'), $latest_post['0']->post_date);
        $category = get_the_category_list( ', ', $parents = '', $latest_post['0']->ID );

        $result = "";
    $result .= '<div class="menu-posts">';
    if($closed != ''){
       $result .= '<script type="text/javascript">
                  jQuery("#category-title-single").click(function(){
                    var topParent = jQuery(this).parent();
                    var wrapper = topParent.find(".menu-posts-wrap");
                    wrapper.slideToggle("slow");
                  });
                  </script>
       ';
    }
    $result .= '<div id="category-title-single" class="category-title"><h2 class="fancyFont">Latest Menu</h2></div>';
    $author = get_the_author_meta('nickname', $latest_post['0']->post_author );
    $post_link = get_permalink( $latest_post['0']->ID );
    $post_meta = get_post_meta($latest_post['0']->ID);
    $post_options = unserialize($post_meta['_ait-menu'][0]);
    $post_tags = wp_get_post_tags($latest_post['0']->ID);
    $date = mysql2date(get_option('date_format'), $latest_post['0']->post_date);
    $category = get_the_category_list( ', ', $parents = '', $latest_post['0']->ID );
    $result .= '<div class="menu-posts-wrap">';
    if (get_the_post_thumbnail( $latest_post['0']->ID, 'thumbnail' )) {
      $result .= '<div id="menu-post-'.$i.'" class="menu-post clearfix">';
      $image = wp_get_attachment_image_src( get_post_thumbnail_id( $latest_post['0']->ID ), 'single-post-thumbnail' );

		if(TIMTHUMB_URL)
			$timthumbSrc = TIMTHUMB_URL . '?src='.$image[0].'&amp;w=85&amp;h=66';
		else
			$timthumbSrc = AitImageResizer::resize($image[0], array('w' => 85, 'h' => 66));
      $result .= '  <a class="menu-thumb" href="'.$image[0].'" title="'.$latest_post['0']->post_title.'"><img class="menu-thumbnail" src="'.$timthumbSrc.'" alt="'.$latest_post['0']->post_title.'" /></a>';
    } else {
      $result .= '<div id="menu-post-'.$i.'" class="menu-post clearfix no-thumbnail">';
    }

    $result .= '  <div class="menu-text">';
    //$result .= '    <a href="'.$image[0].'"><img class="menu-thumbnail" src="'.$timthumbSrc.'" alt="'.$latest_post['0']->post_title.'" style="display: none" /><h2 class="menu-title">'.$latest_post->post_title.'</h2></a>';
    $result .= '    <h2 class="menu-title">'.$latest_post->post_title.'</h2>';
    $result .= '    <p class="menu-description">'.$post_options['menuDescription'].'</p>';

    $tags = "";
    foreach($post_tags as $post_tag){
      $tags .= $post_tag->name.', ';
    }
    $tags = substr($tags,0,strlen($tags)-2);

    if(!empty($tags)){
        $result .= '    <p class="menu-tags"><b>Ingredients: </b>'.$tags.'</p>';
    }
    $result .= '  </div>';
    $result .= '  <p class="menu-price"><b>'.$post_options['menuPrice'].'</b></p>';
    $result .= '</div>';
    $result .= do_shortcode('[rule]');
    $result .= '</div>';
    $result .= '</div>';
    if($closed != ''){
       $result .= "";
    }
    return $result;
}
add_shortcode( "get_menu", "get_custom_menu" );

function get_custom_menus( $params ) {
    extract( shortcode_atts( array (
        'number' => '1',
		'excerpt' => 290,
		'closed' => '',
    'display' => '1',
		'readmore' => 'no',
		'readmoretext' => 'Read more'
    ), $params ) );

    $latest_posts = query_posts( array( 'post_type' => 'ait-menu', 'orderby' => 'menu_order', 'order' => 'ASC', 'posts_per_page' => $number )  );

    $result = "";
    $result .= '<div class="menu-posts">';
    if($closed != ''){
       $result .= '<script type="text/javascript">
                  jQuery("#category-title-latest").click(function(){
                    var topParent = jQuery(this).parent();
                    var wrapper = topParent.find(".menu-posts-wrap");
                    wrapper.slideToggle("slow");
                  });
                  </script>
       ';
    }
    $result .= '<div id="category-title-latest" class="category-title"><h2 class="fancyFont">Latest Menus</h2></div>';
    $i = 0;
    $result .= '<div class="menu-posts-wrap">';
    foreach ($latest_posts as $key => $latest_post) {
      $author = get_the_author_meta('nickname', $latest_post->post_author );
      $post_link = get_permalink( $latest_post->ID );
      $post_meta = get_post_meta($latest_post->ID);
      $post_options = unserialize($post_meta['_ait-menu'][0]);
      $post_tags = wp_get_post_tags($latest_post->ID);
      $date = mysql2date(get_option('date_format'), $latest_post->post_date);
      $category = get_the_category_list( ', ', $parents = '', $latest_post->ID );


      if (get_the_post_thumbnail( $latest_post->ID, 'thumbnail' )) {
        $result .= '<div id="menu-post-'.$i.'" class="menu-post clearfix">';
        $image = wp_get_attachment_image_src( get_post_thumbnail_id( $latest_post->ID ), 'single-post-thumbnail' );
        if(TIMTHUMB_URL)
			$timthumbSrc = TIMTHUMB_URL . '?src='.$image[0].'&amp;w=85&amp;h=66';
        else
			$timthumbSrc = AitImageResizer::resize($image[0], array('w' => 85, 'h' => 66));
        $result .= '  <a class="menu-thumb" href="'.$image[0].'" title="'.$latest_post->post_title.'"><img class="menu-thumbnail" src="'.$timthumbSrc.'" alt="'.$latest_post->post_title.'" /></a>';
      } else {
        $result .= '<div id="menu-post-'.$i.'" class="menu-post clearfix no-thumbnail">';
      }

      $result .= '  <div class="menu-text">';
      //$result .= '    <a href="'.$image[0].'"><img class="menu-thumbnail" src="'.$timthumbSrc.'" alt="'.$latest_post->post_title.'" style="display: none" /><h2 class="menu-title">'.$latest_post->post_title.'</h2></a>';
      $result .= '    <h2 class="menu-title">'.$latest_post->post_title.'</h2>';
      $result .= '    <p class="menu-description">'.$post_options['menuDescription'].'</p>';

      $tags = "";
      foreach($post_tags as $post_tag){
        $tags .= $post_tag->name.', ';
      }
      $tags = substr($tags,0,strlen($tags)-2);

      if(!empty($tags)){
        $result .= '    <p class="menu-tags"><b>Ingredients: </b>'.$tags.'</p>';
      }
      $result .= '  </div>';
      $result .= '  <p class="menu-price"><b>'.$post_options['menuPrice'].'</b></p>';
      $result .= '</div>';

      $i++;
    }

    $result .= do_shortcode('[rule]');
    $result .= '</div>';
    $result .= '</div>';
    if($closed != ''){
       $result .= "";
    }
    return $result;
}
add_shortcode( "get_menus", "get_custom_menus" );

function get_category_menus( $params ) {
    extract( shortcode_atts( array (
        'number' => '1',
        'category' => '1',
        'excerpt' => 290,
        'closed' => '',
        'display' => '1',
        'readmore' => 'no',
		'readmoretext' => 'Read more'
    ), $params ) );

    $latest_posts = query_posts( array( 'post_type' => 'ait-menu', 'orderby' => 'menu_order', 'order' => 'ASC', 'posts_per_page' => $number, 'tax_query' => array( array( 'taxonomy' => 'ait-menu-category', 'field' => 'id', 'terms' => $category) ) )  );

    global $wpdb;

    $cat_name = $wpdb->get_results( "SELECT * FROM " .$wpdb->prefix . "terms WHERE `term_id` = ".$category );
    $cat_desc = $wpdb->get_results( "SELECT * FROM " .$wpdb->prefix . "term_taxonomy WHERE `term_id` = ".$category );

    $result = "";
    if(!empty($cat_name[0]->term_id)){
      $result .= '<div class="menu-posts" id="category-'.$cat_name[0]->term_id.'">';
    } else {
      $result .= '<div class="menu-posts">';
    }



    $result .= (!empty($cat_name[0]->name) ? '<div class="category-title"><h2 class="fancyFont">'.$cat_name[0]->name.'</h2></div>' : '<div class="category-title"><h2 class="fancyFont"></h2></div>') ;
    $i = 0;
    $result .= '<div class="menu-posts-wrap">';
    foreach ($latest_posts as $key => $latest_post) {
      $author = get_the_author_meta('nickname', $latest_post->post_author );
      $post_link = get_permalink( $latest_post->ID );
      $post_meta = get_post_meta($latest_post->ID);
      $post_options = unserialize($post_meta['_ait-menu'][0]);
      $post_tags = wp_get_post_tags($latest_post->ID);
      $date = mysql2date(get_option('date_format'), $latest_post->post_date);
      $category = get_the_category_list( ', ', $parents = '', $latest_post->ID );

      if (get_the_post_thumbnail( $latest_post->ID, 'thumbnail' )) {
        $result .= '<div id="menu-post-'.$i.'" class="menu-post clearfix">';
        $image = wp_get_attachment_image_src( get_post_thumbnail_id( $latest_post->ID ), 'single-post-thumbnail' );
        if(TIMTHUMB_URL)
			$timthumbSrc = TIMTHUMB_URL . '?src='.$image[0].'&amp;w=85&amp;h=66';
        else
			$timthumbSrc = AitImageResizer::resize($image[0], array('w' => 85, 'h' => 66));
        $result .= '  <a class="menu-thumb" href="'.$image[0].'" title="'.$latest_post->post_title.'"><img class="menu-thumbnail" src="'.$timthumbSrc.'" alt="'.$latest_post->post_title.'" /></a>';
      } else {
        $result .= '<div id="menu-post-'.$i.'" class="menu-post clearfix no-thumbnail">';
      }

      $result .= '  <div class="menu-text">';
      //$result .= '    <a href="'.$image[0].'"><img class="menu-thumbnail" src="'.$timthumbSrc.'" alt="'.$latest_post->post_title.'" style="display: none" /><h2 class="menu-title">'.$latest_post->post_title.'</h2></a>';
      $result .= '    <h2 class="menu-title">'.$latest_post->post_title.'</h2>';
      $result .= '    <p class="menu-description">'.$post_options['menuDescription'].'</p>';

      $tags = "";
      foreach($post_tags as $post_tag){
        $tags .= $post_tag->name.', ';
      }
      $tags = substr($tags,0,strlen($tags)-2);

      if(!empty($tags)){
        $result .= '    <p class="menu-tags"><b>Ingredients: </b>'.$tags.'</p>';
      }
      $result .= '  </div>';
      $result .= '  <p class="menu-price"><b>'.$post_options['menuPrice'].'</b></p>';
      $result .= '</div>';

      $i++;
    }
    $result .= do_shortcode('[rule]');
    $result .= (!empty($cat_desc[0]->description) ? '<p class="category-description">'.$cat_desc[0]->description.'</p>' : '<p class="category-description"></p>');
    $result .= '</div>';

    if($closed != ''){
       $result .= '<script type="text/javascript">
                  jQuery("#category-'.$cat_name[0]->term_id.' .category-title").click(function(){
                    jQuery("#category-'.$cat_name[0]->term_id.' .menu-posts-wrap").slideToggle("slow");
                  });
                  </script>
       ';
    }

    $result .= '</div>';
    if($closed != ''){
       $result .= "";
    }

    return $result;
}
add_shortcode( "get_menu_category", "get_category_menus" );
