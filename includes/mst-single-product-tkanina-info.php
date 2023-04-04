<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}


add_action('woocommerce_before_add_to_cart_form', 'mst_single_product_choose_tkanina_button', 10);
function mst_single_product_choose_tkanina_button()
{
?>
    <div class="mst_button_wrapper">
        <button class="msw_wybierz_tkanine">Wybierz tkaninę</button>
    </div>
<?php

} //meble_splendor_tkaniny()

add_action('woocommerce_before_add_to_cart_form', 'mst_single_product_choosen_tkanina_info', 20);
function mst_single_product_choosen_tkanina_info()
{
?>
    <div class="mst_choosen_wrapper">
        <div class="tkanina-title">Tkanina</div>
        <div>
            <p class="group"><span class="group-name">GGG</span> <span class="group-price">$$$</span></p>
            <p class="tkanina">
                <img class="zdjecie" src="link"> <span class="name">TTT</span>
            </p>
        </div>
    </div>
<?php
}//mst_single_product_choosen_tkanina_info()