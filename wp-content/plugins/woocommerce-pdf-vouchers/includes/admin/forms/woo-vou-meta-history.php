<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

global $woo_vou_model,$post;

//model class
$model = $woo_vou_model;
$payment_id = $post->ID;

$orderdata = $model->woo_vou_get_post_meta_ordered( $payment_id );
$allorderdata = $model->woo_vou_get_all_ordered_data( $payment_id );

$cart_details 	= new Wc_Order( $payment_id );
$order_items = $cart_details->get_items();

$prefix = WOO_VOU_META_PREFIX;
			
// Check Voucher is enable and cart details are not empty
if( !empty( $orderdata ) && !empty( $order_items ) ) {
	
?>
	<table class="widefat woo-vou-history-table">
		<tr class="woo-vou-history-title-row">
			<th width="8%"><?php _e( 'Logo', 'woovoucher' ); ?></th>
			<th width="17%"><?php _e( 'Product Title', 'woovoucher' ); ?></th>
			<th width="15%"><?php _e( 'Code', 'woovoucher' ); ?></th>
			<th width="45%"><?php _e( 'Voucher Data', 'woovoucher' ); ?></th>
			<th width="10%"><?php _e( 'Expires', 'woovoucher' ); ?></th>
			<th width="5%"><?php _e( 'Qty', 'woovoucher' ); ?></th>
		</tr>
		<?php
			foreach ( $order_items as $download_data_id => $download_data ) {
				
				$download_id = $download_data['product_id'];
				
				// If product is variable product take variation id else product id
				$data_id = ( !empty($download_data['variation_id']) ) ? $download_data['variation_id'] : $download_id;
				
				//vouchers data of pdf
				$voucherdata 	= isset( $orderdata[$data_id] ) ? $orderdata[$data_id] : array();
				
				//get all voucher details from order meta
				$allvoucherdata = isset( $allorderdata[$download_id] ) ? $allorderdata[$download_id] : array();
				
				if( !empty( $voucherdata ) ) { // Check Voucher Data are not empty
		?>
		<tr>
			<td class="woo-vou-history-td"><img src="<?php echo $allvoucherdata['vendor_logo']['src'] ?>" alt="" width="70" height="30" /></td>
			<td class="woo-vou-history-td">
				<?php
					echo $download_data['name'];
					
					// If order item has meta
					if( $metadata = $cart_details->has_meta( $download_data_id ) ) {
						foreach ( $metadata as $item_meta ) {
							
							// Skip hidden core fields
							if ( in_array( $item_meta['meta_key'], array(
								'_qty',
								'_tax_class',
								'_product_id',
								'_variation_id',
								'_line_subtotal',
								'_line_subtotal_tax',
								'_line_total',
								'_line_tax',
								'_line_tax_data'
							) ) ) {
								continue;
							}
							
							// Skip serialised meta
							if ( is_serialized( $item_meta['meta_key'] ) ) {
								continue;
							}
							
							echo '<div>'.'<b>'.ucfirst($item_meta['meta_key']).': </b> '.$item_meta['meta_value'].'</div>';
							
						} // End of foreach
					}
				?>
			</td>
			<td class="woo-vou-history-td"><?php echo $voucherdata['codes']; ?></td>
			<td class="woo-vou-history-td">
				<p><strong><?php _e( 'Vendor\'s Address', 'woovoucher' ); ?></strong></p>
				<p><?php echo !empty( $allvoucherdata['vendor_address'] ) ? nl2br( $allvoucherdata['vendor_address'] ) : __( 'N/A', 'woovoucher' ); ?></p>
				<p><strong><?php _e( 'Site URL', 'woovoucher' ); ?></strong></p>
				<p><?php echo !empty( $allvoucherdata['website_url'] ) ? $allvoucherdata['website_url'] : __( 'N/A', 'woovoucher' ); ?></p>
				<p><strong><?php _e( 'Redeem Instructions', 'woovoucher' ); ?></strong></p>
				<p><?php echo !empty( $allvoucherdata['redeem'] ) ? nl2br( $allvoucherdata['redeem'] ) : __( 'N/A', 'woovoucher' ); ?></p>
			<?php
				if( !empty( $allvoucherdata['avail_locations'] ) ) {

					echo '<p><strong>' . __( 'Locations', 'woovoucher' ) . '</strong></p>';
			
					foreach ( $allvoucherdata['avail_locations'] as $location ) {
			
						if( !empty( $location[$prefix.'locations'] ) ) {
						
							if( !empty( $location[$prefix.'map_link'] ) ) {
								echo '<p><a target="_blank" style="text-decoration: none;" href="' . $location[$prefix.'map_link'] . '">' . $location[$prefix.'locations'] . '</a></p>';
							} else {
								echo '<p>' . $location[$prefix.'locations'] . '</p>';
							}
						}
					}
				}
			?>
			</td>
			<td class="woo-vou-history-td"><?php echo !empty( $allvoucherdata['exp_date'] ) ? $model->woo_vou_get_date_format( $allvoucherdata['exp_date'] ) : __( 'N/A', 'woovoucher' ); ?></td>
			<td class="woo-vou-history-td"><?php echo $download_data['qty']; ?></td>
		</tr>
		<?php } } ?>
	</table>
<?php } ?>