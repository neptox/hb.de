<?php

$options = get_option('wpAppbox');
if($options['wpAppbox_datacachetime'] == '') $options['wpAppbox_datacachetime'] = '300';

define("WPAPPBOX_PLUGIN_NAME", 'WP-Appbox'); 
define("WPAPPBOX_PLUGIN_VERSION", '2.4.7');

define("WPAPPBOX_DATA_CACHINGTIME", $options['wpAppbox_datacachetime']);  

define("WPAPPBOX_PLUGIN_BASE_DIR", basename(dirname(dirname(__FILE__))));

define("WPAPPBOX_CACHE_PREFIX", 'wpAppbox_');
						
$store_names = array(	'amazonapps' => 'Amazon Apps',
						'androidpit' => 'AndroidPit',
						'appstore' => '(Mac) App Store',
						'chromewebstore' => 'Chrome Web Store',
						'firefoxaddon' => 'Firefox Erweiterungen',
						'firefoxmarketplace' => 'Firefox Marketplace',
						'goodoldgames' => 'Good Old Games (GOG.com)',
						'googleplay' => 'Google Play',
						'operaaddons' => 'Opera Add-ons',
						'samsungapps' => 'Samsung Apps',
						'steam' => 'Steam',
						'windowsstore' => 'Windows Store',
						'windowsphone' => 'Windows Phone Store',
						'wordpress' => 'WordPress Plugins',
						);
												
$mobile_stores = array('amazonapps', 'androidpit', 'appstore', 'firefoxmarketplace', 'googleplay', 'samsungapps', 'windowsphone');
												
$style_names_global = array('0' => 'standard',
							'1' => 'simple',
							'2' => 'compact',
							'3' => 'screenshots',
							'6' => 'screenshots-only',
							'4' => 'banner',
							'5' => 'video');	
							
$style_names_appstores = array(	'amazonapps' => array(1, 2, 3, 4, 6),
								'androidpit' => array(1, 2, 3, 4, 6),
								'appstore' => array(1, 2, 3, 6),
								'chromewebstore' => array(1, 2),
								'firefoxaddon' => array(1, 2, 3, 6),
								'firefoxmarketplace' => array(1, 2, 3, 6),
								'goodoldgames' => array(1, 2, 3, 5, 6),
								'googleplay' => array(1, 2, 3, 5, 6),
								'operaaddons' => array(1, 2, 3, 6),
								'samsungapps' => array(1, 2, 3, 6),
								'steam' => array(1, 2, 3, 6),
								'windowsstore' => array(1, 2, 3, 6),
								'windowsphone' => array(1, 2, 3, 6),
								'wordpress' => array(1, 2, 3, 4, 6),
								);
						
?>