<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}


add_action('woocommerce_before_add_to_cart_button', 'mst_calc_cart_form_inputs');
function mst_calc_cart_form_inputs()
{
?>
    <p style="display:none;">group: <input type="text" name="mst_calc_group"></p>
<?php
} //mst_calc_cart_form_inputs()


add_filter('woocommerce_add_cart_item_data', 'mst_tkanina_calc_group_to_cart_item_data', 10, 3);
function mst_tkanina_calc_group_to_cart_item_data($cart_item_data, $product_id, $variation_id)
{

    $group_index = filter_input( INPUT_POST, 'mst_calc_group' );

	if ( empty( $group_index )  && $group_index != '0') {
		return $cart_item_data;
	}

	$cart_item_data['mst_calc_group'] = $group_index;
      
    return $cart_item_data;
} //koniec mst_tkanina_calc_group_to_cart_item_data()





// Change the product price
add_action('woocommerce_before_calculate_totals', 'action_before_calculate_totals_callback', 10, 1);
function action_before_calculate_totals_callback($cart)
{
    /* if ( is_admin() && ! defined( 'DOING_AJAX' ) )
        return;*/

    // Avoiding hook repetition and price calculation problems
    if (did_action('woocommerce_before_calculate_totals') >= 2)
        return;

    // Loop through cart items
    foreach ($cart->get_cart() as $cart_item) {
        $cart_item;
        if (isset($cart_item['mst_calc_group'])) {
            // Set the calculated price
            $group_price = mst_get_group_price_by_group_index($cart_item['mst_calc_group'],$cart_item['product_id']);
            $cart_item['data']->set_price($cart_item['data']->get_price() + $group_price);
        } else {
            $cart_item['data']->set_price($cart_item['data']->get_price());
        } //koniec ifa
    }
}


function mst_get_group_price_by_group_index($index,$prod_id)
{
    $groups = get_field('grupa_tkanin',$prod_id);
    if (!$groups) return false;

    $group_price = $groups[$index]['cena_takanin_w_grupie'];

    return (int)$group_price;
} //mst_get_group_price_by_group_index()