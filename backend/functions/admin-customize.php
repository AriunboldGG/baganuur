<?php
/*
  This PHP file contains helpful functions on our admin panel.

*/

add_action('admin_print_scripts', 'baganuur_ut_admin_theme_scripts');
if (!function_exists('baganuur_ut_admin_theme_scripts')) {
    function baganuur_ut_admin_theme_scripts() {
        global $post, $pagenow;
        if ( current_user_can('edit_posts') && ( $pagenow == 'post-new.php' || $pagenow == 'post.php') ) {
            if ( isset( $post ) ) {
                wp_localize_script( 'jquery', 'uniontheme_script_data', array(
                    'home_uri' => esc_url(home_url('/')),
                    'post_id' => esc_attr($post->ID),
                    'nonce' => esc_attr(wp_create_nonce( 'uniontheme-ajax' )),
                    'image_ids' => esc_attr(get_post_meta( $post->ID, 'gallery_image_ids', true )),
                    'label_create' => esc_html__("Add Gallery Images", 'baganuur'),
                    'label_edit' => esc_html__("Edit Gallery", 'baganuur'),
                    'label_save' => esc_html__("Save Gallery", 'baganuur'),
                    'label_saving' => esc_html__("Saving...", 'baganuur')
                ));
                wp_enqueue_script('jquery-ui-dialog');
                wp_enqueue_script('baganuur-ut-gallery-metabox',  BAGANUUR_UT_THEME_DIR . '/backend/assets/js/admin-script.js', array(), BAGANUUR_UT_THEMEVERSION, true); 
            }
        }
    }
}