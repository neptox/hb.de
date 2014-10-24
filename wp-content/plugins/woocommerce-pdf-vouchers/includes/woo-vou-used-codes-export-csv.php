<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Export to CSV for Voucher
 * 
 * Handles to Export to CSV on run time when 
 * user will execute the url which is sent to
 * user email with purchase receipt
 * 
 * @package WooCommerce - PDF Vouchers
 * @since 1.0.0
 */

function woo_vou_code_export_to_csv(){
	
	$prefix = WOO_VOU_META_PREFIX;
	
	if( isset( $_GET['woo-vou-used-exp-csv'] ) && !empty( $_GET['woo-vou-used-exp-csv'] ) 
		&& $_GET['woo-vou-used-exp-csv'] == '1'
		&& isset($_GET['product_id']) && !empty($_GET['product_id'] ) ) {
		
		global $current_user,$woo_vou_model, $post;
		
		//model class
		$model = $woo_vou_model;
	
		$postid = $_GET['product_id']; 
		
		$exports = '';
		
		// Check action is used codes
		if( isset( $_GET['woo_vou_action'] ) && $_GET['woo_vou_action'] == 'used' ) {
		
		 	//Get Voucher Details by post id
		 	$voucodes = $model->woo_vou_get_used_codes_by_product_id( $postid );
		 	
			$vou_file_name = 'woo-used-voucher-codes-{current_date}';
			
		} else{
			
		 	//Get Voucher Details by post id
		 	$voucodes = $model->woo_vou_get_purchased_codes_by_product_id( $postid );
		 	
			$vou_csv_name = get_option( 'vou_csv_name' );
			$vou_file_name = !empty( $vou_csv_name )? $vou_csv_name : 'woo-purchased-voucher-codes-{current_date}';
		}
		$columns = array(	
							__( 'Voucher Code', 'woovoucher' ),
							__( 'Buyer\'s Name', 'woovoucher' ),
							__( 'Order Date', 'woovoucher' ),
							__( 'Order ID', 'woovoucher' ),
					     );
				
        // Put the name of all fields
		foreach ($columns as $column) {
			
			$exports .= '"'.$column.'",';
		}
		$exports .="\n";
		
		if( !empty( $voucodes ) &&  count( $voucodes ) > 0 ) { 
												
			foreach ( $voucodes as $key => $voucodes_data ) { 
			
				//voucher order id
				$orderid 		= $voucodes_data['order_id'];
				
				//voucher order date
				$orderdate 		= $voucodes_data['order_date'];
				$orderdate 		= !empty( $orderdate ) ? $model->woo_vou_get_date_format( $orderdate ) : '';
				
				//buyer's name who has purchased/used voucher code				
				$buyername 		=  $voucodes_data['buyer_name'];
				
				//voucher code purchased/used
				$voucode 		= $voucodes_data['vou_codes'];

				//this line should be on start of loop
				$exports .= '"'.$voucode.'",';
				$exports .= '"'.$buyername.'",';
				$exports .= '"'.$orderdate.'",';
				$exports .= '"'.$orderid.'",';
				
				$exports .="\n";
			}
		} 
		
		$vou_file_name = str_replace( '{current_date}', date('d-m-Y'), $vou_file_name );
		
		// Output to browser with appropriate mime type, you choose ;)
		header("Content-type: text/x-csv");
		header("Content-Disposition: attachment; filename=".$vou_file_name.".csv");
		echo $exports;
		exit;
		
	}
	
	// generate csv for voucher code
	if( isset( $_GET['woo-vou-voucher-exp-csv'] ) && !empty( $_GET['woo-vou-voucher-exp-csv'] ) 
		&& $_GET['woo-vou-voucher-exp-csv'] == '1' ) {
		
		global $current_user,$woo_vou_model, $post, $woo_vou_vendor_role;
		
		//model class
		$model = $woo_vou_model;
	
		$exports = '';
		
		// Check action is used codes
		if( isset( $_GET['woo_vou_action'] ) && $_GET['woo_vou_action'] == 'used' ) {
		
			$args = array();
		
			$args['meta_query'] = array(
											array(
														'key'		=> $prefix.'used_codes',
														'value'		=> '',
														'compare'	=> '!=',
													)
										);
			//Get user role
			$user_roles	= isset( $current_user->roles ) ? $current_user->roles : array();
			$user_role	= array_shift( $user_roles );
			
			if( in_array( $user_role, $woo_vou_vendor_role  ) ) { // Check vendor user role
				$args['author'] = $current_user->ID;
			}
			
			if( isset( $_GET['woo_vou_post_id'] ) && !empty( $_GET['woo_vou_post_id'] ) ) {
				$args['post_parent'] = $_GET['woo_vou_post_id'];
			}
			
			if( isset( $_GET['s'] ) && !empty( $_GET['s'] ) ) {
				
				//$args['s'] = $_GET['s'];
				$args['meta_query'] = array(
												'relation'	=> 'OR',
												array(
															'key'		=> $prefix.'used_codes',
															'value'		=> $_GET['s'],
															'compare'	=> 'LIKE',
														),
												array(
															'key'		=> $prefix.'first_name',
															'value'		=> $_GET['s'],
															'compare'	=> 'LIKE',
														),
												array(
															'key'		=> $prefix.'last_name',
															'value'		=> $_GET['s'],
															'compare'	=> 'LIKE',
														),
												array(
															'key'		=> $prefix.'order_id',
															'value'		=> $_GET['s'],
															'compare'	=> 'LIKE',
														),
												array(
															'key'		=> $prefix.'order_date',
															'value'		=> $_GET['s'],
															'compare'	=> 'LIKE',
														),
											);
			}
			
		 	//Get Voucher Details by post id
		 	$voucodes = $model->woo_vou_get_voucher_details( $args );
		 	
		 	$vou_file_name = 'woo-used-voucher-codes-{current_date}';
			
		} else{
			
		 	$args = array();
		
			$args['meta_query'] = array(
											array(
														'key'		=> $prefix.'purchased_codes',
														'value'		=> '',
														'compare'	=> '!=',
													)
										);
			//Get user role
			$user_roles	= isset( $current_user->roles ) ? $current_user->roles : array();
			$user_role	= array_shift( $user_roles );
			
			if( in_array( $user_role, $woo_vou_vendor_role  ) ) { // Check vendor user role
				$args['author'] = $current_user->ID;
			}
			
			if( isset( $_GET['woo_vou_post_id'] ) && !empty( $_GET['woo_vou_post_id'] ) ) {
				$args['post_parent'] = $_GET['woo_vou_post_id'];
			}
			
			if( isset( $_GET['s'] ) && !empty( $_GET['s'] ) ) {
				
				//$args['s'] = $_GET['s'];
				$args['meta_query'] = array(
												'relation'	=> 'OR',
												array(
															'key'		=> $prefix.'purchased_codes',
															'value'		=> $_GET['s'],
															'compare'	=> 'LIKE',
														),
												array(
															'key'		=> $prefix.'first_name',
															'value'		=> $_GET['s'],
															'compare'	=> 'LIKE',
														),
												array(
															'key'		=> $prefix.'last_name',
															'value'		=> $_GET['s'],
															'compare'	=> 'LIKE',
														),
												array(
															'key'		=> $prefix.'order_id',
															'value'		=> $_GET['s'],
															'compare'	=> 'LIKE',
														),
												array(
															'key'		=> $prefix.'order_date',
															'value'		=> $_GET['s'],
															'compare'	=> 'LIKE',
														),
											);
			}
			
		 	//Get Voucher Details by post id
		 	$voucodes = $model->woo_vou_get_voucher_details( $args );
		 	
		 	$vou_csv_name = get_option( 'vou_csv_name' );
			$vou_file_name = !empty( $vou_csv_name )? $vou_csv_name : 'woo-purchased-voucher-codes-{current_date}';			
		}
		$columns = array(	
							__( 'Voucher Code', 'woovoucher' ),
							__( 'Product Title', 'woovoucher' ),
							__( 'Buyer\'s Name', 'woovoucher' ),
							__( 'Order Date', 'woovoucher' ),
							__( 'Order ID', 'woovoucher' ),
					     );
				
        // Put the name of all fields
		foreach ($columns as $column) {
			
			$exports .= '"'.$column.'",';
		}
		$exports .="\n";
		
		if( !empty( $voucodes ) &&  count( $voucodes ) > 0 ) { 
												
			foreach ( $voucodes as $key => $voucodes_data ) { 
			
				//voucher order id
				$orderid 		= get_post_meta( $voucodes_data['ID'], $prefix.'order_id', true );
				
				//voucher order date
				$orderdate 		= get_post_meta( $voucodes_data['ID'], $prefix.'order_date', true );
				$orderdate 		= !empty( $orderdate ) ? $model->woo_vou_get_date_format( $orderdate ) : '';
				
				//buyer's name who has purchased/used voucher code				
				$first_name = get_post_meta( $voucodes_data['ID'], $prefix.'first_name', true );
				$last_name 	= get_post_meta( $voucodes_data['ID'], $prefix.'last_name', true );
				$buyername  = $first_name . ' ' . $last_name;
				
				//voucher code purchased/used
				$voucode 		= get_post_meta( $voucodes_data['ID'], $prefix.'purchased_codes', true );
				
				$product_title = get_the_title( $voucodes_data['post_parent'] );
				
				//this line should be on start of loop
				$exports .= '"'.$voucode.'",';
				$exports .= '"'.$product_title.'",';
				$exports .= '"'.$buyername.'",';
				$exports .= '"'.$orderdate.'",';
				$exports .= '"'.$orderid.'",';
				
				$exports .="\n";
			}
		} 
		
		$vou_file_name = str_replace( '{current_date}', date('d-m-Y'), $vou_file_name );
		
		// Output to browser with appropriate mime type, you choose ;)
		header("Content-type: text/x-csv");
		header("Content-Disposition: attachment; filename=".$vou_file_name.".csv");
		echo $exports;
		exit;
		
	}
}
add_action( 'admin_init', 'woo_vou_code_export_to_csv' );
?>