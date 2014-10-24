<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Purchased Voucher Code List Page
 *
 * The html markup for the purchased voucher code list
 * 
 * @package WooCommerce - PDF Vouchers
 * @since 1.0.0
 */


if( ! class_exists( 'WP_List_Table' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}
	
class WOO_Vou_List extends WP_List_Table {

	var $model,$render;
	
	function __construct(){
	
        global $woo_vou_model,$woo_vou_render;
                
        //Set parent defaults
        parent::__construct( array(
							            'singular'  => 'usedvou',   //singular name of the listed records
							            'plural'    => 'usedvous',  //plural name of the listed records
							            'ajax'      => false        //does this table support ajax?
							        ) );   
		
		$this->model = $woo_vou_model;
		$this->render = $woo_vou_render;
		
    }
    
    /**
	 * Displaying Prodcuts
	 *
	 * Does prepare the data for displaying the products in the table.
	 * 
	 * @package WooCommerce - PDF Vouchers
	 * @since 1.0.0
	 */	
	function display_purchased_vouchers() {
	
		global $current_user, $woo_vou_vendor_role;
		
		$prefix = WOO_VOU_META_PREFIX;
		
		$args = $data = array();
		
		$args['meta_query'] = array(
										array(
													'key' 		=> $prefix . 'purchased_codes',
													'value' 	=> '',
													'compare' 	=> '!='
												)
									);		
		
		//Current user role
		$user_roles	= isset( $current_user->roles ) ? $current_user->roles : array();
		$user_role	= array_shift( $user_roles );
		
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
		
		//get purchased voucher codes data from database
		$data = $this->model->woo_vou_get_voucher_details( $args );
		
		foreach ( $data as $key => $value ) {
			
			$data[$key]['ID'] 			= $value['ID'];
			$data[$key]['post_parent'] 	= $value['post_parent'];
			$data[$key]['code'] 		= get_post_meta( $value['ID'], $prefix.'purchased_codes', true );
			$data[$key]['first_name'] 	= get_post_meta( $value['ID'], $prefix.'first_name', true );
			$data[$key]['last_name'] 	= get_post_meta( $value['ID'], $prefix.'last_name', true );
			$data[$key]['buyers_name']  = $data[$key]['first_name'] . ' ' . $data[$key]['last_name'];
			$data[$key]['order_id'] 	= get_post_meta( $value['ID'], $prefix.'order_id', true );
			$data[$key]['order_date'] 	= get_post_meta( $value['ID'], $prefix.'order_date', true );
			$data[$key]['post_title'] 	= get_the_title( $value['post_parent'] );
		}
		return $data;
	}
	
	/**
	 * Mange column data
	 *
	 * Default Column for listing table
	 * 
	 * @package WooCommerce - PDF Vouchers
	 * @since 1.0.0
	 */
	function column_default( $item, $column_name ){
		
		global $current_user, $woo_vou_vendor_role;
		
		//Current user role
		$user_roles	= isset( $current_user->roles ) ? $current_user->roles : array();
		$user_role	= array_shift( $user_roles );
		
         switch( $column_name ){
            case 'code':
			case 'buyers_name' :
            	return $item[ $column_name ];
			case 'post_title' :
            	$page_url = add_query_arg( array( 'woo_vou_post_id' => $item[ 'post_parent' ] ) );
            	return '<a href="' . $page_url . '">' . $item[ $column_name ] . '</a>';
			case 'order_id' :
				if( in_array( $user_role, $woo_vou_vendor_role ) ) { // Check vendor user role
					return $item[ $column_name ];
				} else {
					$page_url = add_query_arg( array( 'post' => $item[ $column_name ], 'action' => 'edit' ), admin_url( 'post.php' ) );
	            	return '<a target="_blank" href="' . $page_url . '">' . $item[ $column_name ] . '</a>';
				}
			case 'order_date' :
				$datetime = $this->model->woo_vou_get_date_format($item[ $column_name ]);
            	return $datetime;	
            default:
				return $item[ $column_name ];
        }
    }
	       
    function column_cb($item){
        return sprintf(
            '<input type="checkbox" name="%1$s[]" value="%2$s" />',
            /*$1%s*/ $this->_args['singular'],  //Let's simply repurpose the table's singular label ("movie")
            /*$2%s*/ $item['ID']                //The value of the checkbox should be the record's id
        );
    }
    
    /**
     * Display Columns
     *
     * Handles which columns to show in table
     * 
	 * @package WooCommerce - PDF Vouchers
	 * @since 1.0.0
     */
	function get_columns(){
	
         $columns = array(
				            'code'			=>	__( 'Voucher Code', 'woovoucher' ),
				            'post_title'	=>	__(	'Product Title', 'woovoucher' ),
				            'buyers_name'	=>	__(	'Buyer\'s Name', 'woovoucher' ),
				            'order_date'	=>	__(	'Order Date', 'woovoucher' ),
				            'order_id'		=>	__(	'Order ID', 'woovoucher' ),
				        );
        return apply_filters('woo_vou_used_add_column',$columns);
    }
	
    /**
     * Sortable Columns
     *
     * Handles soratable columns of the table
     * 
	 * @package WooCommerce - PDF Vouchers
	 * @since 1.0.0
     */
	function get_sortable_columns() {
		
		
        $sortable_columns = array(
        								'code'			=>	array( 'code', true ),
							            'post_title'	=>	array( 'post_title', true ),     //true means its already sorted
							            'buyers_name'	=>	array( 'buyers_name', true ),
							            'order_date'	=>	array( 'order_date', true ),
							            'order_id'		=>	array( 'order_id', true ),  
						        );
        return apply_filters('woo_vou_used_add_sortable_column',$sortable_columns);
    }
	
	function no_items() {
		//message to show when no records in database table
		_e( 'No purchased voucher codes yet.', 'woovoucher' );
	}
	
	/**
     * Bulk actions field
     *
     * Handles Bulk Action combo box values
     * 
	 * @package WooCommerce - PDF Vouchers
	 * @since 1.0.0
     */
	function get_bulk_actions() {
		//bulk action combo box parameter
		//if you want to add some more value to bulk action parameter then push key value set in below array
        $actions = array();
        return $actions;
    }
    
    /**
	 * Add Filter for Sorting
	 * 
	 * Handles to add filter for sorting
	 * in listing
	 * 
	 * @package WooCommerce - PDF Vouchers
	 * @since 1.0.0
	 **/
    function extra_tablenav( $which ) {
    	
    	if( $which == 'top' ) {
				
			global $current_user, $woo_vou_vendor_role;
			
			$prefix = WOO_VOU_META_PREFIX;
			
			$args = array();
			
			$args['meta_query'] = array(
											array(
														'key'		=> $prefix.'purchased_codes',
														'value'		=> '',
														'compare'	=> '!=',
													)
										);
			
			//Current user role
			$user_roles	= isset( $current_user->roles ) ? $current_user->roles : array();
			$user_role	= array_shift( $user_roles );
			
			if( in_array( $user_role, $woo_vou_vendor_role ) ) { // Check vendor user role
				$args['author'] = $current_user->ID;
			}
			
    		$products_data = $this->model->woo_vou_get_products_by_voucher( $args );
    		
    		echo '<div class="alignleft actions woo-vou-dropdown-wrapper">';
		?>
				<select id="woo_vou_post_id" name="woo_vou_post_id" class="chosen_select">
					<option value=""><?php _e( 'Show all products', 'woovoucher' ); ?></option>
		<?php
					if( !empty( $products_data ) ) {
						
						foreach ( $products_data as $product_data ) {
							
							echo '<option value="' . $product_data['ID'] . '" ' . selected( isset( $_GET['woo_vou_post_id'] ) ? $_GET['woo_vou_post_id'] : '', $product_data['ID'], false ) . '>' . $product_data['post_title'] . '</option>';
						}
					}
		?>
				</select>
		<?php
    		submit_button( __( 'Apply', 'woovoucher' ), 'button', false, false, array( 'id' => 'post-query-submit' ) );
			echo '</div>';
    	}
    }
    
	function prepare_items() {
        
		/**
         * First, lets decide how many records per page to show
         */
        $per_page = '10';
       
        /**
         * REQUIRED. Now we need to define our column headers. This includes a complete
         * array of columns to be displayed (slugs & titles), a list of columns
         * to keep hidden, and a list of columns that are sortable. Each of these
         * can be defined in another method (as we've done here) before being
         * used to build the value for our _column_headers property.
         */
        $columns = $this->get_columns();
        $hidden = array();
        $sortable = $this->get_sortable_columns();
        
        
        /**
         * REQUIRED. Finally, we build an array to be used by the class for column 
         * headers. The $this->_column_headers property takes an array which contains
         * 3 other arrays. One for all columns, one for hidden columns, and one
         * for sortable columns.
         */
        $this->_column_headers = array($columns, $hidden, $sortable);
        
         /**
         * Optional. You can handle your bulk actions however you see fit. In this
         * case, we'll handle them within our package just to keep things clean.
         */
        //$this->process_bulk_action();
        
        /**
         * Instead of querying a database, we're going to fetch the example data
         * property we created for use in this plugin. This makes this example 
         * package slightly different than one you might build on your own. In 
         * this example, we'll be using array manipulation to sort and paginate 
         * our data. In a real-world implementation, you will probably want to 
         * use sort and pagination data to build a custom query instead, as you'll
         * be able to use your precisely-queried data immediately.
         */
		$data = $this->display_purchased_vouchers();
		
        
        /**
         * This checks for sorting input and sorts the data in our array accordingly.
         * 
         * In a real-world situation involving a database, you would probably want 
         * to handle sorting by passing the 'orderby' and 'order' values directly 
         * to a custom query. The returned data will be pre-sorted, and this array
         * sorting technique would be unnecessary.
         */
        function usort_reorder($a,$b){
            $orderby = (!empty($_REQUEST['orderby'])) ? $_REQUEST['orderby'] : 'ID'; //If no sort, default to title
            $order = (!empty($_REQUEST['order'])) ? $_REQUEST['order'] : 'desc'; //If no order, default to asc
            $result = strcmp($a[$orderby], $b[$orderby]); //Determine sort order
            return ($order==='asc') ? $result : -$result; //Send final sort direction to usort
        }
        usort($data, 'usort_reorder');
       
                
        /**
         * REQUIRED for pagination. Let's figure out what page the user is currently 
         * looking at. We'll need this later, so you should always include it in 
         * your own package classes.
         */
        $current_page = $this->get_pagenum();
        
        /**
         * REQUIRED for pagination. Let's check how many items are in our data array. 
         * In real-world use, this would be the total number of items in your database, 
         * without filtering. We'll need this later, so you should always include it 
         * in your own package classes.
         */
        $total_items = count($data);
        
        
        /**
         * The WP_List_Table class does not handle pagination for us, so we need
         * to ensure that the data is trimmed to only the current page. We can use
         * array_slice() to 
         */
        $data = array_slice($data,(($current_page-1)*$per_page),$per_page);        
        
        
        /**
         * REQUIRED. Now we can add our *sorted* data to the items property, where 
         * it can be used by the rest of the class.
         */
        $this->items = $data;
        
        
        /**
         * REQUIRED. We also have to register our pagination options & calculations.
         */
        $this->set_pagination_args( array(
									            'total_items' => $total_items,                  //WE have to calculate the total number of items
									            'per_page'    => $per_page,                     //WE have to determine how many items to show on a page
									            'total_pages' => ceil($total_items/$per_page)   //WE have to calculate the total number of pages
									        ) );
    }
    
}

global $current_user;

//Create an instance of our package class...
$WooPurchasedVouListTable = new WOO_Vou_List();
	
//Fetch, prepare, sort, and filter our data...
$WooPurchasedVouListTable->prepare_items();
		
?>

<div class="wrap">
   
    <?php 
    	//showing sorting links on the top of the list
    	$WooPurchasedVouListTable->views(); 
    ?>

    <!-- Forms are NOT created automatically, so you need to wrap the table in one to use features like bulk actions -->
    <form id="product-filter" method="get" action="">
        
    	<!-- For plugins, we also need to ensure that the form posts back to our current page -->
        <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
        
        <!-- Search Title -->
        <?php $WooPurchasedVouListTable->search_box( __( 'Search' ), 'woovoucher' ); ?>
        
        <div class="alignright">
			<?php
				$generatpdfurl = add_query_arg( array( 
														'woo-vou-voucher-gen-pdf'	=>	'1'
													));
				$exportcsvurl = add_query_arg( array( 
														'woo-vou-voucher-exp-csv'	=>	'1'
													));
			?>

			<a href="<?php echo $exportcsvurl; ?>" id="woo-vou-export-csv-btn" class="button-secondary woo-gen-pdf" title="<?php echo __('Export CSV','woovoucher'); ?>"><?php echo __("Export CSV",'woovoucher'); ?></a>
			<a href="<?php echo $generatpdfurl; ?>" id="woo-vou-pdf-btn" class="button-secondary" title="<?php echo __('Generate PDF','woovoucher'); ?>"><?php echo __("Generate PDF",'woovoucher'); ?></a>		
		
		</div>
        
        <!-- Now we can render the completed list table -->
        <?php $WooPurchasedVouListTable->display(); ?>
        
    </form>
	        
</div>