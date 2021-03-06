=== Alfie WP Weather ===
Contributors: appcuarium
Donate link: https://secure.savethechildren.org/site/donor.asp
Tags: weather, forecast
Requires at least: 3.3
Tested up to: 3.9
Stable tag: 1.2.13
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Alfie WP Weather is a powerful, flexible plugin that adds weather information to your WordPress website with style.

== Description ==

NEW in version 1.2.1:

* GeoIP based weather: You can choose to show the weather on users current location. If no location is found, the widget will display the custom location you selected in the widget configuration.
* Exceptional load performance optimizations have been added.
* Available in 16 languages

Alfie WP Weather is a smart plugin that adds weather information to your WordPress website. It comes with an integrated Ajax location search, so you can setup everything with just a few clicks. Every aspect of the plugin is configurable. You can choose to display minimum, custom or full weather information available, including the forecast. The plugin uses the Yahoo! API for the real-time location and weather information. The information is cached for an hour to avoid over-usage of the Yahoo! API and also to provide the fastest response times from the server.

Alfie WP Weather has received the compatibility certification from <a href="http://wpml.org/plugin/alfie-wp-weather/" target="_blank">WPML</a>.

The plugin and widget are translated into the following languages:

* Catalan
* Croatian
* Danish
* Dutch
* English
* French
* German
* Greek
* Italian
* Moldavian ( Romanian )
* Persian
* Polish
* Portuguese
* Romanian
* Russian
* Spanish

More translations and cool features coming soon.

Each Alfie WP Weather update is tested for fully compatibility with latest WordPress releases for:

* WordPress default installs
* WordPress subfolder installs
* WordPress MultiSite subdomain mapping
* WordPress MultiSite subfolder mapping
* Domanin re-mapping of WordPress MultiSite installs

If you like the plugin and want to donate, please make your donation to Save The Children at https://secure.savethechildren.org/site/donor.asp

== Installation ==

1. Upload the alfie-wp-weather folder to the /wp-content/plugins/ directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. There's no configuration needed. You can add the Alfie WP Weather widget in a sidebar like usually.
4. To display the weather info anywhere on your WordPress site use the shortcode [alfie_wp_weather]. By default, the shortcode will activate the full weather info, will show the temperature in Celsius degrees. If you want to disable some of the info displayed, you can pass 0 as parameter for the desired option.

For example, in order to display the weather info for New York in Fahrenheit degrees, disabling country and condition info, the shortcode will look like this:

[alfie_wp_weather woeid="2459115" country=0 condition=0 units="f" automatic_location=0]

Available parameters are: 

	[woeid] -> string
	[automatic_location] -> boolean
	[image] -> boolean
	[country] -> boolean
	[condition] -> boolean
	[units] -> string
	[highlow] -> boolean
	[wind] -> boolean
	[humidity] -> boolean
	[visibility] -> boolean
	[sunrise] -> boolean
	[sunset] -> boolean
	[forecast] -> boolean
	[forecast_image] -> boolean
	[credits] -> boolean

IMPORTANT: GeoIP needs a server with bcmath extension installed. It can be easily installed from the terminal, issuing the following command ( CentOS 6 example below ):

yum install php-bcmath

== Frequently asked questions ==

* Why do i see only the widget title but no content?

You should enable allow_url_fopen in your server configuration, as it is needed by Alfie WP Weather to get the info from Yahoo.

== Screenshots ==

1. Site widget night view
2. Site widget day view
3. Dashboard widget location search

== Changelog ==

= 1.2.13 =
* Added Portuguese translation

= 1.2.12 =
* Added Russian translation
* Added Polish translation
* Fixed a styling issue that could appear with certain themes
* Fixed "Not available" image condition
* Code optimization

= 1.2.11 =

* Fixed an error that could appear with long urls

= 1.2.1 =

* Added GeoIP based widget display
* Added session storage for even faster data display
* Updated language files

= 1.2.0 =

* Added Danish translation
* Added Dutch translation
* Corrected a styling issue that could appear on certain installs
* Corrected the path to minified styles and scripts
* Fixed an exception with live WOEID search
* Global code optimizations
* Moved image for condition 20 locally

= 1.1.1 =

* Fixed an issue with the main condition image display
* Tested for compatibility with WordPress 3.9

= 1.1.0 =

* Added Croatian language ( H. Felbar )
* Added Catalan translation
* Added French translation
* Corrected a forecast styling issue that could appear on certain installations
* Corrected a typo in Fahrenheit
* Updated translation files
* Fixed text positioning relative to the main image
* Checked compatibility with WordPress 3.8.2
* Code improvement

= 1.0.15 =

* Compatibility update for WordPress 3.8
* Fixed CSS selectors in minified version
* Added compatibility with earlier versions of WordPress

= 1.0.14 =
* Fixed an issue with cPanel mod_userdir activated (domain/~username/wordpress_path/) returning an error with controller script
* Changed some CSS selectors naming to a more personalized one, to avoid conflicts with possible common used names
* Added Greek translation ( Nikolaos Batsis )
* Added German translation
* Added Italian translation
* Added Persian translation
* Added Moldavian translation
* General code improvement

= 1.0.13 =
* Fixed an issue with latest commit

= 1.0.12 =

* Fixed an issue with main condition image displaying on the widget even if the checkbox was unchecked in admin
* Added option to deactivate the widget forecast images
* General code optimization
* Fully compatible with WordPress 3.7.1
* Now the data is retrieved asynchronously, non-blocking page load

= 1.0.11 =

* Changed the way internal referencing of files is made. Now the plugin is fully compatible with subdirectory WordPress installs.

= 1.0.10 =

* Corrected an error that prevented the changes made in version 1.0.9 to be uploaded to WordPress servers

= 1.0.9 =

* Changed the shorcode parameters name to shorter ones
* Added shortcode usage instructions

= 1.0.8 =

* Added shortcode. Now the weather info can be displayed anywhere.
* Fixed an issue with the plugin not loading if WordPress was installed in a directory other than root

= 1.0.7 =

* Fixed minor bugs.

= 1.0.6 =

* Fixed minor bugs.
* Added donation link to savethechildren.org

= 1.0.5 =

* Now you cand add multiple widgets on the same page.
* Corrected a bug wich triggered an error when WPML wasn't installed.
* Made credits footer optional, you can now disable it if you want from widget options.

= 1.0.4 =

* Corrected image background size.
* Added background gradient to weather conditions that triggered white background images ( false invisible/missing ).
* Fixed locales with WPML in Ajax call.
* Added Romanian translation for the widget.

= 1.0.3 =

* Corrected Spanish language file / CSS styling of city and condition.
* Fixed style bullet display.

= 1.0.2 =

* Added localization for weather condition and forecast week days names.
* Updated main .po file to reflect the latest localization data.
* Updated Spanish translation.
* Added minified CSS files.
* Added minified JS files.

= 1.0.1 =

* Fixed minor display bugs.

== Upgrade notice ==

Will be available when upgrade is released.

== Localization ==

The plugin and widget are fully localized. Full compatibility with WPML and qTranslate.

Note: This product includes GeoLite2 data created by MaxMind, available from <a href="http://www.maxmind.com">http://www.maxmind.com</a>.