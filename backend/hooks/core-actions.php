<?php
/*
  This PHP file contains Uniontheme core action.
 * Prefix: baganuur_ut_hook
 */

/*
  Header Hook action

 */

if (!function_exists('baganuur_ut_hook_header_default')) {
    function baganuur_ut_hook_header_default() {

        if ( !baganuur_ut_header_visible() ) {
            return;
        }

        //Display Header Layout
        baganuur_ut_header_display_header();

    }
}
add_action('baganuur_ut_hook_header', 'baganuur_ut_hook_header_default');