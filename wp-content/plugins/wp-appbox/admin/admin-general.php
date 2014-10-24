<h3><?php _e('Grundeinstellungen', 'wp-appbox'); ?></h3>
<p><?php _e('Sonstiges Gedöns, was keine eigene Kategorie benötigt :D', 'wp-appbox'); ?></p>

<table class="form-table">
	<tr valign="top">
		<?php 
			$mobile_stores_count = count($mobile_stores);
			$i = 0;
			foreach($mobile_stores as $name) { 
				$i++;
				$mobile_stores_output .= '<kbd>'.$name.'</kbd>';
				if($mobile_stores_count > $i) $mobile_stores_output .= ', ';
			} 
		?>
		<th scope="row"><label for="wpAppbox_qrcode"><?php _e('QR-Codes', 'wp-appbox'); ?>:</label></th>
		<td>	
			<label for="wpAppbox_qrcode">
				<input type="radio" name="wpAppbox_qrcode" value="1" <?php  if($options['wpAppbox_qrcode'] == '1') echo 'checked="checked"'; ?> />
				<?php _e('Zeigt alle QR-Codes in sämtlichen App-Badges an.', 'wp-appbox'); ?>
			</label>
			<br />
			<label for="wpAppbox_qrcode">
				<input type="radio" name="wpAppbox_qrcode" value="2" <?php  if($options['wpAppbox_qrcode'] == '2') echo 'checked="checked"'; ?> />
				<?php _e('Zeigt QR-Codes nur für mobile App Stores an:', 'wp-appbox'); ?> <?php echo $mobile_stores_output; ?>
			</label>
			<br />
			<label for="wpAppbox_qrcode">
				<input type="radio" name="wpAppbox_qrcode" value="0" <?php  if($options['wpAppbox_qrcode'] == '0') echo 'checked="checked"'; ?> />
				<?php _e('Blendet sämtliche QR-Codes in den App-Badges aus. Temporär funktioniert dies auch über das Attribut "noqrcode" im Shortcode.', 'wp-appbox'); ?>
			</label>
		</td>
	</tr>
	<tr valign="top">
		<th scope="row"><label for="wpAppbox_showrating"><?php _e('App-Bewertungen', 'wp-appbox'); ?>:</label></th>
		<td>	
			<label for="wpAppbox_showrating">
				<input type="checkbox" name="wpAppbox_showrating" id="wpAppbox_showrating" value="1" <?php  if($options['wpAppbox_showrating']) echo 'checked="checked"'; ?> />
				<?php _e('Zeige App-Bewertungen aus den Stores im Banner an (Variable {RATING} im Template).', 'wp-appbox'); ?>
			</label>
		</td>
	</tr>
	<tr valign="top">
		<th scope="row"><label for="wpAppbox_nofollow"><?php _e('Nofollow', 'wp-appbox'); ?>:</label></th>
		<td>	
			<label for="wpAppbox_nofollow">
				<input type="checkbox" name="wpAppbox_nofollow" id="wpAppbox_nofollow" value="1" <?php  if($options['wpAppbox_nofollow']) echo 'checked="checked"'; ?> />
				<?php _e('Fügt allen Links das Attribut "<a href="http://de.wikipedia.org/wiki/Nofollow" target="_blank">nofollow</a>" hinzu', 'wp-appbox'); ?>
			</label>
		</td>
	</tr>
	<tr valign="top">
		<th scope="row"><label for="wpAppbox_blank"><?php _e('Öffne Links in einem neuen Fenster', 'wp-appbox'); ?>:</label></th>
		<td>	
			<label for="wpAppbox_blank">
				<input type="checkbox" name="wpAppbox_blank" id="wpAppbox_blank" value="1" <?php  if($options['wpAppbox_blank']) echo 'checked="checked"'; ?> />
				<?php _e('Öffnet alle App-Links in einem neuen Fenster (target="blank")', 'wp-appbox'); ?>
			</label>
		</td>
	</tr>
	<tr valign="top">
		<th scope="row"><label for="wpAppbox_show_reload_link"><?php _e('"Neu laden"-Link anzeigen', 'wp-appbox'); ?>:</label></th>
		<td>	
			<label for="wpAppbox_show_reload_link">
				<input type="checkbox" name="wpAppbox_show_reload_link" id="wpAppbox_show_reload_link" value="1" <?php  if($options['wpAppbox_show_reload_link']) echo 'checked="checked"'; ?> />
				<?php _e('Zeigt in der Appbox einen Link zum erneuten Laden der App-Daten an (nur für Autoren und höher).', 'wp-appbox'); ?>
			</label>
		</td>
	</tr>
	<?php if($oauthisteinarschloch) { ?>
	<tr valign="top">
		<th scope="row"><label for="wpAppbox_urlshortener"><?php _e('URL-Shortener', 'wp-appbox'); ?>:</label></th>
		<td>
			<select name="wpAppbox_urlshortener" id="wpAppbox_urlshortener" class="postform" style="min-width:250px;">
			   <option class="level-0" value="0" <?php if($options['wpAppbox_urlshortener'] == '0') echo 'selected="selected"'; ?>><?php _e('Keine Kurz-URLs verwenden', 'wp-appbox'); ?></option> 
			   <option class="level-0" value="tinyurl" <?php if($options['wpAppbox_urlshortener'] == 'tinyurl') echo 'selected="selected"'; ?>><?php _e('TinyURL || tinyurl.com', 'wp-appbox'); ?></option>
			</select>
		</td>
	</tr>
	<?php } ?>
	<tr valign="top">
		<th scope="row"><label for="wpAppbox_useownsheet"><?php _e('CSS-Sheet des Plugins deaktivieren', 'wp-appbox'); ?>:</label></th>
		<td>	
			<label for="wpAppbox_useownsheet">
				<input type="checkbox" name="wpAppbox_useownsheet" id="wpAppbox_useownsheet" value="1" <?php  if($options['wpAppbox_useownsheet']) echo 'checked="checked"'; ?> />
				<?php _e('Deaktiviert die Plugin-eigenen Stylesheets und ermöglichen den Einsatz eigener Anpassungen.', 'wp-appbox'); ?>
			</label>
		</td>
	</tr>
</table>

<h3><?php _e('Cache-Einstellungen', 'wp-appbox'); ?></h3>
<p><?php _e('Die Cachingzeiten geben an, wie oft die Daten aktualisiert vom Server geladen werden - dies erhöht die Performance und sollte eigentlich nicht geändert werden.', 'wp-appbox'); ?></p>

<table class="form-table">
	<tr valign="top">
		<th scope="row"><label for="wpAppbox_datacachetime"><?php _e('Caching-Zeit (in Minuten)', 'wp-appbox'); ?></label></th>
		<td>
			<input type="number" pattern="[0-9]*" name="wpAppbox_datacachetime" id="wpAppbox_datacachetime" value="<?php echo $options['wpAppbox_datacachetime']; ?>" /> <label for="wpAppbox_datacachetime"><?php _e('Die empfohlene Zeitspanne beträgt <strong>300</strong> Minuten', 'wp-appbox'); ?></label>
		</td>
	</tr>
</table>

<h3><?php _e('Fehlerausgabe & Fehlerbehebung', 'wp-appbox'); ?></h3>
<p><?php _e('Die Fehlerausgabe sollte nur in Problemfällen eingeschaltet werden. Kann das Design auseinandernehmen.', 'wp-appbox'); ?></p>

<table class="form-table">
	<tr valign="top">
		<th scope="row"><label for="wpAppbox_curl_timeout"><?php _e('Server Timeout', 'wp-appbox'); ?>:</label></th>
		<td>	
			<label for="wpAppbox_curl_timeout">
				<input type="number" pattern="[0-9]*" name="wpAppbox_curl_timeout" id="wpAppbox_curl_timeout" value="<?php echo $options['wpAppbox_curl_timeout']; ?>" />
				<?php _e('Der empfohlene Timeout-Wert beträgt <strong>5</strong> Sekunden. Nur ändern, sofern Apps nicht gefunden werden.', 'wp-appbox'); ?>
			</label>
		</td>
	</tr>
	<tr valign="top">
		<th scope="row"><label for="wpAppbox_error_onlyforauthor"><?php _e('Fehlermeldungen', 'wp-appbox'); ?>:</label></th>
		<td>	
			<label for="wpAppbox_error_onlyforauthor">
				<input type="checkbox" name="wpAppbox_error_onlyforauthor" id="wpAppbox_error_onlyforauthor" value="1" <?php  if($options['wpAppbox_error_onlyforauthor']) echo 'checked="checked"'; ?> />
				<?php _e('Fehlermeldungen nur für Autoren anzeigen.', 'wp-appbox'); ?>
			</label>
		</td>
	</tr>
	<tr valign="top">
		<th scope="row"><label for="wpAppbox_error_parseoutput"><?php _e('Parse Output', 'wp-appbox'); ?>:</label></th>
		<td>	
			<label for="wpAppbox_error_parseoutput">
				<input type="checkbox" name="wpAppbox_error_parseoutput" id="wpAppbox_error_parseoutput" value="1" <?php  if($options['wpAppbox_error_parseoutput']) echo 'checked="checked"'; ?> />
				<?php _e('Parse Output aktivieren. Nur sichtbar für Administratoren.', 'wp-appbox'); ?>
			</label>
		</td>
	</tr>
	<tr valign="top">
		<th scope="row"><?php _e('Cache deaktivieren', 'wp-appbox'); ?>:</th>
		<td>	
			<?php _e('Der Cache nur kann temporär deaktiviert werden, indem an die URL eines Artikel "?wpappbox_nocache" angehangen wird. Nur von Usern möglich, die mindestens Autor sind.', 'wp-appbox'); ?>
		</td>
	</tr>
	<tr valign="top">
		<th scope="row"><?php _e('Neue Daten erzwingen', 'wp-appbox'); ?>:</th>
		<td>	
			<?php _e('Sofern das erneute Laden von App-Daten (trotz Cache) erzwungen werden soll, dann funktioniert dies, indem an die URL eines Artikels "?wpappbox_reload_cache" angehangen wird. Nur von Usern möglich, die mindestens Autor sind.', 'wp-appbox'); ?>
		</td>
	</tr>
	<tr valign="top">
		<th scope="row"><label for="wpAppbox_itunes_secureimage"><?php _e('Apple App Store Icons', 'wp-appbox'); ?>:</label></th>
		<td>	
			<label for="wpAppbox_itunes_secureimage">
				<input type="checkbox" name="wpAppbox_itunes_secureimage" id="wpAppbox_itunes_secureimage" value="1" <?php  if($options['wpAppbox_itunes_secureimage']) echo 'checked="checked"'; ?> />
				<?php _e('Kompatibilitätsmodus für App-Icons aus dem (Mac) App Store.', 'wp-appbox'); ?>
			</label>
		</td>
	</tr>
</table>