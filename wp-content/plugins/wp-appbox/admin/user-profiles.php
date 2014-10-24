<?php function wpAppbox_add_custom_affiliate_id($user) { ?>
		<?php  
			$options = get_option("wpAppbox");
			if($options['wpAppbox_user_affiliateids']) {
				$userid = $user->ID;
				if(!current_user_can('edit_user', $userid)) return FALSE;
				?>
		<h3><?php _e('WP-Appbox: Affiliate-IDs', 'wpappbox'); ?></h3>
		<script>
			function show_hide_options(affid) {
				var status = document.getElementById("wpAppbox_user<?php echo($userid); ?>_"+affid+"_global").checked;
				var table = document.getElementById("wpAppbox_user<?php echo($userid); ?>_"+affid+"_div");
				if(status == true) { table.style.display = ""; }
				else { table.style.display = "none"; }
			}
		</script>
		<table class="form-table">
			<tr>
				<th>
					<label for="wpAppbox_user<?php echo($userid); ?>_apple"><?php _e('Apple/PHG Token', 'wpappbox'); ?>:</label>
				</th>
				<td>
					<p><label for="wpAppbox_user<?php echo($userid); ?>_apple_global"><input onClick="javascript:show_hide_options('apple')" type="checkbox" name="wpAppbox_user<?php echo($userid); ?>_apple_global" id="wpAppbox_user<?php echo($userid); ?>_apple_global" value="1" <?php if($options['wpAppbox_user'.$userid.'_apple_global'] == true) echo 'checked="checked"'; ?> /> <?php _e('Nutze andere IDs als die globalen IDs aus den Einstellungen der WP-Appbox.', 'wp-appbox'); ?></label></p>
					<div id="wpAppbox_user<?php echo($userid); ?>_apple_div" <?php if(!$options['wpAppbox_user'.$userid.'_apple_global']) echo 'style="display:none;"'; ?>>
						<p style="margin-left: 24px;"><input type="text" name="wpAppbox_user<?php echo($userid); ?>_apple" id="wpAppbox_user<?php echo($userid); ?>_apple" value="<?php echo $options['wpAppbox_user'.$userid.'_apple']; ?>" class="regular-text" style="width: 200px;" /> <span class="description"><?php _e('Dein Affiliate Token bei Apple/PHG. Wird keine ID angegeben, wird die Standard-ID genutzt.', 'wpappbox'); ?></span></p>
						<p style="margin-left: 24px;"><label for="wpAppbox_user<?php echo($userid); ?>_apple_sponsored"><input type="checkbox" name="wpAppbox_user<?php echo($userid); ?>_apple_sponsored" value="1" <?php  if($options['wpAppbox_user'.$userid.'_apple_sponsored'] == true) echo 'checked="checked"'; ?> /> <?php _e('Ich habe keine ID bei Apple/PHG und möchte die ID des Entwicklers nutzen. (In diesem Falle: <strong>Danke</strong>!)', 'wp-appbox'); ?></label></p>
					</div>
				</td>
			</tr>
			<tr>
				<th>
					<label for="wpAppbox_user<?php echo($userid); ?>_affilinet"><?php _e('Affili.net-ID', 'wpappbox'); ?>:</label>
				</th>
				<td>
					<p><label for="wpAppbox_user<?php echo($userid); ?>_affilinet_global"><input onClick="javascript:show_hide_options('affilinet')" type="checkbox" name="wpAppbox_user<?php echo($userid); ?>_affilinet_global" id="wpAppbox_user<?php echo($userid); ?>_affilinet_global" value="1" <?php if($options['wpAppbox_user'.$userid.'_affilinet_global'] == true) echo 'checked="checked"'; ?> /> <?php _e('Nutze andere IDs als die globalen IDs aus den Einstellungen der WP-Appbox.', 'wp-appbox'); ?></label></p>
					<div id="wpAppbox_user<?php echo($userid); ?>_affilinet_div" <?php if(!$options['wpAppbox_user'.$userid.'_affilinet_global']) echo 'style="display:none;"'; ?>>
						<p style="margin-left: 24px;"><input type="text" name="wpAppbox_user<?php echo($userid); ?>_affilinet" id="wpAppbox_user<?php echo($userid); ?>_affilinet" value="<?php echo $options['wpAppbox_user'.$userid.'_affilinet']; ?>" class="regular-text" style="width: 200px;" /> <span class="description"><?php _e('Deine Affiliate-ID bei Affili.net. Wird keine ID angegeben, wird die Standard-ID genutzt.', 'wpappbox'); ?></span></p>
						<p style="margin-left: 24px;"><label for="wpAppbox_user<?php echo($userid); ?>_affilinet_sponsored"><input type="checkbox" name="wpAppbox_user<?php echo($userid); ?>_affilinet_sponsored" value="1" <?php  if($options['wpAppbox_user'.$userid.'_affilinet_sponsored'] == true) echo 'checked="checked"'; ?> /> <?php _e('Ich habe keine ID bei Affili.net und möchte die ID des Entwicklers nutzen. (In diesem Falle: <strong>Danke</strong>!)', 'wp-appbox'); ?></label></p>
					</div>
				</td>
			</tr>
			<tr>
				<th>
					<label for="wpAppbox_user<?php echo($userid); ?>_amazonpartnernet"><?php _e('Amazon PartnerNet ID', 'wpappbox'); ?>:</label>
				</th>
				<td>
					<p><label for="wpAppbox_user<?php echo($userid); ?>_amazonpartnernet_global"><input onClick="javascript:show_hide_options('amazonpartnernet')" type="checkbox" name="wpAppbox_user<?php echo($userid); ?>_amazonpartnernet_global" id="wpAppbox_user<?php echo($userid); ?>_amazonpartnernet_global" value="1" <?php  if($options['wpAppbox_user'.$userid.'_amazonpartnernet_global'] == true) echo 'checked="checked"'; ?> /> <?php _e('Nutze andere IDs als die globalen IDs aus den Einstellungen der WP-Appbox.', 'wp-appbox'); ?></label></p>
					<div id="wpAppbox_user<?php echo($userid); ?>_amazonpartnernet_div" <?php if(!$options['wpAppbox_user'.$userid.'_amazonpartnernet_global']) echo 'style="display:none;"'; ?>>
						<p style="margin-left: 24px;"><input type="text" name="wpAppbox_user<?php echo($userid); ?>_amazonpartnernet" id="wpAppbox_user<?php echo($userid); ?>_amazonpartnernet" value="<?php echo $options['wpAppbox_user'.$userid.'_amazonpartnernet']; ?>" class="regular-text" style="width: 200px;" /> <span class="description"><?php _e('Deine Affiliate-ID beim Amazon PartnerNet. Wird keine ID angegeben, wird die Standard-ID genutzt.', 'wpappbox'); ?></span></p>
						<p style="margin-left: 24px;"><label for="wpAppbox_user<?php echo($userid); ?>_amazonpartnernet_sponsored"><input type="checkbox" name="wpAppbox_user<?php echo($userid); ?>_amazonpartnernet_sponsored" value="1" <?php  if($options['wpAppbox_user'.$userid.'_amazonpartnernet_sponsored'] == true) echo 'checked="checked"'; ?> /> <?php _e('Ich habe keine ID beim Amazon PartnerNet und möchte die ID des Entwicklers nutzen. (In diesem Falle: <strong>Danke</strong>!)', 'wp-appbox'); ?></label></p>
					</div>
				</td>
			</tr>
		</table>
<?php }
}

function wpAppbox_save_custom_affiliate_id($user_id) {
	if(!current_user_can('edit_user', $user_id)) return FALSE;
	$settings = get_option("wpAppbox");
	if($settings['wpAppbox_user_affiliateids']) {
		$settings['wpAppbox_user'.$user_id.'_apple'] = $_POST['wpAppbox_user'.$user_id.'_apple'];
		$settings['wpAppbox_user'.$user_id.'_apple_global'] = $_POST['wpAppbox_user'.$user_id.'_apple_global'];
		$settings['wpAppbox_user'.$user_id.'_apple_sponsored'] = $_POST['wpAppbox_user'.$user_id.'_apple_sponsored'];
		$settings['wpAppbox_user'.$user_id.'_affilinet'] = $_POST['wpAppbox_user'.$user_id.'_affilinet'];
		$settings['wpAppbox_user'.$user_id.'_affilinet_global'] = $_POST['wpAppbox_user'.$user_id.'_affilinet_global'];
		$settings['wpAppbox_user'.$user_id.'_affilinet_sponsored'] = $_POST['wpAppbox_user'.$user_id.'_affilinet_sponsored'];
		$settings['wpAppbox_user'.$user_id.'_amazonpartnernet'] = $_POST['wpAppbox_user'.$user_id.'_amazonpartnernet'];
		$settings['wpAppbox_user'.$user_id.'_amazonpartnernet_global'] = $_POST['wpAppbox_user'.$user_id.'_amazonpartnernet_global'];
		$settings['wpAppbox_user'.$user_id.'_amazonpartnernet_sponsored'] = $_POST['wpAppbox_user'.$user_id.'_amazonpartnernet_sponsored'];
		update_option("wpAppbox", $settings);
	}
}

add_action('show_user_profile', 'wpAppbox_add_custom_affiliate_id');
add_action('edit_user_profile', 'wpAppbox_add_custom_affiliate_id');

add_action('personal_options_update', 'wpAppbox_save_custom_affiliate_id');
add_action('edit_user_profile_update', 'wpAppbox_save_custom_affiliate_id');

?>