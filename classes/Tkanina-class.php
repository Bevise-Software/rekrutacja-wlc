<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


class Tkanina {

    function __construct($post_id)
    {
        // $this->post_id = $post_id;
        $this->name = $this->get_name($post_id);
        $this->excerpt = $this->get_excerpt($post_id);
        $this->link = $this->get_link($post_id);
        $this->colors = $this->get_colors($post_id);
    }



    function get_name($id){
        return get_the_title($id);
    }

    function get_link($id){
        return get_the_permalink($id);
    }

    function get_colors($id){
        return get_field('kolory',$id);
    }

    function get_excerpt($id){
        return get_field('zajawka',$id);
    }






}// class Tkanina