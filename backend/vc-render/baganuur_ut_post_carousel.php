<?php

$row_element_dark = baganuur_ut_globals::get('row_element_dark');

$atts = shortcode_atts(array(
    // Global
    'css' => '',
    'custom_class' => '',
    'animated' => 'none',
    'animation_delay' => '',
    // VC Padding
    't_padding' => '',
    'b_padding' => '',
    // Element class
    'element_class' => 'baganuur-ut-element baganuur-ut-post-carousel baganuur-ut-carousel-container ',
    // Content
    'cats'  => '',
    'auto_play' => 'false',
    'count' => '6',
    'excerpt_count' => '',
    // Style
    'element_type' => 'carousel',
    // Color
), vc_map_get_attributes( $this->getShortcode(), $atts ) );
$class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $atts['css'], ' ' ), $this->settings['base'], $atts );

$post_content = $thumb = $add_class = $data_anim = $opacity_0 = '';

$query = array(
    'post_type' => 'post',
    'posts_per_page' => $atts['count'],
);

$cats = empty( $atts['cats'] ) ? false : explode( ",", $atts['cats'] );

$data = ' data-autoplay="' . esc_attr($atts['auto_play']) . '" data-items="1"';

if ( $cats ) {
    $query['tax_query'] = Array(Array(
            'taxonomy' => 'category',
            'terms' => $cats,
            'field' => 'slug'
        )
    );
}

if (isset($atts['animated']) && $atts['animated'] !== 'none') {
    $atts['animation_delay'] = empty($atts['animation_delay']) ? '0' : str_replace(' ', '', $atts['animation_delay']);
    $anim_data = ' data-animation="' . $atts['animated'] . '" data-animation-delay="' . $atts['animation_delay'] . '" data-animation-offset="90%"';

    $add_class = ' baganuur-ut-animate-gen';
    $data_anim = $anim_data;
    $opacity_0 = 'opacity:0;';
    wp_enqueue_script('waypoints');
}
$output = baganuur_ut_vc_item ( $atts, $class, $data );
    query_posts($query);

    if (have_posts()) {
        wp_enqueue_script('owl-carousel');
        $output .= '<div class="baganuur-ut-carousel owl-carousel owl-theme">';
        while( have_posts() ) { the_post();
            ob_start();
            baganuur_ut_blog_get_content($atts);
            $post_contentt = ob_get_clean();
            $atts['is_carousel'] = true;
            $thumb = baganuur_ut_blog_standard_media ('', $atts );

            $output .= '<div class="baganuur-ut-owl-item ' . $add_class . '" style="' . $opacity_0 . '" ' . $data_anim . '>';
                $output .= '<div class="carousel-thumb">' . $thumb . '</div>';
                $output .= '<div class="post-content">';
                    $output .= '<div class="post-content-inner">';
                        $output .= '<div class="entry-title-outer">';
                            $output .= '<h6 class="entry-title"><a href="' . esc_url(get_permalink()) . '">' . get_the_title() . '</a></h6>';
                        $output .= '</div>';
                        $output .= '<div class="entry-title-outer">';
                            $output .= $post_contentt;
                        $output .= '</div>';
                    $output .= '</div>';
                $output .= '</div>';
            $output .= '</div>';
        }
        $output .= '</div>';
    }
    wp_reset_query();

$output .= "</div>";

echo balanceTags($output);
