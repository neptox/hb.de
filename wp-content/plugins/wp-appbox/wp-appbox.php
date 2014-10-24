<?php
/*
Plugin Name: WP-Appbox
Plugin URI: http://www.blogtogo.de/wp-appbox-app-badge-fuer-google-play-mac-app-store-windows-store-windows-phone-store-co/
Description: "WP-Appbox" ermöglicht es, via Shortcode schnell und einfach App-Details von Apps aus einer Reihe an App Stores in Artikeln oder Seiten anzuzeigen.
Author: Marcel Schmilgeit
Version: 2.4.7
Author URI: http://www.blogtogo.de
*/

load_plugin_textdomain('wp-appbox', false, dirname(plugin_basename( __FILE__ )) . '/lang');

include_once("inc/definitions.php");
include_once("admin/admin.php");
include_once("admin/user-profiles.php");
include_once('inc/getappinfo.class.php');
include_once('inc/createattributs.class.php');
include_once('inc/createoutput.class.php');
require_once(ABSPATH . 'wp-includes/pluggable.php');


function has_user_permissions() {
	$userdata = get_userdata(get_current_user_id());
	if(intval($userdata->user_level) >= 2) return true;
	else false;
}


function has_user_admin_permissions() {
	$userdata = get_userdata(get_current_user_id());
	if(intval($userdata->user_level) >= 9) return true;
	else false;
}


function cache_deactive() {
	if(has_user_permissions()) {
		if(isset($_GET['wpappbox_nocache'])) return true;
		else false;
	}
}


function old_create_new_cache() {
	if(has_user_permissions()) {
		if((isset($_GET['wpappbox_reload_cache'])) || ($_GET['action'] === 'wpappbox_reload_cache')) return true;
		else false;
	}
}


function create_new_cache($app_id) {
	if(has_user_permissions()) {
		if((isset($_GET['wpappbox_reload_cache'])) || ($_GET['action'] === 'wpappbox_reload_cache')) {
			if(!isset($_GET['wpappbox_appid'])) return true;
			elseif($_GET['wpappbox_appid'] === $app_id) return true;
		}
	}
	return false;
}


function shorten_title_author($sts, $wts) {
	global $noqrcode, $store, $mobile_stores;
	$title_short = 28;
	$title_long = 35;
	$author_short = 25;
	$author_long = 36;
	$ending = '…';
	$options = get_option('wpAppbox');
	if(get_storename_css() == 'macappstore') $store = 'macappstore';
	if($noqrcode) {
		switch($wts) {
			case 'title':
				if(strlen($sts) > ($title_long-1)) $sts = mb_substr($sts, 0, $title_long).$ending;
			break;
			case 'author':
				if(strlen($sts) > ($author_long-1)) $sts = mb_substr($sts, 0, $author_long).$ending;
			break;
		}
		return($sts);
	}
	switch($options['wpAppbox_qrcode']) {
		case 0: //Zeige keinen
			switch($wts) {
				case 'title':
					if(strlen($sts) > ($title_long-1)) $sts = mb_substr($sts, 0, $title_long).$ending;
				break;
				case 'author':
					if(strlen($sts) > ($author_long-1)) $sts = mb_substr($sts, 0, $author_long).$ending;
				break;
			}
			break;
		case 2: //Zeige nur Mobile
			switch($wts) {
				case 'title':
					if((!in_array($store, $mobile_stores)) && (strlen($sts) > ($title_long-1)))  $sts = mb_substr($sts, 0, $title_long).$ending;
					elseif((in_array($store, $mobile_stores)) && (strlen($sts) > ($title_short-1)))  $sts = mb_substr($sts, 0, $title_short).$ending;
				break;
				case 'author':
					if((!in_array($store, $mobile_stores)) && (strlen($sts) > ($author_long-1)))  $sts = mb_substr($sts, 0, $author_long).$ending;
					elseif((in_array($store, $mobile_stores)) && (strlen($sts) > ($author_short-1)))  $sts = mb_substr($sts, 0, $author_short).$ending;
				break;
			}
			break;
		default: //Zeige alle == 1
			switch($wts) {
				case 'title':
					if(strlen($sts) > ($title_short-1)) $sts = mb_substr($sts, 0, $title_short).$ending;
				break;
				case 'author':
					if(strlen($sts) > ($author_short-1)) $sts = mb_substr($sts, 0, $author_short).$ending;
				break;
			}
			break;
	}
	return($sts);
}


function get_storename_css() {
	global $ItemInfo;
	foreach($ItemInfo['General'] as $appdata) if(trim($appdata->storename_css) != '') return($appdata->storename_css);
}


function loadTemplate($style) {
	ob_start();
	include('tpl/'.$style.'.php');
	$tpl = ob_get_contents();
	print_r($tpl);
	ob_end_clean();
	return($tpl);
}


function wpAppbox_appbox($appbox_attributs, $content) {
	$attr = new CreateAttributs;
	$attr = $attr->devideAttributs($appbox_attributs);
	$output = new CreateOutput;
	$output = $output->theOutput($attr); 
	return($output);
}


function wpAppbox_add_buttons($buttons) {
	$options = get_option('wpAppbox');
	$option = $options['wpAppbox_button_default'];
	if(($option == '0') || ($option == '3')) {
		if(($options['wpAppbox_button_alone_amazonapps']) || ($option == '0')) array_push($buttons, "separator", "wpAppbox_AmazonAppsButton");
		if(($options['wpAppbox_button_alone_androidpit']) || ($option == '0')) array_push($buttons, "separator", "wpAppbox_AndroidPitButton");
		if(($options['wpAppbox_button_alone_appstore']) || ($option == '0')) array_push($buttons, "separator", "wpAppbox_AppStoreButton");
		if(($options['wpAppbox_button_alone_chromewebstore']) || ($option == '0')) array_push($buttons, "separator", "wpAppbox_ChromeWebStoreButton");
		if(($options['wpAppbox_button_alone_firefoxaddon']) || ($option == '0')) array_push($buttons, "separator", "wpAppbox_FirefoxAddonButton");
		if(($options['wpAppbox_button_alone_firefoxmarketplace']) || ($option == '0')) array_push($buttons, "separator", "wpAppbox_FirefoxMarketplaceButton");
		if(($options['wpAppbox_button_alone_googleplay']) || ($option == '0')) array_push($buttons, "separator", "wpAppbox_GooglePlayButton");
		if(($options['wpAppbox_button_alone_operaaddons']) || ($option == '0')) array_push($buttons, "separator", "wpAppbox_OperaAddonsButton");
		if(($options['wpAppbox_button_alone_samsungapps']) || ($option == '0')) array_push($buttons, "separator", "wpAppbox_SamsungAppsButton");
		if(($options['wpAppbox_button_alone_steam']) || ($option == '0')) array_push($buttons, "separator", "wpAppbox_SteamButton");
		if(($options['wpAppbox_button_alone_windowsstore']) || ($option == '0')) array_push($buttons, "separator", "wpAppbox_WindowsStoreButton");
		if(($options['wpAppbox_button_alone_windowsphone']) || ($option == '0')) array_push($buttons, "separator", "wpAppbox_WindowsPhoneButton");
		if(($options['wpAppbox_button_alone_wordpress']) || ($option == '0')) array_push($buttons, "separator", "wpAppbox_WordPressButton");
	}
	if(($option == '1') || ($option == '3')) array_push($buttons, "separator", "wpAppbox_AppboxButton");
	return $buttons;
}


function wpAppbox_register($plugin_array) {
	global $store_names;
	$options = get_option('wpAppbox');
	$option = $options['wpAppbox_button_default'];
	foreach($store_names as $store => $name) {
		if($options['wpAppbox_button_appbox_'.$store]) $iscombined = true;
	}
	if(($option == '1') || ($option == '3')) {
		if(($iscombined) || ($option == '1')) {
			if(version_compare(get_bloginfo('version'), '3.9', '>=')) $plugin_array['wpAppbox_CombinedButton'] = plugins_url( 'buttons/combined.btn.js.php', __FILE__ );
			else $plugin_array['wpAppboxCombined'] = plugins_url( 'buttons/combined.btn.old.js.php', __FILE__ );
		}
	}
	if(($option == '0') || ($option == '3')) $plugin_array["wpAppboxSingle"] = plugins_url('buttons/single.btn.js.php', __FILE__);
	return $plugin_array;
}


function wpAppbox_add_settings_link($links, $file) {
	static $this_plugin;
	if(!$this_plugin) $this_plugin = plugin_basename(__FILE__);
	if($file == $this_plugin) {
		$settings_link = '<a href="options-general.php?page=wp-appbox">' . __('Einstellungen') . '</a>';
		$links = array_merge(array($settings_link), $links);
	}
	return $links;
}


function wpAppbox_add_more_links($links, $file) {
	static $this_plugin;
	if(!$this_plugin) $this_plugin = plugin_basename(__FILE__);
	if($file == $this_plugin) {
		$links = array();
		$links[] = 'Version '.WPAPPBOX_PLUGIN_VERSION;
		$links[] = '<a target="_blank" href="https://twitter.com/Marcelismus">' . __('Folge mir auf Twitter') . '</a>';
		$links[] = '<a target="_blank" href="http://www.blogtogo.de/wp-appbox-app-badge-fuer-google-play-mac-app-store-windows-store-windows-phone-store-co/">' . __('Plugin-Seite') . '</a>';
		$links[] = '<a target="_blank" href="http://wordpress.org/support/view/plugin-reviews/wp-appbox">' . __('Bewertung abgeben') . '</a>';
		$links[] = '<a target="_blank" href="http://www.amazon.de/gp/registry/wishlist/1FC2DA2J8SZW7">' . __('Amazon Wishlist') . '</a>';
		$links[] = '<a target="_blank" href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=SH9AAS276RAS6">' . __('PayPal-Donation') . '</a>';
	}
	return $links;
}


function br_trigger_error($message) {
    if(isset($_GET['action']) && $_GET['action'] == 'error_scrape') {
        echo '<strong>'.$message.'</strong>';
        exit;
    } 
    else trigger_error($message, E_USER_ERROR);
}


function wpAppbox_activate()
{
	if(version_compare(phpversion(), '5.0') == -1) {
		br_trigger_error(__('Für die Nutzung dieses Plugins wird mindestens PHP Version 5.0 benötigt.', 'wp-appbox')); 
	} 
	//if(!ini_get('allow_url_fopen')) {
		//br_trigger_error(__('"allow_url_fopen" ist auf diesem Server deaktiviert, wird aber benötigt. Bitte aktiviere das Feature oder kontaktiere deinen Webhoster.', 'wp-appbox')); 
	//} 
	if(!function_exists('curl_init')){
		br_trigger_error(__('"cURL" ist auf diesem Server deaktiviert, wird aber benötigt. Bitte aktiviere das Feature oder kontaktiere deinen Webhoster.', 'wp-appbox')); 
	}
	if(!function_exists('curl_exec')){
		br_trigger_error(__('"curl_exec" ist auf diesem Server deaktiviert, wird aber benötigt. Bitte aktiviere das Feature oder kontaktiere deinen Webhoster.', 'wp-appbox')); 
	}  
}


function wpAppbox_uninstall() {
	delete_option('wpAppbox');
}


function wpAppbox_RegisterStyle() {
	$options = get_option('wpAppbox');
	if(!$options['wpAppbox_useownsheet']) {
		wp_register_style('wpappbox', plugins_url('css/styles.min.css', __FILE__), array(), WPAPPBOX_PLUGIN_VERSION, 'screen');
		wp_enqueue_style('wpappbox');
	}
}

 
add_shortcode('appbox', 'wpAppbox_appbox');
 
add_filter('mce_external_plugins', "wpAppbox_register");
add_filter('mce_buttons', 'wpAppbox_add_buttons', 0);
add_filter('plugin_action_links', 'wpAppbox_add_settings_link', 10, 2);
add_filter('plugin_row_meta', 'wpAppbox_add_more_links', 10, 2 );

add_action('admin_menu', 'wpAppbox_pageInit');
add_action('admin_init', 'wpAppbox_adminInit');
add_action('wp_enqueue_scripts', 'wpAppbox_RegisterStyle');
if(version_compare(get_bloginfo('version'), '3.9', '>=')) add_action('admin_enqueue_scripts', 'wpAppbox_RegisterStyle');

register_activation_hook(__FILE__, 'wpAppbox_activate');
register_uninstall_hook(__FILE__, 'wpAppbox_uninstall');

?>