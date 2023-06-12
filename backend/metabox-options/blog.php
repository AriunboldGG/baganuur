<?php

/*
  Blog

 */

if ( function_exists("register_field_group") ) {
    register_field_group( array (
        'id' => 'acf_blog-metabox',
        'title' => esc_html__('Post Options', 'baganuur'),
        'fields' => array (
            array (
                'key' => 'field_56ef566f26d91',
                'label' => esc_html__('Blog Size', 'baganuur'),
                'name' => 'blog_size',
                'type' => 'select',
                'instructions' => esc_html__('This options will be used Blog Metro only. 1x1 Recommended Size: 500x500 pixel, 1x2 mean 500:1000 etc', 'baganuur'),
                'choices' => array (
                    'default' => esc_html__('Default (1x1)', 'baganuur'),
                    'horizontal' => esc_html__('Horizontal (2x1)', 'baganuur'),
                    'vertical' => esc_html__('Vertical (1x2)', 'baganuur'),
                    'large' => esc_html__('Large (2x2)', 'baganuur'),
                ),
                'default_value' => 'default',
                'allow_null' => 0,
                'multiple' => 0,
            ),
            array (
                'key' => 'field_56ef566f26d99',
                'label' => esc_html__('Position (Metro Style)', 'baganuur'),
                'name' => 'blog_position',
                'type' => 'select',
                'instructions' => esc_html__('Metro style only.', 'baganuur'),
                'choices' => array (
                    'left top' => esc_html__('Left Top', 'baganuur'),
                    'left center' => esc_html__('Left Center', 'baganuur'),
                    'left bottom' => esc_html__('Left Bottom', 'baganuur'),
                    'center top' => esc_html__('Center Top', 'baganuur'),
                    'center center' => esc_html__('Center Center', 'baganuur'),
                    'center bottom' => esc_html__('Center Bottom', 'baganuur'),
                    'right top' => esc_html__('Right Top', 'baganuur'),
                    'right center' => esc_html__('Right Center', 'baganuur'),
                    'right bottom' => esc_html__('Right Bottom', 'baganuur'),
                ),
                'default_value' => 'center center',
                'allow_null' => 0,
                'multiple' => 0,
            ),
            array (
                'key' => 'field_56ef566f26d98',
                'label' => esc_html__('Gallery Transition', 'baganuur'),
                'name' => 'blog_gallery_transition',
                'type' => 'select',
                'instructions' => esc_html__('Single Post only.', 'baganuur'),
                'choices' => array (
                    'fade' => esc_html__('Fade', 'baganuur'),
                    'backSlide' => esc_html__('BackSlide', 'baganuur'),
                    'goDown' => esc_html__('goDown', 'baganuur'),
                    'fadeUp' => esc_html__('FadeUp', 'baganuur'),
                ),
                'default_value' => 'fade',
                'allow_null' => 0,
                'multiple' => 0,
            ),
            array (
                'key' => 'field_56ef566f26d97',
                'label' => esc_html__('Gallery Progress Bar', 'baganuur'),
                'name' => 'blog_gallery_progressbar',
                'type' => 'radio',
                'instructions' => esc_html__('Single Post only.', 'baganuur'),
                'choices' => array (
                    'progressbar-on' => esc_html__('On', 'baganuur'),
                    'progressbar-off' => esc_html__('Off', 'baganuur'),
                ),
                'default_value' => 'progressbar-off',
                'allow_null' => 0,
                'multiple' => 0,
                'layout' => 'horizontal',
            ),
        ),
        'location' => array (
            array (
                array (
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'post',
                    'order_no' => 1,
                    'group_no' => 1,
                ),
            ),
        ),
        'options' => array (
            'position' => 'normal',
            'layout' => 'default',
            'hide_on_screen' => array (
            ),
        ),
        'menu_order' => 6,
    ));
}
