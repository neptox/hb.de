<p><?php _e('Welche App-Banner sollen bei der Verwendung ohne Formatstag standardmäßig genutzt werden?', 'wp-appbox'); ?></p>

<table class="form-table">
	<tr valign="top">
		<th scope="row"><label for="default_appbanner"><?php _e('Standard App-Banner', 'wp-appbox'); ?></label></th>
		<td colspan="7">
			<select name="wpAppbox_view_default" id="wpAppbox_view_default" class="postform" style="min-width:250px;">
			   <option class="level-0" value="1" <?php if($options['wpAppbox_view_default'] == '1') echo 'selected="selected"'; ?>><?php _e('Simple Badge', 'wp-appbox'); ?></option> 
			   <option class="level-0" value="3" <?php if($options['wpAppbox_view_default'] == '3') echo 'selected="selected"'; ?>><?php _e('Screenshots', 'wp-appbox'); ?></option>
			   <option class="level-0" value="6" <?php if($options['wpAppbox_view_default'] == '6') echo 'selected="selected"'; ?>><?php _e('Screenshots Only', 'wp-appbox'); ?></option>
			   <option class="level-0" value="2" <?php if($options['wpAppbox_view_default'] == '2') echo 'selected="selected"'; ?>><?php _e('Compact Badge', 'wp-appbox'); ?></option> 
			</select>
		</td>
	</tr>
	<?php 
		$th_last = count($store_names);
		$th_half = ceil($th_last/2);
		$th_count = -1;
		foreach($style_names_appstores as $store => $styles) { ?>
		<?php $th_count++; ?>
		<?php if(($th_count == 0) || ($th_half == $th_count)) { ?>
			<tr valign="top">
				<th scope="row"></th>
				<td style="width: 80px; text-align:center;"><?php _e('Standard', 'wp-appbox'); ?></td>
				<td style="width: 80px; text-align:center;"><?php _e('Simple', 'wp-appbox'); ?></td>
				<td style="width: 80px; text-align:center;"><?php _e('Compact', 'wp-appbox'); ?></td>
				<td style="width: 80px; text-align:center;"><?php _e('Screenshots', 'wp-appbox'); ?></td>
				<td style="width: 80px; text-align:center;"><?php _e('Screenshots&nbsp;Only', 'wp-appbox'); ?></td>
				<td style="width: 80px; text-align:center;"><?php _e('Banner', 'wp-appbox'); ?></td>
				<td style="width: 80px; text-align:center;"><?php _e('Video', 'wp-appbox'); ?></td>
				<td></td>
			</tr>
		<?php } ?>
		<tr valign="top">
			<th scope="row"><label for="default_<?php echo $store; ?>"><?php echo($store_names[$store]); ?></label></th>
			<?php foreach($style_names_global as $style_id => $style_name) { ?>
				<?php if((in_array($style_id, $styles)) || ($style_id == '0')) { ?>
					<td style="text-align:center;"><input name="wpAppbox_view_<?php echo $store; ?>" <?php if($options['wpAppbox_view_'.$store] == $style_id) echo 'checked="checked"'; ?>type="radio" id="wpAppbox_view_<?php echo $store; ?>" value="<?php echo $style_id; ?>" /></td>
				<?php } else { ?>
					<td></td>
				<?php } ?>
			<?php } ?>		
			<td></td>
		</tr>
	<?php } ?>
	<tr valign="top">
		<th scope="row"></th>
		<td style="width: 80px; text-align:center;"><?php _e('Standard', 'wp-appbox'); ?></td>
		<td style="width: 80px; text-align:center;"><?php _e('Simple', 'wp-appbox'); ?></td>
		<td style="width: 80px; text-align:center;"><?php _e('Compact', 'wp-appbox'); ?></td>
		<td style="width: 80px; text-align:center;"><?php _e('Screenshots', 'wp-appbox'); ?></td>
		<td style="width: 80px; text-align:center;"><?php _e('Screenshots&nbsp;Only', 'wp-appbox'); ?></td>
		<td style="width: 80px; text-align:center;"><?php _e('Banner', 'wp-appbox'); ?></td>
		<td style="width: 80px; text-align:center;"><?php _e('Video', 'wp-appbox'); ?></td>
		<td></td>
	</tr>
</table>