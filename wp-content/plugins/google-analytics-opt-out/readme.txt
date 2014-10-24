=== Google Analytics Opt-Out ===
Contributors: wp-buddy
Donate link: http://wp-buddy.com/products/plugins/google-analytics-opt-out/
Tags: google analytics, analytics, analytics opt-out, analytics opt out
Version: 0.1.2
Requires at least: 3.7
Stable tag: 0.1.2
Tested up to: 4.0
License: GPLv2
License URI: http://www.gnu.org/licenses/gpl-2.0.html


Provides an Opt-Out functionality for Google Analytics

== Description ==

This plugin provides an Opt-Out functionality for Google Analytics by setting a cookie that prevents analytics.js to collect data.

Works perfectly together with the [Yoast Analytics Plugin](http://wordpress.org/plugins/google-analytics-for-wordpress/ "Yoast Analytics Plugin").

Please by the Pro Version of the [Google Analytics Opt Out WordPress Plugin](http://wp-buddy.com/products/plugins/google-analytics-opt-out/ "Google Analytics Opt Out WordPress Plugin") to even keep the free version up-to-date! Thanks!

== Installation ==

* Install and activate the plugin via your WordPress Administration panel
* Go the "Settings" -> "Analytics Opt Out" and enter your UA-code (you don't need this step if Yoasts Analytics plugin is active)
*
* IMPORTANT: Check the sourcecode of your website and make sure that the Analytics code follows AFTER the opt-out code. Otherwise the Opt-Out feature will not work.
* Read the FAQ for more information.

== Frequently Asked Questions ==

= The opt-out code appears AFTER the Analytics code. What can I do? =

Use Yoasts Analytics plugin OR add the code manually:

add this code to your themes functions.php:
`<?php
// This stops the plugin to integrate the JS into the header
function my_gaoo_stop_head(){
	return true;
}
add_filter('gaoo_stop_head', 'my_gaoo_stop_head');
?>`

Then open your themes header.php and add the following code BEFORE your Analytics code AND between `<head>` and `</head>`:
`<?php
if ( function_exists( 'gaoo_js' ) ) {
  // echos out the Javascript
	gaoo_js();
}
?>`


== Screenshots ==

1. The Opt-Out link can be added with this little button (shortcode)

2. This is how the code looks like

3. This is the settings page

== Changelog ==

= 0.1.2 =
* Works again with the Google Analytics plugin by Yoast

= 0.1.1 =
* Fixed the issue that error message still shows shows up
* Added/replaced some translations
* Fixed an issue that Yoasts Analytics for WordPress plugin has changed the option name

= 0.1 =
* The first version

== Upgrade Notice ==