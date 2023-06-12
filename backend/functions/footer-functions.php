<?php

/*
  Footer Copyright Text Field

 */

if (!function_exists('baganuur_ut_footer_get_copyright_text')) {

    function baganuur_ut_footer_get_copyright_text() {
        
        return baganuur_ut_get_options(BAGANUUR_UT_T_OPTIONS . 'copyright_text');

    }

}