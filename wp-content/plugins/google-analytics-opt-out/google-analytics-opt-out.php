<?php
/*
Plugin Name: Google Analytics Opt-Out
Plugin URI: http://wp-buddy.com/products/plugins/google-analytics-opt-out
Description: Provides an Opt-Out functionality for Google Analytics
Version: 0.1.2
Author: WP-Buddy
Author URI: http://wp-buddy.com
License: GPL2
Text Domain: gaoo
Domain Path: /languages/

Copyright 2013  WP-Buddy  (email : info@wp-buddy.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// for translations only
__( 'Google Analytics Opt-Out', 'gaoo' );
__( 'Provides an Opt-Out functionality for Google Analytics', 'gaoo' );

define( 'GAOO_FILE', __FILE__ );
define( 'GAOO_PATH', trailingslashit( plugin_dir_path( __FILE__ ) ) );
define( 'GAOO_URL', trailingslashit( plugins_url() ) . trailingslashit( dirname( plugin_basename( __FILE__ ) ) ) );

add_action( 'init', 'gaoo_add_translation' );
function gaoo_add_translation() {
	load_plugin_textdomain( 'gaoo', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}

require_once GAOO_PATH . 'classes/functions.php';
require_once GAOO_PATH . 'classes/admin.php';
require_once GAOO_PATH . 'classes/shortcodes.php';
require_once GAOO_PATH . 'classes/scripts.php';
require_once GAOO_PATH . 'classes/settings.php';

