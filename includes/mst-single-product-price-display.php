<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

add_action('woocommerce_before_add_to_cart_button', 'mst_tkanina_display_price_addition');
function mst_tkanina_display_price_addition()
{
    ?>
    <p style="display:none;">display_price_addition: <input type="text" name="display_price_addition"></p>
    <?php
} //mst_tkanina_display_price_addition()



add_action('woocommerce_before_add_to_cart_button', 'mst_fake_price_displayed',5);
function mst_fake_price_displayed(){
    ?>
    <div class="mst_fake_price">    </div>
    <?php
}//mst_fake_price_displayed()

