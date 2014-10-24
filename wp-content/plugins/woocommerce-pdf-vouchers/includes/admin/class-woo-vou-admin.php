<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Admin Class
 *
 * Handles generic Admin functionality and AJAX requests.
 *
 * @package WooCommerce - PDF Vouchers
 * @since 1.0.0
 */
class WOO_Vou_Admin{
	
	var $scripts,$model,$render,$voumeta;
	
	public function __construct(){
		
		global $woo_vou_scripts,$woo_vou_model,
				$woo_vou_render, $woo_vou_admin_meta;
		
		$this->scripts 	= $woo_vou_scripts;
		$this->model 	= $woo_vou_model;
		$this->render 	= $woo_vou_render;
		$this->voumeta	= $woo_vou_admin_meta;
	}
	
	/**
	 * Adding Submenu Page
	 * 
	 * Handles to adding submenu page for 
	 * voucher extension
	 * 
	 * @package WooCommerce - PDF Vouchers
	 * @since 1.0.0
	 */
	public function woo_vou_admin_submenu() {
		
		global $current_user, $woo_vou_vendor_role;
		
		$main_menu_slug = WOO_VOU_MAIN_MENU_NAME;
		
		//Current user role
		$user_roles	= isset( $current_user->roles ) ? $current_user->roles : array();
		$user_role	= array_shift( $user_roles );
		
		if( in_array( $user_role, $woo_vou_vendor_role ) ) { // Check vendor user role
			
			$main_menu_slug = 'woo-vou-codes';
			//add WooCommerce Page
			add_menu_page( __( 'WooCommerce', 'woovoucher' ),__( 'WooCommerce', 'woovoucher' ), WOO_VOU_VENDOR_LEVEL, $main_menu_slug, '' );
			add_submenu_page( $main_menu_slug , __( 'Voucher Codes', 'woovoucher'), __( 'Voucher Codes', 'woovoucher' ), WOO_VOU_VENDOR_LEVEL, $main_menu_slug, array($this,'woo_vou_codes_page')); 
			
		} else {
		
			//voucher codes page
			$voucher_page = add_submenu_page( $main_menu_slug , __( 'Voucher Codes', 'woovoucher'), __( 'Voucher Codes', 'woovoucher' ), WOO_VOU_VENDOR_LEVEL, 'woo-vou-codes', array($this,'woo_vou_codes_page')); 
		}
		
		//add check voucher code page
		$check_voucher_page = add_submenu_page( $main_menu_slug, __( 'Check Voucher Code', 'woovoucher' ),__( 'Check Voucher Code', 'woovoucher' ), WOO_VOU_VENDOR_LEVEL, 'woo-vou-check-voucher-code', array( $this, 'woo_vou_check_voucher_code_page' ) );
		
	}
	
	/**
	 * Add Page to See Used Voucher for
	 * all Products
	 * 
	 * Handles to list the products for which vouchers 
	 * used
	 * 
	 * @package WooCommerce - PDF Vouchers
	 * @since 1.1.0
	 */
	
	public function woo_vou_codes_page() {
		
		include_once( WOO_VOU_ADMIN . '/forms/woo-vou-codes-page.php' );
	}
	
	/**
	 * Check Voucher Code Page for
	 * all Products
	 * 
	 * Handles to check voucher code page
	 * for all voucher codes and manage codes
	 * 
	 * @package WooCommerce - PDF Vouchers
	 * @since 1.1.0
	 */
	public function woo_vou_check_voucher_code_page() {
		
		include_once( WOO_VOU_ADMIN . '/forms/woo-vou-check-code.php');	
		
	}
	
	/**
	 * Import Codes From CSV
	 * 
	 * Handle to import voucher codes from CSV Files
	 * 
	 * @package WooCommerce - PDF Vouchers
	 * @since 1.0.0
	 */
	
	public function woo_vou_import_codes() {
		
		//import csv file code for voucher code importing to textarea
		if( ( isset( $_FILES['woo_vou_csv_file']['tmp_name'] ) && !empty( $_FILES['woo_vou_csv_file']['tmp_name'] ) ) ) {
			
			$filename = $_FILES['woo_vou_csv_file']['tmp_name'];
			$deletecode = isset( $_POST['woo_vou_delete_code'] ) && !empty( $_POST['woo_vou_delete_code'] ) ? $_POST['woo_vou_delete_code'] : '';
			$existingcode = isset( $_POST['woo_vou_existing_code'] ) && !empty( $_POST['woo_vou_existing_code'] ) ? $_POST['woo_vou_existing_code'] : '';
			$csvseprator = isset( $_POST['woo_vou_csv_sep'] ) && !empty( $_POST['woo_vou_csv_sep'] ) ? $_POST['woo_vou_csv_sep'] : ',';
			$csvenclosure = isset( $_POST['woo_vou_csv_enc'] ) ? $_POST['woo_vou_csv_enc'] : '';
			
			$importcodes = '';
			
			$importcodes = '';
			$pattern_data = array();
			
			if( !empty($existingcode) && $deletecode != 'y' ) { // check existing code and existing code not remove
				$pattern_data = explode( ',', $existingcode );
				$pattern_data = array_map( 'trim', $pattern_data );
			}
				
			if ( !empty( $filename ) && ( $handle = fopen( $filename, "r") ) !== FALSE) {
				
				if( !empty($csvenclosure) ) {
				
					while (($data = fgetcsv($handle, 1000, $csvseprator, $csvenclosure)) !== FALSE) { // check all row of csv
					
						foreach ( $data as $key => $value ) { // check all column of particular row
							
							if( !empty($value) && !in_array( $value, $pattern_data) ) { // cell value is not empty and avoid duplicate code
								
								$pattern_data[] = str_replace( ',', '', $value);
							}
					    }
					}
				} else {
				
					while (($data = fgetcsv($handle, 1000, $csvseprator)) !== FALSE) { // check all row of csv
					
						foreach ( $data as $key => $value ) { // check all column of particular row
							
							if( !empty($value) && !in_array( $value, $pattern_data) ) { // cell value is not empty and avoid duplicate code
								
								$pattern_data[] = str_replace( ',', '', $value);
							}
					    }
					}
				}
				
			    fclose($handle);
			    unset($_FILES['woo_vou_csv_file']);
			}
			
		    $import_code = implode( ', ', $pattern_data ); // all pattern codes
		
			echo $import_code;
			exit;
		}
	}
		
	/**
	 * Import Random Code using AJAX
	 *
	 * @package WooCommerce - PDF Vouchers
	 * @since 1.0.0
	 */
	public function woo_vou_import_code() {
		
		$noofvoucher 	= !empty($_POST['noofvoucher']) ? $_POST['noofvoucher'] : 0;
		$codeprefix 	= !empty($_POST['codeprefix']) ? $_POST['codeprefix'] : '';
		$codeseperator 	= !empty($_POST['codeseperator']) ? $_POST['codeseperator'] : '';
		$pattern 		= !empty($_POST['codepattern']) ? $_POST['codepattern'] : '';
		$existingcode	= !empty($_POST['existingcode']) ? $_POST['existingcode'] : '';
		$deletecode		= !empty($_POST['deletecode']) ? $_POST['deletecode'] : '';
		
		$pattern_prefix = $codeprefix . $codeseperator; // merge prefix with seperator
		
		$pattern_data = array();
		if( !empty($existingcode) && $deletecode != 'y' ) { // check existing code and existing code not remove
			$pattern_data = explode( ',', $existingcode );
			$pattern_data = array_map( 'trim', $pattern_data );
		}
		
		for ( $j = 0; $j < $noofvoucher; $j++ ) { // no of codes are generate
			
			$pattern_string = $pattern_prefix . $this->model->woo_vou_get_pattern_string( $pattern );
			
			while ( in_array( $pattern_string, $pattern_data) ) { // avoid duplicate pattern code
				$pattern_string = $pattern_prefix . $this->model->woo_vou_get_pattern_string( $pattern );
			}
			
			$pattern_data[] = str_replace( ',', '', $pattern_string);
		}
		$import_code = implode( ', ', $pattern_data ); // all pattern codes
		
		echo $import_code;
		exit;
		
	}
	
	/**
	 * Add Popup For import Voucher Code 
	 * 
	 * Handels to show import voucher code popup
	 * 
	 * @package WooCommerce - PDF Vouchers
	 * @since 1.0.0
	 */
	public function woo_vou_import_footer() {
		
		global $post;
		
		//Check product post type page 
		if( isset( $post->post_type ) && $post->post_type == WOO_VOU_MAIN_POST_TYPE ) {
			
			include_once( WOO_VOU_ADMIN . '/forms/woo-vou-import-code-popup.php' );
		}
	}
		
	/**
	 * Add Custom meta boxs  for voucher templates post tpye
	 * 
	 * Handles to add custom meta boxs in voucher templates
	 * 
	 * @package WooCommerce - PDF Vouchers
	 * @since 1.0.0
	 */
	public function woo_vou_editor_meta_box() {

		global $wp_meta_boxes;
		
		// add metabox for edtior
		add_meta_box( 'woo_vou_page_voucher' ,__( 'Voucher', 'woovoucher' ), array( $this, 'woo_vou_editor_control' ), WOO_VOU_POST_TYPE, 'normal', 'high', 1 );
		
		// add metabox for style options 
		add_meta_box( 'woo_vou_pdf_options' ,__( 'Voucher Options', 'woovoucher' ), array( $this, 'woo_vou_pdf_options_page' ), WOO_VOU_POST_TYPE, 'normal', 'high' );
		
	}
	
	/**
	 * Add Custom Editor
	 * 
	 * Handles to add custom editor
	 * 
	 * @package WooCommerce - PDF Vouchers
	 * @since 1.0.0
	 */
	function woo_vou_editor_control() {
		
		include( WOO_VOU_ADMIN . '/forms/woo-vou-editor.php');
	}
	
	/**
	 * Add Style Options
	 * 
	 * Handles to add Style Options
	 * 
	 * @package WooCommerce - PDF Vouchers
	 * @since 1.0.0
	 */
	function woo_vou_pdf_options_page() {
		
		include( WOO_VOU_ADMIN . '/forms/woo-vou-meta-options.php');
	}
	
	/**
	 * Save Voucher Meta Content
	 * 
	 * Handles to saving voucher meta on update voucher template post type
	 * 
	 * @package WooCommerce - PDF Vouchers
	 * @since 1.0.0
	 */
	function woo_vou_save_metadata( $post_id ) {
	
		global $post_type;
		
		$prefix = WOO_VOU_META_PREFIX;
		
		$post_type_object = get_post_type_object( $post_type );
		
		// Check for which post type we need to add the meta box
		$pages = array( WOO_VOU_POST_TYPE );

		if ( ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )                // Check Autosave
		|| ( ! isset( $_POST['post_ID'] ) || $post_id != $_POST['post_ID'] )        // Check Revision
		|| ( ! in_array( $post_type, $pages ) )              // Check if current post type is supported.
		|| ( ! check_admin_referer( WOO_VOU_PLUGIN_BASENAME, 'at_woo_vou_meta_box_nonce') )      // Check nonce - Security
		|| ( ! current_user_can( $post_type_object->cap->edit_post, $post_id ) ) )       // Check permission
		{
		  return $post_id;
		}
		
		$metacontent = isset( $_POST['woo_vou_meta_content'] ) ? $_POST['woo_vou_meta_content'] : '';
		$metacontent = trim( $metacontent );
		update_post_meta( $post_id, $prefix . 'meta_content', $metacontent ); // updating the content of page builder editor
		
		//Update Editor Status
		if( isset( $_POST[ $prefix . 'editor_status' ] ) ) {			
			
			update_post_meta( $post_id, $prefix . 'editor_status', $_POST[ $prefix . 'editor_status' ] );
		}
		
		//Update Background Style
		if( isset( $_POST[ $prefix . 'pdf_bg_style' ] ) ) {
			
			update_post_meta( $post_id, $prefix . 'pdf_bg_style', $_POST[ $prefix . 'pdf_bg_style' ] );
		}
		//Update Background Pattern
		if( isset( $_POST[ $prefix . 'pdf_bg_pattern' ] ) ) {
			
			update_post_meta( $post_id, $prefix . 'pdf_bg_pattern', $_POST[ $prefix . 'pdf_bg_pattern' ] );
		}
		//Update Background Image
		if( isset( $_POST[ $prefix . 'pdf_bg_img' ] ) ) {
			
			update_post_meta( $post_id, $prefix . 'pdf_bg_img', $_POST[ $prefix . 'pdf_bg_img' ] );
		}
		//Update Background Color
		if( isset( $_POST[ $prefix . 'pdf_bg_color' ] ) ) {
			
			update_post_meta( $post_id, $prefix . 'pdf_bg_color', $_POST[ $prefix . 'pdf_bg_color' ] );
		}
		//Update PDF View
		if( isset( $_POST[ $prefix . 'pdf_view' ] ) ) {
			
			update_post_meta( $post_id, $prefix . 'pdf_view', $_POST[ $prefix . 'pdf_view' ] );
		}
		//Update Margin Top
		if( isset( $_POST[ $prefix . 'pdf_margin_top' ] ) ) {
			
			update_post_meta( $post_id, $prefix . 'pdf_margin_top', $_POST[ $prefix . 'pdf_margin_top' ] );
		}
		//Update Margin Left
		if( isset( $_POST[ $prefix . 'pdf_margin_left' ] ) ) {
			
			update_post_meta( $post_id, $prefix . 'pdf_margin_left', $_POST[ $prefix . 'pdf_margin_left' ] );
		}
		//Update Margin Right
		if( isset( $_POST[ $prefix . 'pdf_margin_right' ] ) ) {
			
			update_post_meta( $post_id, $prefix . 'pdf_margin_right', $_POST[ $prefix . 'pdf_margin_right' ] );
		}

	}
	
	/**
	 * Custom column
	 *
	 * Handles the custom columns to voucher listing page
	 * 
	 * @package WooCommerce - PDF Vouchers
	 * @since 1.0.0
	 */
	public function woo_vou_manage_custom_column( $column_name, $post_id ) {
		
		global $wpdb,$post;
		
		$prefix = WOO_VOU_META_PREFIX;
		
		switch ($column_name) {
				
			case 'voucher_preview' :
										$preview_url = $this->woo_vou_get_preview_link( $post_id );
										echo '<a href="' . $preview_url . '" class="woo-vou-pdf-preview">' . __( 'View Preview', 'woovoucher' ) . '</a>';
										break;
								
		}
	}
	
	/**
	 * Add New Column to voucher listing page
	 *
	 * @package WooCommerce - PDF Vouchers
	 * @since 1.0.0
	 */
	function woo_vou_add_new_columns($new_columns) {
 		
 		unset($new_columns['date']);
 		
 		$new_columns['voucher_preview'] = __( 'View Preview', 'woovoucher' );
		$new_columns['date']			= _x( 'Date', 'column name', 'woovoucher' );
		
		return $new_columns;
	}

	/**
	 * Get Preview Link
	 *
	 * Handles to get preview link
	 * 
	 * @package WooCommerce - PDF Vouchers
	 * @since 1.0.0
	 */
	function woo_vou_get_preview_link( $postid ) {
		
		$preview_url = add_query_arg( array( 'post_type' => WOO_VOU_POST_TYPE, 'woo_vou_pdf_action' => 'preview', 'voucher_id' => $postid ), admin_url( 'edit.php' ) );
		
		return $preview_url;
	}
	
	/**
	 * Add New Action For Create Duplicate
	 * 
	 * Handles to add new action for 
	 * Create Duplicate link of that voucher
	 *
	 * @package WooCommerce - PDF Vouchers
	 * @since 1.0.0
	 */
	public function woo_vou_dupd_action_new_link_add( $actions, $post ) {
		
		//check current user can have administrator rights
		//post type must have vouchers post type
		if ( ! current_user_can( 'manage_options' ) || $post->post_type != WOO_VOU_POST_TYPE ) 
			return $actions;
			
		// add new action for create duplicate
		$args = array( 'action'	=>	'woo_vou_duplicate_vou', 'woo_vou_dupd_vou_id' => $post->ID );
		$dupdurl = add_query_arg( $args, admin_url( 'edit.php' ) );
		$actions['woo_vou_duplicate_vou'] = '<a href="' . wp_nonce_url( $dupdurl, 'duplicate-vou_' . $post->ID ) . '" title="' . __( 'Make a duplicate from this voucher', 'woovoucher' )
										. '" rel="permalink">' .  __( 'Duplicate', 'woovoucher' ) . '</a>';
		
		// return all actions
		return $actions ;
		
	}
	
	/**
	 * Add Preview Button
	 * 
	 * Handles to add preview button within
	 * Publish meta box
	 * 
	 * @package WooCommerce - PDF Vouchers
	 * @since 1.0.0
	 */
	function woo_vou_add_preview_button() {
		
		global $typenow, $post;
		
		if ( ! current_user_can( 'manage_options' )
			|| ! is_object( $post )
			|| $post->post_type != WOO_VOU_POST_TYPE ) {
				return;
		}
		
		if ( isset( $_GET['post'] ) ) {
			
			$args = array( 'action'	=>	'woo_vou_duplicate_vou', 'woo_vou_dupd_vou_id' => absint( $_GET['post'] ) );
			$dupdurl = add_query_arg( $args, admin_url( 'edit.php' ) );
			$notifyUrl = wp_nonce_url( $dupdurl, 'duplicate-vou_' . $_GET['post'] );
			?>
			<div id="duplicate-action"><a class="submitduplicate duplication" href="<?php echo esc_url( $notifyUrl ); ?>"><?php _e( 'Copy to a new draft', 'woovoucher' ); ?></a></div>
			<?php
		}
		
		$preview_url = $this->woo_vou_get_preview_link( $post->ID );
		echo '<a href="' . $preview_url . '" class="button button-secondary button-large woo-vou-pdf-preview-button" >' . __( 'Preview', 'woovoucher' ) . '</a>';
	}
	
	/**
	 * Duplicate Voucher
	 * 
	 * Handles to creating duplicate voucher
	 * 
	 * @package WooCommerce - PDF Vouchers
	 * @since 1.0.0
	 */
	function woo_vou_duplicate_process() {
		
		//check the duplicate create action is set or not and order id is not empty
		if( isset($_GET['action']) && !empty($_GET['action']) && $_GET['action'] == 'woo_vou_duplicate_vou'
			&& isset( $_GET['woo_vou_dupd_vou_id'] ) && !empty($_GET['woo_vou_dupd_vou_id'])) {
			
			// get the vou id
			$vou_id = $_GET['woo_vou_dupd_vou_id'];
			
			//check admin referer	
			check_admin_referer( 'duplicate-vou_' . $vou_id );
			
			// create duplicate voucher
			$this->model->woo_vou_dupd_create_duplicate_vou( $vou_id );
		}
	}

	/**
	 * Vouchers Lists display based on menu order with ascending order
	 * 
	 * @package WooCommerce - PDF Vouchers
	 * @since 1.0.0
	 */
	public function woo_vou_edit_posts_orderby( $orderby_statement ) {
		
		global $wpdb;
		
		 //Check post type is woovouchers & sorting not applied by user
		if( isset( $_GET['post_type'] ) && $_GET['post_type'] == WOO_VOU_POST_TYPE && !isset( $_GET['orderby'] ) ) {
			
			$orderby_statement =  "{$wpdb->posts}.menu_order ASC, {$wpdb->posts}.post_date DESC";
		}
		return $orderby_statement;
	}
	
	/**
	 * Save Metabox Data
	 * 
	 * Handles to save metabox details
	 * to database
	 * 
	 * @package WooCommerce - PDF Vouchers
	 * @since 1.0.0
	 */
	public function woo_vou_product_save_data( $post_id, $post ) {
		
		global $post_type;
		
		$prefix = WOO_VOU_META_PREFIX;
		
		//is downloadable
		$is_downloadable 		= get_post_meta( $post_id, '_downloadable', true );
		
		// Getting product type
		$product_type 			= !empty($_POST['product-type']) ? $_POST['product-type'] : '';
		
		// Enable Voucher Codes
		$woo_vou_enable			= !empty( $_POST[ $prefix.'enable' ] ) ? 'yes' : '';
		
		// get Pdf template
		$woo_vou_pdf_template   = isset($_POST[$prefix.'pdf_template']) ? $_POST[$prefix.'pdf_template'] : ''; 
		
		// Usability
		$woo_vou_using_type		= isset( $_POST[$prefix.'using_type'] ) ? $_POST[$prefix.'using_type'] : '';
		
		// get logo
		$woo_vou_logo 			= isset($_POST[$prefix.'logo']) ? $_POST[$prefix.'logo'] : ''; 
		
		// get address
		$woo_vou_address_phone  = isset($_POST[$prefix.'address_phone']) ? $_POST[$prefix.'address_phone'] : ''; 
		
		// get website
		$woo_vou_website  		= isset($_POST[$prefix.'website']) ? $_POST[$prefix.'website'] : ''; 
		
		// get redeem instructions
		$woo_vou_how_to_use 	= isset($_POST[$prefix.'how_to_use']) ? $_POST[$prefix.'how_to_use'] : ''; 
		
		
				
		// Check if downloadable is on or variable product then set voucher enable option otherwise not set
		if( $is_downloadable == 'yes' || $product_type == 'variable' ) {
			
			$enable_voucher = $woo_vou_enable;
			
		} else {
			$enable_voucher =  '';
		}
		
		// Getting downloadable variable
		//$variable_is_downloadable = !empty($_POST['variable_is_downloadable']) ? $_POST['variable_is_downloadable'] : array();
		
		update_post_meta( $post_id, $prefix.'enable', $enable_voucher );
		
		// PDF Template
		update_post_meta( $post_id, $prefix.'pdf_template', $woo_vou_pdf_template );
		
		// Vendor User
		update_post_meta( $post_id, $prefix.'vendor_user', $_POST[$prefix.'vendor_user'] );
		
		
		update_post_meta( $post_id, $prefix.'exp_type', $_POST[$prefix.'exp_type'] );
		
		update_post_meta( $post_id, $prefix.'days_diff', $_POST[$prefix.'days_diff'] );
		
		$custom_days	=  !empty( $_POST[$prefix.'custom_days']) && is_numeric( $_POST[$prefix.'custom_days'] ) ? trim(round ( $_POST[$prefix.'custom_days'] ) ) : '';
		update_post_meta( $post_id, $prefix.'custom_days', $custom_days );
		
		// Expiration Date
		$exp_date = $_POST[$prefix.'exp_date'];
		
		if(!empty($exp_date)) {
			$exp_date = strtotime( $this->model->woo_vou_escape_slashes_deep( $exp_date ) );
			$exp_date = date('Y-m-d H:i:s',$exp_date);
		}
		update_post_meta( $post_id, $prefix.'exp_date', $exp_date );
		
		// Voucher Codes
		$voucher_codes = isset( $_POST[$prefix.'codes'] ) ? $this->model->woo_vou_escape_slashes_deep( $_POST[$prefix.'codes'] ) : '';
		update_post_meta( $post_id, $prefix.'codes', $voucher_codes );
		
		
		$usability = $woo_vou_using_type;
		
		if( isset( $_POST[$prefix.'vendor_user'] ) && !empty( $_POST[$prefix.'vendor_user'] ) || $usability == '') {//if bendor user is set and usability is default 
			
			$usability = get_user_meta( $_POST[$prefix.'vendor_user'], $prefix.'using_type', true );
		}
		
		// If usability is default then take it from setting
		if( $usability == '' ) {
			$usability = get_option('vou_pdf_usability');
		}
		
		update_post_meta( $post_id, $prefix.'using_type', $woo_vou_using_type );
		
		// vendor's Logo
		update_post_meta( $post_id, $prefix.'logo', $woo_vou_logo );
		
		// Vendor's Address
		update_post_meta( $post_id, $prefix.'address_phone', $this->model->woo_vou_escape_slashes_deep( $woo_vou_address_phone, true, true ) );
		
		// Website URL
		update_post_meta( $post_id, $prefix.'website', $this->model->woo_vou_escape_slashes_deep( $woo_vou_website ) );
		
		// Redeem Instructions
		update_post_meta( $post_id, $prefix.'how_to_use', $this->model->woo_vou_escape_slashes_deep( $woo_vou_how_to_use, true, true ) );
		
		// update available products count on bases of entered voucher codes
		if( isset( $_POST[$prefix.'codes'] ) && $enable_voucher == 'yes' ) {
			
			$voucount = '';
			$vouchercodes = trim( $_POST[$prefix.'codes'], ',' );
			if( !empty( $vouchercodes ) ) {
				$vouchercodes = explode( ',', $vouchercodes );
				$voucount = count( $vouchercodes );
			}
			
			if( empty( $usability ) ) {// using type is only one time
				
				$avail_total = empty( $voucount ) ? '0' : $voucount;
				
				// Getting variable product id
				$variable_post_id = (!empty($_POST['variable_post_id'])) ? $_POST['variable_post_id'] : array();
				
				// If product is variable and id's are not blank then update their quantity with blank
				if( $product_type == 'variable' && !empty($variable_post_id) ) {
					
					foreach ( $variable_post_id as $variable_post ) {
						
						// Update variation stock qty with blank
						update_post_meta( $variable_post, '_stock', '' );
						
						// Update variation downloadable with yes
						update_post_meta( $variable_post, '_downloadable', 'yes' );
					}
				}
				
				//update manage stock with yes
				update_post_meta( $post_id, '_manage_stock', 'yes' );
				
				//update available count on bases of 
				update_post_meta( $post_id, '_stock', $avail_total );
				
				//update Stock status
				update_post_meta( $post_id, '_stock_status', 'instock' );
				
			}
			
			if( empty( $_POST[$prefix.'codes'] ) ) { // check voucher codea are empty
				
				//update Stock status
				update_post_meta( $post_id, '_stock_status', 'outofstock' );
				
			}
		}
		
		//update location and map links
		$availlocations = array();
		if( isset( $_POST[$prefix.'locations'] ) ) {
			
			$locations = $_POST[$prefix.'locations'];
			$maplinks = $_POST[$prefix.'map_link'];
			for ( $i = 0; $i < count( $locations ); $i++ ){
				if( !empty( $locations[$i] ) || !empty( $maplinks[$i])) { //if location or map link is not empty then
					$availlocations[$i][$prefix.'locations'] = $this->model->woo_vou_escape_slashes_deep( $locations[$i], true, true );
					$availlocations[$i][$prefix.'map_link'] = $this->model->woo_vou_escape_slashes_deep( $maplinks[$i] );
				}
			}
		}
		
		//update location and map links
		update_post_meta( $post_id, $prefix. 'avail_locations', $availlocations );
		
	}	
		
	/**
	 * Display Voucher Data within order meta
	 *
	 * @package WooCommerce - PDF Vouchers
	 * @since 1.1.0
	 */
	public function woo_vou_display_voucher_data() {
		
		include( WOO_VOU_ADMIN . '/forms/woo-vou-meta-history.php' );
	}
	
	/**
	 * Add Voucher Details meta box within Order
	 *
	 * @package WooCommerce - PDF Vouchers
	 * @since 1.1.0
	 */
	public function woo_vou_order_meta_boxes() {

		add_meta_box('woo-vou-order-voucher-details', __( 'Voucher Details', 'woovoucher' ), array( $this, 'woo_vou_display_voucher_data' ), WOO_VOU_MAIN_SHOP_POST_TYPE, 'normal', 'default' );
		
	}
	
	/**
	 * Delete order meta and all order detail whene order delete.
	 *
	 * @package WooCommerce - PDF Vouchers
	 * @since 1.4.1
	 */
	public function woo_vou_order_delete( $order_id = '' ){
		
		$prefix		= WOO_VOU_META_PREFIX;		
		
		if( !empty( $order_id ) ) { // check if order id is not empty
			
			$post_type = get_post_type( $order_id ); // get	post type from order id
			
			if( $post_type == 'shop_order' ){ // check if post type is shop_order
				
				$args = array(
							'post_type'		=> WOO_VOU_CODE_POST_TYPE,
							'post_status'	=> 'any',
							'meta_query' 	=> array(
													array(
														'key' 	=> $prefix.'order_id',
														'value' => $order_id
													)
								)
				 );
				
				// get posts from order id
				$posts = get_posts($args);
				
				if( !empty( $posts ) ){ // check if get any post
					
					foreach ( $posts as $post ){
						
						wp_delete_post( $post->ID, true );
					}
				}
			}
		}
	}
	
	/**
	 * Function for Add an extra fields in edit user page
	 *
	 * @package WooCommerce - PDF Vouchers
	 * @since 1.5
	 */
	public function woo_vou_user_edit_profile_fields( $user ){
		
		global $woo_vou_vendor_role;
		
		//Get user role
		$user_roles	= isset( $user->roles ) ? $user->roles : array();
		$user_role = array_shift( $user_roles );
		
		//check if user role is vendor or not
		if( isset( $user_role ) && in_array( $user_role, $woo_vou_vendor_role) ) {
			
			include_once( WOO_VOU_ADMIN . '/forms/woo-vou-user-meta.php' );
		}
	}
	
	/**
	 * Function for update an user meta fields
	 *
	 * @package WooCommerce - PDF Vouchers
	 * @since 1.5
	 */
	public function woo_vou_update_profile_fields( $user_id ){
		
		$prefix = WOO_VOU_META_PREFIX;
		
		// update pdf template to user meta
		if( isset( $_POST[ $prefix.'pdf_template' ] ) )
		update_user_meta( $user_id, $prefix.'pdf_template', $_POST[ $prefix.'pdf_template' ] );
		
		// update pdf template to user meta
		if( isset( $_POST[ $prefix.'using_type' ] ) )
		update_user_meta( $user_id, $prefix.'using_type', $_POST[ $prefix.'using_type' ] );
		
		// update vendor address to user meta
		if( isset( $_POST[ $prefix.'address_phone' ] ) )
		update_user_meta( $user_id, $prefix.'address_phone', trim ( $this->model->woo_vou_escape_slashes_deep ( $_POST[ $prefix.'address_phone' ] ) ) );
		
		// update vendor address to user meta
		if( isset( $_POST[ $prefix.'siteurl_text' ] ) )
		update_user_meta( $user_id, $prefix.'website', trim ( $this->model->woo_vou_escape_slashes_deep ( $_POST[ $prefix.'siteurl_text' ] ) ) );
		
		// update vendor logo to user meta
		if( isset( $_POST[ $prefix.'logo' ] ) )
		update_user_meta( $user_id, $prefix.'logo', $_POST[ $prefix.'logo' ] );
		
		// update vendor Redeem Instructions to user meta
		if( isset( $_POST[ $prefix.'how_to_use' ] ) )
		update_user_meta( $user_id, $prefix.'how_to_use', trim ( $this->model->woo_vou_escape_slashes_deep ( $_POST[ $prefix.'how_to_use' ] ) ) );
		
		//update location and map links
		$availlocations = array();
		if( isset( $_POST[$prefix.'locations'] ) ) {
			
			$locations = $_POST[$prefix.'locations'];
			$maplinks = $_POST[$prefix.'map_link'];
			for ( $i = 0; $i < count( $locations ); $i++ ){
				if( !empty( $locations[$i] ) || !empty( $maplinks[$i])) { //if location or map link is not empty then
					$availlocations[$i][$prefix.'locations'] = $this->model->woo_vou_escape_slashes_deep( $locations[$i], true, true );
					$availlocations[$i][$prefix.'map_link'] = $this->model->woo_vou_escape_slashes_deep( $maplinks[$i] );
				}
			}
		}
		
		//update location and map links
		update_user_meta( $user_id, $prefix. 'avail_locations', $availlocations );
		
	}
	
	 
	/**
	 * Adding Hooks
	 *
	 * @package WooCommerce - PDF Vouchers
	 * @since 1.0.0
	 */
	public function add_hooks() {
		
		if(woo_vou_is_edit_page()) {
				
			//add content for import voucher codes in footer
			add_action( 'admin_footer', array($this, 'woo_vou_import_footer') );
		}
		
		//add filter to add settings
		add_filter( 'woocommerce_general_settings', array( $this->model, 'woo_vou_settings') );
		
		//add action to import csv file for codes with Ajaxform
		add_action ( 'init',  array( $this, 'woo_vou_import_codes' ) );
		
		//add submenu page
		add_action( 'admin_menu', array( $this, 'woo_vou_admin_submenu' ) );
		
		//AJAX action for import code
		add_action( 'wp_ajax_woo_vou_import_code', array( $this, 'woo_vou_import_code') );
		add_action( 'wp_ajax_nopriv_woo_vou_import_code', array( $this, 'woo_vou_import_code') );
		
		//add new field to voucher listing page
		add_action( 'manage_'.WOO_VOU_POST_TYPE.'_posts_custom_column', array( $this, 'woo_vou_manage_custom_column' ), 10, 2 );
		add_filter( 'manage_edit-'.WOO_VOU_POST_TYPE.'_columns', array( $this, 'woo_vou_add_new_columns' ) );
		
		//add action to add custom metaboxes on voucher template post type
		add_action( 'add_meta_boxes', array( $this, 'woo_vou_editor_meta_box' ) );	
		
		//saving voucher meta on update or publish voucher template post type
		add_action( 'save_post', array( $this, 'woo_vou_save_metadata' ) );
		
		//ajax call to edit all controls
		add_action( 'wp_ajax_woo_vou_page_builder', array( $this->render, 'woo_vou_page_builder') );
		add_action( 'wp_ajax_nopriv_woo_vou_page_builder', array( $this->render, 'woo_vou_page_builder' ) );
		
		//add filter to add new action "duplicate" on admin vouchers page
		add_filter( 'post_row_actions', array( $this , 'woo_vou_dupd_action_new_link_add' ), 10, 2 );
		
		//add action to add preview button after update button
		add_action( 'post_submitbox_start', array( $this, 'woo_vou_add_preview_button' ) ); 
		
		//add action to create duplicate voucher
		add_action( 'admin_init', array( $this, 'woo_vou_duplicate_process' ) );
		
		//add filter to display vouchers by menu order with ascending order
		add_filter( 'posts_orderby', array( $this, 'woo_vou_edit_posts_orderby' ) );
		
		// add metabox in products
		add_action( 'woocommerce_product_write_panel_tabs', array( $this->voumeta, 'woo_vou_product_write_panel_tab' ) );
		add_action( 'woocommerce_product_write_panels',     array( $this->voumeta, 'woo_vou_product_write_panel') );
		add_action( 'woocommerce_process_product_meta',     array( $this, 'woo_vou_product_save_data' ), 20, 2 );
		
		// Add a custom field types
		add_action( 'woocommerce_admin_field_filename', array( $this->render, 'woo_vou_render_filename_callback' ) );
		add_action( 'woocommerce_admin_field_upload', array( $this->render, 'woo_vou_render_upload_callback' ) );
		add_action( 'woocommerce_admin_field_bigtext', array( $this->render, 'woocommerce_admin_field_bigtext' ) );
		
		// save custom field types
		add_action( 'woocommerce_update_option_filename', array( $this->render, 'woo_vou_save_filename_field' ) );
		add_action( 'woocommerce_update_option_upload', array( $this->render, 'woo_vou_save_upload_field' ) );
		add_action( 'woocommerce_update_option_bigtext', array( $this->render, 'woo_vou_save_bigtext_field' ) );
		
		//add action to display voucher history
		add_action( 'add_meta_boxes', array( $this, 'woo_vou_order_meta_boxes' ), 35 );
		
		//add action to delete order meta when woocommerce order delete
		add_action( 'before_delete_post', array( $this, 'woo_vou_order_delete' ) );		
		
		// add action to add an extra fields in edit user page
		add_action('edit_user_profile', array( $this, 'woo_vou_user_edit_profile_fields' ) );
		
		// add action to store user meta in database
		add_action('edit_user_profile_update', array( $this, 'woo_vou_update_profile_fields' ) );
	}
}
?>