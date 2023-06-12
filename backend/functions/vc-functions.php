<?php

/*
  This PHP file contains Visual Composer functions.
 * prefix: baganuur_ut_vc_

 * Item
 * Icon
 * Animation

 */

/*
  Item

 */

if (!function_exists('baganuur_ut_vc_item')) {

    function baganuur_ut_vc_item( $atts, $class = '', $data = '', $style = '', $has_column = false ) {

        $divClass = $output = '';

        $animActive = false;

        if (array_key_exists('element_class', $atts)) {
            foreach ( explode(" ", $atts['element_class'] ) as $field ) {
                if ( $field === 'baganuur-ut-accordion' || $field === 'baganuur-ut-blog' || $field === 'baganuur-ut-circle-chart' || $field === 'baganuur-ut-iconbox-general' || $field === 'baganuur-ut-milestones' || $field === 'baganuur-ut-partner' || $field === 'baganuur-ut-post-carousel' || $field === 'baganuur-ut-pricing'  || $field === 'baganuur-ut-team' ) {
                    $animActive = true;
                }
            }
        }

        if ( $animActive === false ) {
            $animData = baganuur_ut_vc_anim($atts);
        }

        if (!empty($animData)) {
            $class .= ' baganuur-ut-animate-gen ';
            $data .= $animData;
            $style .= 'opacity:0;';
            wp_enqueue_script('waypoints');
        }
        if (!empty($atts['custom_id'])) {
            $data .= ' id="' . $atts['custom_id'] . '"';
        }
        if (!empty($atts['element_class'])) {
            $class .= ' ' . $atts['element_class'];
        }
        if (!empty($atts['custom_class'])) {
            $class .= ' ' . $atts['custom_class'];
        }
        if (!empty($style)) {
            $data .= ' style="' . esc_attr($style) . '"';
        }
        if (!empty($class)) {
            $divClass = ' class="' . esc_attr($class) . '"';
        }

        if($has_column) {
            $temp = array();
            $temp["data"] = $data;
            $temp["class"] = $class;
            return $temp;
        } else {
            $output = '<div' . $data . $divClass . '>';
            return $output;
        }

    }

}

/*
  Icon

 */

if (!function_exists('baganuur_ut_vc_icon')) {

    function baganuur_ut_vc_icon($atts, $styled = false) {
        $output = '';
        if (is_array($atts) && !empty($atts['icon']) && !empty($atts[$atts['icon']]) && $atts['icon'] !== 'none') {
            vc_icon_element_fonts_enqueue($atts['icon']);
            $style = $btn_icon_position = $icon_style = $class = $span_tag = $span_color = '';
            $class = $atts[$atts['icon']];

            if (array_key_exists('i_style', $atts)) {
                switch ($atts['i_style']) {
                    case 'basic':
                        $icon_style = ' basic-style';
                        if ( !empty( $atts['i_color'] ) ) {
                            $class .= ' custom-color';
                        }
                        break;
                    case 'border':
                        $icon_style = ' ut-draw-style border-style';
                        if ( !empty( $atts['i_color'] ) ) {
                            $class .= ' custom-color';
                        }
                        break;
                    case 'flat':
                        $icon_style = ' ut-draw-style flat-style hover';
                        if ( !empty( $atts['i_color'] ) ) {
                            $class .= ' custom-color';
                        }
                        break;
                    default: $icon_style = ' basic';
                }
            }

            if (array_key_exists('i_size', $atts)) {
                switch ($atts['i_size']) {
                    case 'small':
                        $icon_style .= ' small-fi';
                        break;
                    case 'medium':
                        $icon_style .= ' medium-fi';
                        break;
                    case 'large':
                        $icon_style .= ' large-fi';
                        break;
                    default: $icon_style .= ' small-fi';
                }
            }

            if (!empty($atts['fi_margin'])) {
                $margins = explode(",", $atts['fi_margin']);
                foreach ($margins as $key => $margin) {
                    if (!empty($margin)) {
                        if ($key == 0)
                            $style .= "margin-top:" . $margin . 'px;';
                        elseif ($key == 1)
                            $style .= "margin-right:" . $margin . 'px;';
                        elseif ($key == 2)
                            $style .= "margin-bottom:" . $margin . 'px;';
                        elseif ($key == 3)
                            $style .= "margin-left:" . $margin . 'px;';
                    }
                }
            }

            if (array_key_exists('icon_position', $atts)) {
                if ( empty($atts['icon_position']) || $atts['icon_position'] === 'right' ) {
                    $btn_icon_position .= ' right';
                } else {
                    $btn_icon_position .= ' left';
                }
            }

            if ($atts['icon'] === 'i_image') {
                $output .= baganuur_ut_core_get_image_by_id($class);
            } elseif ($atts['icon'] === 'i_text') {
                $output .= $atts[$atts['icon']];
            } else {
                if ($styled) {
                    if (array_key_exists('i_color', $atts)) {
                        if (isset($atts['i_color'])) {
                            if ( $atts['i_color'] === '#fff' || $atts['i_color'] === '#ffffff' || $atts['i_color'] === 'rgba(255, 255, 255, 1)' || $atts['i_color'] === 'rgb(255, 255, 255)' || $atts['i_color'] === 'white' ) {
                                $class .= ' icon-color-white';
                            }
                            $style .= 'color:' . esc_attr($atts['i_color']) . ';';
                        }
                    }
                    if (array_key_exists('i_style', $atts)) {
                        if ( $atts['i_style'] === 'basic' ) {
                            $style .= ' color: ' . esc_attr($atts['i_color']) . ';';
                        }
                        if ( $atts['i_style'] === 'border' ) {
                            $style .= ' color: ' . esc_attr($atts['i_color']) . ';';
                            $style .= ' border-color: ' . esc_attr($atts['i_color']) . ';';
                            $span_color .= ' style="background-color: ' . esc_attr($atts['i_color']) . ';"';
                        }
                        if ( $atts['i_style'] === 'flat' ) {
                            $style .= ' color: #ffffff;';
                            $style .= ' border-color: ' . esc_attr($atts['i_color']) . ';';
                            $style .= ' background-color: ' . esc_attr($atts['i_color']) . ';';
                            $span_color .= ' style="background-color: ' . esc_attr($atts['i_color']) . ';"';
                        }
                    }
                }

                if (array_key_exists('i_style', $atts)) {
                    if ( $atts['i_style'] === 'border' || $atts['i_style'] === 'flat' ) {
                        $span_tag .= '<span class="border-left" ' . $span_color . '></span>';
                        $span_tag .= '<span class="border-top" ' . $span_color . '></span>';
                        $span_tag .= '<span class="border-right" ' . $span_color . '></span>';
                    }
                }

                $is_exists = array_key_exists('i_link', $atts);
                if ($is_exists === true) {
                    if (!empty($atts['i_link'])) {
                        $output = '<a href="' . esc_url($atts['i_link']) . '" target="' . esc_attr( $atts['i_target'] ) . '">';
                            $output .= '<i class="fi ' . esc_attr($class) . $btn_icon_position . $icon_style . '" style="' . esc_attr($style) . ' display:block">';
                                $output .= $span_tag;
                            $output .= '</i>';
                        $output .= '</a>';
                    } else {
                        $output .= '<i class="fi ' . esc_attr($class) . $btn_icon_position . $icon_style . '" style="' . esc_attr($style) . '">';
                            $output .= $span_tag;
                        $output .= '</i>';
                    }
                } else {
                    $output .= '<i class="fi ' . esc_attr($class) . $btn_icon_position . $icon_style . '" style="' . esc_attr($style) . '">';
                        $output .= $span_tag;
                    $output .= '</i>';
                }
            }
        }
        return $output;
    }

}

/*
  Animation

 */

if (!function_exists('baganuur_ut_vc_anim')) {

    function baganuur_ut_vc_anim($atts) {
        $data = '';
        if (isset($atts['animated']) && $atts['animated'] !== 'none') {
            $atts['animation_delay'] = empty($atts['animation_delay']) ? '0' : str_replace(' ', '', $atts['animation_delay']);
            $data .= ' data-animation="' . $atts['animated'] . '" data-animation-delay="' . $atts['animation_delay'] . '" data-animation-offset="90%"';
        }
        return $data;
    }
   
}

/*
  Enqueue - Waypoint

 */

if (!function_exists('baganuur_ut_vc_enqueue_waypoint')) {

    function baganuur_ut_vc_enqueue_waypoint() {
        
        wp_enqueue_script( 'waypoints' );

    }
   
}

/*
  Enqueue - Isotope

 */

if (!function_exists('baganuur_ut_vc_enqueue_isotope')) {

    function baganuur_ut_vc_enqueue_isotope() {
        
        wp_enqueue_script('baganuur-ut-isotope');

    }
   
}

/*
  Enqueue - Owl Carousel

 */

if (!function_exists('baganuur_ut_vc_enqueue_owl_carousel')) {

    function baganuur_ut_vc_enqueue_owl_carousel() {
        
        wp_enqueue_script('owl-carousel');

    }
   
}

/*
  Enqueue - UI Tooltip

 */

if (!function_exists('baganuur_ut_vc_enqueue_ui_tooltip')) {

    function baganuur_ut_vc_enqueue_ui_tooltip() {
        
        wp_enqueue_script('jquery-ui-tooltip');

    }
   
}

/*
  Enqueue - UI Accordion

 */

if (!function_exists('baganuur_ut_vc_enqueue_ui_accordion')) {

    function baganuur_ut_vc_enqueue_ui_accordion() {
        
        wp_enqueue_script('jquery-ui-accordion');

    }
   
}

/*
  Enqueue - wpb composer front js

 */

if (!function_exists('baganuur_ut_vc_enqueue_wpb_composer_front_js')) {

    function baganuur_ut_vc_enqueue_wpb_composer_front_js() {
        
        wp_enqueue_script( 'wpb_composer_front_js' );

    }
   
}
/*
  Enqueue - UI Tabs

 */

if (!function_exists('baganuur_ut_vc_enqueue_ui_tabs')) {

    function baganuur_ut_vc_enqueue_ui_tabs() {
        
        wp_enqueue_script('jquery-ui-tabs');

    }
   
}


/*
  Enqueue - Easy Pie Chart

 */

if (!function_exists('baganuur_ut_vc_enqueue_easy_pie_chart')) {

    function baganuur_ut_vc_enqueue_easy_pie_chart() {
        
        wp_enqueue_script( 'easy-pie-chart', BAGANUUR_UT_THEME_DIR . '/frontend/js/jquery.easy-pie-chart.js', false, false, true );

    }
   
}

/*
  Enqueue - Animated Headline CSS

 */

if (!function_exists('baganuur_ut_vc_enqueue_headline_css')) {

    function baganuur_ut_vc_enqueue_headline_css() {
        
        wp_enqueue_style('baganuur-ut-animated-headline-css');

    }
   
}

/*
  Enqueue - Animated Headline JS

 */

if (!function_exists('baganuur_ut_vc_enqueue_headline_js')) {

    function baganuur_ut_vc_enqueue_headline_js() {
        
        wp_enqueue_script('baganuur-ut-animated-headline-js');

    }
   
}