<h3><?php _e('(Mac) App Store &amp; App Store: PHG', 'wp-appbox'); ?></h3>
<p><?php _e('Du hast eine Affiliate-ID bei PHG? Dann gebe sie hier an und die App-Store-Links werden mit deiner Affiliate-ID versehen. Du hast keinen PHG-Account?', 'wp-appbox'); ?> <a href="http://affiliate.itunes.apple.com/de/apply" target="_blank"><?php _e('Hier bekommst du einen.', 'wp-appbox'); ?></a></p>

<table class="form-table">
	<tr valign="top">
		<th scope="row"><label for="wpAppbox_affid"><?php _e('Affiliate Token', 'wp-appbox'); ?>:</label></th>
		<td>
			<input type="text" name="wpAppbox_affid" id="wpAppbox_affid" value="<?php echo $options['wpAppbox_affid']; ?>" />
		</td>
	</tr>
	<tr valign="top">
		<th scope="row"><label for="wpAppbox_affid_sponsored"><?php _e('Nutze die ID des Entwicklers', 'wp-appbox'); ?>:</label></th>
		<td>	
			<input type="checkbox" name="wpAppbox_affid_sponsored" id="wpAppbox_affid_sponsored" value="1" <?php if($options['wpAppbox_affid_sponsored'] == true) echo 'checked="checked"'; ?> /> <?php _e('Ich habe keine ID bei Apple/PHG und möchte die ID des Entwicklers nutzen. (In diesem Falle: <strong>Danke</strong>!)', 'wp-appbox'); ?>
		</td>
	</tr>
</table>

<h3><?php _e('AndroidPit: Affili.net', 'wp-appbox'); ?></h3>
<p><?php _e('Du hast eine Affiliate-ID bei Affili.net? Dann gebe sie hier an und die AndroidPit-Links werden mit deiner Affiliate-ID versehen. Du hast keinen Affili.net-Account?', 'wp-appbox'); ?> <a href="http://www.affili.net/" target="_blank"><?php _e('Hier bekommst du einen.', 'wp-appbox'); ?></a></p>

<table class="form-table">
	<tr valign="top">
		<th scope="row"><label for="wpAppbox_affid_affilinet"><?php _e('Affili.net-ID', 'wp-appbox'); ?>:</label></th>
		<td>
			<input type="text" name="wpAppbox_affid_affilinet" id="wpAppbox_affid_affilinet" value="<?php echo $options['wpAppbox_affid_affilinet']; ?>" />
		</td>
	</tr>
	<tr valign="top">
		<th scope="row"><label for="wpAppbox_affid_affilinet_sponsored"><?php _e('Nutze die ID des Entwicklers', 'wp-appbox'); ?>:</label></th>
		<td>	
			<input type="checkbox" name="wpAppbox_affid_affilinet_sponsored" id="wpAppbox_affid_affilinet_sponsored" value="1" <?php if($options['wpAppbox_affid_affilinet_sponsored'] == true) echo 'checked="checked"'; ?> /> <?php _e('Ich habe keine ID bei Affili.net und möchte die ID des Entwicklers nutzen. (In diesem Falle: <strong>Danke</strong>!)', 'wp-appbox'); ?>
		</td>
	</tr>
</table>

<h3><?php _e('Amazon Apps: Amazon PartnerNet', 'wp-appbox'); ?></h3>
<p><?php _e('Du hast eine Affiliate-ID beim Amazon PartnerNet? Dann gebe sie hier an und die Amazon-App-Shop-Links werden mit deiner Affiliate-ID versehen. Du hast keinen Amazon-PartnerNet-Account?', 'wp-appbox'); ?> <a href="https://partnernet.amazon.de/" target="_blank"><?php _e('Hier bekommst du einen.', 'wp-appbox'); ?></a></p>

<table class="form-table">
	<tr valign="top">
		<th scope="row"><label for="wpAppbox_affid_amazonpartnernet"><?php _e('Amazon PartnerNet ID', 'wp-appbox'); ?>:</label></th>
		<td>	
			<input type="text" name="wpAppbox_affid_amazonpartnernet" id="wpAppbox_affid_amazonpartnernet" value="<?php echo $options['wpAppbox_affid_amazonpartnernet']; ?>" />
		</td>
	</tr>
	<tr valign="top">
		<th scope="row"><label for="wpAppbox_affid_amazonpartnernet_sponsored"><?php _e('Nutze die ID des Entwicklers', 'wp-appbox'); ?>:</label></th>
		<td>	
			<input type="checkbox" name="wpAppbox_affid_amazonpartnernet_sponsored" id="wpAppbox_affid_amazonpartnernet_sponsored" value="1" <?php  if($options['wpAppbox_affid_amazonpartnernet_sponsored'] == true) echo 'checked="checked"'; ?> /> <?php _e('Ich habe keine ID beim Amazon PartnerNet und möchte die ID des Entwicklers nutzen. (In diesem Falle: <strong>Danke</strong>!)', 'wp-appbox'); ?>
		</td>
	</tr>
</table>

<h3><?php _e('Benutzerdefinitierte Affiliate-IDs', 'wp-appbox'); ?></h3>
<p><?php _e('Jeder Benutzer und Autor kann seine eigenen Affiliate-IDs nutzen, sofern unter seinem Namen ein Artikel veröffentlicht wird. Wird keine ID im Benutzerprofil angegeben, so werden die globalen IDs verwendet.', 'wp-appbox'); ?></p>

<table class="form-table">
	<tr valign="top">
		<th scope="row"><label for="wpAppbox_user_affiliateids"><?php _e('Benutzer-IDs aktivieren', 'wp-appbox'); ?>:</label></th>
		<td>	
			<input type="checkbox" name="wpAppbox_user_affiliateids" id="wpAppbox_user_affiliateids" value="1" <?php if($options['wpAppbox_user_affiliateids']) echo 'checked="checked"'; ?> /> <?php _e('Aktiviert die Möglichkeit, benutzerspezifische IDs zu nutzen.', 'wp-appbox'); ?>
		</td>
	</tr>
</table>