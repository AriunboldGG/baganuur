<?php

if (!function_exists('baganuur_ut_header_visible')) {

    function baganuur_ut_header_visible() {

        $return = true;

        if ( baganuur_ut_acf_get_field('header_visible') === 'off' && baganuur_ut_core_check_metabox() ) {
            $return = false;
        }
        
        return $return;

    }

}

if (!function_exists('baganuur_ut_header_display_header')) {

    function baganuur_ut_header_display_header() {

        get_template_part('backend/partials/header/header', 'layout5');

    }

}