<?php

/*
  Logo Generate

 */

function baganuur_ut_logo() {
    $width = '';
    $bodyclass = get_body_class();

    $core_logo = baganuur_ut_get_options(BAGANUUR_UT_T_OPTIONS . "upload_core_logo");
    $top_logo = baganuur_ut_get_options(BAGANUUR_UT_T_OPTIONS . "upload_top_logo");
    $bottom_logo = baganuur_ut_get_options(BAGANUUR_UT_T_OPTIONS . "upload_bottom_logo");
    
    $echo_core_logo = $core_logo;
    $echo_top_logo = $top_logo;
    $echo_bottom_logo = $bottom_logo;

    if (!empty($echo_core_logo)) {
        echo '<div class="baganuur-ut-header-images">';
            echo '<a class="logo" href="' . esc_url(home_url('/')) . '">';
                if (!empty($echo_top_logo)) {
                    echo '<img class="top-logo-img" src="' . esc_url($echo_top_logo['url']) . '" alt="' . esc_attr(get_bloginfo('name')) . '"/>';
                }
                    echo '<img class="core-logo-img" src="' . esc_url($echo_core_logo['url']) . '" alt="' . esc_attr(get_bloginfo('name')) . '"/>';
                if (!empty($echo_bottom_logo)) {
                    echo '<img class="bottom-logo-img" src="' . esc_url($echo_bottom_logo['url']) . '" alt="' . esc_attr(get_bloginfo('name')) . '"/>';
                }
            echo '</a>';
        echo '</div>';
    } else {
        echo '<h2 class="site-name"><a class="logo" href="' . esc_url(home_url('/')) . '">';
        bloginfo('name');
        echo '</a></h2>';
    }
}

function baganuur_ut_mobile_logo() {
    $width = '';
    $bodyclass = get_body_class();

    $core_logo = baganuur_ut_get_options(BAGANUUR_UT_T_OPTIONS . "upload_core_logo");
    $top_logo = baganuur_ut_get_options(BAGANUUR_UT_T_OPTIONS . "upload_top_logo");
    $bottom_logo = baganuur_ut_get_options(BAGANUUR_UT_T_OPTIONS . "upload_bottom_logo");
    
    $echo_core_logo = $core_logo;
    $echo_top_logo = $top_logo;
    $echo_bottom_logo = $bottom_logo;

    if (!empty($echo_core_logo)) {
        echo '<div class="baganuur-ut-header-images">';
            echo '<a class="logo" href="' . esc_url(home_url('/')) . '">';
                echo '<img class="core-logo-img" src="' . esc_url($echo_core_logo['url']) . '" alt="' . esc_attr(get_bloginfo('name')) . '"/>';
            echo '</a>';
        echo '</div>';
    } else {
        echo '<h2 class="site-name"><a class="logo" href="' . esc_url(home_url('/')) . '">';
        bloginfo('name');
        echo '</a></h2>';
    }
}

/*
  Favicon

 */

function baganuur_ut_favicon() {
    if (!function_exists('has_site_icon') || !has_site_icon()) {
        $retina_logo_ready = baganuur_ut_get_options(BAGANUUR_UT_T_OPTIONS . 'retina_logo_ready');
        $retina_favicon = baganuur_ut_get_options(BAGANUUR_UT_T_OPTIONS . 'retina_favicon');

        if ( $retina_logo_ready == 1 && $retina_favicon !=='' ) {
            $favicon = $retina_favicon;
        }

        if ( !empty($favicon)) {
            $favicon = baganuur_ut_get_options(BAGANUUR_UT_T_OPTIONS . 'upload_fav_icon');
        } else {
            $favicon = BAGANUUR_UT_THEME_DIR . '/backend/assets/img/favicon.ico';
        }

        echo '<link rel="shortcut icon" href="' . esc_url($favicon) . '"/>';
    }
}