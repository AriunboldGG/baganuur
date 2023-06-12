<?php

$team = baganuur_ut_globals::get('team');

$atts = shortcode_atts( array(
    // Global
    'css' => '',
    'custom_class' => '',
    'animated' => $team['animated'],
    'animation_delay' => $team['animation_delay'],
    // Element class
    'element_class' => 'baganuur-ut-element baganuur-ut-team-item',
    // Content 
    'title' => '',
    'mem_position' => '',
    'mem_image' => '',
    'social_links' => '',
    'full_width' => '',
), vc_map_get_attributes( $this->getShortcode(), $atts ) );
$class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $atts['css'],' ' ), $this->settings['base'], $atts );

$class = $anchor_open = $anchor_close = $overlay = $social = $team_content = $grayscale = $carousel_item = $add_class = $data = $opacity_0 = $width = $height = $modal = $item_image_column_start = $item_image_column_end = $item_content_column_start = $item_content_column_end = '';

if ( !empty( $team['t_padding'] )) {
    $atts['element_class'] .= ' baganuur-ut-top-padding-' . $team['t_padding'] . ' ';
}

if ( !empty( $team['b_padding'] )) {
    $atts['element_class'] .= ' baganuur-ut-bottom-padding-' . $team['b_padding'] . ' ';
}

$position = $atts['mem_position'];

$member_img = baganuur_ut_core_team_get_lazy_image($atts['mem_image'], true);
$member_img_lazy_load = baganuur_ut_core_team_get_lazy_image($atts['mem_image'], false);
$thumbnail_bg_img = $member_img['url'];
$image_alt = $member_img['alt'];
if ( $member_img['url'] ) {
    $member_img = '<img class="member-image-metro" src="' . esc_url(BAGANUUR_UT_THEME_DIR . '/backend/assets/img/metro-img.png') . '" alt="' . esc_attr($member_img['alt']) . '"/>';
    $overlay = '<a class="image-overlay" href="' . esc_attr($thumbnail_bg_img) . '" download="' . esc_attr($image_alt) . '.jpg"></a>';
}

$social_links = explode( ",", $atts['social_links'] );
foreach ( $social_links as $social_link ) {
    $social .= baganuur_ut_social_link ( $social_link );
}

$text = '<div class="clearfix"></div><p>' . strip_tags($content) . '</p>';

$team_content .= '<div class="member-content">';
    $team_content .= '<div class="member-title">';
        $team_content .= '<h6 class="member-name">' . esc_html( $atts['title'] ) . '</h6>';
        $team_content .= '<div class="member-pos">' . esc_html($position) . '</div>';
    $team_content .= '</div>';
    $team_content .= '<a class="member-modal-btn" href="#' . esc_attr($image_alt) . '">ᠲᠠᠨᠢᠯᠴᠠᠭᠤᠯᠭ᠎ᠠ</a>';
$team_content .= '</div>';

if ( $atts['full_width'] === 'true' ) {
    $class .= ' baganuur-team-item-full-width';
    $add_class .= ' row';
    $item_image_column_start = '<div class="col-md-5">';
    $item_image_column_end = '</div>';
    $item_content_column_start = '<div class="col-md-7">';
    $item_content_column_end = '</div>';
    $introduction = '';
}
if ($content) {
    $modal = '<div id="' . esc_attr($image_alt) . '" class="modal baganuur-ut-team-modal">';
        $modal .= '<div class="modal-content">';
            $modal .= '<div class="modal-form">';
                $modal .= '<span class="modal-close"><i class="ion-android-close"></i></span>';
                    $modal .= '<div class="baganuur-ut-thumbnail-outer">';
                        $modal .= '<div class="member-image baganuur-ut-thumbnail baganuur-lazy baganuur-ut-thumbnail-bg-image" data-src="' . esc_url($thumbnail_bg_img) . '">';
                            if ( isset( $member_img_lazy_load ) ) {
                                $modal .= $member_img_lazy_load;
                            }
                            $modal .= $member_img;
                        $modal .='</div>';
                        $modal .= '<div class="baganuur-modal-socials">';
                            $modal .= $social;
                        $modal .= '</div>';
                    $modal .= '</div>';
                    $modal .= '<div class="member-content">';
                        $modal .= '<div class="member-title">';
                            $modal .= '<h6 class="member-name">' . esc_html( $atts['title'] ) . '</h6>';
                            $modal .= '<div class="member-pos">' . esc_html($position) . '</div>';
                        $modal .= '</div>';
                    $modal .= '</div>';
                    $modal .= '<div class="baganuur-modal-content">';
                        $modal .= '<p>' . balanceTags( $content ) . '</p>';
                    $modal .= '</div>';
            $modal .= '</div>';
        $modal .= '</div>';
    $modal .= '</div>';
}

/* item animation */
if (isset($atts['animated']) && $atts['animated'] !== 'none') {
    $atts['animation_delay'] = empty($atts['animation_delay']) ? '0' : str_replace(' ', '', $atts['animation_delay']);
    $anim_data = ' data-animation="' . $atts['animated'] . '" data-animation-delay="' . $atts['animation_delay'] . '" data-animation-offset="90%"';

    $add_class .= ' baganuur-ut-animate-gen';
    $data = $anim_data;
    $opacity_0 = 'style="opacity:0;"';
    wp_enqueue_script('waypoints');
}
/* end item animation */

$column = substr_count ( $content,'[baganuur_ut_team_item' );

$output  = baganuur_ut_vc_item ( $atts, $class );
    $output .= '<div class="team-member ' . $carousel_item . $add_class . ' clearfix" ' . $opacity_0 . $data . '>';
        $output .= $item_image_column_start;
            $output .= '<div class="member-image baganuur-ut-thumbnail baganuur-lazy baganuur-ut-thumbnail-bg-image" data-src="' . esc_url($thumbnail_bg_img) . '">';
                if ( isset( $member_img_lazy_load ) ) {
                    $output .= $member_img_lazy_load;
                }
                $output .= $member_img;
                $output .= $overlay;
            $output .='</div>';
        $output .= $item_image_column_end;
        $output .= $item_content_column_start;
            $output .= $team_content;
            if ( $atts['full_width'] === 'true' ) {
                $output .= '<p>' . balanceTags( $content ) . '</p>';
            }
        $output .= $item_content_column_end;
    $output .= '</div>';
    $output .= $modal;
$output .= '</div>';

echo balanceTags($output);
