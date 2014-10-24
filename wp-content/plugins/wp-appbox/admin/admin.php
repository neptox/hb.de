<?php

function wpAppbox_pageInit() {
	$settings_page = add_options_page(WPAPPBOX_PLUGIN_NAME, WPAPPBOX_PLUGIN_NAME, 'manage_options', 'wp-appbox.php', 'wpAppbox_options_page');
	add_action( "load-{$settings_page}", 'wpAppbox_loadSettingsPage' );
}

function wpAppbox_clear_cache() {
	global $wpdb;
	if(isset($_GET['clearcache'])) {
		if($wpdb->query("DELETE FROM `$wpdb->options` WHERE `option_name` LIKE ('%".WPAPPBOX_CACHE_PREFIX."%')")) echo '<div id="setting-error-settings_updated" class="updated settings-error"><p><strong>'.__('Der WP-Appbox-Cache wurde geleert.', 'wp-appbox').'</strong></p></div>';
		else echo '<div id="setting-error-settings_updated" class="updated settings-error"><p><strong>'.__('Der WP-Appbox-Cache konnte nicht geleert werden.', 'wp-appbox').'</strong></p></div>';
	}
}

function wpAppbox_adminInit() {
	global $store_names;
	$settings = get_option("wpAppbox");
	if(empty($settings)) {
		$settings = array();	
		add_option("wpAppbox", $settings, '', 'yes');
	}	
	$settings = get_option("wpAppbox");
	if(!array_key_exists('wpAppbox_piccache', $settings)) $settings['wpAppbox_piccache'] = true;
	if(!array_key_exists('wpAppbox_datacache', $settings)) $settings['wpAppbox_datacache'] = false;
	if(!array_key_exists('wpAppbox_piccchetime', $settings)) $settings['wpAppbox_piccchetime'] = '300';
	if(!array_key_exists('wpAppbox_datacachetime', $settings)) $settings['wpAppbox_datacachetime'] = '300';
	if(!array_key_exists('wpAppbox_qrcode', $settings)) $settings['wpAppbox_qrcode'] = '1';
	if(!array_key_exists('wpAppbox_force_language', $settings)) $settings['wpAppbox_force_language'] = '0';
	if(!array_key_exists('wpAppbox_nofollow', $settings)) $settings['wpAppbox_nofollow'] = '1';
	if(!array_key_exists('wpAppbox_showrating', $settings)) $settings['wpAppbox_showrating'] = '1';
	if(!array_key_exists('wpAppbox_urlshortener', $settings)) $settings['wpAppbox_urlshortener'] = '0';
	if(!array_key_exists('wpAppbox_blank', $settings)) $settings['wpAppbox_blank'] = '1';
	if(!array_key_exists('wpAppbox_show_reload_link', $settings)) $settings['wpAppbox_show_reload_link'] = '1';
	if(!array_key_exists('wpAppbox_error_onlyforauthor', $settings)) $settings['wpAppbox_error_onlyforauthor'] = '0';
	if(!array_key_exists('wpAppbox_error_erroroutput', $settings)) $settings['wpAppbox_error_erroroutput'] = '0';
	if(!array_key_exists('wpAppbox_curl_timeout', $settings)) $settings['wpAppbox_curl_timeout'] = '3';
	if(!array_key_exists('wpAppbox_itunes_secureimage', $settings)) $settings['wpAppbox_itunes_secureimage'] = '0';
	if(!array_key_exists('wpAppbox_notification', $settings)) $settings['wpAppbox_notification'] = '0';
	if(!array_key_exists('wpAppbox_version', $settings)) $settings['wpAppbox_version'] = WPAPPBOX_PLUGIN_VERSION;
	if(!array_key_exists('wpAppbox_useownsheet', $settings)) $settings['wpAppbox_useownsheet'] = '0';
	if(!array_key_exists('wpAppbox_user_affiliateids', $settings)) $settings['wpAppbox_user_affiliateids'] = '0';
	if(!array_key_exists('wpAppbox_affid', $settings)) $settings['wpAppbox_affid'] = '';
	if(!array_key_exists('wpAppbox_affid_sponsored', $settings)) $settings['wpAppbox_affid_sponsored'] = '0';
	if(!array_key_exists('wpAppbox_affid_affilinet', $settings)) $settings['wpAppbox_affid_affilinet'] = '';
	if(!array_key_exists('wpAppbox_affid_affilinet_sponsored', $settings)) $settings['wpAppbox_affid_affilinet_sponsored'] = '0';
	if(!array_key_exists('wpAppbox_affid_amazonpartnernet', $settings)) $settings['wpAppbox_affid_amazonpartnernet'] = '';
	if(!array_key_exists('wpAppbox_affid_amazonpartnernet_sponsored', $settings)) $settings['wpAppbox_affid_amazonpartnernet_sponsored'] = '0';
	if(!array_key_exists('wpAppbox_view_default', $settings)) $settings['wpAppbox_view_default'] = '1';
	if(!array_key_exists('wpAppbox_view_appstore', $settings)) $settings['wpAppbox_view_appstore'] = '0';
	if(!array_key_exists('wpAppbox_view_googleplay', $settings)) $settings['wpAppbox_view_googleplay'] = '0';
	if(!array_key_exists('wpAppbox_view_androidpit', $settings)) $settings['wpAppbox_view_androidpit'] = '0';
	if(!array_key_exists('wpAppbox_view_windowsstore', $settings)) $settings['wpAppbox_view_windowsstore'] = '0';
	if(!array_key_exists('wpAppbox_view_windowsphone', $settings)) $settings['wpAppbox_view_windowsphone'] = '0';
	if(!array_key_exists('wpAppbox_view_chromewebstore', $settings)) $settings['wpAppbox_view_chromewebstore'] = '0';
	if(!array_key_exists('wpAppbox_view_amazonapps', $settings)) $settings['wpAppbox_view_amazonapps'] = '0';
	if(!array_key_exists('wpAppbox_view_firefoxaddon', $settings)) $settings['wpAppbox_view_firefoxaddon'] = '0';
	if(!array_key_exists('wpAppbox_view_goodoldgames', $settings)) $settings['wpAppbox_view_goodoldgames'] = '0';
	if(!array_key_exists('wpAppbox_view_firefoxmarketplace', $settings)) $settings['wpAppbox_view_firefoxmarketplace'] = '0';
	if(!array_key_exists('wpAppbox_view_operaaddons', $settings)) $settings['wpAppbox_view_operaaddons'] = '0';
	if(!array_key_exists('wpAppbox_view_samsungapps', $settings)) $settings['wpAppbox_view_samsungapps'] = '0';
	if(!array_key_exists('wpAppbox_view_steam', $settings)) $settings['wpAppbox_view_steam'] = '0';
	if(!array_key_exists('wpAppbox_view_wordpress', $settings)) $settings['wpAppbox_view_wordpress'] = '0';
	if(!array_key_exists('wpAppbox_button_default', $settings)) $settings['wpAppbox_button_default'] = '0';
	foreach($store_names as $id => $name) {
		if(!array_key_exists('wpAppbox_button_appbox_'.$id, $settings)) $settings['wpAppbox_button_appbox_'.$id] = '0';
		if(!array_key_exists('wpAppbox_button_alone_'.$id, $settings)) $settings['wpAppbox_button_alone_'.$id] = '1';
		if(!array_key_exists('wpAppbox_button_hidden_'.$id, $settings)) $settings['wpAppbox_button_hidden_'.$id] = '0';
	}
	if($settings['wpAppbox_view_appstore'] == '-1') $settings['wpAppbox_view_appstore'] = '0';
	if($settings['wpAppbox_view_googleplay'] == '-1') $settings['wpAppbox_view_googleplay'] = '0';
	if($settings['wpAppbox_view_androidpit'] == '-1') $settings['wpAppbox_view_androidpit'] = '0';
	if($settings['wpAppbox_view_windowsstore'] == '-1') $settings['wpAppbox_view_windowsstore'] = '0';
	if($settings['wpAppbox_view_windowsphone'] == '-1') $settings['wpAppbox_view_windowsphone'] = '0';
	if($settings['wpAppbox_view_chromewebstore'] == '-1') $settings['wpAppbox_view_chromewebstore'] = '0';
	if($settings['wpAppbox_view_amazonapps'] == '-1') $settings['wpAppbox_view_amazonapps'] = '0';
	if($settings['wpAppbox_view_goodoldgames'] == '-1') $settings['wpAppbox_view_goodoldgames'] = '0';
	if($settings['wpAppbox_view_firefoxaddon'] == '-1') $settings['wpAppbox_view_firefoxaddon'] = '0';
	if($settings['wpAppbox_view_firefoxmarketplace'] == '-1') $settings['wpAppbox_view_firefoxmarketplace'] = '0';
	if($settings['wpAppbox_view_operaaddons'] == '-1') $settings['wpAppbox_view_operaaddons'] = '0';
	if($settings['wpAppbox_view_samsungapps'] == '-1') $settings['wpAppbox_view_samsungapps'] = '0';
	if($settings['wpAppbox_view_steam'] == '-1') $settings['wpAppbox_view_steam'] = '0';
	if($settings['wpAppbox_view_wordpress'] == '-1') $settings['wpAppbox_view_wordpress'] = '0';
	$updated = update_option("wpAppbox", $settings);
}

function wpAppbox_createTabs($current = '') {
	if(isset($_GET['tab'])) $current = $_GET['tab'];
    $tabs = array(	'cache' => __('Cache', 'wp-appbox'),
    				'general' => __('Optionen', 'wp-appbox'),  
    				'banner' => __('App-Banner', 'wp-appbox'), 
    				'buttons' => __('Buttons', 'wp-appbox'),  
    				'affiliate' => __('Affiliate IDs', 'wp-appbox'),  
    				'help' => __('Hilfe', 'wp-appbox'));
    echo '<h2 class="nav-tab-wrapper">';
    foreach( $tabs as $tab => $name ){
        $class = ( $tab == $current ) ? ' nav-tab-active' : '';
        echo "<a class='nav-tab$class' href='?page=wp-appbox&tab=$tab'>$name</a>";

    }
    echo '</h2>';
}

function wpAppbox_loadSettingsPage() {
	if($_GET['tab'] === 'cache') {
		$args = array(
		       'label' => __('Apps', 'wp-appbox'),
		       'default' => 50,
		       'option' => 'apps_per_page'
		       );
		add_screen_option( 'per_page', $args );
	}
	if($_POST["wp-appbox-settings-submit"] == 'Y') {
		check_admin_referer("wp-appbox-setting-page");
		wpAppbox_saveSettings();
		$url_parameters = isset($_GET['tab'])?'updated=true&tab='.$_GET['tab']:'updated=true';
		wp_redirect(admin_url('options-general.php?page=wp-appbox&'.$url_parameters));
		exit;
	}
}


function wpAppbox_setScreenOptions($status, $option, $value) {
  if ('apps_per_page' == $option) return $value;
}
add_filter('set-screen-option', 'wpAppbox_setScreenOptions', 10, 3);


function wpAppbox_saveSettings() {
	global $store_names;
	$settings = get_option("wpAppbox");
	if(isset($_GET['tab'])) $tab = $_GET['tab'];
	switch($tab) {
    	case 'general':
    		$settings['wpAppbox_datacachetime'] = $_POST['wpAppbox_datacachetime'];
    		$settings['wpAppbox_useownsheet'] = $_POST['wpAppbox_useownsheet'];
    		$settings['wpAppbox_nofollow'] = $_POST['wpAppbox_nofollow'];
    		$settings['wpAppbox_blank'] = $_POST['wpAppbox_blank'];
    		$settings['wpAppbox_qrcode'] = $_POST['wpAppbox_qrcode'];
    		$settings['wpAppbox_force_language'] = $_POST['wpAppbox_force_language'];
    		$settings['wpAppbox_showrating'] = $_POST['wpAppbox_showrating'];
    		$settings['wpAppbox_show_reload_link'] = $_POST['wpAppbox_show_reload_link'];
    		$settings['wpAppbox_error_erroroutput'] = $_POST['wpAppbox_error_erroroutput'];
    		$settings['wpAppbox_error_onlyforauthor'] = $_POST['wpAppbox_error_onlyforauthor'];
    		$settings['wpAppbox_curl_timeout'] = $_POST['wpAppbox_curl_timeout'];
    		$settings['wpAppbox_itunes_secureimage'] = $_POST['wpAppbox_itunes_secureimage'];
    		$settings['wpAppbox_urlshortener'] = $_POST['wpAppbox_urlshortener'];
	   	break;
		case 'buttons':
			$settings['wpAppbox_button_default'] = $_POST['wpAppbox_button_default'];
			foreach($store_names as $id => $name) {
				$settings['wpAppbox_button_appbox_'.$id] = $_POST['wpAppbox_button_appbox_'.$id];
				$settings['wpAppbox_button_alone_'.$id] = $_POST['wpAppbox_button_alone_'.$id];
				$settings['wpAppbox_button_hidden_'.$id] = $_POST['wpAppbox_button_hidden_'.$id];
			}
		break;
		case 'banner':
			$settings['wpAppbox_view_default'] = $_POST['wpAppbox_view_default'];
			foreach($store_names as $id => $name) $settings['wpAppbox_view_'.$id] = $_POST['wpAppbox_view_'.$id];
		break;
		case 'affiliate':
			$settings['wpAppbox_user_affiliateids'] = $_POST['wpAppbox_user_affiliateids'];
			$settings['wpAppbox_affiliate_apple_service'] = $_POST['wpAppbox_affiliate_apple_service'];
			$settings['wpAppbox_affid'] = Trim($_POST['wpAppbox_affid']);
			$settings['wpAppbox_affid_sponsored'] = $_POST['wpAppbox_affid_sponsored'];
			$settings['wpAppbox_affid_affilinet'] = Trim($_POST['wpAppbox_affid_affilinet']);
			$settings['wpAppbox_affid_affilinet_sponsored'] = $_POST['wpAppbox_affid_affilinet_sponsored'];
			$settings['wpAppbox_affid_amazonpartnernet'] = Trim($_POST['wpAppbox_affid_amazonpartnernet']);
			$settings['wpAppbox_affid_amazonpartnernet_sponsored'] = $_POST['wpAppbox_affid_amazonpartnernet_sponsored'];
		break;
	}
	$settings['wpAppbox_version'] = WPAPPBOX_PLUGIN_VERSION;
	$updated = update_option("wpAppbox", $settings);
}

function wpAppbox_options_page() {
	global $store_names, $style_names_global, $style_names_appstores, $mobile_stores;
	?>
	<div class="wrap">
		<div id="icon-options-general" class="icon32">
			<br>
		</div>
		<h2><?php echo WPAPPBOX_PLUGIN_NAME; ?> (Version <?php echo WPAPPBOX_PLUGIN_VERSION; ?>)</h2>
		<?php $options = get_option('wpAppbox'); ?>
		<?php 
			if($options['wpAppbox_notification'] != WPAPPBOX_PLUGIN_VERSION) {
				echo '<div id="setting-error-settings_updated" class="updated settings-error"><p><strong>'.__('<a href="http://www.blogtogo.de/wp-appbox-2-4-3-entfernt-tradedoubler-bitte-prueft-eure-affiliate-id/" target="_blank">WP-Appbox 2.4.5</a> ist da! Falls Dir das Plugin gefällt, <a href="http://wordpress.org/support/view/plugin-reviews/wp-appbox" target="_blank">bewerte es doch im Plugin-Verzeichnis</a>. :-)', 'wp-appbox').'</strong></p></div>'; 
				$options['wpAppbox_notification'] = WPAPPBOX_PLUGIN_VERSION;
				$updated = update_option("wpAppbox", $options);
			}
		?>
		<?php wpAppbox_clear_cache(); ?>
		<div class="widget" style="margin:15px 0;"><p style="margin:10px;">
			<a href="https://twitter.com/Marcelismus" target="_blank"><?php _e('Folge mir via Twitter', 'wp-appbox'); ?></a> | <a href="http://www.blogtogo.de/wp-appbox-app-badge-fuer-google-play-mac-app-store-windows-store-windows-phone-store-co/" target="_blank"><?php _e('Besuch die Plugin-Seite', 'wp-appbox'); ?></a> | <a href="http://wordpress.org/extend/plugins/wp-appbox/" target="_blank"><?php _e('Plugin im WordPress Directory', 'wp-appbox'); ?></a> | <a href="http://wordpress.org/plugins/wp-appbox/changelog/" target="_blank"><?php _e('Changelog', 'wp-appbox'); ?></a>
			<a href="/wp-admin/options-general.php?page=wp-appbox&clearcache" onClick="return confirm('<?php _e('Soll der Cache wirklich geleert werden? Sämtliche App-Daten müssen dann neu von den Servern der Betreiber geladen werden.', 'wp-appbox'); ?>')" style="float:right;"><?php _e('Cache leeren', 'wp-appbox'); ?></a>
		</p></div>
		<?php if(isset($_GET['tab'])) { ?>
		<div style="float: right;">
			<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
				<input type="hidden" name="cmd" value="_s-xclick">
				<input type="hidden" name="hosted_button_id" value="SH9AAS276RAS6">
				<input type="image" src="https://www.paypalobjects.com/de_DE/DE/i/btn/btn_donate_SM.gif" border="0" name="submit" alt="Jetzt einfach, schnell und sicher online bezahlen – mit PayPal.">
				<img alt="" border="0" src="https://www.paypalobjects.com/de_DE/i/scr/pixel.gif" width="1" height="1">
			</form>
		</div>
		<?php } ?>
		<?php wpAppbox_createTabs(); ?>
		<?php settings_fields('wpAppbox'); ?>
		<form method="post" action="<?php admin_url('options-general.php?page=wp-appbox'); ?>">
		<?php wp_nonce_field("wp-appbox-setting-page"); ?>
		<?php
			if(isset($_GET['tab'])) $tab = $_GET['tab'];
			if(isset($tab)) include_once('admin-'.$tab.'.php');
			else {
			?>
			<style>
				.donation-link>a:link,
				.donation-link>a:visited {
					position: absolute;
					bottom: 12px;
					width: 76px;
					height: 48px;
					display: block;
					padding-top: 28px;
					-webkit-border-radius: 42px;
					-moz-border-radius: 42px;
					border-radius: 42px;
					background-color: #D4B06A;
					color: #FFF;
					text-decoration: none;
					font-size: 14px;
				}
				.donation-link>a:hover,
				.donation-link>a:active {
					background-color: #996632;
				}
				.donation-link.amazon>a:link {
					right: 12px;
				}
				.donation-link.paypal>a:link {
					right: 100px;
				}
			</style>
			<div style="position: relative;width:100%; height: auto; text-align: center; background-color:#f5d6a9;">
				<div style="position: absolute; bottom: 4px; left: 8px;"><small>Logo by <a href="https://twitter.com/craive" target="_blank">@craive</a></small></div>
				<div class="donation-link amazon"><a href="http://www.amazon.de/gp/registry/wishlist/1FC2DA2J8SZW7" target="_blank">Amazon</a></div>
				<div class="donation-link paypal"><a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=SH9AAS276RAS6" target="_blank">PayPal</a></div>
				<img style="width:100%; max-width: 1000px; max-height: 500px;" src="<?php echo plugins_url('img/wpappbox-logo.png', dirname(__FILE__)); ?>" alt="<?php echo WPAPPBOX_PLUGIN_NAME; ?> (Version <?php echo WPAPPBOX_PLUGIN_VERSION; ?>)" title="<?php echo WPAPPBOX_PLUGIN_NAME; ?> (Version <?php echo WPAPPBOX_PLUGIN_VERSION; ?>)" />
			</div>
			<?php
			}
		?>
		<?php 
		if($tab != 'help') {
		?>
		<p class="submit" style="clear: both;">
		  <?php if((isset($_GET['tab'])) && ($tab != 'cache') && ($tab != 'help')) { ?><input type="submit" name="Submit" class="button-primary" value="<?php _e('Änderungen speichern', 'wp-appbox'); ?>" /><?php } ?>
	      <input type="hidden" name="wp-appbox-settings-submit" value="Y" />
	   </p>
		<?php 
		}
	?>
	</form>
	</div>
<?php } ?>