jQuery(document).ready(function ($) {


    function bv_get_product_type() {

        if ($('body').hasClass('single-product')) {
            if($('article').hasClass('product-type-simple')){
                var type = 'simple';
            }
            if($('article').hasClass('product-type-variable')){
                var type = 'variable';
            }
        } else {
        return false;   
        }//if
        return type;

    }//bv_get_product_type()

    bv_get_product_type();

    $(document).on('open_mst_shelf', function () {
        $('#mst_footer_shelf').addClass('opened');
        $('#mst_shelf_bg').fadeIn('fast');
        $('body').addClass('no-scroll');
    });


    $(document).on('close_mst_shelf', function () {
        $('#mst_footer_shelf').removeClass('opened');
        $('#mst_shelf_bg').fadeOut('fast');
        $('body').removeClass('no-scroll');
    });



    $('.msw_wybierz_tkanine').click(function () {
        $(document).trigger('open_mst_shelf');
    });

    $('.mst_close_button, #mst_shelf_bg').click(function () {
        $(document).trigger('close_mst_shelf');
    });





    $('.mst_shelf_wrapper').on('mouseover', '.mst_tkanina_contner', function () {
        $(this).addClass('opened');
    });

    $('.mst_shelf_wrapper').on('mouseout', '.mst_tkanina_contner.opened', function () {
        $(this).removeClass('opened');
    });


    function mst_get_chosen_tkanina_data() {

        var $tkanina_checked = $('input[name="color"]:checked');

        var choosen_tkanina = {
            'group': $('input[name="group"]:checked').val(),
            'tkanina': $('input[name="color"]:checked').val(),
            'img': $tkanina_checked.closest('label.color-item').find('img').attr('src'),
            'name': $tkanina_checked.closest('label.color-item').find('span').text(),
            'price': $('input[name="group"]:checked').attr('price'),
        }

        return choosen_tkanina;

    }//mst_get_chosen_tkanina_data()



    // $('.color-item input').click(function () {
    $('.mst_shelf_wrapper').on('click', '.color-item input', function () {
        var $contener = $(this).closest('.mst_tkanina_contner');
        if (!$contener.hasClass('stay')) {
            $('.mst_tkanina_contner.stay').removeClass('stay');
            $contener.addClass('stay')
        }//if

        var choosen_tkanina = mst_get_chosen_tkanina_data();

        $(document).trigger('update_tkanina', [choosen_tkanina]);

    });//click




    $(document).on('update_tkanina', function (e, choosen_tkanina) {

        var $choosen_group = $('.mst_bar_group_button[group="' + choosen_tkanina.group + '"]');
        var group_name = $choosen_group.find('.title').text();
        var group_price = $choosen_group.find('.price').text();

        $('.mst_choosen_wrapper .group-name').text(group_name)
        $('.mst_choosen_wrapper .group-price').text(group_price)

        $('.mst_choosen_wrapper .name').text(choosen_tkanina.name);
        $('.mst_choosen_wrapper img.zdjecie').attr('src', choosen_tkanina.img);

        $('input[name="display_price_addition"]').val(choosen_tkanina.price);


        $(document).trigger('bv_variation_changed');


    });
    ``

    $(document).on('update_tkanina', function (e, choosen_tkanina) {

        $('input[name="tkanina_name"]').val(choosen_tkanina.name);
        $('input[name="mst_calc_group"]').val(choosen_tkanina.group);

    });



    function mst_start_check() {
        var group_calc = $('[name="mst_calc_group"]').val();
        if (group_calc) {
            $('.mst_bar_group_button[group="' + group_calc + '"]').trigger('click');
        }
        var input_calc = $('[name="tkanina_name"]').val();
        if (!input_calc) {
            $('input[value="0-0"]').trigger('click');
        }
    }




    function mst_check_color_checked() {
        var checked_color = $('input[name="tkanina_name"]').val();
        if (!checked_color) return false;

        $('.color-item span:contains(' + checked_color + ')').closest('.color-item').find('input').trigger('click');

    }//mst_check_color_checked()




    //ajax
    function mst_group_ajax_output(group_index) {

        var $miejsce = $('.mst_tkaniny_list_wrapper');

        var ajax_data = {
            action: 'mst_ajax_get_group',
            group: group_index,
            product_id: $('article').attr('id').replace('post-', ''),
        };//koniec ajax_data

        $.post(
            '/wp-admin/admin-ajax.php',
            ajax_data,
            function (response) {
                // console.log(response);
                $miejsce.html(response);
                mst_check_color_checked();
            }//koniec response
        );//koniec $.post

    }//mst_group_ajax_output()



    $('.mst_bar_group_button').click(function () {
        var group_index = $(this).attr('group');
        mst_group_ajax_output(group_index);
    });


    mst_start_check();


    $(document).on('bv_variation_changed', function (event) {
        mst_fake_price_populate_variable();
    });


    function mst_fake_price_populate_variable() {

        var currency = $('.woocommerce-Price-currencySymbol').first().text();
        var tkanina_price = parseFloat($('[name="display_price_addition"]').val());
        if (!tkanina_price) tkanina_price = 0;

        var sale_price = parseFloat($('.woocommerce-variation-price .price ins bdi').text().replace(',', '.'));

        if (sale_price) {
            sale_price = sale_price + tkanina_price;
            var regular_price = parseFloat($('.woocommerce-variation-price .price del bdi').text().replace(',', '.')) + tkanina_price;
            var price_html = '<del class="regular_price">' + regular_price + ' ' + currency + '</del> <span class="sale_price">' + sale_price + ' ' + currency + '</span>';
        } else {
            var regular_price = parseFloat($('.woocommerce-variation-price .price bdi').text().replace(',', '.')) + tkanina_price;
            var price_html = '<span class="regular_price">' + regular_price + ' ' + currency + '</span>';
        }
        $('.mst_fake_price').html(price_html);

    }//mst_fake_price_populate_variable()


    if(bv_get_product_type() == 'simple'){
        mst_fake_price_populate_simple();
    }

    function mst_fake_price_populate_simple() {

        var currency = $('.woocommerce-Price-currencySymbol').first().text();
        var tkanina_price = parseFloat($('[name="display_price_addition"]').val());
        if (!tkanina_price) tkanina_price = 0;

        var sale_price = parseFloat($('.entry-summary .price ins bdi').text().replace(',', '.'));

        if (sale_price) {
            sale_price = sale_price + tkanina_price;
            var regular_price = parseFloat($('.entry-summary .price del bdi').text().replace(',', '.')) + tkanina_price;
            var price_html = '<del class="regular_price">' + regular_price + ' ' + currency + '</del> <span class="sale_price">' + sale_price + ' ' + currency + '</span>';
        } else {
            var regular_price = parseFloat($('.entry-summary .price bdi').text().replace(',', '.')) + tkanina_price;
            var price_html = '<span class="regular_price">' + regular_price + ' ' + currency + '</span>';
        }
        $('.mst_fake_price').html(price_html);

    }//mst_fake_price_populate_simple()
  


});//jQuery