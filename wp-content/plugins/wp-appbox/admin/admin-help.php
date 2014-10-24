<h3><?php _e('Die IDs der Apps', 'wp-appbox'); ?></h3>
<p><?php _e('Eine kleine Übersicht darüber, wie ihr an die ID einer App gelangt.', 'wp-appbox'); ?></p>

<table class="form-table">
	<?php foreach($store_names as $id => &$name) { ?>
	<tr valign="top">
		<th scope="row"><?php echo $name; ?>:</th>
		<td><img src="<?php echo plugins_url('img/appid/'.$id.'.jpg', dirname(__FILE__)); ?>" alt="<?php echo $name; ?> ID" /></td>
	</tr>
	<?php } ?>
</table>

<h3><?php _e('Der Shortcode', 'wp-appbox'); ?></h3>
<p><?php _e('Eine kleine Übersicht über Tags und Parameter.', 'wp-appbox'); ?></p>

<table class="form-table">
	<tr valign="top">
		<th scope="row"><?php _e('QR-Code nicht anzeigen', 'wp-appbox'); ?>:</th>
		<td><?php _e('Soll der QR-Code nur für bestimmte Banner nicht angezeigt werden, reicht es aus, den Tag "noqrcode" im Shortcode zu verwenden. Beispiel: [appbox appstore appid noqrcode]', 'wp-appbox'); ?></td>
	</tr>
	<tr valign="top">
		<th scope="row"><?php _e('App Store Screenshots', 'wp-appbox'); ?>:</th>
		<td><?php _e('Bindet man eine Universal-App für iOS ein, so kann man sich auf Wunsch auch nur die iPhone- beziehungsweise iPad-Screenshots anzeigen lassen. Dazu muss lediglich ein "-iphone" beziehungsweise "-ipad" an die App-ID angehangen werden. Beispiel: [appbox appstore appid-iphone screenshots]', 'wp-appbox'); ?></td>
	</tr>
	<tr valign="top">
		<th scope="row"><?php _e('Alten Preis anzeigen', 'wp-appbox'); ?>:</th>
		<td><?php _e('Möchte man neben einem Aktionspreis auch einen alten Preis angeben, so kann der Tag oldprice="xy" (oder alterpreis="xy") im Shortcode verwendet werden. Dieser wird nur angezeigt, sofern er sich vom aktuellen Preis unterscheidet. Beispiel: [appbox appstore appid oldprice="1,99€"]', 'wp-appbox'); ?></td>
	</tr>
	<tr valign="top">
		<th scope="row"><?php _e('Cache temporär deaktivieren', 'wp-appbox'); ?>:</th>
		<td><?php _e('Apps können neugeladen werden, indem an die URL eines Artikels der Parameter "?wpappbox_reload_cache" angehangen wird. Nur für eingeloggte Autoren möglich.', 'wp-appbox'); ?></td>
	</tr>
</table>