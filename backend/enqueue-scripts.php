<?php

/*
  Calling baganuur register scripts and styles

 */

add_action('wp_enqueue_scripts', 'baganuur_ut_scripts');
if (!function_exists('baganuur_ut_scripts')) {
    function baganuur_ut_scripts() {

        wp_enqueue_style('bootstrap', BAGANUUR_UT_THEME_DIR . '/frontend/css/bootstrap.min.css', array(), '3.3.5');
        wp_enqueue_style('baganuur-ut-base', BAGANUUR_UT_THEME_DIR . '/frontend/css/base.css', array(), BAGANUUR_UT_THEMEVERSION);
        wp_enqueue_style('baganuur-ut-core', BAGANUUR_UT_THEME_DIR . '/frontend/css/baganuur-ut.css', array(), BAGANUUR_UT_THEMEVERSION);
        wp_enqueue_style('baganuur-ut-menu', BAGANUUR_UT_THEME_DIR . '/frontend/css/menu.css', array(), BAGANUUR_UT_THEMEVERSION);
        
        wp_enqueue_style('font-awesome', BAGANUUR_UT_THEME_DIR . '/frontend/css/font-awesome.min.css', array(), '4.6.1');
        wp_enqueue_style('ionicons', BAGANUUR_UT_THEME_DIR . '/frontend/css/ionicons.min.css', array(), '2.0.0');
        wp_enqueue_style('animate', BAGANUUR_UT_THEME_DIR . '/frontend/css/animate.css', array(), '3.5.1');
        wp_enqueue_style('owl-carousel-transitions', BAGANUUR_UT_THEME_DIR . '/frontend/css/owl.carousel.min.css', array(), '2.2.1');
//        wp_enqueue_style('owl-carousel-transitions', BAGANUUR_UT_THEME_DIR . '/frontend/css/owl.transitions.css', array(), '1.3.2');
        wp_enqueue_style('baganuur-ut-responsive', BAGANUUR_UT_THEME_DIR . '/frontend/css/responsive.css', array(), BAGANUUR_UT_THEMEVERSION);
        wp_enqueue_style('baganuur-ut-prettyphoto', BAGANUUR_UT_THEME_DIR . '/frontend/css/pretty-photo.css', array(), '3.1.6');
        
        wp_enqueue_script( 'html5', BAGANUUR_UT_THEME_DIR . '/frontend/js/html5.js', array(), '3.6.0', true );
        wp_script_add_data( 'html5', 'conditional', 'lt IE 9' );
        if ( baganuur_ut_get_switch_result(BAGANUUR_UT_T_OPTIONS . 'smooth_scrolling') == 'on' ) {
            wp_enqueue_script('smoothscroll', BAGANUUR_UT_THEME_DIR . '/frontend/js/smoothscroll.js', array('jquery'), '0.9.9', true);
        }

        wp_register_script('owl-carousel', BAGANUUR_UT_THEME_DIR . '/frontend/js/owl.carousel.min.js', array(), '2.2.1', true);
//        wp_register_script('owl-carousel', BAGANUUR_UT_THEME_DIR . '/frontend/js/owl-carousel.min.js', array(), '1.3.3', true);
        // Isotop Need to Our Prefix, Because it's customized on our own!
        wp_register_script('baganuur-ut-isotope', BAGANUUR_UT_THEME_DIR . '/frontend/js/jquery.isotope.min.js', array(), '2.0.1', true);
        
        wp_enqueue_script('baganuur-ut-scripts', BAGANUUR_UT_THEME_DIR . '/frontend/js/scripts.js', array('jquery'), BAGANUUR_UT_THEMEVERSION, true);
        wp_enqueue_script('zepto-lazy', BAGANUUR_UT_THEME_DIR . '/frontend/js/jquery.lazy.min.js', array(), '1.7.4', true);
        wp_enqueue_script('baganuur-ut-mousewheel', BAGANUUR_UT_THEME_DIR . '/frontend/js/mousewheel.js', array(), '', true);
        wp_enqueue_script('baganuur-ut-script', BAGANUUR_UT_THEME_DIR . '/frontend/js/baganuur-ut-script.js', array(), BAGANUUR_UT_THEMEVERSION, true);

    }
}

add_action('admin_init', 'baganuur_ut_init_admin_css');
if (!function_exists('baganuur_ut_init_admin_css')) {
    function baganuur_ut_init_admin_css() {
        wp_enqueue_style( 'baganuur-ut-admin-css', get_template_directory_uri() . '/backend/assets/css/baganuur-ut-admin.css', array(), BAGANUUR_UT_THEMEVERSION );
    }
}

if ( !function_exists( 'baganuur_ut_load_custom_wp_admin_style' ) ) {
    function baganuur_ut_load_custom_wp_admin_style() {
        wp_enqueue_script( 'baganuur-ut-admin-script', get_template_directory_uri() . '/backend/assets/js/admin-script.js', array(), BAGANUUR_UT_THEMEVERSION, true);
    }
}