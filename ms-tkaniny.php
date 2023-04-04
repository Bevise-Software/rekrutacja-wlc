<?php

/**
 * Plugin Name:       Wybór tkanic
 * Author:            Piotr Pac
 * Description:       Moduł zarządzania tkaninami wybieranymi na stronie produktu.
 */


add_action('wp_enqueue_scripts', 'mst_scripts_register');
function mst_scripts_register()
{

    $plugin_url = plugin_dir_url(__FILE__);
    $ver_time = time();
    //styles
    wp_enqueue_style('mst_styles', $plugin_url . 'css/mst_styles.css', array(), $ver_time);


    //scripts
    wp_enqueue_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js', array(), null, true);
    wp_enqueue_script('mst_scripts', plugin_dir_url(__FILE__) . 'js/mst_scripts.js', array(), $ver_time, true);
} //mst_scripts_register()


//classes
include_once 'classes/Tkanina-class.php';


//includes
include_once 'includes/mst-single-product-tkanina-info.php';
include_once 'includes/mst-szelf-footer.php';
include_once 'includes/mst-tkaniny-in-shelf.php';
include_once 'includes/mst-tkanina-info-to-cart.php';
include_once 'includes/mst-price-calculator.php';
include_once 'includes/mst-custom-validation.php';
include_once 'includes/mst-single-product-price-display.php';
