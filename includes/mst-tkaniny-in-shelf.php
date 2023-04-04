<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

add_action('mst_side_shelf', 'mst_shelf_close_button', 5);
function mst_shelf_close_button()
{
?>
    <div class="mst_close_button">
        <span>X Zamknij</span>
    </div>
<?php
} //mst_shelf_close_button()





add_action('mst_side_shelf', 'mst_shelf_head', 10);
function mst_shelf_head()
{
?>
    <h3>Wybierz tkaninę</h3>
<?php
} //mst_head_title()


add_action('mst_side_shelf', 'mst_tkaniny_groups', 20);
function mst_tkaniny_groups()
{

    $groups = get_field('grupa_tkanin');
    if (!$groups) return;
?>
    <div class="top_bar_groups_contener">
        <?php
        mst_top_bar_groups($groups);
        ?>
    </div>

    <div class="mst_tkaniny_list_contener">
        <h4>Wybierz tkaninę i jej kolor.</h4>
        <p>Więcej informacji o tkaninach znajdziesz na <a href="/tkaniny/">Tkaniny</a>.</p>
        <div class="mst_tkaniny_list_wrapper">

            <?php mst_tkaniny_list(0,get_the_ID()) ?>
        </div>
    </div>

<?php
} //mst_tkaniny_groups()


function mst_top_bar_groups($groups)
{
    if (!$groups) return;

?>
    <div class="top_bar_groups_wrapper">
        <?php
        foreach ($groups as $index => $group) :
            $group_name = $group['nazwa_grupy'];
            $group_price = $group['cena_takanin_w_grupie'];
            $checked = ($index < 1) ? 'checked' : '';
        ?>
        <label>
            <input type="radio" name="group" value="<?php echo $index ?>" <?php echo $checked ?> price="<?php echo $group_price ?>">
            <div class="mst_bar_group_button" group="<?php echo $index ?>">
                <p class="title"><?php echo $group_name ?></p>
                <p class="price"><?php echo $group_price ?> zł</p>
            </div>
        </label>
        <?php

        endforeach;
        ?>
    </div>
    <?php

} //mst_top_bar_groups()





function mst_tkaniny_list($index,$product_id)
{

    $groups = get_field('grupa_tkanin',$product_id);
    if (!$groups) return;

    $group = $groups[$index];

    if (!$group['tkaniny']) return;
    foreach ($group['tkaniny'] as $index => $tkanina_id) :
        $Tkanina = new Tkanina($tkanina_id);
    ?>
        <div class="mst_tkanina_contner">
            <h3><?php echo $Tkanina->name ?> <a href="<?php echo $Tkanina->link ?>" class="more-about-link" target="_blank" rel="noopener">Więcej o tej tkaninie &#10148;</a></h3>
            <div class="mst_tkanina_excerpt"><?php echo $Tkanina->excerpt; ?></div>
            <div class="mst_tkanina_colors_wrapper">
<?php
    foreach($Tkanina->colors as $color_index => $color):
        ?>
    <label class="color-item">
        <input type="radio" name="color" value="<?php echo $index.'-'.$color_index ?>">
        <div class="mst_color_box">
            <img src="<?php echo $color['zdjecie'] ?>">
            <span><?php echo $color['nazwa'] ?></span>
        </div>
</label>
        <?php
    endforeach;
    

?>
            </div>
        </div>
<?php
        if ($index != array_key_last($group['tkaniny'])) echo '<hr>';

    endforeach;
}//mst_tkaniny_list()




// mst_ajax_get_group
add_action('wp_ajax_mst_ajax_get_group', 'mst_ajax_get_group');
add_action('wp_ajax_nopriv_mst_ajax_get_group', 'mst_ajax_get_group');
function mst_ajax_get_group(){
	global $wpdb;
	$group_index = $_POST['group'];
	$product_id = $_POST['product_id'];

    
	echo mst_tkaniny_list($group_index,$product_id);
 
    
	wp_die();
	
}//koniec mst_ajax_get_group