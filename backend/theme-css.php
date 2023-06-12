<?php
/*
  The PHP file contains custom CSS on our theme.

 * Website Content Configuration
 * Add classes to body class
 * Custom CSS Generate
 */

/*
  Custom CSS Generate

 */

add_action('wp_head', 'baganuur_ut_option_styles', 100);

if (!function_exists('baganuur_ut_option_styles')) {

    function baganuur_ut_option_styles() {
        ?>
        <style type="text/css" id="baganuur-ut-inline-css">
        <?php
        /*
          Functions

         * Primary Color
         * Header Style
         */

        $primary_color = baganuur_ut_get_primary_color();
        $header_border_height = 1;

        /*
          Theme Options Fonts

         */

        /*
          Variables without metabox

         */
        
        $body_color = baganuur_ut_get_options(BAGANUUR_UT_T_OPTIONS . 'body_color');
        $body_bg_color = baganuur_ut_get_options(BAGANUUR_UT_T_OPTIONS . 'body_bg_color');
        $img_overlay_color = baganuur_ut_get_options(BAGANUUR_UT_T_OPTIONS . 'img_overlay_color');
        $img_overlay_color_opacity = baganuur_ut_get_options(BAGANUUR_UT_T_OPTIONS . 'img_overlay_color_opacity');

        $heading_title_color = baganuur_ut_get_options(BAGANUUR_UT_T_OPTIONS . 'heading_title_color');
        $widget_title_color = baganuur_ut_get_options(BAGANUUR_UT_T_OPTIONS . 'widget_title_color');

        $header_light_color = baganuur_ut_get_options(BAGANUUR_UT_T_OPTIONS . 'header_light_color');
        $header_dark_color = baganuur_ut_get_options(BAGANUUR_UT_T_OPTIONS . 'header_dark_color');

        /*
          Collect Theme CSS Data

         * Array Elements:
         * * ltc_height
         * * ltc_small_height
         * * hwh_height
         * * hwh_small_height
         */

        ?>
                                
        /*---------- Core ----------*/

        /* Header background CSS */

        /* pseudo code */
        input.wpcf7-form-control.wpcf7-text::-moz-placeholder,
        textarea.wpcf7-form-control.wpcf7-textarea::-moz-placeholder {
            font-family: <?php echo esc_attr($bf_data['font-family']); ?>;
        }
        </style>
        <?php
    }

}

/*
  Add classes to body class

 */

add_filter('body_class', 'baganuur_ut_class');
if (!function_exists('baganuur_ut_class')) {

    function baganuur_ut_class($classes) {

        global $post;
        
        $left_side_menu = 'header-leftside';

        $arr = array(
            $left_side_menu,
        );

        foreach ($arr as $el) {
            if (!empty($el)) {
                $classes[] = $el;
            }
        }

        $classes[] = "header-large";

        if ( baganuur_ut_core_check_singular() ) {
            $vc_enabled = get_post_meta(get_the_ID(), '_wpb_vc_js_status', true);
            if ($vc_enabled == 'true') {
                $classes[] = "baganuur-ut-composer";
            }
        }

        return $classes;
    }

}

/*
  Theme custom css

 */

add_action('wp_head', 'baganuur_ut_custom_css', 100);
if (!function_exists('baganuur_ut_custom_css')) {

    function baganuur_ut_custom_css() {
        $custom_css = baganuur_ut_get_options(BAGANUUR_UT_T_OPTIONS . 'custom_css');?>
        <?php if ($custom_css !== '') {?>
            <style type="text/css" id="baganuur-ut-custom-css">
            <?php echo balanceTags($custom_css); ?>
            </style><?php
        }
    }

}