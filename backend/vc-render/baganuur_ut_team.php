<?php

$atts = shortcode_atts( array(
    // Global
    'css' => '',
    'custom_class' => '',
    'animated' => 'none',
    'animation_delay' => '',
    'element_class' => 'baganuur-ut-element baganuur-ut-team',
    // VC Padding
    't_padding' => '',
    'b_padding' => '',
    // Style
    'layout' => 'style-1',
), vc_map_get_attributes( $this->getShortcode(), $atts ) );

baganuur_ut_globals::set( 'team', $atts );

$data = '';

$class = $atts['layout'];

$class .= apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $atts['css'], ' ' ), $this->settings['base'], $atts );

if ( !empty( $atts['t_padding'] )) {
    $atts['element_class'] .= ' baganuur-ut-top-padding-' . $atts['t_padding'] . ' ';
}

if ( !empty( $atts['b_padding'] )) {
    $atts['element_class'] .= ' baganuur-ut-bottom-padding-' . $atts['b_padding'] . ' ';
}

$subItems = substr_count ( $content, '[baganuur_ut_team_item' );

$output .= baganuur_ut_vc_item ( $atts, $class, $data );
//    $output .= '<div class="vc_row">';
        $output .= wpb_js_remove_wpautop($content);
//    $output .= '</div>';
$output .= '</div>';

echo balanceTags($output);