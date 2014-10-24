<?php
/**
 * Creates widget with posts
 */

class Featured_Widget extends WP_Widget
{

/**
 * Widget constructor
 *
 * @desc sets default options and controls for widget
 */
	function Featured_Widget () {
		/* Widget settings */
		$widget_ops = array (
			'classname' => 'widget_featured',
			'description' => __('Insert a featured item', 'ait')
		);

		/* Create the widget */
		$this->WP_Widget('featured-widget', __('Theme &rarr; Featured Item', 'ait'), $widget_ops);
	}

/**
 * Displaying the widget
 *
 * Handle the display of the widget
 * @param array
 * @param array
 */
	function widget ( $args, $instance ) {
		extract ($args);
		global $wp_query;
		/* Before widget(defined by theme)*/
		echo $before_widget;

		$posts = query_posts( array( 'post_type' => $instance['item_type'], 'posts_per_page' => -1)  );
		$featured_posts = array();
    foreach($posts as $post){
      if($instance['item_ignoreFeatured']){
        array_push($featured_posts, $post);
      } else {
        $post_meta = get_post_meta($post->ID, ''); // empty string - backward compatibility
        $post_options = unserialize($post_meta['_ait-menu'][0]);
        if(isset($post_options['featured'])){
          array_push($featured_posts, $post);
        }
      }
    }

    if($instance['item_order'] == 'random'){
      shuffle($featured_posts);
    }

    wp_reset_query();

    echo('<div class="box widget-container widget_featured" id="featured-5689">');
    echo('<div class="box-wrapper">');
    echo('<h2 class="widget-title">'.do_shortcode($instance['widget_title']).'</h2>');

    foreach($featured_posts as $i => $featured_post){
      if($i < $instance['item_count']){
        echo('<div class="featured-item">');
        $image = wp_get_attachment_image_src( get_post_thumbnail_id( $featured_post->ID ), 'single-post-thumbnail' );
        $post_meta = get_post_meta($featured_post->ID, ''); // empty string - backward compatibility
        if(isset($post_meta['_ait-menu'])){
          $options = unserialize($post_meta['_ait-menu'][0]);
        }
        echo('<div class="thumb-wrapper">');
        if(isset($post_meta['_ait-menu'])){
          echo('<div class="price">'.$options['menuPrice'].'</div>');
        }

		if(TIMTHUMB_URL)
			$timthumbSrc = TIMTHUMB_URL . '?src='. getRealThumbnailUrl($image[0]) . '&amp;w=189&amp;h=80';
        else
			$timthumbSrc = AitImageResizer::resize(getRealThumbnailUrl($image[0]), array('w' => 189, 'h' => 80));

        echo('<a class="" href="'.$image[0].'" title="'.$featured_post->post_title.'"><img src="'.$timthumbSrc.'" alt="" title="'.$featured_post->post_title.'" width="189" class="border alignnone" /></a>');
        echo('</div>');
        if(isset($post_meta['_ait-menu'])){
        echo('<br><p><strong>'.$featured_post->post_title.': </strong>'.$options['menuDescription'].'</p>');
        } else {
          echo('<br><p><strong>'.$featured_post->post_title.': </strong>'.wp_trim_words($featured_post->post_content, 10).'</p>');
        }
        echo('</div>');
      }
    }
    echo('</div>');
    echo('</div>');
    ?>

    <?php
		/* After widget(defined by theme)*/
		echo $after_widget;
		//wp_reset_query();
	}

/**
 * Update and save widget
 *
 * @param array $new_instance
 * @param array $old_instance
 * @return array New widget values
 */
	function update ( $new_instance, $old_instance ) {
		$old_instance['widget_title'] = strip_tags( $new_instance['widget_title'] );
    $old_instance['item_type'] = strip_tags( $new_instance['item_type'] );
		$old_instance['item_count'] = strip_tags( $new_instance['item_count'] );
		$old_instance['item_order'] = strip_tags( $new_instance['item_order'] );
		$old_instance['item_ignoreFeatured'] = strip_tags( $new_instance['item_ignoreFeatured'] );

		return $old_instance;
	}


/**
 * Creates widget controls or settings
 *
 * @param array Return widget options form
 */

	function form ( $instance ) {
		$instance = wp_parse_args( (array) $instance, array(
        	'widget_title' => '',
        	'item_type' => '',
        	'item_count' => '5',
        	'item_order' => 'newest',
        	'item_ignoreFeatured' => false,
        ) );
	?>
		<p>
			<label for="<?php echo $this->get_field_id( 'widget_title' ); ?>"><?php echo __( 'Widget Title', 'ait' ); ?>:</label>
			<input type="text" id="<?php echo $this->get_field_id( 'widget_title' ); ?>" name="<?php echo $this->get_field_name( 'widget_title' ); ?>" value="<?php echo $instance['widget_title']; ?>"class="widefat" style="width:100%;" />
        </p>
		<p>

    <p>
			<label for="<?php echo $this->get_field_id( 'item_type' ); ?>"><?php echo __( 'Item type', 'ait' ); ?>:</label>
			<select id="<?php echo $this->get_field_id( 'item_type' ); ?>" name="<?php echo $this->get_field_name( 'item_type' ); ?>">
				<?php
        $post_types = get_post_types();
        foreach ($post_types  as $post_type ) {
          if(strlen(strstr($post_type,"ait-"))>0){
            $ignore = array("ait-portfolio","ait-slider-creator","ait-");
            $post_type_object = get_post_type_object($post_type);
            if(in_array($post_type,$ignore) == false){
              if ( strcmp($post_type,$instance['item_type']) == 0 ){
                echo('<option selected="selected" value="'.$post_type.'">'.$post_type_object->labels->name.'</option>');
              } else {
                echo('<option value="'.$post_type.'">'.$post_type_object->labels->name.'</option>');
              }
            }
          }
        }
        ?>
			</select>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'item_count' ); ?>"><?php echo __( 'Item count', 'ait' ); ?>:</label>
			<select id="<?php echo $this->get_field_id( 'item_count' ); ?>" name="<?php echo $this->get_field_name( 'item_count' ); ?>">
				<option <?php if ( '1' == $instance['item_count'] ) echo 'selected="selected"'; ?> value="1">1</option>
				<option <?php if ( '2' == $instance['item_count'] ) echo 'selected="selected"'; ?> value="2">2</option>
				<option <?php if ( '3' == $instance['item_count'] ) echo 'selected="selected"'; ?> value="3">3</option>
				<option <?php if ( '4' == $instance['item_count'] ) echo 'selected="selected"'; ?> value="4">4</option>
				<option <?php if ( '5' == $instance['item_count'] ) echo 'selected="selected"'; ?> value="5">5</option>
			</select>
		</p>

    <p>
			<label for="<?php echo $this->get_field_id( 'item_order' ); ?>"><?php echo __( 'Item order', 'ait' ); ?>:</label>
			<select id="<?php echo $this->get_field_id( 'item_order' ); ?>" name="<?php echo $this->get_field_name( 'item_order' ); ?>">
				<option <?php if ( 'random' == $instance['item_order'] ) echo 'selected="selected"'; ?> value="random">Random</option>
				<option <?php if ( 'newest' == $instance['item_order'] ) echo 'selected="selected"'; ?> value="newest">Newest</option>
			</select>
		</p>

		<p>
      <?php $checked = ''; if ( $instance['item_ignoreFeatured'] ) $checked = 'checked="checked"'; ?>
			<input type="checkbox" <?php echo $checked; ?> id="<?php echo $this->get_field_id( 'item_ignoreFeatured' ); ?>" name="<?php echo $this->get_field_name( 'item_ignoreFeatured' ); ?>" class="checkbox" />
			<label for="<?php echo $this->get_field_id( 'item_ignoreFeatured' ); ?>"><?php echo __( 'Ignore featured property', 'ait' ); ?></label>
    </p>
		<?php
	}
}
register_widget( 'Featured_Widget' );