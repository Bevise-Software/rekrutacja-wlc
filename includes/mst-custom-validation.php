<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

add_filter('woocommerce_add_to_cart_validation', 'mst_custom_fields_validation', 10, 5);

function mst_custom_fields_validation($passed)
{
    if (empty($_REQUEST['mst_calc_group']) || empty($_REQUEST['tkanina_name'])) {
        wc_add_notice('Wybierz tkaninę by kontynuować zamówienie.', 'error');
        $passed = false;
    }


    return $passed;
}//mst_custom_fields_validation()
