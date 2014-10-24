<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

function woo_vou_generate_pdf_by_html( $html = '', $pdf_args = array() ) {
	
	//include tcpdf file
	require_once WOO_VOU_DIR . '/includes/exports/tcpdf/tcpdf.php';
		
	$prefix = WOO_VOU_META_PREFIX;
		
	$pdf_margin_top = PDF_MARGIN_TOP;
	$pdf_margin_left = PDF_MARGIN_LEFT;
	$pdf_margin_right = PDF_MARGIN_RIGHT;
	$pdf_bg_image = '';
	$vou_template_pdf_view = '';
	
	if( isset( $pdf_args['vou_template_id'] ) && !empty( $pdf_args['vou_template_id'] ) ) {
		
		global $woo_vou_template_id;
		
		//Voucher PDF ID
		$woo_vou_template_id = $pdf_args['vou_template_id'];
		
		// Extend the TCPDF class to create custom Header and Footer
		class VOUPDF extends TCPDF {
			
			function __construct($orientation='P', $unit='mm', $format='A4', $unicode=true, $encoding='UTF-8', $diskcache=false, $pdfa=false) {

				// Call parent constructor
				parent::__construct($orientation, $unit, $format, $unicode, $encoding, $diskcache, $pdfa);
			}
			
			//Page header
			public function Header() {
				
				global $woo_vou_model, $woo_vou_template_id;
				
				//model class
				$model = $woo_vou_model;
				
				$prefix = WOO_VOU_META_PREFIX;
		
				$vou_template_bg_style 		= get_post_meta( $woo_vou_template_id, $prefix . 'pdf_bg_style', true );
				$vou_template_bg_pattern 	= get_post_meta( $woo_vou_template_id, $prefix . 'pdf_bg_pattern', true );
				$vou_template_bg_img 		= get_post_meta( $woo_vou_template_id, $prefix . 'pdf_bg_img', true );
				$vou_template_bg_color 		= get_post_meta( $woo_vou_template_id, $prefix . 'pdf_bg_color', true );
				$vou_template_pdf_view 		= get_post_meta( $woo_vou_template_id, $prefix . 'pdf_view', true );
				
				//Voucher PDF Background Color
				if( !empty( $vou_template_bg_color ) ) {
					
					if( $vou_template_pdf_view == 'land' ) { // Check PDF View option is landscape
						
						// Background color
		    			$this->Rect(0, 0, 300, 160, 'F', '', $fill_color = $model->woo_vou_hex_2_rgb( $vou_template_bg_color ) );
		    			
					} else {
						
						// Background color      
		    			$this->Rect(0, 0, 210, 297, 'F', '', $fill_color = $model->woo_vou_hex_2_rgb( $vou_template_bg_color ) );
					}
				}
				
				//Voucher PDF Background style is image & image is not empty
				if( !empty( $vou_template_bg_style ) && $vou_template_bg_style == 'image'
					&& isset( $vou_template_bg_img['src'] ) && !empty( $vou_template_bg_img['src'] ) ) {
					
					$img_file = $vou_template_bg_img['src'];
					
				} else if( !empty( $vou_template_bg_style ) && $vou_template_bg_style == 'pattern'
					&& !empty( $vou_template_bg_pattern ) ) {//Voucher PDF Background style is pattern & Background Pattern is not selected
					
					if( $vou_template_pdf_view == 'land' ) { // Check PDF View option is landscape
						
						// Background Pattern Image
		    			$img_file = WOO_VOU_IMG_URL . '/patterns/' . $vou_template_bg_pattern . '.png';
		    			
					} else {
						
						// Background Pattern Image      
		    			$img_file = WOO_VOU_IMG_URL . '/patterns/port_' . $vou_template_bg_pattern . '.png';
					}
					
				}
				
				if( !empty( $img_file ) ) { //Check image file
					
					// get the current page break margin
					$bMargin = $this->getBreakMargin();
					// get current auto-page-break mode
					$auto_page_break = $this->AutoPageBreak;
					// disable auto-page-break
					$this->SetAutoPageBreak(false, 0);
					
					if( $vou_template_pdf_view == 'land' ) { // Check PDF View option is landscape
						
						// Background image
						$this->Image($img_file, 0, 0, 300, 160, '', '', '', false, 300, '', false, false, 0);
						
					} else {
						
						// Background image
						$this->Image($img_file, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);
					}
					// restore auto-page-break status
					$this->SetAutoPageBreak($auto_page_break, $bMargin);
					// set the starting point for the page content
					$this->setPageMark();
					
				}
			}
		}
		
		//Voucher PDF Margin Top
		$vou_template_pdf_view = get_post_meta( $woo_vou_template_id, $prefix . 'pdf_view', true );
				
		//Voucher PDF Margin Top
		$vou_template_margin_top = get_post_meta( $woo_vou_template_id, $prefix . 'pdf_margin_top', true );
		if( !empty( $vou_template_margin_top ) ) {
			$pdf_margin_top = $vou_template_margin_top;
		}
		
		//Voucher PDF Margin Left
		$vou_template_margin_left = get_post_meta( $woo_vou_template_id, $prefix . 'pdf_margin_left', true );
		if( !empty( $vou_template_margin_left ) ) {
			$pdf_margin_left = $vou_template_margin_left;
		}
		
		//Voucher PDF Margin Right
		$vou_template_margin_right = get_post_meta( $woo_vou_template_id, $prefix . 'pdf_margin_right', true );
		if( !empty( $vou_template_margin_right ) ) {
			$pdf_margin_right = $vou_template_margin_right;
		}
					
		// create new PDF document
		$pdf = new VOUPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		
	} else {
		
		// create new PDF document
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

		// remove default header
		$pdf->setPrintHeader(false);

	}
	
	// remove default footer
	$pdf->setPrintFooter(false);
		
	// Auther name and Creater name 
	$pdf->SetCreator( utf8_decode( __('WooCommerce','woovoucher') ) );
	$pdf->SetAuthor( utf8_decode( __('WooCommerce','woovoucher') ) );
	$pdf->SetTitle( utf8_decode(__('WooCommerce Voucher','woovoucher') ) );

	// set default header data
	//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 021', PDF_HEADER_STRING);
	
	// set header and footer fonts
	$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
	$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
	
	// set default monospaced font
	$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
	
	// set margins
	$pdf->SetMargins($pdf_margin_left, $pdf_margin_top, $pdf_margin_right);
	$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
	$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
	
	// set auto page breaks
	$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
	
	// set image scale factor
	$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
	
	// set default font subsetting mode
    $pdf->setFontSubsetting(true);
    
	// ---------------------------------------------------------

	// set font
	$pdf->SetFont( apply_filters( 'woo_vou_pdf_generate_fonts', 'helvetica' ), '', 12);
	
	// add a page
	if( $vou_template_pdf_view == 'land' ) { // Check PDF View option is landscape		
		$pdf->AddPage( 'L', array( '300', '160' ) );
	} else {
		$pdf->AddPage();
	}
	
	// set cell padding
	//$pdf->setCellPaddings(1, 1, 1, 1);
	
	// set cell margins
	$pdf->setCellMargins(0, 1, 0, 1);
	
	// set font color
	$pdf->SetTextColor( 50, 50, 50 );
	$pdf->SetFillColor( 238, 238, 238 );
	
	// output the HTML content
	$pdf->writeHTML($html, true, 0, true, 0);
	
	// reset pointer to the last page
	$pdf->lastPage();
	
	// ---------------------------------------------------------
	$order_pdf_name = get_option('order_pdf_name');
	if( !empty( $order_pdf_name ) ){
		
		
		$pdf_file_name = str_replace("{current_date}",date('d-m-Y'),$order_pdf_name);
				
	} else {
		
		$pdf_file_name = 'woo-voucher-'. date('d-m-Y');
		
	}
	//Get pdf name
	$pdf_name = isset( $pdf_args['pdf_name'] ) && !empty( $pdf_args['pdf_name'] ) ? $pdf_args['pdf_name'] : $pdf_file_name;
	
	//Close and output PDF document
	//Second Parameter I that means display direct and D that means ask product or open this file
	$pdf->Output( $pdf_name . '.pdf', 'D' );
	exit;
}

/**
 * View Preview for Voucher PDF
 * 
 * Handles to view preview for voucher pdf
 * 
 * @package WooCommerce - PDF Vouchers
 * @since 1.0.0
 */
function woo_vou_preview_pdf() {
	
	global $woo_vou_model;
	
	$model = $woo_vou_model;
	
	$pdf_args = array();
	
	if( isset( $_GET['voucher_id'] ) && !empty( $_GET['voucher_id'] )
		&& isset( $_GET['woo_vou_pdf_action'] ) && $_GET['woo_vou_pdf_action'] == 'preview' ) {
			
		$voucher_template_id = $_GET['voucher_id'];
			
		$pdf_args['vou_template_id'] = $voucher_template_id;
				
		//site logo
		$vousitelogohtml = '';
		$vou_site_url = get_option( 'vou_site_logo' );
		if( !empty( $vou_site_url ) ) {
			
			$vousitelogohtml = '<img src="' . $vou_site_url . '" alt="" />';
		}
		
		//vendor's logo
		$vou_url = WOO_VOU_IMG_URL . '/vendor-logo.png';
		$voulogohtml = '<img src="' . $vou_url . '" alt="" />';
		
		$vendor_address = __( 'Infiniti Mall Malad', 'woovoucher' ) . "\n\r" . __( 'GF 9 & 10, Link Road, Mindspace, Malad West', 'woovoucher' ) . "\n\r" . __( 'Mumbai, Maharashtra 400064', 'woovoucher' );
		$vendor_address = nl2br( $vendor_address );
		
		$nextmonth = mktime(0, 0, 0, date("m")+1,   date("d"),   date("Y"));
		
		$redeem_instruction = __( 'Redeem instructions :', 'woovoucher' );
		$redeem_instruction .= __( 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s.', 'woovoucher' );
		
		$locations = '<strong>' . __( 'DELHI:', 'woovoucher' ) . '</strong> ' . __( 'Dlf Promenade Mall & Pacific Mall', 'woovoucher' );
		$locations .= ' <strong>' . __( 'MUMBAI:', 'woovoucher' ) . '</strong> ' . __( 'Infiniti Mall, Malad & Phoenix MarketCity', 'woovoucher' );
		$locations .= ' <strong>' . __( 'BANGALORE:', 'woovoucher' ) . '</strong> ' . __( 'Phoenix MarketCity Mall', 'woovoucher' );
		$locations .= ' <strong>' . __( 'PUNE:', 'woovoucher' ) . '</strong> ' . __( 'Phoenix MarketCity Mall', 'woovoucher' );
		
		$buyer_fullname = __('WpWeb', 'woovoucher');
		$buyer_email 	= 'web101@gmail.com';
		$orderid 		= '101';
		$orderdate		= date("d-m-Y");
		$productname	= __('Test Product', 'woovoucher');
		$codes 			= __( '[The voucher code will be inserted automatically here]', 'woovoucher' );
		
		$content_post 			= get_post( $voucher_template_id );
		$content 				= isset( $content_post->post_content ) 	? $content_post->post_content 	: '';
		$post_title 			= isset( $content_post->post_title ) 	? $content_post->post_title 	: '';
		$voucher_template_html 	= do_shortcode( $content );
		
		$voucher_template_html = str_replace( '{redeem}', $redeem_instruction, $voucher_template_html );
		$voucher_template_html = str_replace( '{vendorlogo}', $voulogohtml, $voucher_template_html );
		$voucher_template_html = str_replace( '{sitelogo}', $vousitelogohtml, $voucher_template_html );
		$voucher_template_html = str_replace( '{expiredate}', $model->woo_vou_get_date_format( date('d-m-Y', $nextmonth ) ), $voucher_template_html );
		$voucher_template_html = str_replace( '{vendoraddress}', $vendor_address, $voucher_template_html );
		$voucher_template_html = str_replace( '{siteurl}', 'www.bebe.com', $voucher_template_html );
		$voucher_template_html = str_replace( '{location}', $locations, $voucher_template_html );
		$voucher_template_html = str_replace( '{buyername}', $buyer_fullname, $voucher_template_html );
		$voucher_template_html = str_replace( '{buyeremail}', $buyer_email, $voucher_template_html );
		$voucher_template_html = str_replace( '{orderid}', $orderid, $voucher_template_html );
		$voucher_template_html = str_replace( '{orderdate}', $model->woo_vou_get_date_format( $orderdate ), $voucher_template_html );
		$voucher_template_html = str_replace( '{productname}', $productname, $voucher_template_html );
		$voucher_template_html = str_replace( '{codes}', $codes, $voucher_template_html );
		
		//Set pdf name
		$post_title = str_replace( ' ', '-', strtolower( $post_title ) );
		$pdf_args['pdf_name'] = $post_title . __( '-preview-', 'woovoucher' ) . $voucher_template_id;
		
		woo_vou_generate_pdf_by_html( $voucher_template_html, $pdf_args );
	}
}
add_action( 'init', 'woo_vou_preview_pdf', 9 );


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
function woo_vou_process_product_pdf( $productid, $orderid, $orderdvoucodes = array() ) {

	$prefix = WOO_VOU_META_PREFIX;
		
	global $current_user,$woo_vou_model;
	
	//model class
	$model = $woo_vou_model;
			
	$pdf_args = array();

	if( !empty( $productid ) && !empty( $orderid ) ) { // Check product id & order id are not empty
	
		//orderdata
		$orderdata = $model->woo_vou_get_post_meta_ordered( $orderid );
		
		//get all voucher details from order meta
		$allorderdata 	= $model->woo_vou_get_all_ordered_data( $orderid );
		
		// Creating order object for order details
		$woo_order = new WC_Order( $orderid );
		$woo_order_details = $woo_order;
		$items = $woo_order_details->get_items();
		
		// Getting product name
		$woo_product_name = $model->woo_vou_get_product_name( $orderid, $items );
		
		// productid is variation id in case of variable product so we need to take actual product id
		$variation_id	= $productid; // set variation id
		$woo_variation 	= new WC_Product_Variation( $variation_id );
		
		// $woo_variation->id return product id 
		$productid		= ( !empty($woo_variation->id) ) ? $woo_variation->id : $variation_id; 
		
		// Getting order details
		$buyer_email 	= $woo_order_details->billing_email;
		$buyer_fname 	= $woo_order_details->billing_first_name;
		$buyer_lname 	= $woo_order_details->billing_last_name;
		$buyer_fullname = $buyer_fname .' '. $buyer_lname;
		$productname 	= isset($woo_product_name[$productid]) ? $woo_product_name[$productid] : '';
		
		//vouchers data of pdf
		$voucherdata = isset( $orderdata[$variation_id] ) ? $orderdata[$variation_id] : array();
		
		//get all voucher details from order meta
		$allvoucherdata = isset( $allorderdata[$productid] ) ? $allorderdata[$productid] : array();
		
		//how to use the voucher details
		//$howtouse = get_post_meta( $productid, $prefix.'how_to_use', true );
		$howtouse = isset( $allvoucherdata['redeem'] ) ? $allvoucherdata['redeem'] : '';
		
		//expiry data
		//$exp_date = get_post_meta( $productid, $prefix.'exp_date', true );
		$exp_date = isset( $allvoucherdata['exp_date'] ) ? $allvoucherdata['exp_date'] : '';
		
		//vou order date
		$orderdate = get_the_time( 'Y-m-d', $orderid );
		if( !empty( $orderdate ) ){
			$orderdate = $model->woo_vou_get_date_format( $orderdate );
		}
		
		//vou logo
		//$voulogo = get_post_meta( $productid, $prefix.'logo', true );
		$voulogo = isset( $allvoucherdata['vendor_logo'] ) ? $allvoucherdata['vendor_logo'] : '';
		$voulogo = isset( $voulogo['src'] ) && !empty( $voulogo['src'] ) ? $voulogo['src'] : '';
		
		//vendor logo
		$voulogohtml = '';
		if( !empty( $voulogo ) ) {
			
			$voulogohtml = '<img src="' . $voulogo . '" alt="" />';
		}
		
		//site logo 
		$vousitelogohtml = '';
		$vou_site_url = get_option( 'vou_site_logo' );
		if( !empty( $vou_site_url ) ) {
			
			$vousitelogohtml = '<img src="' . $vou_site_url . '" alt="" />';
		}
		
		//expiration date
		if( !empty( $exp_date ) ) {
			$expiry_date = $model->woo_vou_get_date_format( $exp_date );
		} else {
			$expiry_date = __( 'No Expiration', 'woovoucher' );
		}	
		
		//website url 
		//$website = get_post_meta( $productid, $prefix.'website', true );
		$website = isset( $allvoucherdata['website_url'] ) ? $allvoucherdata['website_url'] : '';
		
		//vendor address
		//$addressphone = get_post_meta( $productid, $prefix.'address_phone', true );
		$addressphone = isset( $allvoucherdata['vendor_address'] ) ? $allvoucherdata['vendor_address'] : '';
		
		//location where voucher is availble
		//$locations = get_post_meta( $productid, $prefix.'avail_locations', true );
		$locations = isset( $allvoucherdata['avail_locations'] ) ? $allvoucherdata['avail_locations'] : '';
		
		//get voucher template id
		//$voucher_template_id = get_option( 'vou_pdf_template' );
		
		//vendor user
		$vendor_user 	= get_post_meta( $productid, $prefix.'vendor_user', true );
		
		//get vendor detail
		$vendor_detail	= $model->woo_vou_get_vendor_detail( $productid , $vendor_user );
		
		//pdf template
		$pdf_template_meta	= $vendor_detail['pdf_template'];
		
		//Voucher template from meta
		//$pdf_template_meta = get_post_meta( $productid, $prefix.'pdf_template', true );
		//$pdf_template_meta = isset( $allvoucherdata['pdf_template'] ) ? $allvoucherdata['pdf_template'] : '';
		
		//set voucher template id priority
		//$voucher_template_id = !empty( $pdf_template_meta ) ? $pdf_template_meta : $voucher_template_id;
		
		//get template data for check its exist
		//$voucher_template_data = get_post( $voucher_template_id );
		$voucodes = '';
		
		//voucher codes
		//$multiple_pdf = get_option( 'multiple_pdf' );
		//Get mutiple pdf option from order meta
		$multiple_pdf = empty( $orderid ) ? '' : get_post_meta( $orderid, $prefix . 'multiple_pdf', true );
		
		if( $multiple_pdf == 'yes' && !empty( $orderdvoucodes ) ){ //check is enable multiple pdf
			
			$key = isset( $_GET['key'] ) ? $_GET['key'] : '';
			$voucodes = $orderdvoucodes[$key];
			
		} elseif ( !empty( $voucherdata['codes'] ) ) {
			
			$voucodes = trim( $voucherdata['codes'] );
		}
		
		include_once( WOO_VOU_DIR . '/includes/woo-vou-generate-order-pdf.php' );
	}
}