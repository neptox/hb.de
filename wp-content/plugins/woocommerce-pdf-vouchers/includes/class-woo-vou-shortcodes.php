<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Shortcodes Class
 * 
 * Handles shortcodes functionality of plugin
 * 
 * @package WooCommerce - PDF Vouchers
 * @since 1.0.0
 */
class WOO_Vou_Shortcodes {
	
	var $model;
	function __construct(){
		
		global $woo_vou_model;
		$this->model	= $woo_vou_model;
	}
	
	/**
	 * Voucher Code Title Container
	 * 
	 * Handles to display voucher code title content
	 * 
	 * @package WooCommerce - PDF Vouchers
	 * @since 1.0.0 
	 */
	public function woo_vou_code_title_container( $atts, $content ) {
		
		$html = $voucher_codes_html = '';
		$codes = array();
		
		$content = str_replace( '<p></p>', '', $content );
		
		extract( shortcode_atts( array(
									 		'bgcolor' 		=> '',
									 		'color' 		=> '#000000',
									 		'fontsize' 		=> '10',
									 		'textalign' 	=> 'left',
								 		), $atts ) );
		
		$bgcolor_css = $color_css = $textalign_css = $fontsize_css = '';
		if( !empty( $bgcolor ) ) {
			$bgcolor_css = 'background-color: ' . $bgcolor . ';';
		}
		if( !empty( $textalign ) ) {
			$textalign_css = 'text-align: ' . $textalign . ';';
		}
		if( !empty( $fontsize ) ) {
			$fontsize_css = 'font-size: ' . $fontsize . 'pt;';
		}
		
		if( !empty( $content ) && trim( $content ) != '' ) {
			
			$html .= '<table class="woo_vou_textblock" style="padding: 0px 5px; ' . $textalign_css . $bgcolor_css . $color_css . $fontsize_css . '">
						<tr>
							<td>
								' . wpautop( $content ) . '
							</td>
						</tr>
					</table>';
		}
		
		return $html;
	}
	
	/**
	 * Voucher Code Container
	 * 
	 * Handles to display voucher code content
	 * 
	 * @package WooCommerce - PDF Vouchers
	 * @since 1.0.0
	 */
	public function woo_vou_code_container( $atts, $content ) {
		
		$prefix = WOO_VOU_META_PREFIX;
		
		$html	 = $voucher_codes_html = '';
		$codes	 = array();
		$content = str_replace( '<p></p>', '', $content );
		
		extract( shortcode_atts( array(
									 		'bgcolor' 		=> '',
									 		'color' 		=> '#000000',
									 		'fontsize' 		=> '10',
									 		'textalign' 	=> 'left',
									 		'codeborder'	=> '',
									 		'codetextalign'	=> 'left',
									 		'codecolumn'	=> '1',
								 		), $atts ) );
	 	
		if( isset( $_GET['woo_vou_pdf_action'] ) && $_GET['woo_vou_pdf_action'] == 'preview' ) { // Check Test PDF Template
			
			$codes =array(
							__( '[The voucher code will be inserted automatically here]', 'woovoucher' )
						);
		} elseif( !class_exists( 'WOO_Vou_Ext_Public' ) ) { // condition for addon
			
			//Check order is not set or order is empty
			if( !isset( $_GET['order'] ) || empty( $_GET['order'] ) ) {
				return false;
			}
			
			//Get order id by order key using woocommerce function
			$orderid = wc_get_order_id_by_order_key( $_GET['order'] );
			
			// Check order id and product id are not empty
			if( !empty( $orderid ) && !empty( $_GET['download_file'] ) ) {
				
				//orderdata
				$orderdata = $this->model->woo_vou_get_post_meta_ordered( $orderid );
				
				$productid = $_GET['download_file'];
				
				//vouchers data of pdf
				$voucherdata = isset( $orderdata[$productid] ) ? $orderdata[$productid] : array();
				
				//voucher code
				if( isset( $voucherdata['codes'] ) && !empty( $voucherdata['codes'] ) ) {
					
					$codes = explode( ',', trim( $voucherdata['codes'] ) );
				}
			}
		}
		
		$codeborder_attr = $codetextalign_css = '';
		if( !empty( $codeborder ) ) {
			$codeborder_attr .= 'border="' . $codeborder . '"';
		}
		if( !empty( $codetextalign ) ) {
			$codetextalign_css .= 'text-align: ' . $codetextalign . ';';
		}
		
		return '<table width="100%" ' . $codeborder_attr . 'style="padding: 5px; ' . $codetextalign_css . '">
					<tr>
						<td>
							' . wpautop($content) . '
						</td>
					</tr>
				</table>';
	}
	
	/**
	 * Voucher Redeem Container
	 * 
	 * Handles to display voucher redeem instructions
	 * 
	 * @package WooCommerce - PDF Vouchers
	 * @since 1.0.0
	 */
	public function woo_vou_redeem_container( $atts, $content ) {
		
		$content = str_replace( '<p></p>', '', $content );
		
		extract( shortcode_atts( array(
									 		'bgcolor' 	=> ''
								 		), $atts ) );
		
		$bgcolor_css = '';
		if( !empty( $bgcolor ) ) {
			$bgcolor_css = 'background-color: ' . $bgcolor . ';';
		}
		
		return '<table class="woo_vou_messagebox" style="padding: 0px 5px; ' . $bgcolor_css . '">
					<tr>
						<td>
							' . wpautop( $content ) . '
						</td>
					</tr>
				</table>';
	}
	
	/**
	 * Voucher Site Logo Container
	 * 
	 * Handles to display voucher site logo container
	 * 
	 * @package WooCommerce - PDF Vouchers
	 * @since 1.0.0
	 */
	public function woo_vou_site_logo_container( $atts, $content ) {
		
		$content = str_replace( '<p></p>', '', $content );
		
		extract( shortcode_atts( array(
		 		), $atts ) );
		 
		 return '<table class="woo_vou_sitelogobox" style="text-align: center">
					<tr>
						<td>
							' . wpautop( $content ) . '
						</td>
					</tr>
				</table>';
	}
	
	/**
	 * Voucher Logo Container
	 * 
	 * Handles to display voucher logo container
	 * 
	 * @package WooCommerce - PDF Vouchers
	 * @since 1.0.0
	 */
	public function woo_vou_logo_container( $atts, $content ) {
		
		$content = str_replace( '<p></p>', '', $content );
		
		extract( shortcode_atts( array(	
		 		), $atts ) );
		 
		 return '<table class="woo_vou_logobox" style="text-align: center">
					<tr>
						<td>
							' . wpautop( $content ) . '
						</td>
					</tr>
				</table>';
	}
	
	/**
	 * Voucher Expire Date Container
	 * 
	 * Handles to display voucher expire date content
	 * 
	 * @package WooCommerce - PDF Vouchers
	 * @since 1.0.0
	 */
	public function woo_vou_expire_date_container( $atts, $content ) {
		
		$content = str_replace( '<p></p>', '', $content );
		
		extract( shortcode_atts( array(
									 		'bgcolor' 	=> ''
								 		), $atts ) );
		
		$bgcolor_css = '';
		if( !empty( $bgcolor ) ) {
			$bgcolor_css = 'background-color: ' . $bgcolor . ';';
		}
		
		return '<table class="woo_vou_expireblock" style="padding: 0px 5px; ' . $bgcolor_css . '">
					<tr>
						<td>
							' . wpautop( $content ) . '
						</td>
					</tr>
				</table>';
	}
	
	/**
	 * Vendor's Address Container
	 * 
	 * Handles to display vendor's address content
	 * 
	 * @package WooCommerce - PDF Vouchers
	 * @since 1.0.0 
	 */
	public function woo_vou_vendor_address_container( $atts, $content ) {
		
		$content = str_replace( '<p></p>', '', $content );
		
		extract( shortcode_atts( array(
									 		'bgcolor' 	=> ''
								 		), $atts ) );
		
		$bgcolor_css = '';
		if( !empty( $bgcolor ) ) {
			$bgcolor_css = 'background-color: ' . $bgcolor . ';';
		}
		
		return '<table class="woo_vou_venaddrblock" style="padding: 0px 5px; ' . $bgcolor_css . '">
					<tr>
						<td>
							' . wpautop( $content ) . '
						</td>
					</tr>
				</table>';
	}
	
	/**
	 * Website URL Container
	 * 
	 * Handles to display website URL content
	 * 
	 * @package WooCommerce - PDF Vouchers
	 * @since 1.0.0
	 */
	public function woo_vou_siteurl_container( $atts, $content ) {
		
		$content = str_replace( '<p></p>', '', $content );
		
		extract( shortcode_atts( array(
									 		'bgcolor' 	=> ''
								 		), $atts ) );
		
		$bgcolor_css = '';
		if( !empty( $bgcolor ) ) {
			$bgcolor_css = 'background-color: ' . $bgcolor . ';';
		}
		
		return '<table class="woo_vou_siteurlblock" style="padding: 0px 5px; ' . $bgcolor_css . '">
					<tr>
						<td>
							' . wpautop( $content ) . '
						</td>
					</tr>
				</table>';
	}
	
	/**
	 * Voucher Locations Container
	 * 
	 * Handles to display voucher locations content
	 * 
	 * @package WooCommerce - PDF Vouchers
	 * @since 1.0.0 
	 */
	public function woo_vou_location_container( $atts, $content ) {
		
		$content = str_replace( '<p></p>', '', $content );
		
		extract( shortcode_atts( array(
									 		'bgcolor' 	=> ''
								 		), $atts ) );
		
		$bgcolor_css = '';
		if( !empty( $bgcolor ) ) {
			$bgcolor_css = 'background-color: ' . $bgcolor . ';';
		}
		
		return '<table class="woo_vou_locblock" style="padding: 0px 5px; ' . $bgcolor_css . '">
					<tr>
						<td>
							' . wpautop( $content ) . '
						</td>
					</tr>
				</table>';
	}
	
	/**
	 * Custom Container
	 * 
	 * Handles to display custom content
	 * 
	 * @package WooCommerce - PDF Vouchers
	 * @since 1.0.0
	 */
	public function woo_vou_custom_container( $atts, $content ) {
		
		$content = str_replace( '<p></p>', '', $content );
		
		extract( shortcode_atts( array(	
									 		'bgcolor' 	=> ''
								 		), $atts ) );
		
		$bgcolor_css = '';
		if( !empty( $bgcolor ) ) {
			$bgcolor_css = 'background-color: ' . $bgcolor . ';';
		}
		
		return '<table class="woo_vou_customblock" style="padding: 0px 5px; ' . $bgcolor_css . '">
					<tr>
						<td>
							' . wpautop( $content ) . '
						</td>
					</tr>
				</table>';
	}
	
	/**
	 * Check Voucher Code
	 * 
	 * Handles to display check voucher code
	 * 
	 * @package WooCommerce - PDF Vouchers
	 * @since 1.0.0
	 */
	public function woo_vou_check_code( $attr, $content ) {
		
		ob_start();
		if ( is_user_logged_in() ) { // check is user loged in
			
			do_action( 'woo_vou_check_code_content' );
			
		} else {
			
			_e( 'You need to be logged in to your account to see check voucher code.', 'woovoucher' );
		}
		$content .= ob_get_clean();
		
		return $content;
	}
	
	/**
	 * Adding Hooks
	 * 
	 * Adding proper hoocks for the shortcodes.
	 * 
	 * @package WooCommerce - PDF Vouchers
	 * @since 1.0.0
	 */
	public function add_hooks() {
		
		add_shortcode( 'woo_vou_code_title', array( $this, 'woo_vou_code_title_container' ) ); // for voucher code title
		add_shortcode( 'woo_vou_code', array( $this, 'woo_vou_code_container' ) ); // for voucher code
		add_shortcode( 'woo_vou_redeem', array( $this, 'woo_vou_redeem_container' ) ); //for redeem instruction
		add_shortcode( 'woo_vou_site_logo', array( $this, 'woo_vou_site_logo_container' ) ); //for voucher site logo
		add_shortcode( 'woo_vou_logo', array( $this, 'woo_vou_logo_container' ) ); //for voucher logo
		add_shortcode( 'woo_vou_expire_date', array( $this, 'woo_vou_expire_date_container' ) ); //for voucher expire date
		add_shortcode( 'woo_vou_vendor_address', array( $this, 'woo_vou_vendor_address_container' ) ); //for vendor's address
		add_shortcode( 'woo_vou_siteurl', array( $this, 'woo_vou_siteurl_container' ) ); //for website url
		add_shortcode( 'woo_vou_location', array( $this, 'woo_vou_location_container' ) ); //for voucher locations
		add_shortcode( 'woo_vou_custom', array( $this, 'woo_vou_custom_container' ) ); //for custom
		add_shortcode( 'woo_vou_check_code', array( $this, 'woo_vou_check_code' ) ); //for check voucher code
	}
}