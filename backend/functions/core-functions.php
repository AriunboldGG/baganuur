<?php

/*
  This PHP file contains Uniontheme core functions for its themes.
 * prefix: baganuur_ut_core_

 */

/*
  Check class in Body class

 */

if ( !function_exists('baganuur_ut_core_check_body_class') ) {

    function baganuur_ut_core_check_body_class( $class_name = '') {

        $result = false;

        if ( empty($class_name) ) {
            return $result;
        }

        $body_class = get_body_class();

        foreach ( $body_class as $class ) {
            if ( $class == $class_name ) {
                $result = true;
            }
        }

        return $result;

    }

}

/*
  Visual Composer - Disable Update

 */

function baganuur_ut_core_vcSetAsTheme() {
    
    vc_set_as_theme( $disable_updater = true );
    
}
add_action('vc_before_init', 'baganuur_ut_core_vcSetAsTheme');

/*
  Compress CSS Inline

 */

if (!function_exists('baganuur_ut_core_compress_css_inline')) {

    function baganuur_ut_core_compress_css_inline($inline_css) {
        // Remove comments
        $inline_css = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $inline_css);

        // Remove space after colons
        $inline_css = str_replace(': ', ':', $inline_css);

        // Remove whitespace
        $inline_css = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $inline_css);

        // Write everything out
        return $inline_css;
    }

}

/*
  Seen Count

 */

if (!function_exists('baganuur_ut_core_seen_count')) {

    function baganuur_ut_core_seen_count() {
        if ( is_single() ) {
            $post = baganuur_ut_globals::get('post');
            $seen = get_post_meta($post->ID, 'post_seen', true);
            $seen = intval($seen) + 1;
            update_post_meta($post->ID, 'post_seen', $seen);
        } else {
            $post = baganuur_ut_globals::get('post');
            return get_post_meta($post->ID, 'post_seen', true);
        }
        
    }

}

/*
  Comment Count

 */

if (!function_exists('baganuur_ut_core_comment_count')) {

    function baganuur_ut_core_comment_count() {
        $comment_count = get_comments_number('0', '1', '%');
        if ($comment_count == 0) {
            $comment_trans = esc_html__('No Comment', 'baganuur');
        } elseif ($comment_count == 1) {
            $comment_trans = esc_html__('1 Comment', 'baganuur');
        } else {
            $comment_trans = sprintf(esc_html__('%s Comments', 'baganuur'), $comment_count);
        }
        return "<a href='" . esc_url(get_comments_link()) . "' title='" . esc_attr($comment_trans) . "' class='comment-count'>" . esc_html($comment_trans) . "</a>";
    }

}

/*
  Get Uploaded Image

 */

if (!function_exists('baganuur_ut_core_image')) {

    function baganuur_ut_core_image($width = 0, $height = "", $returnURL = false, $noImg = false) {
        global $post;
        $attachment = get_post(get_post_thumbnail_id($post->ID));
        if (!empty($attachment)) {
            $lrg_img = wp_get_attachment_image_src($attachment->ID, 'full');
            
            if ($width != 0) {
                $resize = aq_resize($lrg_img[0], $width, $height, true);
            }
            $url = empty($resize) ? $lrg_img[0] : $resize;

            $alt0 = get_post_meta($attachment->ID, '_wp_attachment_image_alt', true);
            $alt = empty($alt0) ? $attachment->post_title : $alt0;
        } elseif ($noImg) {
            $url = BAGANUUR_UT_THEME_DIR . '/frontend/img/no-image.png';
            $alt = esc_html__('No Image', 'baganuur');
            if ($width != 0) {
                $resize = aq_resize($url, $width, $height, true);
            }
            $url = empty($resize) ? $url : $resize;
        }
        if (!empty($url) && !empty($alt)) {
            if ($returnURL) {
                $img['url'] = $url;
                $img['alt'] = $alt;
                return $img;
            } else {
                return '<img src="' . esc_url($url) . '" alt="' . esc_attr($alt) . '"/>';
            }
        } else {
            return false;
        }
    }

}

/*
  Get Uploaded Image with Lazy load

 */

if (!function_exists('baganuur_ut_core_get_lazy_image')) {

    function baganuur_ut_core_get_lazy_image($width = 0, $height = "", $returnURL = false, $noImg = false, $noBgStyle = true) {
        global $post;
        $attachment = get_post(get_post_thumbnail_id($post->ID));
        if (!empty($attachment)) {
            $lrg_img = wp_get_attachment_image_src($attachment->ID, 'full');

            if ( $lrg_img[1] == $lrg_img[2] ) {
                $thumb_width = 100;
                $thumb_height = 100;
            } elseif ( $lrg_img[1] > $lrg_img[2] ) {
                $thumb_width = round(100 * $lrg_img[1] / $lrg_img[2]);
                $thumb_height = 100;
            } else {
                $thumb_width = 100;
                $thumb_height = round(100 * $lrg_img[2] / $lrg_img[1]);
            }
            
            $thumb_url = aq_resize($lrg_img[0], $thumb_width, $thumb_height, true);
            
            if ($width != 0) {
                $resize = aq_resize($lrg_img[0], $width, $height, true);
            }
            $url = empty($resize) ? $lrg_img[0] : $resize;

            $alt0 = get_post_meta($attachment->ID, '_wp_attachment_image_alt', true);
            $alt = empty($alt0) ? $attachment->post_title : $alt0;
        } elseif ($noImg) {
            $url = BAGANUUR_UT_THEME_DIR . '/frontend/img/no-image.png';
            $alt = esc_html__('No Image', 'baganuur');
            if ($width != 0) {
                $resize = aq_resize($url, $width, $height, true);
            }
            $url = empty($resize) ? $url : $resize;
        }
        if (!empty($url) && !empty($alt)) {
            if ($returnURL) {
                $img['url'] = $url;
                $img['thumb_url'] = $thumb_url;
                $img['alt'] = $alt;
                return $img;
            } else {
                $output = '<div class="baganuur-ut-lazy-container">';
                $output .= '<img class="lazy-thumbnail" src="' .esc_url($thumb_url) . '" alt="thumbnail ' . esc_attr($alt) . '"/>';
                if ( $noBgStyle ) {
                    $output .= '<img class="baganuur-lazy" src="#" data-src="' . esc_url($url) . '" alt="' . esc_attr($alt) . '"/>';
                }
                $output .= '</div>';
                
                return balanceTags($output);
            }
        } else {
            return false;
        }
    }

}

/*
  Get Uploaded Image with Lazy load with attachment id

 */

if (!function_exists('baganuur_ut_core_get_lazy_image_by_attachment_id')) {

    function baganuur_ut_core_get_lazy_image_by_attachment_id($attachment_id = 0, $width = 0, $height = "", $returnURL = false, $noImg = false) {

        if (!empty($attachment_id)) {
            $lrg_img = wp_get_attachment_image_src($attachment_id, 'full');

            if ( $lrg_img[1] == $lrg_img[2] ) {
                $thumb_width = 100;
                $thumb_height = 100;
            } elseif ( $lrg_img[1] > $lrg_img[2] ) {
                $thumb_width = round(100 * $lrg_img[1] / $lrg_img[2]);
                $thumb_height = 100;
            } else {
                $thumb_width = 100;
                $thumb_height = round(100 * $lrg_img[2] / $lrg_img[1]);
            }
            
            $thumb_url = aq_resize($lrg_img[0], $thumb_width, $thumb_height, true);
            
            if ($width != 0) {
                $resize = aq_resize($lrg_img[0], $width, $height, true);
            }
            $url = empty($resize) ? $lrg_img[0] : $resize;

            $alt0 = get_post_meta($attachment_id, '_wp_attachment_image_alt', true);
            $alt = empty($alt0) ? 'team-image-' .rand(1000,10000) : $alt0;
        } elseif ($noImg) {
            $url = WORLDSUMMIT_UT_THEME_DIR . '/frontend/img/no-image.png';
            $alt = esc_html__('No Image', 'baganuur');
            if ($width != 0) {
                $resize = aq_resize($url, $width, $height, true);
            }
            $url = empty($resize) ? $url : $resize;
        }
        if (!empty($url) && !empty($alt)) {
            if ($returnURL) {
                $img['url'] = $url;
                $img['thumb_url'] = $thumb_url;
                $img['alt'] = $alt;
                return $img;
            } else {
                return '<div class="baganuur-ut-lazy-container"><img class="lazy-thumbnail" src="' .esc_url($thumb_url) . '" width="' . esc_attr($lrg_img[1]) . '" height="' . esc_attr($lrg_img[2]) . '" alt="thumbnail ' . esc_attr($alt) . '"/><img class="baganuur-lazy" src="#" data-src="' . esc_url($url) . '" alt="' . esc_attr($alt) . '"/></div>';
            }
        } else {
            return false;
        }
    }

}

/*
  Get Uploaded Image with Lazy load

 */

if (!function_exists('baganuur_ut_core_team_get_lazy_image')) {

    function baganuur_ut_core_team_get_lazy_image($attachment_id = '', $returnURL = false) {

        if ( empty( $attachment_id ) ) {
            return '';
        }

        $lrg_img = wp_get_attachment_image_src($attachment_id, 'full');

        if ( $lrg_img[1] > $lrg_img[2] ) {
            $thumb_width = 150;
            $thumb_height = 150 * $lrg_img[2] / $lrg_img[1];
        } else {
            $thumb_width = 150 * $lrg_img[1] / $lrg_img[2];
            $thumb_height = 150;
        }

        $thumb_url = aq_resize($lrg_img[0], $thumb_width, $thumb_height, true);
        
        $url = $lrg_img[0];
        $alt = 'team-image-' .rand(1000,10000);
        
        if (!empty($url) && !empty($alt)) {
            if ($returnURL) {
                $img['url'] = $url;
                $img['thumb_url'] = $thumb_url;
                $img['alt'] = $alt;
                return $img;
            } else {
                return '<div class="baganuur-ut-lazy-container"><img class="lazy-thumbnail" src="' .esc_url($thumb_url) . '" width="' . esc_attr($lrg_img[1]) . '" height="' . esc_attr($lrg_img[2]) . '" alt="thumbnail ' . esc_attr($alt) . '"/></div>';
            }
        } else {
            return false;
        }
    }

}


/*
  Hex to RGB

 */

if (!function_exists('baganuur_ut_core_hex2rgb')) {

    function baganuur_ut_core_hex2rgb($hex) {
        $hex = str_replace("#", "", $hex);

        if (strlen($hex) == 3) {
            $r = hexdec(substr($hex, 0, 1) . substr($hex, 0, 1));
            $g = hexdec(substr($hex, 1, 1) . substr($hex, 1, 1));
            $b = hexdec(substr($hex, 2, 1) . substr($hex, 2, 1));
        } else {
            $r = hexdec(substr($hex, 0, 2));
            $g = hexdec(substr($hex, 2, 2));
            $b = hexdec(substr($hex, 4, 2));
        }
        $rgb = array($r, $g, $b);
        return implode(",", $rgb); // returns the rgb values separated by commas
    }

}

/*
  Social Name

 */

if (!function_exists('baganuur_ut_core_get_social_name')) {

    function baganuur_ut_core_get_social_name($url) {
        if (strpos($url, 'twitter.com')) {
            $social['name'] = 'twitter';
            $social['class'] = 'fa fa-twitter';
            return $social;
        }
        if (strpos($url, 'print')) {
            $social['name'] = 'print';
            $social['class'] = 'ion-android-print';
            return $social;
        }
        if (strpos($url, 'linkedin.com')) {
            $social['name'] = 'linkedin';
            $social['class'] = 'fa fa-linkedin';
            return $social;
        }
        if (strpos($url, 'facebook.com')) {
            $social['name'] = 'facebook';
            $social['class'] = 'fa fa-facebook';
            return $social;
        }
        if (strpos($url, 'delicious.com')) {
            $social['name'] = 'delicious';
            $social['class'] = 'fa fa-delicious';
            return $social;
        }
        if (strpos($url, 'codepen.io')) {
            $social['name'] = 'codepen';
            $social['class'] = 'fa fa-codepen';
            return $social;
        }
        if (strpos($url, 'github.com')) {
            $social['name'] = 'github';
            $social['class'] = 'fa fa-github';
            return $social;
        }
        if (strpos($url, 'wordpress.org') || strpos($url, 'wordpress.com')) {
            $social['name'] = 'wordpress';
            $social['class'] = 'fa fa-wordpress';
            return $social;
        }
        if (strpos($url, 'youtube.com')) {
            $social['name'] = 'youtube';
            $social['class'] = 'fa fa-youtube-play';
            return $social;
        }
        if (strpos($url, 'behance.net')) {
            $social['name'] = 'behance';
            $social['class'] = 'fa fa-behance';
            return $social;
        }
        if (strpos($url, 'pinterest.com')) {
            $social['name'] = 'pinterest';
            $social['class'] = 'fa fa-pinterest';
            return $social;
        }
        if (strpos($url, 'foursquare.com')) {
            $social['name'] = 'foursquare';
            $social['class'] = 'fa fa-foursquare';
            return $social;
        }
        if (strpos($url, 'soundcloud.com')) {
            $social['name'] = 'soundcloud';
            $social['class'] = 'fa fa-soundcloud';
            return $social;
        }
        if (strpos($url, 'dribbble.com')) {
            $social['name'] = 'dribbble';
            $social['class'] = 'ion-social-dribbble';
            return $social;
        }
        if (strpos($url, 'instagram.com')) {
            $social['name'] = 'instagram';
            $social['class'] = 'fa fa-instagram';
            return $social;
        }
        if (strpos($url, 'plus.google')) {
            $social['name'] = 'google';
            $social['class'] = 'ion-social-googleplus';
            return $social;
        }
        if (strpos($url, 'vine.co')) {
            $social['name'] = 'vine';
            $social['class'] = 'fa fa-vine';
            return $social;
        }
        if (strpos($url, 'twitch.tv')) {
            $social['name'] = 'twitch';
            $social['class'] = 'fa fa-twitch';
            return $social;
        }
        if (strpos($url, 'tumblr.com')) {
            $social['name'] = 'tumblr';
            $social['class'] = 'fa fa-tumblr';
            return $social;
        }
        if (strpos($url, 'trello.com')) {
            $social['name'] = 'trello';
            $social['class'] = 'fa fa-trello';
            return $social;
        }
        if (strpos($url, 'spotify.com')) {
            $social['name'] = 'spotify';
            $social['class'] = 'fa fa-spotify';
            return $social;
        }
        if (strpos($url, 'vimeo.com')) {
            $social['name'] = 'vimeo';
            $social['class'] = 'fa fa-vimeo';
            return $social;
        }
        if (strpos($url, 'whatsapp.com')) {
            $social['name'] = 'whatsapp';
            $social['class'] = 'fa fa-whatsapp';
            return $social;
        }

        $social['name'] = 'custom';
        $social['class'] = 'fa fa-link';
        return $social;
    }

}

/*
  Encode

 */

if (!function_exists('baganuur_ut_core_encode')) {

    function baganuur_ut_core_encode( $value ) {

        $func = 'base64' . '_encode';
        return $func( $value );

    }

}

/*
  Decode

 */

if (!function_exists('baganuur_ut_core_decode')) {

    function baganuur_ut_core_decode( $value ) {

        $func = 'base64' . '_decode';
        return $func( $value );

    }

}

/*
  Get Latest Post ID

 */

if (!function_exists('baganuur_ut_core_get_latest_post_id')) {

    function baganuur_ut_core_get_latest_post_id() {
        $posts = get_posts('numberposts=1');
        $latest = $posts[0]->ID;
        wp_reset_postdata();

        return $latest;
    }

}

/*
  Get Image by ID

 */

if (!function_exists('baganuur_ut_core_get_image_by_id')) {

    function baganuur_ut_core_get_image_by_id($id, $url = false, $size = 'full') {
        $lrg_img = wp_get_attachment_image_src($id, $size);
        $output = '';
        $attachment_title = get_the_title( $id );
        if (isset($lrg_img[0])) {
            if ($url) {
                $output .= $lrg_img[0];
            } else {
                $output .= '<img alt="' . $attachment_title . '" src="'.esc_url($lrg_img[0]).'" />';
            }
        }
        return $output;
    }

}

/*
  Check Singular

 */

if (!function_exists('baganuur_ut_core_check_singular')) {

    function baganuur_ut_core_check_singular() {
        // Check if post or page is singular. Here you can add another condition.
        if ( is_single() == true ) {
            return true;
        } elseif ( is_page() == true ) {
            return true;
        } else {
            return false;
        }
    }

}

/*
  Check metabox

 */

if (!function_exists('baganuur_ut_core_check_metabox')) {

    function baganuur_ut_core_check_metabox() {
        
        $return = false;

        if ( baganuur_ut_acf_get_field('metabox') === 'on' ) {
            $return = true;
        }
        
        return $return;

    }

}

/*
  Check both Singular and metabox

 */

if (!function_exists('baganuur_ut_core_check_singular_and_metabox')) {

    function baganuur_ut_core_check_singular_and_metabox() {
        
        $return = false;

        if (baganuur_ut_core_check_singular() && baganuur_ut_acf_get_field('metabox') === 'on' ) {
            $return = true;
        }
        
        return $return;

    }

}

/*
  Get Current Post Type

 */

if (!function_exists('baganuur_ut_core_get_current_post_type')) {

    function baganuur_ut_core_get_current_post_type() {
        global $post, $typenow, $current_screen;

        if ($post && $post->post_type) {
            return $post->post_type;
        } elseif ($typenow) {
            return $typenow;
        } elseif ($current_screen && $current_screen->post_type) {
            return $current_screen->post_type;
        } elseif (isset($_REQUEST['post_type'])) {
            return sanitize_key($_REQUEST['post_type']);
        } elseif (isset($_GET['post'])) {
            $thispost = get_post($_GET['post']);
            return $thispost->post_type;
        } else {
            return null;
        }
    }

}

/*
  Removing Demo Mode and Notices

 */

add_action('init', 'baganuur_ut_core_redux_remove_demo_mode_notices');
if (!function_exists('baganuur_ut_core_redux_remove_demo_mode_notices')) {

    function baganuur_ut_core_redux_remove_demo_mode_notices() { // Be sure to rename this function to something more unique
        if ( class_exists('ReduxFramework') ) {
            remove_filter( 'plugin_row_meta', array( ReduxFrameworkPlugin::get_instance(), 'plugin_metalinks'), null, 2 );
        }
        if ( class_exists('ReduxFramework') ) {
            remove_action('admin_notices', array( ReduxFrameworkPlugin::get_instance(), 'admin_notices' ) );    
        }
    }
}