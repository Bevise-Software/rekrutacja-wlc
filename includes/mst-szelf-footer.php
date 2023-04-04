<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}




add_action('wp_footer', 'mst_side_shelf_output',20);
function mst_side_shelf_output()
{
?>
<div id="mst_shelf_bg"></div>
    <div id="mst_footer_shelf" class="mst_shelf_contener">
        <div class="mst_shelf_wrapper">
            <?php do_action('mst_side_shelf'); ?>
        </div>
    </div>
<?php
}//mst_side_shelf()


