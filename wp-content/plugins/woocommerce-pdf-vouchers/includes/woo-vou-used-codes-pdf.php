<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Generate PDF for Voucher
 * 
 * Handles to Generate PDF on run time when 
 * user will execute the url which is sent to
 * user email with purchase receipt
 * 
 * @package WooCommerce - PDF Vouchers
 * @since 1.0.0
 */

function woo_vou_code_pdf(){
	
	$prefix = WOO_VOU_META_PREFIX;
	
	if( isset( $_GET['woo-vou-used-gen-pdf'] ) && !empty( $_GET['woo-vou-used-gen-pdf'] )
		&& $_GET['woo-vou-used-gen-pdf'] == '1' 
		&& isset($_GET['product_id']) && !empty($_GET['product_id']) ) {
		
		global $current_user,$woo_vou_model, $post;
		
		//model class
		$model = $woo_vou_model;
	
		$postid = $_GET['product_id']; 
		
		// include tcpdf library
		require_once WOO_VOU_DIR . '/includes/exports/tcpdf/tcpdf.php';
		
		// Check action is used codes
		if( isset( $_GET['woo_vou_action'] ) && $_GET['woo_vou_action'] == 'used' ) {
			
		 	//Get Voucher Details by post id
		 	$voucodes = $model->woo_vou_get_used_codes_by_product_id( $postid );
		 	
		 	$voucher_heading 	= __( 'Used Voucher Codes','woovoucher' );
		 	$voucher_empty_msg	= __( 'No voucher codes used yet.', 'woovoucher' );
		 	
			$vou_file_name = 'woo-used-voucher-codes-{current_date}';
			
		} else {
			
		 	//Get Voucher Details by post id
		 	$voucodes = $model->woo_vou_get_purchased_codes_by_product_id( $postid );
		 	
		 	$voucher_heading 	= __( 'Purchased Voucher Codes','woovoucher' );
		 	$voucher_empty_msg	= __( 'No voucher codes purchased yet.', 'woovoucher' );
		 	
			$vou_pdf_name = get_option( 'vou_pdf_name' );
			$vou_file_name = !empty( $vou_pdf_name )? $vou_pdf_name : 'woo-purchased-voucher-codes-{current_date}';
		}
		
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		
		// remove default header
		$pdf->setPrintHeader(false);
		
		// remove default footer
		$pdf->setPrintFooter(false);
	
		$pdf->AddPage( 'L', 'A4' );
		
		// Auther name and Creater name
		$pdf->SetTitle( utf8_decode(__('WooCommerce Voucher','woovoucher')) );
		$pdf->SetAuthor( utf8_decode( __('WooCommerce','woovoucher') ) );
		$pdf->SetCreator( utf8_decode( __('WooCommerce','woovoucher') ) );
		
		// Set margine of pdf (float left, float top , float right)
		$pdf->SetMargins( 8, 8, 8 );
		$pdf->SetX( 8 );
		
		
		// Font size set
		$pdf->SetFont( 'Helvetica', '', 18 );
		$pdf->SetTextColor( 50, 50, 50 );
		
		$pdf->Cell( 270, 5, utf8_decode( $voucher_heading ), 0, 2, 'C', false );
		$pdf->Ln(5);
		$pdf->SetFont( 'Helvetica', '', 12 );
		$pdf->SetFillColor( 238, 238, 238 );
		
		//voucher logo
		if( !empty( $voulogo ) ) {
			$pdf->Image( $voulogo, 95, 25, 20, 20 );
			$pdf->Ln(35);
		}
		
		$columns = array(
							array('name' => __('Voucher Code', 'woovoucher') 	, 'width' => 70),
							array('name' => __('Buyer\'s Name', 'woovoucher') 	, 'width' => 70),
							array('name' => __('Order Date', 'woovoucher') 		, 'width' => 70),
							array('name' => __('Order ID', 'woovoucher') 		, 'width' => 70)
						);
		
		// Table head Code
		foreach ($columns as $column) {
			// parameter : (height, width, string, border[0 - no border, 1 - frame], )

			$pdf->Cell( 70, 8, utf8_decode($column['name']), 1, 0, 'L', true );
		}
		$pdf->Ln();	
	
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

				$pdf->Cell(70, 8, utf8_decode( $voucode ), 1, 0, 'L', false );
				$pdf->Cell(70, 8, utf8_decode( $buyername ), 1, 0, 'L', false );
				$pdf->Cell(70, 8, utf8_decode( $orderdate ), 1, 0, 'L', false );
				$pdf->Cell(70, 8, utf8_decode( $orderid ), 1, 1, 'L', false );
					
			}
			
		} else { 
			
			$title = utf8_decode( $voucher_empty_msg );
			$pdf->Cell(280, 8, utf8_decode($title), 1, 1, 'L', false );
			
		}
		
		//voucher code
		$pdf->SetFont( 'Helvetica', 'B', 14 );
		
		$vou_file_name = str_replace( '{current_date}', date('d-m-Y'), $vou_file_name );
		$pdf->Output( $vou_file_name . '.pdf', 'D' );
		exit;
		
	}

	// generate pdf for voucher code
	if( isset( $_GET['woo-vou-voucher-gen-pdf'] ) && !empty( $_GET['woo-vou-voucher-gen-pdf'] )
		&& $_GET['woo-vou-voucher-gen-pdf'] == '1' ) {
		
		$prefix = WOO_VOU_META_PREFIX;
		
		global $current_user,$woo_vou_model, $post, $woo_vou_vendor_role;
		
		//model class
		$model = $woo_vou_model;
	
		//$postid = $_GET['product_id']; 
		
		// include tcpdf library
		require_once WOO_VOU_DIR . '/includes/exports/tcpdf/tcpdf.php';
		
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
			$user_role = array_shift( $user_roles );
			
			if( in_array( $user_role, $woo_vou_vendor_role ) ) { // Check vendor user role
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
		 	
		 	$voucher_heading 	= __( 'Used Voucher Codes','woovoucher' );
		 	$voucher_empty_msg	= __( 'No voucher codes used yet.', 'woovoucher' );
		 	
		 	
			$vou_file_name = 'woo-used-voucher-codes-{current_date}';	
			
		} else {
			
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
			$user_role = array_shift( $user_roles );
			
			if( in_array( $user_role, $woo_vou_vendor_role ) ) { // Check vendor user role
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
		 	
		 	$voucher_heading 	= __( 'Purchased Voucher Codes','woovoucher' );
		 	$voucher_empty_msg	= __( 'No voucher codes purchased yet.', 'woovoucher' );
		 	
		 	$vou_pdf_name = get_option( 'vou_pdf_name' );
			$vou_file_name = !empty( $vou_pdf_name )? $vou_pdf_name : 'woo-purchased-voucher-codes-{current_date}';	
		}
		
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		
		// remove default header
		$pdf->setPrintHeader(false);
		
		// remove default footer
		$pdf->setPrintFooter(false);
	
		$pdf->AddPage( 'L', 'A4' );
		
		// Auther name and Creater name
		$pdf->SetTitle( utf8_decode(__('Easy Digital Products Voucher','woovoucher')) );
		$pdf->SetAuthor( utf8_decode( __('Easy Digital Products','woovoucher') ) );
		$pdf->SetCreator( utf8_decode( __('Easy Digital Products','woovoucher') ) );
		
		// Set margine of pdf (float left, float top , float right)
		$pdf->SetMargins( 8, 8, 8 );
		$pdf->SetX( 8 );
		
		
		// Font size set
		$pdf->SetFont( 'Helvetica', '', 18 );
		$pdf->SetTextColor( 50, 50, 50 );
		
		$pdf->Cell( 270, 5, utf8_decode( $voucher_heading ), 0, 2, 'C', false );
		$pdf->Ln(5);
		$pdf->SetFont( 'Helvetica', '', 12 );
		$pdf->SetFillColor( 238, 238, 238 );
		
		//voucher logo
		if( !empty( $voulogo ) ) {
			$pdf->Image( $voulogo, 95, 25, 20, 20 );
			$pdf->Ln(35);
		}
		
		$columns = array(
							array('name' => __('Voucher Code', 'woovoucher') 	, 'width' => 56),
							array('name' => __('Product Title', 'woovoucher') 	, 'width' => 56),
							array('name' => __('Buyer\'s Name', 'woovoucher') 	, 'width' => 56),
							array('name' => __('Order Date', 'woovoucher') 		, 'width' => 56),
							array('name' => __('Order ID', 'woovoucher') 		, 'width' => 56)
						);
		
		// Table head Code
		foreach ($columns as $column) {
			// parameter : (height, width, string, border[0 - no border, 1 - frame], )

			$pdf->Cell( $column['width'], 8, utf8_decode($column['name']), 1, 0, 'L', true );
		}
		$pdf->Ln();	
	
		if( count( $voucodes ) > 0 ) { 
												
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
				
				$pdf->Cell(56, 8, utf8_decode( $voucode ), 1, 0, 'L', false );
				$pdf->Cell(56, 8, utf8_decode( $product_title ), 1, 0, 'L', false );
				$pdf->Cell(56, 8, utf8_decode( $buyername ), 1, 0, 'L', false );
				$pdf->Cell(56, 8, utf8_decode( $orderdate ), 1, 0, 'L', false );
				$pdf->Cell(56, 8, utf8_decode( $orderid ), 1, 1, 'L', false );
			}
			
		} else { 
			
			$title = utf8_decode( $voucher_empty_msg );
			$pdf->Cell(280, 8, utf8_decode($title), 1, 1, 'L', false );
			
		}
		
		//voucher code
		$pdf->SetFont( 'Helvetica', 'B', 14 );
		
		$vou_file_name = str_replace( '{current_date}', date('d-m-Y'), $vou_file_name );
		$pdf->Output( $vou_file_name . '.pdf', 'D' );
		exit;
		
	}
}
add_action( 'admin_init', 'woo_vou_code_pdf' );
?>