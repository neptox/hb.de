<?php
/*
 * Plugin Name: WooCommerce - PDF Vouchers
 * Plugin URI:  http://wpweb.co.in/
 * Description: With Pdf Vouchers Extension, you can create unlimited vouchers, either for Local Businesses / Local Stores or even online stores. The sky is the limit.
 * Version: 1.5.1
 * Author: WPWeb
 * Author URI: http://wpweb.co.in
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Basic plugin definitions
 * 
 * @package WooCommerce - PDF Vouchers
 * @since 1.0.0
 */
if( !defined( 'WOO_VOU_DIR' ) ) {
	define( 'WOO_VOU_DIR', dirname( __FILE__ ) ); // plugin dir
}
if( !defined( 'WOO_VOU_URL' ) ) {
	define( 'WOO_VOU_URL', plugin_dir_url( __FILE__ ) ); // plugin url
}
if( !defined( 'WOO_VOU_ADMIN' ) ) {
	define( 'WOO_VOU_ADMIN', WOO_VOU_DIR . '/includes/admin' ); // plugin admin dir
}
if( !defined( 'WOO_VOU_IMG_URL' ) ) {
	define( 'WOO_VOU_IMG_URL', WOO_VOU_URL.'includes/images' ); // plugin admin dir
}
if( !defined( 'WOO_VOU_META_DIR' ) ) {
	define( 'WOO_VOU_META_DIR', WOO_VOU_DIR . '/includes/meta-boxes' ); // path to meta boxes
}
if( !defined( 'WOO_VOU_META_URL' ) ) {
	define( 'WOO_VOU_META_URL', WOO_VOU_URL . 'includes/meta-boxes' ); // path to meta boxes
}
if( !defined( 'WOO_VOU_META_PREFIX' ) ) {
	define( 'WOO_VOU_META_PREFIX', '_woo_vou_' ); // meta box prefix
}
if( !defined( 'WOO_VOU_POST_TYPE' ) ) {
	define( 'WOO_VOU_POST_TYPE', 'woovouchers' ); // custom post type voucher templates
}
if( !defined( 'WOO_VOU_CODE_POST_TYPE' ) ) {
	define( 'WOO_VOU_CODE_POST_TYPE', 'woovouchercodes' ); // custom post type voucher codes
}
if( !defined( 'WOO_VOU_MAIN_POST_TYPE' ) ) {
	define( 'WOO_VOU_MAIN_POST_TYPE', 'product' ); //woocommerce post type
}
if( !defined( 'WOO_VOU_MAIN_SHOP_POST_TYPE' ) ) {
	define( 'WOO_VOU_MAIN_SHOP_POST_TYPE', 'shop_order' ); //woocommerce post type
}
if( !defined( 'WOO_VOU_MAIN_MENU_NAME' ) ) {
	define( 'WOO_VOU_MAIN_MENU_NAME', 'woocommerce' ); //woocommerce main menu name
}
if( !defined( 'WOO_VOU_PLUGIN_BASENAME' ) ) {
	define( 'WOO_VOU_PLUGIN_BASENAME', basename( WOO_VOU_DIR ) ); //Plugin base name
}
if( !defined( 'WOO_VOU_PLUGIN_BASE_FILENAME' ) ) {
	define( 'WOO_VOU_PLUGIN_BASE_FILENAME', basename( __FILE__ ) ); //Plugin base file name
}
//Get Vendor Role name

if( !defined( 'WOO_VOU_VENDOR_ROLE' ) ) {
	
	define( 'WOO_VOU_VENDOR_ROLE', 'woo_vou_vendors' ); //plugin vendor role
}

if( !defined( 'WOO_VOU_VENDOR_LEVEL' ) ) {
	define( 'WOO_VOU_VENDOR_LEVEL' , 'woo_vendor_options' ); //plugin vendor capability
}

global $woo_vou_vendor_role;

// loads the Misc Functions file
require_once ( WOO_VOU_DIR . '/includes/woo-vou-misc-functions.php' );

//Post type to handle custom post type
require_once( WOO_VOU_DIR . '/includes/woo-vou-post-types.php' );

/**
 * Activation Hook
 * 
 * Register plugin activation hook.
 * 
 * @package WooCommerce - PDF Vouchers
 * @since 1.0.0
 */

register_activation_hook( __FILE__, 'woo_vou_install' );

/**
 * Plugin Setup (On Activation)
 * 
 * Does the initial setup,
 * stest default values for the plugin options.
 * 
 * @package WooCommerce - PDF Vouchers
 * @since 1.0.0
 */
function woo_vou_install() {
	
	global $wpdb;
	
	//register post type
	woo_vou_register_post_types();
	
	//IMP Call of Function
	//Need to call when custom post type is being used in plugin
	flush_rewrite_rules();
	
	//get option for when plugin is activating first time
	$woo_vou_set_option = get_option( 'woo_vou_set_option' );
	
	if( empty( $woo_vou_set_option ) ) { //check plugin version option
		
		//update default options
		woo_vou_default_settings();
		
		//update plugin version to option
		update_option( 'woo_vou_set_option', '1.0' );
	}
	
	//get option for when plugin is activating first time
	$woo_vou_set_option = get_option( 'woo_vou_set_option' );
	
	if( $woo_vou_set_option == '1.0' ) { //check set option for plugin is set 1.0
		
		$options = array(
							'vou_email_subject'	=> __( 'New Sale', 'woovoucher' ),
							'vou_email_body'	=> __( 'Hello,', 'wpcoupons' ) . "\n\n" . __('A new sale on', 'woovoucher').' {site_name}.'.
													"\n\n" . __('Product Title:', 'woovoucher').' {product_title}'.
													"\n\n" . __('Voucher Code:', 'woovoucher').' {voucher_code}'.
													"\n\n" . __('Thank you', 'woovoucher')
						);
		
		foreach ($options as $key => $value) {
			update_option( $key, $value );
		}
		
		//get vendor role
		$vendor_role = get_role( WOO_VOU_VENDOR_ROLE );
		if( empty( $vendor_role ) ) { //check vendor role
			
			$capabilities  = array(
										WOO_VOU_VENDOR_LEVEL	=> true,  // true allows add vendor level
										'read' 					=> true
									);
			add_role( WOO_VOU_VENDOR_ROLE,__( 'Vendor', 'woovoucher' ), $capabilities );
		} else {
			
			$vendor_role->add_cap( WOO_VOU_VENDOR_LEVEL );
		}
		
		$role = get_role( 'administrator' );
		$role->add_cap( WOO_VOU_VENDOR_LEVEL );
		
		//update plugin version to option
		update_option( 'woo_vou_set_option', '1.1.0' );
		
	} //check plugin set option value is 1.0
	
	$woo_vou_set_option = get_option( 'woo_vou_set_option' );
	
	if( $woo_vou_set_option == '1.1.0' ) {
		
		// update default order pdf name
		update_option( 'order_pdf_name', 'woo-voucher-{current_date}' );
		
		//update plugin version to option
		update_option( 'woo_vou_set_option', '1.1.1' );
		
	}
	
	$woo_vou_set_option = get_option( 'woo_vou_set_option' );
	if( $woo_vou_set_option == '1.1.1' ) {
		
		update_option( 'vou_pdf_usability', '0' );
		
		//update plugin version to option
		update_option( 'woo_vou_set_option', '1.2' );
		
	} // check plugin set option value is 1.1.1
	
	if( $woo_vou_set_option == '1.2' ) {
		// Feature code will be done here.
	}
}

function woo_vou_default_settings() {
	
	// Create default templates
	$default_templates = woo_create_default_templates();
	
	// Get default template page id
	$default_template_page_id = isset( $default_templates['default_template'] ) ? $default_templates['default_template'] : '';
	
	$options = array(
					'vou_site_logo'				=> '',
					'vou_pdf_name'				=> __( 'woo-purchased-voucher-codes-{current_date}', 'woovoucher' ),
					'vou_csv_name'				=> __( 'woo-purchased-voucher-codes-{current_date}', 'woovoucher' ),
					'vou_email_subject'			=> __( 'New Sale', 'woovoucher' ),
					'vou_email_body'			=> __( 'Hello,', 'wpcoupons' ) . "\n\n" . __('A new sale on', 'woovoucher').' {site_name}.'.
													"\n\n" . __('Product Title:', 'woovoucher').' {product_title}'.
													"\n\n" . __('Voucher Code:', 'woovoucher').' {voucher_code}'.
													"\n\n" . __('Thank you', 'woovoucher'),
					'vou_pdf_template'			=> $default_template_page_id
				);
	
	foreach ($options as $key => $value) {
		update_option( $key, $value );
	}
}

/**
 * Check if current page is edit page.
 * 
 * @package WooCommerce - PDF Vouchers
 * @since 1.0.0
 */
function woo_vou_is_edit_page() {
	
	global $pagenow;
	
	return in_array( $pagenow, array( 'post.php', 'post-new.php', 'user-edit.php' ) );
}

//add action to load plugin
add_action( 'plugins_loaded', 'woo_vou_plugin_loaded' );

/**
 * Load Plugin
 * 
 * Handles to load plugin after
 * dependent plugin is loaded
 * successfully
 * 
 * @package WooCommerce - PDF Vouchers
 * @since 1.0.0
 **/
function woo_vou_plugin_loaded() {
	
	//check Woocommerce is activated or not
	if( class_exists( 'Woocommerce' ) ) {
		
		global $woo_vou_vendor_role;

		//Initilize pdf voucher plugin
		woo_vou_vendor_initilize();
		
		/**
		 * Load Text Domain
		 * 
		 * This gets the plugin ready for translation.
		 * 
		 * @package WooCommerce - PDF Vouchers
		 * @since 1.0.0
		 */
		function woo_vou_load_textdomain() {
			
			load_plugin_textdomain( 'woovoucher', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
		}
		//add action to load plugin textdomain
		add_action( 'init', 'woo_vou_load_textdomain' );
		
		/**
		 * Deactivation Hook
		 * 
		 * Register plugin deactivation hook.
		 * 
		 * @package WooCommerce - PDF Vouchers
		 * @since 1.0.0
		 */
		register_deactivation_hook( __FILE__, 'woo_vou_uninstall');
		
		/**
		 * Plugin Setup (On Deactivation)
		 * 
		 * Delete  plugin options.
		 * 
		 * @package WooCommerce - PDF Vouchers
		 * @since 1.0.0
		 */
		function woo_vou_uninstall() {
			
			global $wpdb;
			
			//IMP Call of Function
			//Need to call when custom post type is being used in plugin
			flush_rewrite_rules();
			
			// Getting delete option
			$woo_vou_delete_options = get_option( 'vou_delete_options' );
			
			// If option is set
			if( isset( $woo_vou_delete_options ) && !empty( $woo_vou_delete_options ) && $woo_vou_delete_options == 'yes' ) {
				
				// Delete vouchers data
				$post_types = array( 'woovouchers', 'woovouchercodes' );
				
				foreach ( $post_types as $post_type ) {
					
					$args = array( 'post_type' => $post_type, 'post_status' => 'any', 'numberposts' => '-1' );
					$all_posts = get_posts( $args );
					foreach ( $all_posts as $post ) {
						wp_delete_post( $post->ID, true);
					}
				}
				
				$options = array(
					'vou_site_logo',
					'vou_pdf_name',
					'vou_csv_name',
					'vou_email_subject',
					'vou_email_body',
					'vou_pdf_template',
					'woo_vou_set_option',
					'vou_delete_options'
				);
				
				// Delete all options
				foreach ( $options as $option ) {
					delete_option( $option );
				}
				
			} // End of if
		}
		
		//global variables
		global $woo_vou_scripts,$woo_vou_model,$woo_vou_render,
				$woo_vou_shortcode,$woo_vou_admin,$woo_vou_pubilc,
				$woo_vou_admin_meta;
		
		//Model class handles most of functionalities of plugin
		include_once( WOO_VOU_DIR . '/includes/class-woo-vou-model.php' );
		$woo_vou_model = new WOO_Vou_Model();
		
		// Script Class to manage all scripts and styles
		include_once( WOO_VOU_DIR . '/includes/class-woo-vou-scripts.php' );
		$woo_vou_scripts = new WOO_Vou_Scripts();
		$woo_vou_scripts->add_hooks();
		
		//Render class to handles most of html design for plugin
		require_once( WOO_VOU_DIR . '/includes/class-woo-vou-renderer.php' );
		$woo_vou_render = new WOO_Vou_Renderer();
		
		// Admin meta class to handles most of html design for pdf voucher panel
		require_once( WOO_VOU_ADMIN . '/class-woo-vou-admin-meta.php' );
		$woo_vou_admin_meta = new WOO_Vou_Admin_Meta();
		
		//Shortcodes class for handling shortcodes
		require_once( WOO_VOU_DIR . '/includes/class-woo-vou-shortcodes.php' );
		$woo_vou_shortcode = new WOO_Vou_Shortcodes();
		$woo_vou_shortcode->add_hooks();
		
		//Public Class to handles most of functionalities of public side
		require_once( WOO_VOU_DIR . '/includes/class-woo-vou-public.php');
		$woo_vou_pubilc = new WOO_Vou_Public();
		$woo_vou_pubilc->add_hooks();
		
		//Admin Pages Class for admin side
		require_once( WOO_VOU_ADMIN . '/class-woo-vou-admin.php' );
		$woo_vou_admin = new WOO_Vou_Admin();
		$woo_vou_admin->add_hooks();
		
		if( woo_vou_is_edit_page() ) {
			
			//include the meta functions file for metabox
			require_once ( WOO_VOU_META_DIR . '/woo-vou-meta-box-functions.php' );
			
		}
		
		//Export to CSV Process for used voucher codes
		require_once( WOO_VOU_DIR . '/includes/woo-vou-used-codes-export-csv.php' );
		
		//Generate PDF Process for voucher code and used voucher codes
		require_once( WOO_VOU_DIR . '/includes/woo-vou-used-codes-pdf.php' );
		require_once( WOO_VOU_DIR . '/includes/woo-vou-pdf-process.php' );
		
	}//end if to check class Woocommerce is exist or not
	
} //end if to check plugin loaded is called or not