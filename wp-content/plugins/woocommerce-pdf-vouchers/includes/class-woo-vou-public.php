<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Public Pages Class
 *
 * Handles all the different features and functions
 * for the front end pages.
 *
 * @package WooCommerce - PDF Vouchers
 * @since 1.0.0
 */
class WOO_Vou_Public{
	
	var $model;
	
	public function __construct() {
		
		global $woo_vou_model;
		
		$this->model = $woo_vou_model;
	}
	
	/**
	 * Handles to update voucher details in order data
	 * 
	 * @package WooCommerce - PDF Vouchers
	 * @since 1.0.0
	 */
	public function woo_vou_product_purchase( $order_id ) {
		
		$prefix = WOO_VOU_META_PREFIX;
			
		$changed = false;
		$voucherdata = $vouchermetadata = array();
		
		$userdata    	= $this->model->woo_vou_get_payment_user_info( $order_id );
		
		$userfirstname 	= isset( $userdata['first_name'] ) ? trim( $userdata['first_name'] ) : '';
		$userlastname 	= isset( $userdata['last_name'] ) ? trim( $userdata['last_name'] ) : '';
		$useremail 		= isset( $userdata['email'] ) ? $userdata['email'] : '';
		$buyername		= $userfirstname;
		
		//get voucher order details 
		$voucherdata = get_post_meta( $order_id, $prefix.'order_details', true );
		
		// Check woocommerce order class & voucher data are not empty so code get executed once only
		if( class_exists( 'WC_Order' ) && empty( $voucherdata ) ) {
			
			$order = new WC_Order( $order_id );
			$order_items = $order->get_items();
			
			//Get Order Date
			$order_date = isset( $order->order_date ) ? $order->order_date : '';
			
			if ( is_array( $order_items ) ) {
		
				// Check cart details
				foreach ( $order_items as  $item_id => $item ) {
					
					$productid = $item['product_id'];
					
					$productqty = $item['qty'];
					
					// Taking variation id
					$variation_id = !empty($item['variation_id']) ? $item['variation_id'] : '';
					
					// If product is variable product take variation id else product id
					$data_id = ( !empty($variation_id) ) ? $variation_id : $productid;
					
					//Total voucher codes
					$avail_total_codes 	 = get_post_meta( $productid, '_stock', true );
					
					//voucher codes
					$vou_codes 			 = get_post_meta( $productid, $prefix.'codes', true );
					
					//check enable voucher & is downlable & total codes are not empty
					if( $this->model->woo_vou_check_enable_voucher( $productid, $variation_id ) && !empty( $vou_codes ) && $avail_total_codes != '0' ) {
						
						//vendor user
						$vendor_user 	 = get_post_meta( $productid, $prefix.'vendor_user', true );
						
						//get vendor detail
						$vendor_detail	 = $this->model->woo_vou_get_vendor_detail( $productid , $vendor_user );
						
						//pdf template
						$pdf_template	 = $vendor_detail['pdf_template'];
						
						//vendor logo
						$vendor_logo 	 = $vendor_detail['vendor_logo'];
						
						//vendor address
						$vendor_address  = $vendor_detail['vendor_address'];
						
						//website url
						$website_url 	 = $vendor_detail['vendor_website'];
						
						//redeem instruction
						$redeem			 = $vendor_detail['how_to_use'];
						
						//locations
						$avail_locations = $vendor_detail['avail_locations'];
						
						//using type of voucher
						$using_type 	 = $vendor_detail['using_type'];
						
						//expiry data
						$exp_date		 = get_post_meta( $productid, $prefix.'exp_date', true );
						
						$exp_type 		 = get_post_meta( $productid, $prefix.'exp_type', true );
						$custom_days 	 = '';
						
						if( $exp_type == 'based_on_purchase' ){
							
							$days_diff	= get_post_meta( $productid, $prefix.'days_diff', true );
							
								if( $days_diff == 'cust' ) {
									
									$custom_days	= get_post_meta( $productid, $prefix.'custom_days', true );
									$custom_days	= isset( $custom_days ) ? $custom_days : '';
									if( !empty( $custom_days ) ) {
										$add_days 	= '+'.$custom_days.' days';									
										$exp_date 	= date( 'Y-m-d',strtotime( $order_date . $add_days ) );
									}else {
										$exp_date 	= date( 'Y-m-d' );
									}
									
								} else {
									
									$custom_days = $days_diff;
									
									$add_days 	= '+'.$custom_days.' days';
									
									$exp_date 	= date( 'Y-m-d',strtotime( $order_date . $add_days ) );
								}							
							
						}
						
						//voucher code
						$vouchercodes = get_post_meta( $productid, $prefix.'codes', true );
						$vouchercodes = trim( $vouchercodes, ',' );
						
						//explode all voucher codes
						$salecode = explode( ',', $vouchercodes );
					
						// trim code
						foreach ( $salecode as $code_key => $code ) {
							$salecode[$code_key] = trim( $code );
						}
						
						//update voucher code data to database with order id
						$voucheruseddata = get_post_meta( $productid, $prefix.'used_data', true );
						
						$allcodes = '';
												
						//if voucher useing type is more than one time then generate voucher codes
						if( !empty( $using_type ) ) { 
							
							//if user buy more than 1 quantity of voucher
							if( isset( $productqty ) && $productqty > 1 ) {
								
								$uniquecodedata = '';
								
								for ( $i = 1; $i <= $productqty; $i++ ) {
									
									$voucode = '';
									
									//make voucher code
									$randcode = array_rand( $salecode );
									
									if( !empty( $buyername ) ) {
										$voucode .= $buyername.'-';
									}
									if( !empty( $salecode[$randcode] ) && trim( $salecode[$randcode] ) != '' ) {
										$voucode .= trim( $salecode[$randcode] ).'-';
									}
									$voucode .= $order_id.'-'.$data_id.'-'.$i;
									
									$uniquecodedata .= $order_id.'#$#$#'.$voucode.',';
									
									$allcodes .= $voucode.', ';
									
								}
								
								$voucheruseddata .= $uniquecodedata;
								
							} else {
								
								//make voucher code when user buy single quantity
								$randcode = array_rand( $salecode );
								
								$voucode = '';
								
								if( !empty( $buyername ) ) {
									$voucode .= $buyername.'-';
								}
								if( !empty( $salecode[$randcode] ) && trim( $salecode[$randcode] ) != '' ) {
									$voucode .= trim( $salecode[$randcode] ).'-';
								}
								$voucode .= $order_id.'-'.$data_id;
								
								$uniquecodedata = $order_id.'#$#$#'.$voucode.',';
								$voucheruseddata .= $uniquecodedata;
								
								$allcodes .= $voucode.', ';
							}
							
						} else { 
							
							//if voucher using type is only one time then generate voucher code to send to user
							$uniquecodedata = '';
							
							for ( $i = 0; $i < $productqty; $i++ ) {
								
								//get first voucher code
								$voucode = $salecode[$i];
								
								$uniquecodedata .= $order_id.'#$#$#'.$salecode[$i].',';
								
								//unset first voucher code to remove from all codes
								unset( $salecode[$i] );
								
								$allcodes .= $voucode.', ';
							}
							
							$voucheruseddata .= $uniquecodedata;
							
							//after unsetting first code make one string for other codes
							$lessvoucodes = implode( ',',$salecode );
							update_post_meta( $productid, $prefix.'codes', trim( $lessvoucodes ) );
						}
						
						$allcodes = trim( $allcodes, ', ' );
						
						//update used voucher codes data
						update_post_meta( $productid, $prefix.'used_data', $voucheruseddata );
						
						$productvoudata = array(
													'product_id'	=> 	$productid,
													'enablevou'		=>	'1',
													'codes'			=>	$allcodes,
												);
						
						$voucherdata[$data_id] = $productvoudata;
						
						// Append for voucher meta data into order		
						$productvoumetadata = array(
														'user_email'		=>	$useremail,
														'pdf_template'		=>	$pdf_template,
														'vendor_logo'		=>	$vendor_logo,
														'exp_date'			=>	$exp_date,
														'exp_type'			=>	$exp_type,
														'custom_days'		=>	$custom_days,
														'using_type'		=>	$using_type,
														'vendor_address'	=>	$vendor_address,
														'website_url'		=>	$website_url,
														'redeem'			=>	$redeem,
														'avail_locations'	=>	$avail_locations,
													);
												
						$vouchermetadata[$productid] = $productvoumetadata;
						
						$all_vou_codes = explode( ', ', $allcodes );
						
						foreach ( $all_vou_codes as $vou_code ) {
							
							$vou_code = trim( $vou_code, ',' );
							$vou_code = trim( $vou_code );
							
							//Insert voucher details into custom post type with seperate voucher code
							$vou_codes_args = array(
														'post_title'		=>	$order_id,
														'post_content'		=>	'',
														'post_status'		=>	'pending',
														'post_type'			=>	WOO_VOU_CODE_POST_TYPE,
														'post_parent'		=>	$productid
													);
							if( !empty( $vendor_user ) ) { // Check vendor user is not empty
								
								$vou_codes_args['post_author'] = $vendor_user;
							}
							
							$vou_codes_id = wp_insert_post( $vou_codes_args );
							
							if( $vou_codes_id ) { // Check voucher codes id is not empty
							
								// update buyer first name
								update_post_meta( $vou_codes_id, $prefix.'first_name', $userfirstname );
								// update buyer last name
								update_post_meta( $vou_codes_id, $prefix.'last_name', $userlastname );
								// update order id
								update_post_meta( $vou_codes_id, $prefix.'order_id', $order_id );
								// update order date
								update_post_meta( $vou_codes_id, $prefix.'order_date', $order_date );
								// update expires date
								update_post_meta( $vou_codes_id, $prefix.'exp_date', $exp_date );
								// update purchased codes
								update_post_meta( $vou_codes_id, $prefix.'purchased_codes', $vou_code );
							}
						}
						
						if( !empty( $vendor_user ) ) { // Check vendor user is not empty
						
							$product_title		= get_the_title( $productid );
							$site_name			= get_bloginfo( 'name' );
							$vendor_user_data	= get_user_by( 'id', $vendor_user );
							$vendor_email		= isset( $vendor_user_data->user_email ) ? $vendor_user_data->user_email : '';
												
							$vou_shortcodes		= array( "{site_name}", "{product_title}", "{voucher_code}" );
							$vou_replacecodes	= array( $site_name, $product_title, $allcodes );
							
							$subject	= get_option( 'vou_email_subject' );
							$subject	= str_replace( $vou_shortcodes, $vou_replacecodes, $subject );
							
							$message	= get_option( 'vou_email_body' );
							$message	= str_replace( $vou_shortcodes, $vou_replacecodes, nl2br( $message ) );
							
							// send email to user
							$this->model->woo_vou_send_email( $vendor_email, $subject, $message );	
						}
					}
				}
				
				//update If setting is set for multipdf or not
				$multiple_pdf	= get_option( 'multiple_pdf' );
				
				//update multipdf option in ordermeta
				update_post_meta( $order_id, $prefix . 'multiple_pdf', $multiple_pdf );
				
				if( !empty( $voucherdata ) ) { // Check voucher data are not empty
					
					//update voucher order details
					update_post_meta( $order_id, $prefix.'order_details', $voucherdata );
				}
				
				if( !empty( $vouchermetadata ) ) { // Check voucher meta data are not empty
					
					//update voucher order details with all meta data ( not in use for now)
					update_post_meta( $order_id, $prefix.'meta_order_details', $vouchermetadata );
				}
			}
		}
	}
	
	/**
	 * Display Download Voucher Link
	 * 
	 * Handles to display product voucher link for user
	 * 
	 * @package WooCommerce - PDF Vouchers
	 * @since 1.0.0
	 */
	public function woo_vou_downloadable_files( $downloadable_files, $product ) {
		
		global $post, $vou_order;
		
		$prefix	= WOO_VOU_META_PREFIX;
		
		$pdf_downloadable_files	= array();
	
		// Taking variation id
		$variation_id = !empty($product->variation_id) ? $product->variation_id : $product->id;
		
		// Check enable voucher
		if( $this->model->woo_vou_check_enable_voucher( $product->id, $variation_id ) ) {
			
			//Set OrderId Blank
			$order_id			= '';
			//Order id get from order detail page
			$order_recieved_id	= get_query_var( 'order-received' );
			//Order id get from view order page
			$order_view_id		= get_query_var( 'view-order' );
			
			if( !empty( $order_recieved_id ) ) { //If on order detail page
				$order_id	= $order_recieved_id;
			} else if( !empty( $order_view_id ) ) { //If on view order page
				$order_id	= $order_view_id;
			} else if( !empty( $vou_order ) ) { // If global order id is set
				$order_id	= $vou_order;
			}
			
			//Get Order id on shop_order page
			if( is_admin() && !empty( $post->post_type ) && $post->post_type == 'shop_order' ) {
				
				$order_id	= isset( $post->ID ) ? $post->ID : '';
			}
			
			if( empty( $order_id ) ) { // Return download files if irder id not found
				return $downloadable_files;
			}
			
			//Get vouchers download files
			$pdf_downloadable_files	= $this->woo_vou_get_vouchers_download_key( $order_id, $variation_id );
			
			//Mearge existing download files with vouchers file
			if( !empty( $downloadable_files ) ) {
				$downloadable_files	= array_merge( $downloadable_files, $pdf_downloadable_files );
			} else {
				$downloadable_files	= $pdf_downloadable_files;
			}
		}
		
		return $downloadable_files;
	}
	
	/**
	 * Download Process
	 *
	 * Handles to product process
	 *
	 * @package WooCommerce - PDF Vouchers
	 * @since 1.0.0
	 */
	public function woo_vou_download_process( $email, $order_key, $product_id, $user_id, $download_id, $order_id ) {
		
		$prefix	= WOO_VOU_META_PREFIX;
		
		$vou_codes_key	= $this->model->woo_vou_get_multi_voucher_key( $order_id, $product_id );
		
		//Get mutiple pdf option from order meta
		$multiple_pdf = empty( $order_id ) ? '' : get_post_meta( $order_id, $prefix . 'multiple_pdf', true );
		
		$orderdvoucodes = array();
		
		if( !empty( $multiple_pdf ) ){
			
			$orderdvoucodes = $this->model->woo_vou_get_multi_voucher( $order_id , $product_id);
		}
		
		// Check out voucher download key
		if( in_array( $download_id, $vou_codes_key ) || $download_id == 'woo_vou_pdf_1' ) {
			
			//product voucher pdf
			woo_vou_process_product_pdf( $product_id, $order_id, $orderdvoucodes );
			exit;	
		}
	}
	
	/**
	 * Insert pdf voucher files
	 * 
	 * Handles to insert pdf voucher
	 * files in database
	 * 
	 * @package WooCommerce - PDF Vouchers
	 * @since 1.0.0
	 */
	public function woo_vou_insert_downloadable_files( $order_id ) {
		
		$prefix	= WOO_VOU_META_PREFIX;
		
		$downloadable_files	= array();
		
		//Get Order
		$order = new WC_Order( $order_id );
		
		if ( sizeof( $order->get_items() ) > 0 ) { //Get all items in order
			
			foreach ( $order->get_items() as $item ) {
				
				//Product Data
				$_product = $order->get_product_from_item( $item );
				
				// Taking variation id
				$variation_id = !empty($item['variation_id']) ? $item['variation_id'] : '';
				
				if ( $_product && $_product->exists()) { // && $_product->is_downloadable()
					
					//get product id from prduct data
					$product_id	= isset( $_product->id ) ? $_product->id : '';
					
					// If product is variable product take variation id else product id
					$data_id = ( !empty($variation_id) ) ? $variation_id : $product_id;
					
					if( $this->model->woo_vou_check_enable_voucher( $product_id, $variation_id ) ) {//Check voucher is enabled or not
						
						//Get vouchers downlodable pdf files
						$downloadable_files	= $this->woo_vou_get_vouchers_download_key( $order_id, $data_id );
						
						foreach ( array_keys( $downloadable_files ) as $download_id ) {
							
							//Insert pdf vouchers in downloadable table
							wc_downloadable_file_permission( $download_id, $data_id, $order );
						}
					}
				}
			}
		}
		
		// Status update from pending to publish when voucher is get completed or processing
		$args	= array( 
						'post_status'	=> array( 'pending' ),
						'meta_query'	=> array(
												array(
													'key'	=> $prefix . 'order_id',
													'value'	=> $order_id,
												)
											)
					);
		
		// Get vouchers code of this order
		$purchased_vochers	= $this->model->woo_vou_get_voucher_details( $args );
		
		if( !empty( $purchased_vochers ) ) { // If not empty voucher codes
			
			//For all possible vouchers
			foreach ( $purchased_vochers as $vocher ) {
				
				// Get voucher data
				$current_post = get_post( $vocher['ID'], 'ARRAY_A' );
				//Change voucher status
				$current_post['post_status'] = 'publish';
				//Update voucher post
				wp_update_post( $current_post );
			}
		}
	}
	
	/**
	 * Get downloadable vouchers files
	 * 
	 * Handles to get downloadable vouchers files
	 * 
	 * @package WooCommerce - PDF Vouchers
	 * @since 1.0.0
	 */
	public function woo_vou_get_vouchers_download_key( $order_id = '', $product_id = '' ) {
		
		$prefix	= WOO_VOU_META_PREFIX;
		$downloadable_files	= array();
		
		//Get mutiple pdf option from order meta
		$multiple_pdf = empty( $order_id ) ? '' : get_post_meta( $order_id, $prefix . 'multiple_pdf', true );
		
		if( !empty( $order_id ) ) {
			
		
			if( $multiple_pdf == 'yes' ) { //If multiple pdf is set
				
				$vouchercodes	= $this->model->woo_vou_get_multi_voucher_key( $order_id, $product_id );
				
				foreach ( $vouchercodes as $codes ) {
					
					$downloadable_files[$codes] = array(
															'name' => __( 'Voucher Download', 'woovoucher' ),
															'file' => get_permalink( $product_id )
														);
				}
			} else {
				
				// Set our vocher download file in download files
				$downloadable_files['woo_vou_pdf_1'] = array(
																'name' => __( 'Voucher Download', 'woovoucher' ),
																'file' => get_permalink( $product_id )
															);
			}
		}	
		
		return $downloadable_files;
	}
	
	/**
	 * Set Order As Global Variable
	 * 
	 * Handles to set order as global variable
	 * when order links displayed in email
	 * 
	 * @package WooCommerce - PDF Vouchers
	 * @since 1.1.0
	 */
	public function woo_vou_email_before_order_table( $order ) {
		
		global $vou_order;
		
		//Get Order_id from order data
		$order_id	= isset( $order->id ) ? $order->id : '';
		//Create global varible for order
		$vou_order	= $order_id;
	}
	
	/**
	 * Allow admin access to vendor user
	 *
	 * Handles to allow admin access to vendor user
	 *
	 * @package WooCommerce - PDF Vouchers
	 * @since 1.1.0
	 */
	public function woo_vou_prevent_admin_access( $prevent_access ) {
		
		global $current_user, $woo_vou_vendor_role;
		
		//Get User roles
		$user_roles	= isset( $current_user->roles ) ? $current_user->roles : array();
		$user_role	= array_shift( $user_roles );
		
		if( in_array( $user_role, $woo_vou_vendor_role ) ) { // Check vendor user role
		
			return false;	
		}
		return $prevent_access;
	}
	
	/**
	 * Check Voucher Code
	 * 
	 * Handles to check voucher code
	 * is valid or invalid via ajax
	 *
	 * @package WooCommerce - PDF Vouchers
	 * @since 1.1.0
	 */
	public function woo_vou_check_voucher_code() {
		
		global $current_user, $woo_vou_vendor_role;
		
		$prefix = WOO_VOU_META_PREFIX;
			
		// Check voucher code is not empty
		if( !empty( $_POST['voucode'] ) ) {
			
			//Voucher Code
			$voucode = $_POST['voucode'];
			
			$args = array(
								'fields' 	=> 'ids',
								'meta_query'=> array(
														array(
																	'key' 		=> $prefix . 'purchased_codes',
																	'value' 	=> $voucode
																)
													)
							);
			
			//Get User roles
			$user_roles	= isset( $current_user->roles ) ? $current_user->roles : array();
			$user_role	= array_shift( $user_roles );
			
			if( in_array( $user_role, $woo_vou_vendor_role ) ) { // Check vendor user role
				$args['author'] = $current_user->ID;
			}
			$voucodedata = $this->model->woo_vou_get_voucher_details( $args );
			
			// Check voucher code ids are not empty
			if( !empty( $voucodedata ) && is_array( $voucodedata ) ) {
				
				$args = array(
									'fields' 	=> 'ids',
									'post__in' 	=> $voucodedata,
									'meta_query'=> array(
															array(
																		'key' 		=> $prefix . 'used_codes',
																		'value' 	=> $voucode
																	)
														)
								);
								
				//Get User roles
				$user_roles	= isset( $current_user->roles ) ? $current_user->roles : array();
				$user_role	= array_shift( $user_roles );
				
				if( in_array( $user_role, $woo_vou_vendor_role ) ) { // Check vendor user role
					$args['author'] = $current_user->ID;
				}
				
				$voucodedata = $this->model->woo_vou_get_voucher_details( $args );
				
				//Check voucher code id is used  
				if( !empty( $voucodedata ) ) {
					
					$voucodeid = isset( $voucodedata[0] ) ? $voucodedata[0] : '';
					
					// get used code date
					$used_code_date = get_post_meta( $voucodeid, $prefix.'used_code_date', true );
					
					echo sprintf( __( 'Voucher code is invalid, was used on %s', 'woovoucher' ), $this->model->woo_vou_get_date_format( $used_code_date, true ) );
					
				} else {
					
					echo 'success';
				}
				
			} else {
				echo 'error';
			}
			exit;
		}
	}
	
	/**
	 * Save Voucher Code
	 * 
	 * Handles to save voucher code
	 * via ajax
	 *
	 * @package WooCommerce - PDF Vouchers
	 * @since 1.1.0
	 */
	public function woo_vou_save_voucher_code() {
		
		$prefix = WOO_VOU_META_PREFIX;
		
		global $woo_vou_vendor_role;
		
		// Check voucher code is not empty
		if( !empty( $_POST['voucode'] ) ) {
			
			//Voucher Code
			$voucode = $_POST['voucode'];
			
			$args = array(
								'fields' 	=> 'ids',
								'meta_query'=> array(
														array(
																	'key' 		=> $prefix . 'purchased_codes',
																	'value' 	=> $voucode
																)
													)
							);
							
			//Get User roles
			$user_roles	= isset( $current_user->roles ) ? $current_user->roles : array();
			$user_role	= array_shift( $user_roles );
			
			if( in_array( $user_role, $woo_vou_vendor_role ) ) { // Check vendor user role
				$args['author'] = $current_user->ID;
			}
			
			$voucodedata = $this->model->woo_vou_get_voucher_details( $args );
			
			// Check voucher code ids are not empty
			if( !empty( $voucodedata ) && is_array( $voucodedata ) ) {
				
				//current date
				$today = $this->model->woo_vou_current_date();
				
				foreach ( $voucodedata as $voucodeid ) {
					
					// update used codes
					update_post_meta( $voucodeid, $prefix.'used_codes', $voucode );
					
					// update used code date
					update_post_meta( $voucodeid, $prefix.'used_code_date', $today );
					
					// break is neccessary so if 2 code found then only 1 get marked as completed.
					break;
				}
			}
			echo 'success';
			exit;
		}
	}
	
	/**
	 * Display Check Code Html
	 * 
	 * Handles to display check code html for user and admin
	 * 
	 * @package WooCommerce - PDF Vouchers
	 * @since 1.0.0
	 */
	public function woo_vou_check_code_content() { ?>
		
		<table class="form-table woo-vou-check-code">
			<tr>
				<th>
					<label for="woo_vou_voucher_code"><?php _e( 'Enter Voucher Code', 'woovoucher' ) ?></label>
				</th>
				<td>
					<input type="text" id="woo_vou_voucher_code" name="woo_vou_voucher_code" value="" />
					<input type="button" id="woo_vou_check_voucher_code" name="woo_vou_check_voucher_code" class="button-primary" value="<?php _e( 'Check It', 'woovoucher' ) ?>" />
					<div class="woo-vou-loader woo-vou-check-voucher-code-loader"><img src="<?php echo WOO_VOU_IMG_URL;?>/ajax-loader.gif"/></div>
					<div class="woo-vou-voucher-code-msg"></div>
				</td>
			</tr>
			<tr class="woo-vou-voucher-code-submit-wrap">
				<th>
				</th>
				<td>
					<input type="button" id="woo_vou_voucher_code_submit" name="woo_vou_voucher_code_submit" class="button-primary" value="<?php _e( 'Redeem', 'woovoucher' ) ?>" />
					<div class="woo-vou-loader woo-vou-voucher-code-submit-loader"><img src="<?php echo WOO_VOU_IMG_URL;?>/ajax-loader.gif"/></div>
				</td>
			</tr>
		</table><?php
	}
	
	/**
	 * Add Capability to vendor role
	 * 
	 * Handle to add capability to vendor role
	 * 
	 * @package WooCommerce - PDF Vouchers
	 * @since 1.0.0
	 */
	public function woo_vou_initilize_role_capabilities() {
		
		global $woo_vou_vendor_role;
		
		$class_exist	= apply_filters( 'woo_vou_initilize_role_capabilities', class_exists( 'WC_Vendors' ) );
		
		//Return if class not exist 
		if( !$class_exist ) return;
		
		foreach ( $woo_vou_vendor_role as $vendor_role ) {
			
			//get vendor role
			$vendor_role_obj = get_role( $vendor_role );
			
			if( !empty( $vendor_role_obj ) ) { // If vendor role is exist 
				
				if( !$vendor_role_obj->has_cap( WOO_VOU_VENDOR_LEVEL ) ) { //If capabilty not exist
					
					//Add vucher level capability to vendor roles
					$vendor_role_obj->add_cap( WOO_VOU_VENDOR_LEVEL );
				}
			}
		}
	}
	
	/**
	 * Adding Hooks
	 *
	 * Adding proper hoocks for the discount codes
	 *
	 * @package WooCommerce - PDF Vouchers
	 * @since 1.0.0
	 */
	public function add_hooks() {
		
		// add capabilities to user roles
		add_action( 'init', array( $this, 'woo_vou_initilize_role_capabilities' ), 100 );
		
		//add action to save voucher in order
		add_action( 'woocommerce_checkout_update_order_meta', array( $this, 'woo_vou_product_purchase' ) );
		
		//add filter to merge voucher pdf with product files
		add_filter( 'woocommerce_product_files', array( $this, 'woo_vou_downloadable_files' ), 10, 2 );
		
		//Insert pdf vouchers in woocommerce downloads fiels table
		add_action( 'woocommerce_grant_product_download_permissions', array( $this, 'woo_vou_insert_downloadable_files' ) );
		
		//add action to product process
		add_action( 'woocommerce_download_product', array( $this, 'woo_vou_download_process' ), 10, 6 );
		
		//add filter to add admin access for vendor role
		add_filter( 'woocommerce_prevent_admin_access', array( $this, 'woo_vou_prevent_admin_access' ) );
		
		//ajax call to edit all controls
		add_action( 'wp_ajax_woo_vou_check_voucher_code', array( $this, 'woo_vou_check_voucher_code') );
		add_action( 'wp_ajax_nopriv_woo_vou_check_voucher_code', array( $this, 'woo_vou_check_voucher_code' ) );
		
		//ajax call to save voucher code
		add_action( 'wp_ajax_woo_vou_save_voucher_code', array( $this, 'woo_vou_save_voucher_code') );
		add_action( 'wp_ajax_nopriv_woo_vou_save_voucher_code', array( $this, 'woo_vou_save_voucher_code' ) );
		
		// add action to add html for check voucher code
		add_action( 'woo_vou_check_code_content', array( $this, 'woo_vou_check_code_content' ) );
		
		// add action to set order as a global variable
		add_action( 'woocommerce_email_before_order_table', array( $this, 'woo_vou_email_before_order_table' ) );
	}
}
?>