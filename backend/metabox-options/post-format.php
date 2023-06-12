<?php
if ( function_exists("register_field_group") ) {

    /*
      Video settings

     */

    register_field_group( array (
        'id' => 'acf_video-settings',
        'title' => esc_html__('Video settings', 'baganuur'),
        'fields' => array (
                array (
                        'key' => 'field_56e8d3031d559',
                        'label' => esc_html__('M4V File URL', 'baganuur'),
                        'name' => 'format_video_m4v',
                        'type' => 'text',
                        'instructions' => esc_html__('The URL to the .m4v video file', 'baganuur'),
                        'default_value' => '',
                        'placeholder' => '',
                        'prepend' => '',
                        'append' => '',
                        'formatting' => 'html',
                        'maxlength' => '',
                ),
                array (
                        'key' => 'field_56e8d35f1d55a',
                        'label' => esc_html__('Video Thumbnail Image', 'baganuur'),
                        'name' => 'format_video_thumb',
                        'type' => 'text',
                        'instructions' => esc_html__('The preview image.', 'baganuur'),
                        'default_value' => '',
                        'placeholder' => '',
                        'prepend' => '',
                        'append' => '',
                        'formatting' => 'html',
                        'maxlength' => '',
                ),
                array (
                        'key' => 'field_56e8d3961d55b',
                        'label' => esc_html__('Embed Code', 'baganuur'),
                        'name' => 'format_video_embed',
                        'type' => 'textarea',
                        'instructions' => esc_html__('If you\'re not using self hosted video then you can add embed code here.', 'baganuur'),
                        'default_value' => '',
                        'placeholder' => '',
                        'maxlength' => '',
                        'rows' => 5,
                        'formatting' => 'br',
                ),
        ),
        'location' => array (
                array (
                        array (
                                'param' => 'post_format',
                                'operator' => '==',
                                'value' => 'video',
                                'order_no' => 1,
                                'group_no' => 0,
                        ),
                ),
        ),
        'options' => array (
                'position' => 'normal',
                'layout' => 'default',
                'hide_on_screen' => array (
                ),
        ),
        'menu_order' => 1,
    ));

    /*
      Audio settings

     */

    register_field_group(array (
            'id' => 'acf_audio-settings',
            'title' => esc_html__('Audio settings', 'baganuur'),
            'fields' => array (
                    array (
                            'key' => 'field_56e8d52212495',
                            'label' => esc_html__('MP3 File URL', 'baganuur'),
                            'name' => 'format_audio_mp3',
                            'type' => 'text',
                            'instructions' => esc_html__('The URL to the .mp3 audio file.', 'baganuur'),
                            'default_value' => '',
                            'placeholder' => '',
                            'prepend' => '',
                            'append' => '',
                            'formatting' => 'html',
                            'maxlength' => '',
                    ),
                    array (
                            'key' => 'field_56e8d54c12496',
                            'label' => esc_html__('Audio Embed Code', 'baganuur'),
                            'name' => 'format_audio_embed',
                            'type' => 'text',
                            'instructions' => esc_html__('Please write/paste embed code here.', 'baganuur'),
                            'default_value' => '',
                            'placeholder' => '',
                            'prepend' => '',
                            'append' => '',
                            'formatting' => 'html',
                            'maxlength' => '',
                    ),
            ),
            'location' => array (
                    array (
                            array (
                                    'param' => 'post_format',
                                    'operator' => '==',
                                    'value' => 'audio',
                                    'order_no' => 2,
                                    'group_no' => 0,
                            ),
                    ),
            ),
            'options' => array (
                    'position' => 'normal',
                    'layout' => 'default',
                    'hide_on_screen' => array (
                            0 => 'custom_fields',
                            1 => 'discussion',
                            2 => 'comments',
                            3 => 'revisions',
                            4 => 'slug',
                            5 => 'send-trackbacks',
                    ),
            ),
            'menu_order' => 2,
    ));

    /*
      Quote settings

     */

    register_field_group(array (
            'id' => 'acf_quote-settings',
            'title' => esc_html__('Quote settings', 'baganuur'),
            'fields' => array (
                    array (
                            'key' => 'field_56e8d6b58086b',
                            'label' => esc_html__('The Quote', 'baganuur'),
                            'name' => 'format_quote_text',
                            'type' => 'textarea',
                            'instructions' => esc_html__('Write a quote in this field.', 'baganuur'),
                            'default_value' => '',
                            'placeholder' => '',
                            'maxlength' => '',
                            'rows' => 5,
                            'formatting' => 'br',
                    ),
                    array (
                            'key' => 'field_56e8d6e68086c',
                            'label' => esc_html__('The Author', 'baganuur'),
                            'name' => 'format_quote_author',
                            'type' => 'text',
                            'instructions' => esc_html__('Write a author name of quote.', 'baganuur'),
                            'default_value' => '',
                            'placeholder' => '',
                            'prepend' => '',
                            'append' => '',
                            'formatting' => 'html',
                            'maxlength' => '',
                    ),
            ),
            'location' => array (
                    array (
                            array (
                                    'param' => 'post_format',
                                    'operator' => '==',
                                    'value' => 'quote',
                                    'order_no' => 5,
                                    'group_no' => 0,
                            ),
                    ),
            ),
            'options' => array (
                    'position' => 'normal',
                    'layout' => 'default',
                    'hide_on_screen' => array (
                            0 => 'custom_fields',
                            1 => 'discussion',
                            2 => 'comments',
                            3 => 'revisions',
                            4 => 'slug',
                            5 => 'send-trackbacks',
                    ),
            ),
            'menu_order' => 4,
    ));

    /*
      Link settings

     */

    register_field_group(array (
            'id' => 'acf_link-settings',
            'title' => esc_html__('Link settings', 'baganuur'),
            'fields' => array (
                    array (
                            'key' => 'field_56e8d72b074a3',
                            'label' => esc_html__('The URL', 'baganuur'),
                            'name' => 'format_link_url',
                            'type' => 'text',
                            'instructions' => esc_html__('Insert the URL you wish to link to.', 'baganuur'),
                            'default_value' => '',
                            'placeholder' => '',
                            'prepend' => '',
                            'append' => '',
                            'formatting' => 'html',
                            'maxlength' => '',
                    ),
            ),
            'location' => array (
                    array (
                            array (
                                    'param' => 'post_format',
                                    'operator' => '==',
                                    'value' => 'link',
                                    'order_no' => 6,
                                    'group_no' => 0,
                            ),
                    ),
            ),
            'options' => array (
                    'position' => 'normal',
                    'layout' => 'default',
                    'hide_on_screen' => array (
                    ),
            ),
            'menu_order' => 5,
    ));
}