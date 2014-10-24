<?php 

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Model Class
 *
 * Handles generic plugin functionality.
 *
 * @package WooCommerce - PDF Vouchers
 * @since 1.0.0
 */
class WOO_Vou_Model {

	public function __construct() {
		
	}
	
	/**
	 * Escape Tags & Slashes
	 *
	 * Handles escapping the slashes and tags
	 *
	 * @package WooCommerce - PDF Vouchers
	 * @since 1.0.0
	 */
	public function woo_vou_escape_attr($data){
		return esc_attr(stripslashes($data));
	}
	
	/**
	 * Strip Slashes From Array
	 *
	 * @package WooCommerce - PDF Vouchers
	 * @since 1.0.0
	 */
	public function woo_vou_escape_slashes_deep( $data = array(), $flag = false, $limited = false ){
			
		if( $flag != true ) {
			
			$data = $this->woo_vou_nohtml_kses($data);
			
		} else {
			
			if( $limited == true ) {
				$data = wp_kses_post( $data );
			}
			
		}
		$data = stripslashes_deep($data);
		return $data;
	}
	
	/**
	 * Strip Html Tags 
	 * 
	 * It will sanitize text input (strip html tags, and escape characters)
	 * 
	 * @package WooCommerce - PDF Vouchers
	 * @since 1.0.0
	 */
	public function woo_vou_nohtml_kses($data = array()) {
		
		if ( is_array($data) ) {
			
			$data = array_map(array($this,'woo_vou_nohtml_kses'), $data);
			
		} elseif ( is_string( $data ) ) {
			
			$data = wp_filter_nohtml_kses($data);
		}
		
		return $data;
	}	
	
	/**
	 * Convert Object To Array
	 *
	 * Converting Object Type Data To Array Type
	 * 
	 * @package WooCommerce - PDF Vouchers
	 * @since 1.0.0
	 */
	public function woo_vou_object_to_array($result) {
		
	    $array = array();
	    foreach ($result as $key=>$value)
	    {	
	        if (is_object($value))
	        {
	            $array[$key]=$this->woo_vou_object_to_array($value);
	        } else {
	        	$array[$key]=$value;
	        }
	    }
	    return $array;
	}
	
	/**
	 * Get Date Format
	 * 
	 * Handles to return formatted date which format is set in backend
	 * 
	 * @package WooCommerce - PDF Vouchers
	 * @since 1.0.0
	 */
	public function woo_vou_get_date_format( $date, $time = false ) {
		
		$format = $time ? get_option( 'date_format' ).' '.get_option('time_format') : get_option('date_format');
		$date = date_i18n( $format, strtotime($date));
		return apply_filters('woo_vou_get_date_format',$date);
	}
	
	/**
	 * Get Downloads For which voucher used
	 * 
	 * Handels to get all products for which vouchers
	 * used for that product
	 * 
	 * @package WooCommerce - PDF Vouchers
	 * @since 1.0.0
	 */
	public function woo_vou_get_used_codes( $args = array() ) {

		$prefix = WOO_VOU_META_PREFIX;
		
		$vouargs = array( 'post_type' => WOO_VOU_MAIN_POST_TYPE, 'post_status' => 'publish');
		$meta = array();
		
		//show products which is used as codes
		if(isset( $args['used_codes'] ) ) {
			$meta['key']	=	$prefix.'used_data';
			$meta['value']	=	'';
			$meta['compare'] = '!=';
		}
		
		//display based on per page
		if( isset( $args['posts_per_page'] ) && !empty( $args['posts_per_page'] ) ) {
			$vouargs['posts_per_page'] = $args['posts_per_page'];
		} else {
			$vouargs['posts_per_page'] = '-1';
		}
				
		//set meta query parameters
		if(!empty($meta) ) {
			$vouargs['meta_query'] = array( $meta );
		}
		
		//get order by records
		$vouargs['order'] = 'DESC';
		$vouargs['orderby'] = 'date';
		
		//fire query in to table for retriving data
		$result = new WP_Query( $vouargs );
		
		if( isset( $args['getcount'] ) && $args['getcount'] == '1' ) {
			$products = $result->post_count;	
		}  else {
			//retrived data is in object format so assign that data to array for listing
			$products = $this->woo_vou_object_to_array($result->posts);
		}
		return $products;
	}
	
	/**
	 * Generate Random Letter
	 *
	 * @package WooCommerce - PDF Vouchers
	 * @since 1.0.0
	 */
	public function woo_vou_get_random_letter( $len = 1 ) {
	   
	    $alphachar = "abcdefghijklmnopqrstuvwxyz";
		$rand_string = substr(str_shuffle($alphachar), 0, $len);
		
	    return $rand_string;
	}
	
	/**
	 * Generate Random Number
	 *
	 * @package WooCommerce - PDF Vouchers
	 * @since 1.0.0
	 */
	public function woo_vou_get_random_number( $len = 1 ) {
	   
	    $alphanum = "0123456789";
		$rand_number = substr(str_shuffle($alphanum), 0, $len);
		
	    return $rand_number;
	}
	
	/**
	 * Generate Random Pattern Code
	 *
	 * @package WooCommerce - PDF Vouchers
	 * @since 1.0.0
	 */
	public function woo_vou_get_pattern_string( $pattern ) {
		
		$pattern_string = '';
		$pattern_length = strlen(trim($pattern, ' '));
		
		for ( $i = 0; $i < $pattern_length; $i++ ) {
			
			$pattern_code = substr($pattern, $i, 1);
			if( strtolower($pattern_code) == 'l' ) {
				$pattern_string .= $this->woo_vou_get_random_letter();
			} else if( strtolower($pattern_code) == 'd' ) {
				$pattern_string .= $this->woo_vou_get_random_number();
			}
		}
		return $pattern_string;
	}
	
	/**
	 * Get all vouchers templates
	 *
	 * Handles to return all vouchers templates
	 * 
	 * @package WooCommerce - PDF Vouchers
	 * @since 1.0.0
	 */
	public function woo_vou_get_vouchers( $args = array() ) {
		
		$vouargs = array( 'post_type' => WOO_VOU_POST_TYPE, 'post_status' => 'publish' );
		
		//return only id
		if(isset($args['fields']) && !empty($args['fields'])) {
			$vouargs['fields'] = $args['fields'];
		}
		
		//return based on meta query
		if(isset($args['meta_query']) && !empty($args['meta_query'])) {
			$vouargs['meta_query'] = $args['meta_query'];
		}
		
		//show how many per page records
		if(isset($args['posts_per_page']) && !empty($args['posts_per_page'])) {
			$vouargs['posts_per_page'] = $args['posts_per_page'];
		} else {
			$vouargs['posts_per_page'] = '-1';
		}
		
		//get by post parent records
		if(isset($args['post_parent']) && !empty($args['post_parent'])) {
			$vouargs['post_parent']	=	$args['post_parent'];
		}
		
		//show per page records
		if(isset($args['paged']) && !empty($args['paged'])) {
			$vouargs['paged']	=	$args['paged'];
		}
		
		//get order by records
		$vouargs['order'] = 'DESC';
		$vouargs['orderby'] = 'date';
		
		//fire query in to table for retriving data
		$result = new WP_Query( $vouargs );
		
		if(isset($args['getcount']) && $args['getcount'] == '1') {
			$postslist = $result->post_count;	
		}  else {
			//retrived data is in object format so assign that data to array for listing
			$postslist = $this->woo_vou_object_to_array($result->posts);
		}
		
		return $postslist;
	}
	
	/**
	 * Get all voucher details
	 *
	 * Handles to return all voucher details
	 * 
	 * @package WooCommerce - PDF Vouchers
	 * @since 1.1.0
	 */
	public function woo_vou_get_voucher_details( $args = array() ) {
		
		$post_status	= isset( $args['post_status'] ) ? $args['post_status'] : 'publish';
		
		$vouargs = array( 'post_type' => WOO_VOU_CODE_POST_TYPE, 'post_status' => $post_status );
		
		//return only id
		if(isset($args['fields']) && !empty($args['fields'])) {
			$vouargs['fields'] = $args['fields'];
		}
		
		//return based on post ids
		if(isset($args['post__in']) && !empty($args['post__in'])) {
			$vouargs['post__in'] = $args['post__in'];
		}
		
		//return based on author
		if(isset($args['author']) && !empty($args['author'])) {
			$vouargs['author'] = $args['author'];
		}
		
		//return based on meta query
		if(isset($args['meta_query']) && !empty($args['meta_query'])) {
			$vouargs['meta_query'] = $args['meta_query'];
		}
		
		//show how many per page records
		if(isset($args['posts_per_page']) && !empty($args['posts_per_page'])) {
			$vouargs['posts_per_page'] = $args['posts_per_page'];
		} else {
			$vouargs['posts_per_page'] = '-1';
		}
		
		//get by post parent records
		if(isset($args['post_parent']) && !empty($args['post_parent'])) {
			$vouargs['post_parent']	=	$args['post_parent'];
		}
		
		//show per page records
		if(isset($args['paged']) && !empty($args['paged'])) {
			$vouargs['paged']	=	$args['paged'];
		}
		
		//get order by records
		$vouargs['order']	= 'DESC';
		$vouargs['orderby']	= 'date';
		
		//fire query in to table for retriving data
		$result = new WP_Query( $vouargs );
		
		if(isset($args['getcount']) && $args['getcount'] == '1') {
			$postslist = $result->post_count;	
		} else {
			//retrived data is in object format so assign that data to array for listing
			$postslist = $this->woo_vou_object_to_array($result->posts);
		}
		
		return $postslist;
	}
	
	/**
	 * Get all products by vouchers
	 *
	 * Handles to return all products by vouchers
	 * 
	 * @package WooCommerce - PDF Vouchers
	 * @since 1.1.0
	 */
	public function woo_vou_get_products_by_voucher( $args = array() ) {
		
		$prefix = WOO_VOU_META_PREFIX;
		
		$args['fields'] = 'id=>parent';
									
		$voucodesdata = $this->woo_vou_get_voucher_details( $args );
		
		$product_ids =array();
		foreach ( $voucodesdata as $voucodes ) {
			
			if( !in_array( $voucodes['post_parent'], $product_ids ) ) {
				
				$product_ids[] = $voucodes['post_parent'];
			}
		}
		
		if( !empty( $product_ids ) ) { // Check products ids are not empty
			
			$vouargs = array( 'post_type' => WOO_VOU_MAIN_POST_TYPE, 'post_status' => 'publish', 'post__in' => $product_ids );
			
			//display based on per page
			if( isset( $args['posts_per_page'] ) && !empty( $args['posts_per_page'] ) ) {
				$vouargs['posts_per_page'] = $args['posts_per_page'];
			} else {
				$vouargs['posts_per_page'] = '-1';
			}
			
			//get order by records
			$vouargs['order']	= 'DESC';
			$vouargs['orderby']	= 'date';
			
			//fire query in to table for retriving data
			$result = new WP_Query( $vouargs );
			
			if( isset( $args['getcount'] ) && $args['getcount'] == '1' ) {
				$products = $result->post_count;	
			}  else {
				//retrived data is in object format so assign that data to array for listing
				$products = $this->woo_vou_object_to_array($result->posts);
			}
			return $products;
			
		} else {
			
			return array();
		}
	}
	
	/**
	 * Get purchased codes by product id
	 *
	 * Handles to get purchased codes by product id
	 * 
	 * @package WooCommerce - PDF Vouchers
	 * @since 1.1.0
	 */
	public function woo_vou_get_purchased_codes_by_product_id( $product_id ) {
		
		global $woo_vou_vendor_role;
		
		//Check product id is empty
		if( empty( $product_id ) ) return array();
		
		global $current_user;
		
		$prefix = WOO_VOU_META_PREFIX;
		
		$args = array( 'post_parent' => $product_id, 'fields' => 'ids' );
		$args['meta_query'] = array(
										array(
													'key' 		=> $prefix . 'purchased_codes',
													'value' 	=> '',
													'compare' 	=> '!='
												)
									);
		
		//Get User roles
		$user_roles	= isset( $current_user->roles ) ? $current_user->roles : array();
		$user_role	= array_shift( $user_roles );
		
		if( in_array( $user_role, $woo_vou_vendor_role ) ) { // Check vendor user role
			$args['author'] = $current_user->ID;
		}
		
		//add filter to group by order id
		add_filter( 'posts_groupby', array( $this, 'woo_vou_groupby_order_id' ) );

		$voucodesdata = $this->woo_vou_get_voucher_details( $args );
		
		//remove filter to group by order id
		remove_filter( 'posts_groupby', array( $this, 'woo_vou_groupby_order_id' ) );

		$vou_code_details = array();
		if( !empty( $voucodesdata ) && is_array( $voucodesdata ) ) {
			
			foreach ( $voucodesdata as $vou_codes_id ) {
				
				// get order id
				$order_id = get_post_meta( $vou_codes_id, $prefix.'order_id', true );
				
				// get order date
				$order_date = get_post_meta( $vou_codes_id, $prefix.'order_date', true );

				//buyer's first name who has purchased voucher code
				$first_name = get_post_meta( $vou_codes_id, $prefix . 'first_name', true );
				
				//buyer's last name who has purchased voucher code
				$last_name = get_post_meta( $vou_codes_id, $prefix . 'last_name', true );
				
				//buyer's name who has purchased voucher code				
				$buyer_name =  $first_name. ' ' .$last_name;
				
				$args = array( 'post_parent' => $product_id, 'fields' => 'ids' );
				$args['meta_query'] = array(
												array(
															'key' 		=> $prefix . 'purchased_codes',
															'value' 	=> '',
															'compare' 	=> '!='
														),
												array(
															'key' 		=> $prefix . 'order_id',
															'value' 	=> $order_id
														)
											);
				$vouorderdata = $this->woo_vou_get_voucher_details( $args );
				
				$purchased_codes = array();
				if( !empty( $vouorderdata ) && is_array( $vouorderdata ) ) {
					
					foreach ( $vouorderdata as $order_vou_id ) {
						
						// get purchased codes
						$purchased_codes[] = get_post_meta( $order_vou_id, $prefix.'purchased_codes', true );
					}
				}
				
				// Check purchased codes are not empty
				if( !empty( $purchased_codes ) ) {
					
					$vou_code_details[] = array(
														'order_id'			=> $order_id,
														'order_date' 		=> $order_date,
														'first_name' 		=> $first_name,
														'last_name' 		=> $last_name,
														'buyer_name' 		=> $buyer_name,
														'vou_codes'			=> implode( ', ', $purchased_codes )
													);
				}
			}
		}
		return $vou_code_details;
	}
	
	/**
	 * Get used codes by product id
	 *
	 * Handles to get used codes by product id
	 * 
	 * @package WooCommerce - PDF Vouchers
	 * @since 1.1.0
	 */
	public function woo_vou_get_used_codes_by_product_id( $product_id ) {
		
		//Check product id is empty
		if( empty( $product_id ) ) return array();
		
		global $current_user, $woo_vou_vendor_role;
		
		$prefix = WOO_VOU_META_PREFIX;
		
		$args = array( 'post_parent' => $product_id, 'fields' => 'ids' );
		$args['meta_query'] = array(
										array(
													'key' 		=> $prefix . 'used_codes',
													'value' 	=> '',
													'compare' 	=> '!='
												)
									);
		
		//Get User roles
		$user_roles	= isset( $current_user->roles ) ? $current_user->roles : array();
		$user_role	= array_shift( $user_roles );
		
		if( in_array( $user_role, $woo_vou_vendor_role ) ) { // Check vendor user role
			$args['author'] = $current_user->ID;
		}
		
		//add filter to group by order id
		add_filter( 'posts_groupby', array( $this, 'woo_vou_groupby_order_id' ) );

		$voucodesdata = $this->woo_vou_get_voucher_details( $args );
		
		//remove filter to group by order id
		remove_filter( 'posts_groupby', array( $this, 'woo_vou_groupby_order_id' ) );

		$vou_code_details = array();
		if( !empty( $voucodesdata ) && is_array( $voucodesdata ) ) {
			
			foreach ( $voucodesdata as $vou_codes_id ) {
				
				// get order id
				$order_id = get_post_meta( $vou_codes_id, $prefix.'order_id', true );
				
				// get order date
				$order_date = get_post_meta( $vou_codes_id, $prefix.'order_date', true );

				//buyer's first name who has purchased voucher code
				$first_name = get_post_meta( $vou_codes_id, $prefix . 'first_name', true );
				
				//buyer's last name who has purchased voucher code
				$last_name = get_post_meta( $vou_codes_id, $prefix . 'last_name', true );
				
				//buyer's name who has purchased voucher code				
				$buyer_name =  $first_name. ' ' .$last_name;
				
				$args = array( 'post_parent' => $product_id, 'fields' => 'ids' );
				$args['meta_query'] = array(
												array(
															'key' 		=> $prefix . 'used_codes',
															'value' 	=> '',
															'compare' 	=> '!='
														),
												array(
															'key' 		=> $prefix . 'order_id',
															'value' 	=> $order_id
														)
											);
				$vouorderdata = $this->woo_vou_get_voucher_details( $args );
				
				$used_codes = array();
				if( !empty( $vouorderdata ) && is_array( $vouorderdata ) ) {
					
					foreach ( $vouorderdata as $order_vou_id ) {
						
						// get purchased codes
						$used_codes[] = get_post_meta( $order_vou_id, $prefix.'used_codes', true );
					}
				}
				
				// Check purchased codes are not empty
				if( !empty( $used_codes ) ) {
					
					$vou_code_details[] = array(
														'order_id'		=> $order_id,
														'order_date' 	=> $order_date,
														'first_name' 	=> $first_name,
														'last_name' 	=> $last_name,
														'buyer_name' 	=> $buyer_name,
														'vou_codes'		=> implode( ',', $used_codes )
													);
				}
			}
		}
		return $vou_code_details;
	}
	
	/**
	 * Group By Order ID
	 *
	 * Handles to group by order id
	 * 
	 * @package WooCommerce - PDF Vouchers
	 * @since 1.0.0
	 */
	public function woo_vou_groupby_order_id( $groupby ) {
	    
		global $wpdb;
	    
	    $groupby = "{$wpdb->posts}.post_title"; // post_title is used for order id
	    
	    return $groupby;
	}
	
	/**
	 * Convert Color Hexa to RGB
	 *
	 * Handles to return RGB color from hexa color
	 * 
	 * @package WooCommerce - PDF Vouchers
	 * @since 1.0.0
	 */
	public function woo_vou_hex_2_rgb( $hex ) {
		
		$rgb = array();
		if( !empty( $hex ) ) {
			
			$hex = str_replace("#", "", $hex);
			
			if(strlen($hex) == 3) {
				$r = hexdec(substr($hex,0,1).substr($hex,0,1));
				$g = hexdec(substr($hex,1,1).substr($hex,1,1));
				$b = hexdec(substr($hex,2,1).substr($hex,2,1));
			} else {
				$r = hexdec(substr($hex,0,2));
				$g = hexdec(substr($hex,2,2));
				$b = hexdec(substr($hex,4,2));
			}
			$rgb = array($r, $g, $b);
		}
		return $rgb; // returns an array with the rgb values
	}
	
	/**
 	 * Add plugin settings
 	 * 
 	 * Handles to add plugin settings
 	 * 
 	 * @package WooCommerce - PDF Vouchers
 	 * @since 1.0.0
 	 */
	public function woo_vou_settings( $settings ) {
		
		$voucher_options	= array( '' => __( 'Please Select', 'woovoucher' ) );
		$voucher_data		= $this->woo_vou_get_vouchers();
		
		foreach ( $voucher_data as $voucher ) {
			
			if( isset( $voucher['ID'] ) && !empty( $voucher['ID'] ) ) { // Check voucher id is not empty
				
				$voucher_options[$voucher['ID']] = $voucher['post_title'];
			}
		}
		
		// Usability options
		$usability_options = array(
									'0'	=> __('One time only', 'woovoucher'),
									'1'	=> __('Unlimited', 'woovoucher')
								);
		
		//Setting 2 for pdf voucher
		$woo_vou_settings	= array(
									array( 
											'title'	=>	__( 'Voucher Options', 'woovoucher' ),
											'type'	=>	'title',
											'desc'	=>	'',
											'id'	=>	'vou_settings'
									),
									array(
										'id'		=> 'vou_delete_options',
										'name'		=> __( 'Delete Options:', 'woovoucher' ),
										'desc'		=> '',
										'type'		=> 'checkbox',
										'desc_tip'	=> '<p class="description">'.__( 'If you don\'t want to use the Pdf Voucher Plugin on your site anymore, you can check that box. This makes sure, that all the settings and tables are being deleted from the database when you deactivate the plugin.','woovoucher' ).'</p>'
									),
									array(
										'id'		=> 'vou_site_logo',
										'name'		=> __( 'Site Logo:', 'woovoucher' ),
										'desc'		=> '<p class="description">'.__( 'Here you can upload a logo of your site. This logo will then be displayed on the Voucher as the Site Logo.', 'woovoucher' ).'</p>',
										'type'		=> 'upload',
										'size'		=> 'regular'
									),
									array(
										'id'		=> 'vou_pdf_name',
										'name'		=> __( 'Export PDF File Name:', 'woovoucher' ),
										'desc'		=> '<p class="description">'.__( 'Enter the PDF file name. This file name will be used when generate a PDF of purchased voucher codes. The available tags are:','woovoucher' ).'<br /><code>{current_date}</code> - '.__('displays the current date', 'woovoucher' ).'</p>',
										'type'		=> 'filename',
										'options'	=> '.pdf'
									),
									array(
										'id'		=> 'vou_csv_name',
										'name'		=> __( 'Export CSV File Name:', 'woovoucher' ),
										'desc'		=> '<p class="description">'.__( 'Enter the CSV file name. This file name will be used when generate a CSV of purchased voucher codes. The available tags are:','woovoucher' ).'<br /><code>{current_date}</code> - '.__('displays the current date', 'woovoucher' ).'</p>',
										'type'		=> 'filename',
										'options'	=> '.csv'
									),
									array(
										'id'		=> 'order_pdf_name',
										'name'		=> __( 'Download PDF File Name:', 'woovoucher' ),
										'desc'		=> '<p class="description">'.__( 'Enter the PDF file name. This file name will be used when users download a PDF of voucher codes on froentend. The available tags are:','woovoucher' ).'<br /><code>{current_date}</code> - '.__('displays the current date', 'woovoucher' ).'</p>',
										'type'		=> 'filename',
										'options'	=> '.pdf'
									),
									array(
										'id'		=> 'vou_pdf_template',
										'name'		=> __( 'PDF Template:', 'woovoucher' ),
										'desc'		=> '<p class="description">'.__( 'Select PDF Template.', 'woovoucher' ).'</p>',
										'type'		=> 'select',
										'class'		=> 'chosen_select',
										'options'	=> $voucher_options
									),
									array(
										'id'		=> 'vou_pdf_usability',
										'name'		=> __( 'Usability:', 'woovoucher' ),
										'desc'		=> '<p class="description">'.__( 'Choose how many times the same Voucher Code can be used by the users.', 'woovoucher' ).'</p>',
										'type'		=> 'select',
										'class'		=> 'chosen_select',
										'options'	=> $usability_options
									),
									array(
										'id'		=> 'multiple_pdf',
										'name'		=> __( 'Multiple voucher:', 'woovoucher' ),
										'desc'		=> __( 'Enable 1 voucher per Pdf', 'woovoucher' ),
										'type'		=> 'checkbox',
										'desc_tip'	=> '<p class="description">'.__( 'Check this box if you want to generate 1 pdf for 1 voucher code instead of creating 1 combined pdf for all vouchers.', 'woovoucher' ).'</p>'
									)
						);
				
				//Add voucher setting if woocommerce vendor plugin activated
				if( class_exists( 'WC_Vendors' ) ) {
					
					$woo_vendor_setting	= array(
												array(
													'id'		=> 'vou_hide_vendor_options',
													'name'		=> __( 'Hide Vendor Options:', 'woovoucher' ),
													'desc'		=> __( 'Hide Vendor Options', 'woovoucher' ),
													'type'		=> 'checkbox',
													'desc_tip'	=> '<p class="description">'.__( 'Check this box if you want to hide vendor specific settings from product meta box for vendor users.', 'woovoucher' ).'</p>'
												)
											);
					
					$woo_vou_settings = array_merge( $woo_vou_settings, $woo_vendor_setting );
				}
				
				//Setting 2 for pdf voucher
				$woo_vou_settings2 = array( 
										array(
											'id'		=> 'vou_email_subject',
											'name'		=> __( 'Email Subject:', 'woovoucher' ),
											'desc'		=> '<p class="description">'.__( 'Enter the subject line for the vendor sale notification email. Available template tags:','woovoucher' ).
															'<br /><code>{site_name}</code> - '.__( 'displays the site name', 'woovoucher' ).
															'<br /><code>{product_title}</code> - '.__( 'displays the product title', 'woovoucher' ).
															'<br /><code>{voucher_code}</code> - '.__( 'displays the voucher code', 'woovoucher' ).'</p>',
											'type'		=> 'text',
											'class'		=> 'regular-text',
										),
										array(
											'id'		=> 'vou_email_body',
											'name'		=> __( 'Email Body:', 'woovoucher' ),
											'desc'		=> '<p class="description">'.__( 'Enter the vendor email that is sent after completion of a purchase. HTML is accepted. Available template tags:','woovoucher' ).
															'<br /><code>{site_name}</code> - '.__('displays the site name', 'woovoucher' ).
															'<br /><code>{product_title}</code> - '.__('displays the product title', 'woovoucher' ).
															'<br /><code>{voucher_code}</code> - '.__('displays the voucher code', 'woovoucher' ).'</p>',
											'type'		=> 'bigtext',
											'class'		=> 'large-text',
											'css' 		=> 'height: 200px;',
										),
										array( 
											'type' 		=> 'sectionend',
											'id' 		=> 'vou_settings'
										)
									);
			
			//Merge all vouvher settings
			$woo_vou_settings = array_merge( $woo_vou_settings, $woo_vou_settings2 );
			
			
		return array_merge( $settings, $woo_vou_settings );
		
	}
	
	/**
	 * Get voucher order details
	 * 
	 * Handles to return voucher order details
	 * 
	 * @package WooCommerce - PDF Vouchers
	 * @since 1.0.0
	 */
	public function woo_vou_get_post_meta_ordered( $orderid ) {
		
		$prefix = WOO_VOU_META_PREFIX;
		
		$data = get_post_meta( $orderid, $prefix.'order_details', true );
		return apply_filters( 'woo_vou_ordered_data', $data );
	}
	
	/**
	 * Get All voucher order details
	 * 
	 * Handles to return all voucher order details
	 * 
	 * @package WooCommerce - PDF Vouchers
	 * @since 1.1.0
	 */
	public function woo_vou_get_all_ordered_data( $orderid ) {
		
		$prefix = WOO_VOU_META_PREFIX;
		
		$data = get_post_meta( $orderid, $prefix.'meta_order_details', true );
		return apply_filters( 'woo_vou_all_ordered_data', $data );
	}
	
	/**
	 * Update Duplicate Post Metas
	 * 
	 * Handles to update all old vous meta to 
	 * duplicate meta
	 * 
	 * @package WooCommerce - PDF Vouchers
	 * @since 1.0.0
	 */
	public function woo_vou_dupd_post_meta( $old_id, $new_id ) {
			
			// set prefix for meta fields 
			$prefix = WOO_VOU_META_PREFIX;
			
			// get all post meta for vou
			$meta_fields = get_post_meta( $old_id );
			
			// take array to store metakeys of old vou
			$meta_keys = array();
			
			foreach ( $meta_fields as $metakey => $matavalues ) {
				// meta keys store in a array
				$meta_keys[] = $metakey;
			}
			
			foreach ( $meta_keys as $metakey ) {
				
				// get metavalue from metakey
				$meta_value = get_post_meta( $old_id, $metakey, true );
				
				// update meta values to new duplicate vou meta
				update_post_meta( $new_id, $metakey, $meta_value );
			}
	}
	/**
	 * Create Duplicate Voucher
	 * 
	 * Handles to create duplicate voucher
	 * 
	 * @package WooCommerce - PDF Vouchers
	 * @since 1.0.0
	 */
	public function woo_vou_dupd_create_duplicate_vou( $vou_id ) {
			
			// get the vou data
			$vou = get_post( $vou_id );
			
			$prefix = WOO_VOU_META_PREFIX;
			
			// start process to create a new vou
			$suffix = __( '(Copy)', 'woovoucher' );
			
			// get post table data
			$post_author   			= $vou->post_author;
			$post_date      		= current_time('mysql');
			$post_date_gmt 			= get_gmt_from_date($post_date);
			$post_type				= $vou->post_type;
			$post_parent			= $vou->post_parent;
			$post_content    		= str_replace("'", "''", $vou->post_content);
			$post_content_filtered 	= str_replace("'", "''", $vou->post_content_filtered);
			$post_excerpt    		= str_replace("'", "''", $vou->post_excerpt);
			$post_title      		= str_replace("'", "''", $vou->post_title).' '.$suffix;
			$post_name       		= str_replace("'", "''", $vou->post_name);
			$post_comment_status  	= str_replace("'", "''", $vou->comment_status);
			$post_ping_status     	= str_replace("'", "''", $vou->ping_status);
			
			// get the column keys
		    $post_data = array(
					            'post_author'			=>	$post_author,
					            'post_date'				=>	$post_date,
					            'post_date_gmt'			=>	$post_date_gmt,
					            'post_content'			=>	$post_content,
					            'post_title'			=>	$post_title,
					            'post_excerpt'			=>	$post_excerpt,
					            'post_status'			=>	'draft',
					            'post_type'				=>	WOO_VOU_POST_TYPE,
					            'post_content_filtered'	=>	$post_content_filtered,
					            'comment_status'		=>	$post_comment_status,
					            'ping_status'			=> 	$post_ping_status,
					            'post_password'			=>	$vou->post_password,
					            'to_ping'				=>	$vou->to_ping,
					            'pinged'				=>	$vou->pinged,
					            'post_modified'			=>	$post_date,
					            'post_modified_gmt'		=>	$post_date_gmt,
					            'post_parent'			=>	$post_parent,
					            'menu_order'			=>	$vou->menu_order,
					            'post_mime_type'		=>	$vou->post_mime_type
				       		);
			
			// returns the vou id if we successfully created that vou
			$post_id = wp_insert_post( $post_data );
			
			//update vous meta values
			$this->woo_vou_dupd_post_meta( $vou->ID, $post_id );
			
			// if successfully created vou than redirect to main page
			wp_redirect( add_query_arg( array( 'post_type' => WOO_VOU_POST_TYPE, 'action' => 'edit', 'post' => $post_id ), admin_url( 'post.php' ) ) );
			
			// to avoid junk
			exit;
	}
	
	/**
	 * Check Enable Voucher
	 * 
	 * Handles to check enable voucher using product id
	 *
	 * @package WooCommerce - PDF Vouchers
	 * @since 1.0.0
	 */
	public function woo_vou_check_enable_voucher( $productid, $variation_id = false ) {
		
		if( !empty( $productid ) ) { // Check product id is not empty
			
			$prefix = WOO_VOU_META_PREFIX;
			
			//enable voucher
			$enable_vou = get_post_meta( $productid, $prefix.'enable', true );
			
			// If variation id
			if(!empty($variation_id) ) {
				
				$is_downloadable = get_post_meta( $variation_id, '_downloadable', true );
				
			} else { // is downloadable
				
				$is_downloadable = get_post_meta( $productid, '_downloadable', true );
			}
			
			// Check enable voucher meta & product is downloadable
			// Check Voucher codes are not empty 
			if( $enable_vou == 'yes' && $is_downloadable == 'yes' ) { // Check enable voucher meta & product is downloadable
				
				return true;
			}
		}
		return false;
	}
	
	/**
	 * Get User Details by order id
	 * 
	 * Handles to get user details by order id
	 *
	 * @package WooCommerce - PDF Vouchers
	 * @since 1.0.0
	 */
	public function woo_vou_get_payment_user_info( $order_id ) {
		
		$userdata = array();
		if( !empty( $order_id ) ) { // Check order id is not empty
			
			$order = new WC_Order( $order_id );
			
			$userdata['first_name'] = isset( $order->billing_first_name ) ? $order->billing_first_name : '';
			$userdata['last_name'] 	= isset( $order->billing_last_name ) ? $order->billing_last_name : '';
			$userdata['email'] 		= isset( $order->billing_email ) ? $order->billing_email : '';
			
		}
		
		return $userdata;
	}
	
	/**
	 * Get Voucher Keys
	 * 
	 * Handles to get voucher keys
	 * 
	 * @package WooCommerce - PDF Vouchers
	 * @since 1.1.0
	 */
	public function woo_vou_get_multi_voucher_key( $order_id = '', $product_id = '' ) {
		
		$voucher_keys	= array();
		$vouchers		= $this->woo_vou_get_multi_voucher( $order_id, $product_id );
		
		if( !empty( $vouchers ) ) {
			
			$voucher_keys	= array_keys( $vouchers );
		}
		
		return $voucher_keys;
	}
	
	/**
	 * Get Vouchers
	 * 
	 * Handles to get vouchers
	 * 
	 * @package WooCommerce - PDF Vouchers
	 * @since 1.1.0
	 */
	public function woo_vou_get_multi_voucher( $order_id = '', $product_id = '' ) {
		
		$vou_ordered	= $this->woo_vou_get_post_meta_ordered( $order_id );
		$codes			= isset( $vou_ordered[$product_id]['codes'] ) ? $vou_ordered[$product_id]['codes'] : '';
		$codes			= explode( ', ', $codes );
		$vouchers		= array();
		
		if( !empty( $codes ) ) {
			
			$key	= 1;
			foreach ( $codes as $code ) {
				
				$vouchers['woo_vou_pdf_'.$key]	= $code;
				$key++;
			}
		}
		
		return $vouchers;
	}
	
	/**
	 * Sendt an email
	 * 
	 * Handles to send an email
	 *
	 * @package WooCommerce - PDF Vouchers
	 * @since 1.1.0
	 */
	public function woo_vou_send_email( $email, $subject, $message ){
		
		$fromEmail = get_option('admin_email');
		
		$headers = 'From: '. $fromEmail . "\r\n";
		$headers .= "Reply-To: ". $fromEmail . "\r\n";
		$headers .= 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";

		wp_mail( $email, $subject, $message, $headers );
	}
	
	/**
	 * Get the current date from timezone
	 * 
	 * Handles to get current date
	 * acording to timezone setting
	 * 
	 * @package WooCommerce - PDF Vouchers
	 * @since 1.1.0
	 **/
	public function woo_vou_current_date( $format = 'Y-m-d H:i:s' ) { 
		
		if( !empty($format) ) {
			
			$date_time = date( $format, current_time('timestamp') );
		} else {
			
			$date_time = date( 'Y-m-d H:i:s', current_time('timestamp') );
		}
		
		return $date_time;
	}
	
	/**
	 * Get the product name from order id
	 * 
	 * @package WooCommerce - PDF Vouchers
	 * @since 1.1.0
	 **/
	public function woo_vou_get_product_name( $orderid, $items = array() ) {
		
		// If order id is empty then return
		if( empty($orderid) ) return false;
		
		// Taking some defaults
		$result_item = array();
		
		// If item is empty or not passed then get from order.
		if( empty($items) || !is_array($items) ) {
			$woo_order 			= new WC_Order( $orderid );
			$woo_order_details 	= $woo_order;
			$items 				= $woo_order_details->get_items();
		}
		
		if( !empty($items) ) {
			foreach ( $items as $item_key => $item_val ) {
				
				if( !empty($item_val['product_id']) ) {
					$result_item[$item_val['product_id']] = isset($item_val['name']) ? $item_val['name'] : '';
				}
			}
		} // End of if
		
		return $result_item;
	}
	
	/**
	 * Get the vendor detail to store in order meta
	 * 
	 * @package WooCommerce - PDF Vouchers
	 * @since 1.5
	 **/
	public function woo_vou_get_vendor_detail( $productid , $vendor_user ) {
		
		global $woo_vou_vendor_role;
		
		$prefix			= WOO_VOU_META_PREFIX;
		$vendor_detail	= array();
		
		$user_data		= get_userdata( $vendor_user );
		
		//Get User roles
		$user_roles	= isset( $user_data->roles ) ? $user_data->roles : array();
		$user_role	= array_shift( $user_roles );
		
		//Vendor Logo
		$vendor_logo 	 = get_post_meta( $productid, $prefix.'logo', true );
		//Vendor Address
		$vendor_address  = get_post_meta( $productid, $prefix.'address_phone', true );
		//Website URL
		$website_url 	 = get_post_meta( $productid, $prefix.'website', true );
		//Redeem Instructions
		$how_to_use 	 = get_post_meta( $productid, $prefix.'how_to_use', true );
		//Locations
		$avail_locations = get_post_meta( $productid, $prefix.'avail_locations', true );
		//Usability
		$using_type 	= get_post_meta( $productid, $prefix.'using_type', true );
		//PDF Template
		$pdf_template    = get_post_meta( $productid, $prefix.'pdf_template', true );
		
		// check if user id is not empty and user role is vendor
		if( !empty( $vendor_user ) && in_array( $user_role, $woo_vou_vendor_role ) ) {
			
			if( empty( $vendor_logo['src'] ) ) {
				$vendor_logo['src']	= get_user_meta( $vendor_user, $prefix.'logo', true );
			}
			
			if( empty( $vendor_address )  ){
				$vendor_address		= get_user_meta( $vendor_user, $prefix.'address_phone', true );			
			}
			
			if( empty( $website_url ) ){
				$website_url		= get_user_meta( $vendor_user, $prefix.'website', true );			
			}
			
			if( empty( $how_to_use ) ){
				$how_to_use			= get_user_meta( $vendor_user, $prefix.'how_to_use', true );			
			}
			
			if( empty( $avail_locations ) ) {
				$avail_locations	= get_user_meta( $vendor_user, $prefix.'avail_locations', true );			
			}
			
			if( $using_type == '' ){
				$using_type			= get_user_meta( $vendor_user, $prefix.'using_type', true );			
			}
					
			if( empty( $pdf_template ) ){
				$pdf_template		= get_user_meta( $vendor_user, $prefix.'pdf_template', true );
			}
		}
		
		// If using type is blank then take it from setting
		if( $using_type == '' ) {
			$using_type = get_option('vou_pdf_usability');
		}
		
		$vendor_detail = array(
								'vendor_logo'		=> $vendor_logo,
								'vendor_address'	=> $vendor_address,
								'vendor_website'	=> $website_url,
								'how_to_use'		=> $how_to_use,
								'avail_locations'	=> $avail_locations,
								'using_type'		=> $using_type,
								'pdf_template'		=> $pdf_template
							);
		return $vendor_detail;
	}
}
?>