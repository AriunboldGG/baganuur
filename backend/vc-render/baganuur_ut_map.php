<?php
$atts = shortcode_atts( array(
    // Global
    'css' => '',
    'custom_class' => '',
    'animated' => 'none',
    'animation_delay' => '',
    // VC Padding
    't_padding' => '',
    'b_padding' => '',
    // Element class
    'element_class' => 'baganuur-ut-element baganuur-ut-map',
    // Content
    'json' => '',
    // Style
    'mouse_wheel' => 'false',
    'style_name' => 'Styled',
    'width' => 400,
    'lat' => '40.0712145',
    'lng' => '-83.4495123',
    'zoom' => '8',
    'contact' => 'false',
    'map_title' => '',
    'map_desc' => '',
    'map_contact' => '0',
    'map_bg_color' => '',
    'markers' => array(),
    // Color
), vc_map_get_attributes( $this->getShortcode(), $atts ) );

$atts['json']=rawurldecode(baganuur_ut_core_decode(strip_tags($atts['json'])));
wp_enqueue_script('waypoints');
$google_map = baganuur_ut_get_options(BAGANUUR_UT_T_OPTIONS . "google_api");
wp_enqueue_script('googleapi-map', 'https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&key=' . esc_attr($google_map), false, false, true);

$atts['map_bg_color'] = baganuur_ut_get_color( $atts['map_bg_color'] );
$class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $atts['css'], ' ' ), $this->settings['base'], $atts );
if ( !empty( $atts['t_padding'] )) {
    $atts['element_class'] .= ' baganuur-ut-top-padding-' . $atts['t_padding'] . ' ';
}

if ( !empty( $atts['b_padding'] )) {
    $atts['element_class'] .= ' baganuur-ut-bottom-padding-' . $atts['b_padding'] . ' ';
}

$data = ' data-style="' . esc_attr( $atts['style_name'] ) . '" data-mouse="' . esc_attr( $atts['mouse_wheel'] ) . '" data-lat="' . esc_attr( $atts['lat'] ) . '" data-lng="' . esc_attr( $atts['lng'] ) . '" data-zoom="' . esc_attr( $atts['zoom'] ) . '" data-json="' . esc_attr( $atts['json'] ) . '"';

$style = $atts['width'] ? ('height: 100%; width:' . esc_attr( $atts['width'] ) . 'px;') : '';

$output  = baganuur_ut_vc_item ( $atts, $class, $data, $style );
    $output .= '<div class="map"></div>';
    $output .= '<div class="map-markers">';
        $icon_default = BAGANUUR_UT_THEME_DIR."/frontend/img/map-marker.png";
        $markers = (array) vc_param_group_parse_atts( $atts['markers'] );
        foreach ( $markers as $marker ){
            $marker = shortcode_atts( array(
                'css' => '',
                'title' => '',
                'lat' => '',
                'lng' => '',
                'icon' => '',
                'icon_width' => '',
                'icon_height' => '',
                'content' => '',
            ), $marker);
            $icon = $marker['icon'];
            if ( $icon ){
                $icon = wp_get_attachment_image_src ( $icon, 'full' );
                $icon = isset ( $icon[0] ) ? $icon[0] : $icon_default;
            }else{
                $icon = $icon_default;
            }
            $data = ' data-title="' . esc_attr( $marker['title'] ) . '" data-lat="' . esc_attr( $marker['lat'] ) . '" data-lng="' . esc_attr( $marker['lng'] ) . '" data-iconsrc="' . esc_url( $icon ) . '" data-iconwidth="' . esc_attr( $marker['icon_width'] ) . '" data-iconheight="' . esc_attr( $marker['icon_height'] ) . '"';
            $output .= '<div class="map-marker"' . $data . '>';
                if ( $marker['title'] ){
                    $output .= '<h4>' . esc_html( $marker['title'] ) . '</h4>';
                }
                $output .= '<div class="marker-content">';
                    $output .= do_shortcode ( $marker['content'] );
                $output .= '</div>';
            $output .= '</div>';
        }
    $output .= '</div>';
$output .= '</div>';

echo balanceTags($output);
