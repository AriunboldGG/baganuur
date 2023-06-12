<?php
/*
  This PHP file contains helpful functions on our theme.

 */

/*
  Comment Form

 */

if (!function_exists('baganuur_ut_comment_form')) {

    function baganuur_ut_comment_form($fields) {

        $commenter = wp_get_current_commenter();
        $req = get_option('require_name_email');
        $aria_req = ( $req ? " aria-required='true'" : '' );

        $fields = array(
            'author' => '<div class="comment-form-author"><p>' .
            '<input id="author" name="author" placeholder="' . esc_html__('Name', 'baganuur') . '" type="text" value="' . esc_attr($commenter['comment_author']) . '" size="30"' . $aria_req . ' />' . '</p>',
            'email' => '<p class="comment-form-email">' .
            '<input id="email" name="email" placeholder="' . esc_html__('Email', 'baganuur') . '" type="text" value="' . esc_attr($commenter['comment_author_email']) . '" size="30"' . $aria_req . ' />' . '</p>',
            'url' => '</div>',
        );
        return $fields;
    }

    add_filter('comment_form_default_fields', 'baganuur_ut_comment_form');
}

/*
  Social Link

 */

if (!function_exists('baganuur_ut_social_link')) {

    function baganuur_ut_social_link($link, $has_icon = 'icon-yes') {
        if (!empty($link)) {
            $social = baganuur_ut_core_get_social_name(esc_url($link));
            if ( $has_icon == 'icon-yes') {
                if ( $social['name'] === 'print' ) {
                    return '<a title="' . esc_attr($social['name']) . '" href="javascript:window.print()" class="' . esc_attr($social['name']) . ' icon"><i class="social-icon-widget ' . esc_attr($social['class']) . '"></i></a>';
                }else{
                    return '<a target="_blank" title="' . esc_attr($social['name']) . '" href="' . esc_url($link) . '" class="' . esc_attr($social['name']) . ' icon"><i class="social-icon-widget ' . esc_attr($social['class']) . '"></i></a>';
                }
            } else {
                return '<a target="_blank" title="' . esc_attr($social['name']) . '" href="' . esc_url($link) . '"><span class="social-icon-widget">' . esc_attr($social['name']) . '</span></a>';
            }
        }
    }

}

/*
  Array to String

 * This function converts one element array to string for metabox.
 */

if (!function_exists('baganuur_ut_array_to_string')) {

    function baganuur_ut_array_to_string($arr) {
        return implode('', $arr);
    }

}

/*
  Pagination - Simple

 */

if (!function_exists('baganuur_ut_pagination_simple')) {

    function baganuur_ut_pagination_simple() {

        global $wp_query;
        $pages = $wp_query->max_num_pages;
        if (get_query_var('paged')) {
            $paged = get_query_var('paged');
        } elseif (get_query_var('page')) {
            $paged = get_query_var('page');
        } else {
            $paged = 1;
        }

        if (empty($pages)) {
            $pages = 1;
        }
        if (1 != $pages) {
            $big = 9999; // need an unlikely integer

            echo "<div class='baganuur-ut-pagination clearfix'>";
            $pagination = paginate_links(
                array(
                    'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
                    'end_size' => 100,
                    'mid_size' => 100,
                    'format' => '?paged=%#%',
                    'current' => max(1, get_query_var('paged')),
                    'total' => $wp_query->max_num_pages,
                    'type' => 'list',
                    'prev_text' => '<i class="fa fa-angle-left"></i>',
                    'next_text' => '<i class="fa fa-angle-right"></i>',
                )
            );
            echo balanceTags($pagination);
            echo "</div>";
        }
    }

}

/*
  Pagination - Infinite

 */

if (!function_exists('baganuur_ut_pagination_infinite')) {

    function baganuur_ut_pagination_infinite() {

        global $wp_query;
        $pages = intval($wp_query->max_num_pages);
        $paged = (get_query_var('paged')) ? intval(get_query_var('paged')) : 1;
        if (empty($pages)) {
            $pages = 1;
        }
        if (1 != $pages) {
            $primary_color = baganuur_ut_get_primary_color();
            echo '<div class="baganuur-ut-pagination baganuur-ut-infinite-scroll align-center" data-has-next="' . ($paged === $pages ? 'false' : 'true') . '">';
            echo '<a class="no-more" href="#">+</a>';
            echo '<a class="loading" href="#">';
                echo '<svg width="15" height="80" viewBox="0 0 45 50" xmlns="http://www.w3.org/2000/svg" fill="' . esc_attr($primary_color) . '">
                        <circle cx="15" cy="15" r="15">
                            <animate attributeName="r" from="15" to="15"
                                     begin="0s" dur="0.8s"
                                     values="15;9;15" calcMode="linear"
                                     repeatCount="indefinite" />
                            <animate attributeName="fill-opacity" from="1" to="1"
                                     begin="0s" dur="0.8s"
                                     values="1;.5;1" calcMode="linear"
                                     repeatCount="indefinite" />
                        </circle>
                        <circle cx="15" cy="60" r="9" fill-opacity="0.3">
                            <animate attributeName="r" from="9" to="9"
                                     begin="0s" dur="0.8s"
                                     values="9;15;9" calcMode="linear"
                                     repeatCount="indefinite" />
                            <animate attributeName="fill-opacity" from="0.5" to="0.5"
                                     begin="0s" dur="0.8s"
                                     values=".5;1;.5" calcMode="linear"
                                     repeatCount="indefinite" />
                        </circle>
                        <circle cx="15" cy="105" r="15">
                            <animate attributeName="r" from="15" to="15"
                                     begin="0s" dur="0.8s"
                                     values="15;9;15" calcMode="linear"
                                     repeatCount="indefinite" />
                            <animate attributeName="fill-opacity" from="1" to="1"
                                     begin="0s" dur="0.8s"
                                     values="1;.5;1" calcMode="linear"
                                     repeatCount="indefinite" />
                        </circle>
                    </svg>';
            echo '</a>';
            echo '<a class="next btn btn-s" href="' . get_pagenum_link($paged + 1) . '">';
                echo esc_html__('ᠦᠷᠭᠦᠯᠵᠢᠯᠡᠭᠦᠯᠬᠦ', 'baganuur');
            echo '</a>';
            echo '</div>';
        }
    }

}

/*
  Get Primary Color

 */

if (!function_exists('baganuur_ut_get_primary_color')) {

    function baganuur_ut_get_primary_color() {

        $primary_color = '';

        if ( baganuur_ut_acf_get_field('metabox') === 'on' ) {
            $metabox = array(
                'unique_primary_color' => baganuur_ut_acf_get_field('unique_primary_color'),
                'primary_color'        => baganuur_ut_acf_get_field('primary_color'),
            );
        }

        $ut_primary_color = baganuur_ut_get_options(BAGANUUR_UT_T_OPTIONS . "primary_color");

        wp_reset_query();

        if ( baganuur_ut_core_check_singular_and_metabox() ) {
            $primary_color = ($metabox['unique_primary_color'] === 'on') ? $metabox['primary_color'] : $ut_primary_color;
        } else {
            $primary_color = $ut_primary_color;
        }

        return $primary_color;
    }

}

/*
  Get Option

 */

if (!function_exists('baganuur_ut_get_options')) {

    function baganuur_ut_get_options($option_name) {
        global $baganuur_ut_get_options;

        if (isset($baganuur_ut_get_options[$option_name])) {
            return $baganuur_ut_get_options[$option_name];
        } else {
            return baganuur_ut_get_default($option_name);
        }

        return false;
    }

}

/*
  Set palette color on Color Picker

 */

add_action('in_admin_footer', 'baganuur_ut_load_javascript_on_admin_edit_post_page');
if (!function_exists('baganuur_ut_load_javascript_on_admin_edit_post_page')) {

    function baganuur_ut_load_javascript_on_admin_edit_post_page() {
        if (class_exists("baganuur_ut_config")) {
            global $parent_file, $baganuur_ut_get_options;

            $primary_color = $baganuur_ut_get_options[BAGANUUR_UT_T_OPTIONS . 'primary_color'];
            $palette_color_1 = $baganuur_ut_get_options[BAGANUUR_UT_T_OPTIONS . 'palette_color_1'];
            $palette_color_2 = $baganuur_ut_get_options[BAGANUUR_UT_T_OPTIONS . 'palette_color_2'];
            $palette_color_3 = $baganuur_ut_get_options[BAGANUUR_UT_T_OPTIONS . 'palette_color_3'];
            $palette_color_4 = $baganuur_ut_get_options[BAGANUUR_UT_T_OPTIONS . 'palette_color_4'];
            $palette_color_5 = $baganuur_ut_get_options[BAGANUUR_UT_T_OPTIONS . 'palette_color_5'];

            // If we're on the edit post page.=
            $str = 'edit.php';
            $result = strpos($parent_file, $str);

            if ($result === 0) {
                echo "<script>
                    jQuery(document).live('acf/setup_fields', function(e, div){
                        jQuery('.color_picker').each(function() {
                            jQuery(this).iris({
                                palettes: ['" . $primary_color . "', '" . $palette_color_1 . "', '" . $palette_color_2 . "', '" . $palette_color_3 . "', '" . $palette_color_4 . "', '" . $palette_color_5 . "']
                            });
                        });
                    });
                    </script>";
            }
        }
    }

}

/*
  Replace typography

 */

if (!function_exists('baganuur_ut_replace_typography')) {

    function baganuur_ut_replace_typography($data = array()) {

        if (empty($data['font-weight'])) {
            $data['font-weight'] = '400';
        }

        if (empty($data['font-style'])) {
            $data['font-style'] = 'normal';
        }

        if ($data['font-style'] == '400') {
            $data['font-weight'] = '400';
            $data['font-style'] = 'normal';
        }

        $data['letter-spacing'] = str_replace('px', '', $data['letter-spacing']);
        $data['letter-spacing'] = str_replace('em', '', $data['letter-spacing']);

        return $data;

    }

}

/*
  Mobile Menu Register

 */

if (!function_exists('baganuur_ut_mobile_menu')) {

    function baganuur_ut_mobile_menu() {
        wp_nav_menu(array(
            'menu' => '',
            'container' => false,
            'menu_id' => '',
            'menu_class' => 'sf-mobile-menu clearfix',
            'fallback_cb' => 'baganuur_ut_no_mobile',
            'theme_location' => 'baganuur-ut-main')
        );
    }

}

if (!function_exists('baganuur_ut_no_mobile')) {

    function baganuur_ut_no_mobile() {
        echo "<ul class='baganuur-ut-menu-list'><li class='baganuur-ut-menu-item'><a href='" . esc_url(admin_url('nav-menus.php?action=locations')) . "' class='baganuur-ut-menu-link'>";
        echo esc_html('Create or Choose Menu', 'baganuur');
        echo "</a></li></ul>";
    }

}

/*
  check redux active

 */

if (!function_exists('baganuur_ut_check_redux_active')) {

    function baganuur_ut_check_redux_active() {

        $is_active = false;
        if (is_plugin_active('redux-framework/redux-framework.php')) {
            $is_active = true;
        }

        return $is_active;
    }

}

/*
  check ACF active

 */

if (!function_exists('baganuur_ut_check_acf_active')) {

    function baganuur_ut_check_acf_active() {

        $is_active = false;
        if (is_plugin_active('advanced-custom-fields/acf.php')) {
            $is_active = true;
        }

        return $is_active;
    }

}

/*
  check Visual Composer active

 */

if (!function_exists('baganuur_ut_check_vc_active')) {

    function baganuur_ut_check_vc_active() {

        $is_active = false;
        if (is_plugin_active('js_composer/js_composer.php')) {
            $is_active = true;
        }

        return $is_active;
    }

}

/*
  check plugin active

 */

if (!function_exists('baganuur_ut_check_plugin_active')) {

    function baganuur_ut_check_plugin_active() {

        $is_active = false;
        if (baganuur_ut_check_redux_active() && baganuur_ut_check_acf_active()) {
            $is_active = true;
        }

        return $is_active;
    }

}

/*
  get ACF fields

 */

if (!function_exists('baganuur_ut_acf_get_field')) {

    function baganuur_ut_acf_get_field($field_name) {

        if (empty($field_name)) {
            return;
        }

        switch ($field_name) {
            /*
              Defaults

             */

            case 'baganuur_ut_revolution_slider':
                if ( !baganuur_ut_check_plugin_active() ) {
                    return '';
                }
                return get_field('baganuur_ut_revolution_slider');
            
            case 'baganuur_ut_layer_slider':
                if ( !baganuur_ut_check_plugin_active() ) {
                    return '';
                }
                return get_field('baganuur_ut_layer_slider');
            
            case 'baganuur_ut_master_slider':
                if ( !baganuur_ut_check_plugin_active() ) {
                    return '';
                }
                return get_field('baganuur_ut_master_slider');
            
            case 'google_map':
                if ( !baganuur_ut_check_plugin_active() ) {
                    return '';
                }
                return get_field('google_map');

            case 'metabox':
                wp_reset_query();
                if ( !baganuur_ut_check_plugin_active() ) {
                    return 'off';
                }
                return get_field('metabox');

            case 'blog_gallery_type':
                if ( !baganuur_ut_check_plugin_active() ) {
                    return 'gallery-carousel';
                }
                return get_field('blog_gallery_type');

            case 'blog_gallery_transition':
                if ( !baganuur_ut_check_plugin_active() ) {
                    return 'fade';
                }
                return get_field('blog_gallery_transition');

            case 'blog_gallery_progressbar':
                if ( !baganuur_ut_check_plugin_active() ) {
                    return 'progressbar-off';
                }
                return get_field('blog_gallery_progressbar');

        }
    }

}

/*
  get Redux defaults

 */

if (!function_exists('baganuur_ut_get_default')) {

    function baganuur_ut_get_default($option_name) {

        if (empty($option_name)) {
            return;
        }

        switch ($option_name) {
            /*
              Defaults

             */
            /*
              General Options
              Logo & Favicon

             */

            case BAGANUUR_UT_T_OPTIONS . 'upload_top_logo':
                $default = array(
                    'url' => BAGANUUR_UT_THEME_DIR . '/backend/assets/img/header-1-img-white.png'
                );
                return $default;
            case BAGANUUR_UT_T_OPTIONS . 'upload_bottom_logo':
                $default = array(
                    'url' => BAGANUUR_UT_THEME_DIR . '/backend/assets/img/header-2-img-white.png'
                );
                return $default;
            case BAGANUUR_UT_T_OPTIONS . 'upload_core_logo':
                $default = array(
                    'url' => BAGANUUR_UT_THEME_DIR . '/backend/assets/img/logo-light.png'
                );
                return $default;
            case BAGANUUR_UT_T_OPTIONS . 'upload_favicon':
                $default = array(
                    'url' => BAGANUUR_UT_THEME_DIR . '/backend/assets/img/favicon.ico'
                );
                return $default;
            

            /*
              General Options
              Retina Ready?

             */

            case BAGANUUR_UT_T_OPTIONS . 'retina_logo_ready':
                $default = false;
                return $default;
            case BAGANUUR_UT_T_OPTIONS . 'retina_dark_logo':
                $default = array(
                    'url' => BAGANUUR_UT_THEME_DIR . '/backend/assets/img/retina-logo-dark.png'
                );
                return $default;
            case BAGANUUR_UT_T_OPTIONS . 'retina_light_logo':
                $default = array(
                    'url' => BAGANUUR_UT_THEME_DIR . '/backend/assets/img/retina-logo-light.png'
                );
                return $default;
            case BAGANUUR_UT_T_OPTIONS . 'retina_favicon':
                $default = array();
                return $default;

            /*
              General Options
              Additional

             */

            case BAGANUUR_UT_T_OPTIONS . 'smooth_scrolling':
                $default = false;
                return $default;
            case BAGANUUR_UT_T_OPTIONS . 'copyright_text':
                $default = esc_html__('ᠮᠣᠩᠭᠣᠯ ᠤᠯᠤᠰ ᠤᠨ ᠶᠡᠷᠦᠩᠬᠡᠶᠢᠯᠡᠭᠴᠢ ᠬᠠᠯᠲᠠᠮ᠎ᠠ ᠶᠢᠨ ᠪᠠᠲᠤᠲᠤᠯᠭ᠎ᠠ', 'baganuur');
                return $default;
            case BAGANUUR_UT_T_OPTIONS . 'mn_url':
                $default = esc_html__('http://www.baganuur.mn', 'baganuur');
                return $default;
            case BAGANUUR_UT_T_OPTIONS . 'mn_text':
                $default = esc_html__('mn', 'baganuur');
                return $default;
            case BAGANUUR_UT_T_OPTIONS . 'en_url':
                $default = esc_html__('http://www.baganuur.mn/en', 'baganuur');
                return $default;
            case BAGANUUR_UT_T_OPTIONS . 'en_text':
                $default = esc_html__('en', 'baganuur');
                return $default;

            /*
              Color Options
              General Colors

             */

            case BAGANUUR_UT_T_OPTIONS . 'primary_color':
                $default = '#ffb504';
                return $default;
            case BAGANUUR_UT_T_OPTIONS . 'body_color':
                $default = '#808080';
                return $default;
            case BAGANUUR_UT_T_OPTIONS . 'body_bg_color':
                $default = '#fff';
                return $default;
            case BAGANUUR_UT_T_OPTIONS . 'img_overlay_color':
                $default = '#ffb504';
                return $default;
            case BAGANUUR_UT_T_OPTIONS . 'img_overlay_color_opacity':
                $default = 0.8;
                return $default;

            /*
              Color Options
              Palette Colors

             */

            case BAGANUUR_UT_T_OPTIONS . 'palette_color_1':
                $default = '#96bf48';
                return $default;
            case BAGANUUR_UT_T_OPTIONS . 'palette_color_2':
                $default = '#121714';
                return $default;
            case BAGANUUR_UT_T_OPTIONS . 'palette_color_3':
                $default = '#666666';
                return $default;
            case BAGANUUR_UT_T_OPTIONS . 'palette_color_4':
                $default = '#f2f7fa';
                return $default;
            case BAGANUUR_UT_T_OPTIONS . 'palette_color_5':
                $default = '#f5f5f5';
                return $default;

            /*
              Typography & Font Options
              Body & Menu Font

             */

            case BAGANUUR_UT_T_OPTIONS . 'body_font':
                $default = array(
                    'font-family' => 'Playfair Display',
                    'font-size' => '14px',
                    'letter-spacing' => '0.025',
                    'font-weight' => '400',
                    'font-style' => '',
                    'google' => true,
                );
                return $default;

            /*
              Google & Twitter API

             */

            case BAGANUUR_UT_T_OPTIONS . 'google_api':
                $default = '';
                return $default;
            case BAGANUUR_UT_T_OPTIONS . 'consumer_key':
                $default = '';
                return $default;
            case BAGANUUR_UT_T_OPTIONS . 'consumer_secret':
                $default = '';
                return $default;
            case BAGANUUR_UT_T_OPTIONS . 'access_token':
                $default = '';
                return $default;
            case BAGANUUR_UT_T_OPTIONS . 'access_token_secret':
                $default = '';
                return $default;

            /*
              Custom Translations

             */

            case BAGANUUR_UT_T_OPTIONS . 'translation_enabled':
                $default = false;
                return $default;
            case BAGANUUR_UT_T_OPTIONS . 'is_category':
                $default = esc_html__('Category', 'baganuur');
                return $default;
            case BAGANUUR_UT_T_OPTIONS . 'is_tag':
                $default = esc_html__('Tag', 'baganuur');
                return $default;
            case BAGANUUR_UT_T_OPTIONS . 'is_404':
                $default = esc_html__('Nothing found!', 'baganuur');
                return $default;
            case BAGANUUR_UT_T_OPTIONS . 'is_author':
                $default = esc_html__('Author', 'baganuur');
                return $default;
            case BAGANUUR_UT_T_OPTIONS . 'is_archive':
                $default = esc_html__('Blog Archives', 'baganuur');
                return $default;
            case BAGANUUR_UT_T_OPTIONS . 'is_day':
                $default = esc_html__('Daily Archives', 'baganuur');
                return $default;
            case BAGANUUR_UT_T_OPTIONS . 'is_month':
                $default = esc_html__('Monthly Archives', 'baganuur');
                return $default;
            case BAGANUUR_UT_T_OPTIONS . 'is_year':
                $default = esc_html__('Yearly Archives', 'baganuur');
                return $default;
            case BAGANUUR_UT_T_OPTIONS . 'is_search':
                $default = esc_html__('Search results for', 'baganuur');
                return $default;

            /*
              Custom CSS

             */

            case BAGANUUR_UT_T_OPTIONS . 'custom_css':
                $default = '';
                return $default;
        }
    }

}

if (!function_exists('baganuur_ut_get_color')) {

    function baganuur_ut_get_color($color) {

        global $baganuur_ut_get_options;

        if ((strpos($color, 'primary_color') !== false ||
            strpos($color, 'palette_color_1') !== false ||
            strpos($color, 'palette_color_2') !== false ||
            strpos($color, 'palette_color_3') !== false ||
            strpos($color, 'palette_color_4') !== false ||
            strpos($color, 'palette_color_5') !== false ) && class_exists('baganuur_ut_config')) {
            return $color = $baganuur_ut_get_options[BAGANUUR_UT_T_OPTIONS . $color];
        } else {
            return $color = $color;
        }
    }

}

/*
  Get result for Redux Switch field

 */

if (!function_exists('baganuur_ut_get_switch_result')) {

    function baganuur_ut_get_switch_result($field = '') {

        if ( empty($field)) {
            return;
        }

        $result = baganuur_ut_get_options($field);

        switch($result) {
            case true:
                return 'on';
            case false:
                return 'off';
            case '1':
                return 'on';
            case '0':
                return 'off';
        }
    }

}

/*
  Visual Composer - Render Path

 */

if (function_exists('vc_set_shortcodes_templates_dir')) {
    $dir = BAGANUUR_UT_THEME_PATH . '/backend/vc-render';
    vc_set_shortcodes_templates_dir($dir);
}

/*
  Comment form - comment field to bottom

 */

if (!function_exists('baganuur_ut_move_comment_field_to_bottom')) {
    function baganuur_ut_move_comment_field_to_bottom( $fields ) {
        if ( isset($fields['comment']) ) {
            $comment_field = $fields['comment'];
            unset( $fields['comment'] );
            $fields['comment'] = $comment_field;
        }
        if ( isset($fields['website']) ) {
            $website_field = $fields['website'];
            unset( $fields['website'] );
            $fields['website'] = $website_field;
        }

        return $fields;
    }
}
add_filter( 'comment_form_fields', 'baganuur_ut_move_comment_field_to_bottom' );

/*
   Posted time

*/

if ( !function_exists('baganuur_ut_k99_relative_time') ) {
    function baganuur_ut_k99_relative_time() {

        $result = false;

        $post_date = get_the_time('U');
        $delta = time() - $post_date;
        if ( $delta < 60 ) {
            $result = '<span>' . esc_html__('few second ago', 'baganuur') . '</span>';
        } elseif ($delta > 60 && $delta < (60*60)){
            $result = '<span>' . strval(round(($delta/60),0)) . ' ' . esc_html__('min ago', 'baganuur') . '</span>';
        } elseif ($delta > (60*60) && $delta < (120*60)){
            $result = '<span>' . esc_html__('1 hour ago', 'baganuur') . '<span>';
        } elseif ($delta > (120*60) && $delta < (24*60*60)){
            $result = '<span>' . strval(round(($delta/3600),0)) . ' ' . esc_html__('hrs ago', 'baganuur') . '</span>';
        } else {
            $result = '<span>' . get_the_time('d.M.Y') . '</span>';
        }

        return $result;

    }
}

/*
  Featured Text

 */

if (!function_exists('baganuur_ut_featured_text')) {

    function baganuur_ut_featured_text() {

        $result = '';

        $translation_enabled = baganuur_ut_get_switch_result(BAGANUUR_UT_T_OPTIONS . 'translation_enabled');

        if (is_category()) {
            $category_text = ( $translation_enabled === 'on' ) ? baganuur_ut_get_options(BAGANUUR_UT_T_OPTIONS . 'is_category') : esc_html__('Category', 'baganuur');
            $result = $category_text . " : " . single_cat_title("", false);
            return $result;
        }

        if (is_tag()) {
            $tag_text = ( $translation_enabled === 'on' ) ? baganuur_ut_get_options(BAGANUUR_UT_T_OPTIONS . 'is_tag') : esc_html__('Tag', 'baganuur');
            $result = $tag_text . " : " . single_tag_title("", false);
            return $result;
        }

        if (is_404()) {
            $page404_text = ( $translation_enabled === 'on' ) ? baganuur_ut_get_options(BAGANUUR_UT_T_OPTIONS . 'is_404') : esc_html__('Nothing Found!', 'baganuur');
            $result = $page404_text;
            return $result;
        }

        if (is_author()) {
            $author_text = ( $translation_enabled === 'on' ) ? baganuur_ut_get_options(BAGANUUR_UT_T_OPTIONS . 'is_author') : esc_html__('Author', 'baganuur');
            $author = baganuur_ut_globals::set('author');
            $userdata = get_userdata($author);
            $result = $author_text . " : " . $userdata->display_name;
            return $result;
        }

        if (is_archive()) {

            if (is_day()) {
                $is_day_text = ( $translation_enabled === 'on' ) ? baganuur_ut_get_options(BAGANUUR_UT_T_OPTIONS . 'is_day') : esc_html__('Daily Archives', 'baganuur');
                $result = $is_day_text . " : " . get_the_date();
            }

            if (is_month()) {
                $is_month_text = ( $translation_enabled === 'on' ) ? baganuur_ut_get_options(BAGANUUR_UT_T_OPTIONS . 'is_month') : esc_html__('Monthly Archives', 'baganuur');
                $result = $is_month_text . " : " . get_the_date("F Y");
            }

            if (is_year()) {
                $is_year_text = ( $translation_enabled === 'on' ) ? baganuur_ut_get_options(BAGANUUR_UT_T_OPTIONS . 'is_year') : esc_html__('Yearly Archives', 'baganuur');
                $result = $is_year_text . " : " . get_the_date("Y");
            }

            $archive_text = ( $translation_enabled === 'on' ) ? baganuur_ut_get_options(BAGANUUR_UT_T_OPTIONS . 'is_archive') : esc_html__('Blog Archives', 'baganuur');
            $result = $archive_text;

            return $result;

        }

        if (is_search()) {
            $is_search_text = ( $translation_enabled === 'on' ) ? baganuur_ut_get_options(BAGANUUR_UT_T_OPTIONS . 'is_search') : esc_html__('Search results for', 'baganuur');
            $return = $is_search_text . " : " . get_search_query();
            return $return;
        }

    }

}

/*
  Metabox

 */

if (!function_exists('baganuur_ut_metabox')) {

    function baganuur_ut_metabox($name) {
        $post_id = get_the_ID();
        if ($post_id) {
            $metabox = get_post_meta($post_id, '', true);
            return isset($metabox[$name]) ? $metabox[$name] : "";
        }
        return array();
    }

}

/*
  Metaboxes

 */

if (!function_exists('baganuur_ut_metaboxes')) {

    function baganuur_ut_metaboxes() {
        $post_id = get_the_ID();
        if ($post_id) {
            return get_post_meta($post_id, '', true);
        }
        return array();
    }

}

/*
  Comment Count Style 2 No Text

 */

if (!function_exists('baganuur_ut_comment_count_s2')) {

    function baganuur_ut_comment_count_s2() {
        $comment_count = get_comments_number('0', '1', '%');
        if ($comment_count == 0) {
            $comment_trans = esc_html__('0', 'baganuur');
        } elseif ($comment_count == 1) {
            $comment_trans = esc_html__('1', 'baganuur');
        } else {
            $comment_trans = sprintf(esc_html__('%s', 'baganuur'), $comment_count);
        }
        return "<a href='" . esc_url(get_comments_link()) . "' title='" . esc_attr($comment_trans) . "' class='comment-count'>" . esc_html($comment_trans) . "</a>";
    }

}