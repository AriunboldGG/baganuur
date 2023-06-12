<?php
/*
  Creates a gallery metabox for WordPress

 */

add_action('admin_init', 'baganuur_ut_gallery_metabox_init');
if ( !function_exists('baganuur_ut_gallery_metabox_init') ) {
    function baganuur_ut_gallery_metabox_init() {
        $types = array(
            'post',
        );

        $types  = apply_filters( 'baganuur_ut_gallery_metabox_post_types', $types );

        foreach ( $types as $type ) {
            add_meta_box(
                'post-format-gallery',    // ID
                esc_html__( 'Gallery Settings', 'baganuur' ),// Title
                'baganuur_ut_gallery_metabox_render',       // Callback
                $type,                          // Post type
                'normal',                       // Cotext
                'high',                          // Priority
                array(
                    array( 
                        "name" => esc_html__('Upload images', 'baganuur'),
                        "desc" => esc_html__('Gallery Images will be displayed in Post Single, Featured Image will be displayed in Post pagebuilder element. Recommended size is: 1170x600, Featured Image size is:700x500.', 'baganuur'),
                        "id" => "gallery_image_ids",
                        "type" => 'gallery'),
                    array(
                        'name' => esc_html__('Gallery height', 'baganuur'),
                        'desc' => esc_html__('NOTES: This option works either single post. If you leave as blank then it will get current image height.', 'baganuur'),
                        'id' => 'gallery_height',
                        'type' => 'text'),
                )
            );
        }
    }
}

/*
  Gallery Metabox Prepare Render

 */

if ( !function_exists('baganuur_ut_gallery_metabox_render') ) {
    function baganuur_ut_gallery_metabox_render($post, $metabox) { ?>
        <input type="hidden" name="baganuur_ut_meta_box_nonce" value="<?php echo wp_create_nonce(basename(__FILE__));?>" />
        <div class="baganuur-ut-metaboxes">
            <?php
                $currID = $post->ID;
                if(!empty($metabox['fe_id'])){
                    if($metabox['fe_id']==='none'){
                        $currID=0;
                    }else{
                        $currID=$metabox['fe_id'];
                    }
                }

                foreach ( $metabox['args'] as $field ) {
                    switch ( $field['id'] ) {
                        case 'gallery_image_ids':
                            call_user_func('baganuur_ut_gallery_render', $field);
                            break;
                        case 'gallery_height':
                            call_user_func('baganuur_ut_gallery_render', $field, false);
                            break;
                    }
                }

                ?>
        </div>
    <?php 
    }
}

/*
  Gallery Metabox Render

 */

if ( !function_exists('baganuur_ut_gallery_render')) {
    function baganuur_ut_gallery_render($settings, $is_gallery = true ){

        global $post;
        if ( $is_gallery ) {
            $ids = get_post_meta( $post->ID, 'gallery_image_ids', true );
            $gallery_thumbs = '';
            $button_text = ($ids) ? esc_html__('Edit Gallery', 'baganuur') : esc_html__('Upload Images', 'baganuur');
            if( $ids ) {
                $thumbs = explode(',', $ids);
                foreach( $thumbs as $thumb ) {
                    if(!empty($thumb)){
                        $gallery_thumbs .= '<li>' . wp_get_attachment_image( $thumb, array(32,32) ) . '</li>';
                    }
                }
            }
        } else {
            $gallery_height = get_post_meta( $post->ID, 'gallery_height', true );
        }

        ?>
        <div class="<?php echo esc_attr($settings['id']); ?>">
            <p class="label">
                <label for="<?php echo esc_attr($settings['id']); ?>"><?php echo esc_attr($settings['name']); ?></label>
                <?php echo esc_attr($settings['desc']); ?>
            </p>
            <div><?php
            if ( $is_gallery ) {?>
                <input type="button" class="button" id="gallery_images_upload" value="<?php echo esc_attr($button_text); ?>" />
                <input type="hidden" name="gallery_image_ids" id="gallery_image_ids" value="<?php echo esc_attr($ids ? $ids : 'false'); ?>" />
                <ul class="gallery-thumbs clearfix"><?php echo balanceTags($gallery_thumbs);?></ul>
            <?php
            } else {?>
                <div class="acf-input-wrap">
                    <input type="text" id="gallery_height" class="text" name="gallery_height" value="<?php echo esc_attr($gallery_height ? $gallery_height : ''); ?>" placeholder="Please write gallery height" />
                </div>
        <?php } ?>
            </div>
            
        </div><?php
    }
}

/*
  Save Metabox

 */

add_action('save_post', 'baganuur_ut_save_custom_meta');
if ( !function_exists('baganuur_ut_save_custom_meta') ) {
    function baganuur_ut_save_custom_meta($post_id) {

        // verify nonce
        if (!isset($_POST['baganuur_ut_meta_box_nonce']) || !wp_verify_nonce($_POST['baganuur_ut_meta_box_nonce'], basename(__FILE__))) {
            return $post_id;
        }

        // check autosave
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return $post_id;
        }

        // check FePublish Trash
        if (!isset($_POST['post_type'])) {
            return $post_id;
        }

        $post_type = baganuur_ut_core_get_current_post_type();

        if ( $post_type == 'post') {
            $ids = strip_tags(rtrim($_POST['gallery_image_ids'], ','));
            $height = $_POST['gallery_height'];

            update_post_meta($post_id, 'gallery_image_ids', $ids);
            update_post_meta($post_id, 'gallery_height', $height);
        }

    }
}

/*
  Save Gallery Metabox

 */

if ( !function_exists('baganuur_ut_gallery_save_images') ) {
    function baganuur_ut_gallery_save_images() {

        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) { return; }

        if ( !isset($_POST['ids']) || !isset($_POST['nonce']) || !wp_verify_nonce( $_POST['nonce'], 'uniontheme-ajax' ) ) { return; }

        if ( !current_user_can( 'edit_posts' ) ) { return; }

        $ids = strip_tags(rtrim($_POST['ids'], ','));

        // update thumbs
        $thumbs = explode(',', $ids);
        $gallery_thumbs = '';
        foreach( $thumbs as $thumb ) {
            if(!empty($thumb)){
                $gallery_thumbs .= '<li>' . wp_get_attachment_image( $thumb, array(32,32) ) . '</li>';
            }
        }

        echo balanceTags($gallery_thumbs);

        die();
    }
}
add_action('wp_ajax_baganuur_ut_gallery_save_images', 'baganuur_ut_gallery_save_images' );