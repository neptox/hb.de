<?php
/**
 * Cart Page
 *
 * @author 		WooThemes, ap
 * @package 	WGM/templates/woocommerce
 * @version     2.1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce;

wc_print_notices();

do_action( 'woocommerce_before_cart' );

// Enable or disable taxes
$showTaxes = apply_filters( 'woocommerce_de_print_including_tax', true );
$showTaxes = $showTaxes && get_option( WGM_Helper::get_wgm_option( 'woocommerce_de_kleinunternehmerregelung' ), 'off' ) == 'off';
?>

    <form action="<?php echo esc_url( WC()->cart->get_cart_url() ); ?>" method="post">

        <?php do_action( 'woocommerce_before_cart_table' ); ?>

        <table class="shop_table cart" cellspacing="0">
            <thead>
            <tr>
                <th class="product-remove">&nbsp;</th>
                <th class="product-thumbnail">&nbsp;</th>
                <th class="product-name"><?php _e( 'Product', 'woocommerce' ); ?></th>
                <th class="product-price"><?php _e( 'Price', 'woocommerce' ); ?></th>
                <th class="product-quantity"><?php _e( 'Quantity', 'woocommerce' ); ?></th>
                <th class="product-subtotal"><?php _e( 'Total', 'woocommerce' ); ?></th>

                <?php

                if ( $showTaxes ) {

                    if( get_option('woocommerce_tax_display_cart') == 'excl' ) {
                        $tax_incl = false;
                        ?><th class="product-tax"><?php _e('zusätzliche MwSt.', 'WooCommerce-German-Market') ?></th> <?php
                    } else {
                        $tax_incl = true;
                        ?><th class="product-tax"><?php _e('enthaltene MwSt.', 'WooCommerce-German-Market') ?></th>	<?php
                    }
                }
                ?>

            </tr>
            </thead>
            <tbody>
            <?php do_action( 'woocommerce_before_cart_contents' ); ?>

            <?php
            foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
                $_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
                $product_id   = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

                if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
                    ?>
                    <tr class="<?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">

                        <td class="product-remove">
                            <?php
                            echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf( '<a href="%s" class="remove" title="%s">&times;</a>', esc_url( WC()->cart->get_remove_url( $cart_item_key ) ), __( 'Remove this item', 'woocommerce' ) ), $cart_item_key );
                            ?>
                        </td>

                        <td class="product-thumbnail">
                            <?php
                            $thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );

                            if ( ! $_product->is_visible() )
                                echo $thumbnail;
                            else
                                printf( '<a href="%s">%s</a>', add_query_arg( $cart_item['variation'], $_product->get_permalink() ), $thumbnail );
                            ?>
                        </td>

                        <td class="product-name">
                            <?php
                            if ( ! $_product->is_visible() )
                                echo apply_filters( 'woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key );
                            else
                                echo apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', ( is_array( $cart_item['variation'] ) ? add_query_arg( $cart_item['variation'], $_product->get_permalink() ) : $_product->get_permalink() ), $_product->get_title() ), $cart_item, $cart_item_key );

                            // Meta data
                            echo WC()->cart->get_item_data( $cart_item );

                            // Backorder notification
                            if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) )
                                echo '<p class="backorder_notification">' . __( 'Available on backorder', 'woocommerce' ) . '</p>';
                            ?>
                        </td>

                        <td class="product-price">
                            <?php
                            echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
                            ?>
                        </td>

                        <td class="product-quantity">
                            <?php
                            if ( $_product->is_sold_individually() ) {
                                $product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
                            } else {
                                $product_quantity = woocommerce_quantity_input( array(
                                    'input_name'  => "cart[{$cart_item_key}][qty]",
                                    'input_value' => $cart_item['quantity'],
                                    'max_value'   => $_product->backorders_allowed() ? '' : $_product->get_stock_quantity(),
                                ), $_product, false );
                            }

                            echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key );
                            ?>
                        </td>

                        <td class="product-subtotal">
                            <?php
                            echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key );
                            ?>
                        </td>

                        <?php if ($showTaxes): ?>
                            <td class="product-tax">
                                <?php
                                $tax = @array_shift( array_values( $woocommerce->cart->tax->get_rates( $_product->tax_class ) ) );
                                echo wc_price( $cart_item['line_subtotal_tax'] ) . ' (' . round( $tax[ 'rate' ], 1 ) . '%)';
                                ?>
                            </td>
                        <?php endif; ?>

                    </tr>
                <?php
                }
            }

            do_action( 'woocommerce_cart_contents' );
            ?>
            <tr>
                <td colspan="<?php echo apply_filters( 'wgm_cart_colspan_value', 7 ); ?>" class="actions">

                    <?php if ( WC()->cart->coupons_enabled() ) { ?>
                        <div class="coupon">

                            <label for="coupon_code"><?php _e( 'Coupon', 'woocommerce' ); ?>:</label> <input name="coupon_code" class="input-text" id="coupon_code" value="" /> <input type="submit" class="button" name="apply_coupon" value="<?php _e( 'Apply Coupon', 'woocommerce' ); ?>" />

                            <?php do_action('woocommerce_cart_coupon'); ?>

                        </div>
                    <?php } ?>

                    <input type="submit" class="button" name="update_cart" value="<?php _e( 'Update Cart', 'woocommerce' ); ?>" /> <input type="submit" class="checkout-button button alt wc-forward" name="proceed" value="<?php _e( 'Proceed to Checkout', 'woocommerce' ); ?>" />

                    <?php do_action('woocommerce_proceed_to_checkout'); ?>

                    <?php wp_nonce_field( 'woocommerce-cart') ?>
                </td>
            </tr>

            <?php do_action( 'woocommerce_after_cart_contents' ); ?>
            </tbody>
        </table>

        <?php do_action( 'woocommerce_after_cart_table' ); ?>

    </form>

    <div class="cart-collaterals">

        <?php do_action('woocommerce_cart_collaterals'); ?>

        <?php woocommerce_cart_totals(); ?>

        <?php woocommerce_shipping_calculator(); ?>

    </div>

<?php do_action( 'woocommerce_after_cart' ); ?>