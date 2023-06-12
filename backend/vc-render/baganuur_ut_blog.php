<?php
$atts = shortcode_atts(array(
    // Global
    'css' => '',
    'custom_class' => '',
    'item_anim' => '',
    'animated' => 'none',
    'animation_delay' => '',
    // VC Padding
    't_padding' => '',
    'b_padding' => '',
    // Element class
    'element_class' => 'baganuur-ut-element baganuur-ut-blog',
    // Style
    'layout' => 'normal',
    'img_height' => '',
    'img_width' => '',
    'filter' => 'simple',
    'pagination' => 'simple',
    'cats' => '',
    'count' => '',
    'excerpt_count' => '',
    'more_text' => '',
    // Other
    'not_in' => '',
    'type' => 'element',
), vc_map_get_attributes($this->getShortcode(), $atts));
$class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $atts['css'], ' ' ), $this->settings['base'], $atts );

$atts['custom_class'] .= $class;
echo balanceTags(baganuur_ut_blog( $atts ));