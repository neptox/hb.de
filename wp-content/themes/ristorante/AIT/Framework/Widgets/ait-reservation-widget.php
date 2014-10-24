<?php
/**
 * Creates widget with posts
 */
class Reservation_Widget extends WP_Widget {
	protected $language;
	/**
	* Widget constructor
	*
	* @desc sets default options and controls for widget
	*/
	function Reservation_Widget(){
		if(!defined('ICL_LANGUAGE_CODE')){
            $this->language = "en";
        } else {
            $this->language = ICL_LANGUAGE_CODE;
        }

		/* Widget settings */
		$widget_ops = array (
			'classname' => 'widget_reservation',
			'description' => __('Insert a reservation form', 'ait')
		);
		/* Create the widget */
		$this->WP_Widget('reservation-widget', __('Theme &rarr; Reservation Form', 'ait'), $widget_ops);
	}
	/**
	* Displaying the widget
	*
	* Handle the display of the widget
	* @param array
	* @param array
	*/
	function widget($args, $instance){
		extract ($args);
		global $wp_query;
		/* Before widget(defined by theme)*/
		echo $before_widget;

		$query_string = '';
		if($instance['item_category'] == 0){
			$category_posts = get_posts( array( 'post_type' => 'ait-item', 'numberposts' => -1, 'orderby' => 'menu_order', 'order' => 'ASC' )  );
			//wp_reset_query();
		} else {
			$category_posts = get_posts( array( 'post_type' => 'ait-item', 'numberposts' => -1, 'orderby' => 'menu_order', 'order' => 'ASC', 'tax_query' => array( array( 'taxonomy' => 'ait-item-category', 'field' => 'id', 'terms' => $instance['item_category_'.$this->language]) ) )  );
			//wp_reset_query();
		}
		?>
		<h2 class="subpage-room-data-title widget-title"><?php echo (do_shortcode($instance['widget_title'])) ?></h2>
		<div class="reservation-form" style="display: none">
			<form id="reservation-form-1" class="clearfix" action="#" method="post">
				<div class="left clearfix holder">
					<div id="formEnabledInputs" style="display:none">
					<?php if(!empty($instance['datepicker_1_show'])){ echo('<div style="display: none">From</div>'); } ?>
					<?php if(!empty($instance['datepicker_2_show'])){ echo('<div style="display: none">To</div>'); } ?>
					</div>
					<div id="inputName1" style="display: None"><?php echo($instance['datepicker_1_text']) ?></div>
					<div id="inputName2" style="display: None"><?php echo($instance['datepicker_2_text']) ?></div>
					<input type="hidden" value="<?php echo( do_shortcode($instance['form_address'])) ?>" name="formLink" id="formLink"/>
					<div class="select-wrapper">
						<select name="room" id="room">
							<option value="NULL" SELECTED><?php echo($instance['dropdown_default_text']) ?></option>
							<?php
							if($instance['item_category'] == 0){
								$categories = get_categories( array( 'taxonomy' => 'ait-item-category', 'orderby' => 'menu_order', 'order' => 'ASC'));
								foreach($categories as $category){
									echo('<optgroup label="'.$category->name.'">');
									$category_posts = get_posts( array( 'post_type' => 'ait-item', 'orderby' => 'menu_order', 'order' => 'ASC', 'tax_query' => array( array( 'taxonomy' => 'ait-item-category', 'field' => 'id', 'terms' => $category->term_id) ) )  );
									//wp_reset_query();
									foreach($category_posts as $post){
										$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' );
										echo('<option value="'.$image[0].'">'.$post->post_title.'</option>');
									}
									echo('</optgroup>');
								}
							} else {
								foreach($category_posts as $post){
									$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' );
									echo('<option value="'.$image[0].'">'.$post->post_title.'</option>');
								}
							}
							?>
						</select>
					</div>
					<div id="datepickerFormat" style="display: none; visibility: hidden"><?php echo($instance['datepicker_format']) ?></div>
					<?php if(!empty($instance['datepicker_1_show'])){ ?>
						<input type="text" id="datePicker1" class="datePicker" name="datepickerFrom" value="<?php echo(do_shortcode($instance['datepicker_1_text'])) ?>" />
					<?php } ?>
						<?php if (!empty($instance['datepicker_2_show'])){ ?>
							<input type="text" id="datePicker2" class="datePicker" class="second" name="datepickerTo" value="<?php echo(do_shortcode($instance['datepicker_2_text'])) ?>" />
						<?php } ?>
				</div>
				<h5 class="book-now-button"><a href="javascript: PopulateForm('reservation-form-1');"><?php echo(do_shortcode($instance['button_text'])) ?></a></h5>
			</form>
		</div>
		<?php
		/* After widget(defined by theme)*/
		echo $after_widget;
	}

	/**
	* Update and save widget
	*
	* @param array $new_instance
	* @param array $old_instance
	* @return array New widget values
	*/
	function update($new_instance, $old_instance){
		$old_instance['widget_title'] = strip_tags( $new_instance['widget_title'] );
		$old_instance['form_address'] = strip_tags( $new_instance['form_address'] );
		$old_instance['item_category_'.$this->language] = strip_tags( $new_instance['item_category_'.$this->language] );
		$old_instance['datepicker_format'] = strip_tags( $new_instance['datepicker_format'] );
		$old_instance['dropdown_default_text'] = strip_tags( $new_instance['dropdown_default_text'] );
		$old_instance['datepicker_1_show'] = strip_tags( $new_instance['datepicker_1_show'] );
		$old_instance['datepicker_1_text'] = strip_tags( $new_instance['datepicker_1_text'] );
		$old_instance['datepicker_2_show'] = strip_tags( $new_instance['datepicker_2_show'] );
		$old_instance['datepicker_2_text'] = strip_tags( $new_instance['datepicker_2_text'] );
		$old_instance['button_text'] = strip_tags( $new_instance['button_text'] );

		return $old_instance;
	}

	/**
	* Creates widget controls or settings
	*
	* @param array Return widget options form
	*/
	function form($instance){
		$instance = wp_parse_args( (array) $instance, array(
			'widget_title' => '',
			'form_address' => '',
			'item_category_'.$this->language => 0,
			'datepicker_format' => 'yy-mm-dd',
			'dropdown_default_text' => '',
			'datepicker_1_show' => true,
			'datepicker_1_text' => '',
			'datepicker_2_show' => true,
			'datepicker_2_text' => '',
			'button_text' => ''
		) );
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'widget_title' ); ?>"><?php echo __( 'Widget Title', 'ait' ); ?>:</label>
			<input type="text" id="<?php echo $this->get_field_id( 'widget_title' ); ?>" name="<?php echo $this->get_field_name( 'widget_title' ); ?>" value="<?php echo $instance['widget_title']; ?>"class="widefat" style="width:100%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'form_address' ); ?>"><?php echo __( 'Form Address', 'ait' ); ?>:</label>
			<input type="text" id="<?php echo $this->get_field_id( 'form_address' ); ?>" name="<?php echo $this->get_field_name( 'form_address' ); ?>" value="<?php echo $instance['form_address']; ?>"class="widefat" style="width:100%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'item_category' ); ?>"><?php echo __( 'Item category', 'ait' ); ?>:</label>
			<?php
				wp_dropdown_categories( array( 'name' => $this->get_field_name("item_category_".$this->language), 'show_option_all' => 'All', 'show_count' => 1 ,'selected' => $instance["item_category_".$this->language],  'taxonomy' => 'ait-item-category' ) );
			?>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'datepicker_format' ); ?>"><?php echo __( 'Datepicker format', 'ait' ); ?>:</label>
			<select id="<?php echo $this->get_field_id( 'datepicker_format' ); ?>" name="<?php echo $this->get_field_name( 'datepicker_format' ); ?>">
				<option <?php if ( 'mm/dd/yy' == $instance['datepicker_format'] ) echo 'selected="selected"'; ?> value="mm/dd/yy">mm/dd/yy</option>
				<option <?php if ( 'yy-mm-dd' == $instance['datepicker_format'] ) echo 'selected="selected"'; ?> value="yy-mm-dd">yy-mm-dd</option>
				<option <?php if ( 'd M, y' == $instance['datepicker_format'] ) echo 'selected="selected"'; ?> value="d M, y">d M, y</option>
				<option <?php if ( 'd MM, y' == $instance['datepicker_format'] ) echo 'selected="selected"'; ?> value="d MM, y">d MM, y</option>
				<option <?php if ( 'DD, d MM, yy' == $instance['datepicker_format'] ) echo 'selected="selected"'; ?> value="DD, d MM, yy">DD, d MM, yy</option>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'dropdown_default_text' ); ?>"><?php echo __( 'Dropdown Default Text', 'ait' ); ?>:</label>
			<input type="text" id="<?php echo $this->get_field_id( 'dropdown_default_text' ); ?>" name="<?php echo $this->get_field_name( 'dropdown_default_text' ); ?>" value="<?php echo $instance['dropdown_default_text']; ?>"class="widefat" style="width:100%;" />
		</p>
		<p>
			<?php $checked = ''; if ( $instance['datepicker_1_show'] ) $checked = 'checked="checked"'; ?>
			<input type="checkbox" <?php echo $checked; ?> id="<?php echo $this->get_field_id( 'datepicker_1_show' ); ?>" name="<?php echo $this->get_field_name( 'datepicker_1_show' ); ?>" class="checkbox" />
			<label for="<?php echo $this->get_field_id( 'datepicker_1_show' ); ?>"><?php echo __( 'Display datepicker 1', 'ait' ); ?></label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'datepicker_1_text' ); ?>"><?php echo __( 'Datepicker 1 text', 'ait' ); ?>:</label>
			<input type="text" id="<?php echo $this->get_field_id( 'datepicker_1_text' ); ?>" name="<?php echo $this->get_field_name( 'datepicker_1_text' ); ?>" value="<?php echo $instance['datepicker_1_text']; ?>"class="widefat" style="width:100%;" />
		</p>
		<p>
			<?php $checked = ''; if ( $instance['datepicker_2_show'] ) $checked = 'checked="checked"'; ?>
			<input type="checkbox" <?php echo $checked; ?> id="<?php echo $this->get_field_id( 'datepicker_2_show' ); ?>" name="<?php echo $this->get_field_name( 'datepicker_2_show' ); ?>" class="checkbox" />
			<label for="<?php echo $this->get_field_id( 'datepicker_2_show' ); ?>"><?php echo __( 'Display datepicker 2', 'ait' ); ?></label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'datepicker_2_text' ); ?>"><?php echo __( 'Datepicker 2 text', 'ait' ); ?>:</label>
			<input type="text" id="<?php echo $this->get_field_id( 'datepicker_2_text' ); ?>" name="<?php echo $this->get_field_name( 'datepicker_2_text' ); ?>" value="<?php echo $instance['datepicker_2_text']; ?>"class="widefat" style="width:100%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'button_text' ); ?>"><?php echo __( 'Send button text', 'ait' ); ?>:</label>
			<input type="text" id="<?php echo $this->get_field_id( 'button_text' ); ?>" name="<?php echo $this->get_field_name( 'button_text' ); ?>" value="<?php echo $instance['button_text']; ?>"class="widefat" style="width:100%;" />
		</p>
		<?php
	}
}
register_widget( 'Reservation_Widget' );