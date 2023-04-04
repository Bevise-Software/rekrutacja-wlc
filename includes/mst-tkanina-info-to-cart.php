<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}



add_action('woocommerce_before_add_to_cart_button', 'mst_tkanina_add_to_cart_form_input');
function mst_tkanina_add_to_cart_form_input()
{
?>
    <p style="display:none;">tkanina_name: <input type="text" name="tkanina_name"></p>
<?php
} //mst_tkanina_add_to_cart_form_input()




// Add selected add-on option as custom cart item data
add_filter('woocommerce_add_cart_item_data', 'mst_tkanina_to_cart_item_data', 10, 3);
function mst_tkanina_to_cart_item_data($cart_item_data, $product_id, $variation_id)
{

	$tkanina_name = filter_input( INPUT_POST, 'tkanina_name' );

	if ( empty( $tkanina_name )) {
		return $cart_item_data;
	}


    $cart_item_data['tkanina'] = $tkanina_name;
    
    return $cart_item_data;
} //koniec mst_tkanina_to_cart_item_data()





/**
 * Display tkanina in the cart.
 */
add_filter( 'woocommerce_get_item_data', 'mst_tkanina_display_in_cart', 10, 2 );
function mst_tkanina_display_in_cart( $item_data, $cart_item ) {
	if ( empty( $cart_item['tkanina'] ) ) {
		return $item_data;
	}

	$item_data[] = array(
		'key'     => 'Tkanina',
		'value'   => wc_clean( $cart_item['tkanina'] ),
		'display' => '',
	);

	return $item_data;
	
}//mst_tkanina_display_in_cart()



/**
 * Add tkanina to order.
 */
add_action( 'woocommerce_checkout_create_order_line_item', 'mst_tkanina_data_to_order_item', 10, 4 );
function mst_tkanina_data_to_order_item( $item, $cart_item_key, $values, $order ) {
	if ( empty( $values['tkanina'] ) ) {
		return;
	}

	$item->add_meta_data( 'Tkanina', $values['tkanina'] );
}//mst_tkanina_data_to_order_item()



