<script>
	function disable_enable_checkboxes(store) {
		var status = document.getElementById("wpAppbox_button_hidden_"+store).checked;
		var checkbox1 = document.getElementById("wpAppbox_button_appbox_"+store);
		var checkbox2 = document.getElementById("wpAppbox_button_alone_"+store);
		checkbox1.disabled = status;
		checkbox2.disabled = status;
		if(status == true) {
			checkbox1.checked = false;
			checkbox2.checked = false;
		}
	}
	function show_hide_table() {
		var status = document.getElementById("wpAppbox_button_default").selectedIndex;
		var table = document.getElementById("table_buttons_settings");
		if(status == "3") { table.style.display = ""; }
		else { table.style.display = "none"; }
	}
	function select_buttons_appbox(status) {
		<?php foreach($store_names as $store => $name) { ?>
			var checkbox_<?php echo $store; ?> = document.getElementById("wpAppbox_button_appbox_<?php echo $store; ?>");
			checkbox_<?php echo $store; ?>.checked = status;
		<?php } ?>
	}
	function select_buttons_alone(status) {
		<?php foreach($store_names as $store => $name) { ?>
			var checkbox_<?php echo $store; ?> = document.getElementById("wpAppbox_button_alone_<?php echo $store; ?>");
			checkbox_<?php echo $store; ?>.checked = status;
		<?php } ?>
	}
	function select_buttons_hidden(status) {
		<?php foreach($store_names as $store => $name) { ?>
			var checkbox_<?php echo $store; ?> = document.getElementById("wpAppbox_button_hidden_<?php echo $store; ?>");
			var checkbox1_<?php echo $store; ?> = document.getElementById("wpAppbox_button_appbox_<?php echo $store; ?>");
			var checkbox2_<?php echo $store; ?> = document.getElementById("wpAppbox_button_alone_<?php echo $store; ?>");
			checkbox_<?php echo $store; ?>.checked = status;
			checkbox1_<?php echo $store; ?>.disabled = status;
			checkbox2_<?php echo $store; ?>.disabled = status;
			if(status == true) {
				checkbox1_<?php echo $store; ?>.checked = false;
				checkbox2_<?php echo $store; ?>.checked = false;
			}
		<?php } ?>
	}
</script>

<p><?php _e('Welche Buttons sollen im WordPress-Editor angezeigt werden Neben einem kombinierten Button ist es auch möglich, häufig genutzte Buttons gesondert anzeigen zu lassen.', 'wp-appbox'); ?></p>

<table class="form-table">
	<tr valign="top">
		<th scope="row"><label for="button_default"><?php _e('Buttonverhalten', 'wp-appbox'); ?></label></th>
		<td colspan="7">
			<select onChange="javascript:show_hide_table()" name="wpAppbox_button_default" id="wpAppbox_button_default" class="postform">
			   <option <?php if($options['wpAppbox_button_default'] == '0') echo 'selected="selected"'; ?>class="level-0" value="0"><?php _e('Zeige sämtliche App-Store-Buttons im Editor', 'wp-appbox'); ?></option> 
			   <option <?php if($options['wpAppbox_button_default'] == '1') echo 'selected="selected"'; ?>class="level-0" value="1"><?php _e('Zeige sämtliche App-Store-Buttons im Editor innerhalb des Appbox-Buttons', 'wp-appbox'); ?></option>
			   <option <?php if($options['wpAppbox_button_default'] == '2') echo 'selected="selected"'; ?>class="level-0" value="2"><?php _e('Zeige keinerlei Buttons im Editor', 'wp-appbox'); ?></option>
			   <option <?php if($options['wpAppbox_button_default'] == '3') echo 'selected="selected"'; ?>class="level-0" value="3"><?php _e('Benutzerdefinierte Einstellungen', 'wp-appbox'); ?></option>
			</select>
		</td>
	</tr>
</table>

<table id="table_buttons_settings" class="form-table" <?php if($options['wpAppbox_button_default'] != '3') echo 'style="display:none;"'; ?>>
	<?php 
		$th_last = count($store_names);
		$th_half = ceil($th_last/2);
		$th_count = -1;
		foreach($store_names as $store => $name) { ?>
		<?php $th_count++; ?>
		<?php if(($th_count == 0) || ($th_half == $th_count)) { ?>
			<tr valign="top">
				<th scope="row"></th>
				<td style="width: 130px; text-align:center;">
					<?php _e('Im Appbox-Button', 'wp-appbox'); ?>
					<?php if($th_count == 0) { ?><br /><small>
						<a href="#" onClick="select_buttons_appbox(true);return false;"><?php _e('Alle', 'wpappbox'); ?></a> | 
						<a href="#" onClick="select_buttons_appbox(false);return false;"><?php _e('Keine', 'wpappbox'); ?></a>
					</small><?php } ?>
				</td>
				<td style="width: 130px; text-align:center;">
					<?php _e('Als Stand-Alone', 'wp-appbox'); ?>
					<?php if($th_count == 0) { ?><br /><small>
						<a href="#" onClick="select_buttons_alone(true);return false;"><?php _e('Alle', 'wpappbox'); ?></a> | 
						<a href="#" onClick="select_buttons_alone(false);return false;"><?php _e('Keine', 'wpappbox'); ?></a>
					</small><?php } ?>
				</td>
				<td style="width: 130px; text-align:center;">
					<?php _e('Button ausblenden', 'wp-appbox'); ?>
					<?php if($th_count == 0) { ?><br /><small>
						<a href="#" onClick="select_buttons_hidden(true);return false;"><?php _e('Alle', 'wpappbox'); ?></a> | 
						<a href="#" onClick="select_buttons_hidden(false);return false;"><?php _e('Keine', 'wpappbox'); ?></a>
					</small><?php } ?>
				</td>
				<td></td>
			</tr>
		<?php } ?>
		<tr valign="top">
			<th scope="row"><label for="button_<?php echo $store; ?>"><?php echo($store_names[$store]); ?></label></th>
				<td style="text-align:center;">
					<input name="wpAppbox_button_appbox_<?php echo $store; ?>" <?php if($options['wpAppbox_button_appbox_'.$store]) echo 'checked="checked"'; ?><?php if($options['wpAppbox_button_hidden_'.$store]) echo 'disabled="disabled"'; ?>type="checkbox" id="wpAppbox_button_appbox_<?php echo $store; ?>" value="1" />
				</td>	
				<td style="text-align:center;">
					<input name="wpAppbox_button_alone_<?php echo $store; ?>" <?php if($options['wpAppbox_button_alone_'.$store]) echo 'checked="checked"'; ?><?php if($options['wpAppbox_button_hidden_'.$store]) echo 'disabled="disabled"'; ?>type="checkbox" id="wpAppbox_button_alone_<?php echo $store; ?>" value="1" />
				</td>	
				<td style="text-align:center;">
					<input name="wpAppbox_button_hidden_<?php echo $store; ?>" <?php if($options['wpAppbox_button_hidden_'.$store]) echo 'checked="checked"'; ?>type="checkbox" id="wpAppbox_button_hidden_<?php echo $store; ?>" onClick="javascript:disable_enable_checkboxes('<?php echo $store; ?>')" value="1" />
				</td>	
			<td></td>
		</tr>
	<?php } ?>
	<tr valign="top">
		<th scope="row"></th>
		<td style="width: 130px; text-align:center;"><?php _e('Im Appbox-Button', 'wp-appbox'); ?></td>
		<td style="width: 130px; text-align:center;"><?php _e('Als Stand-Alone', 'wp-appbox'); ?></td>
		<td style="width: 130px; text-align:center;"><?php _e('Button ausblenden', 'wp-appbox'); ?></td>
		<td></td>
	</tr>
</table>