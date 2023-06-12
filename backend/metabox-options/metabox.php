<?php
/*
  Get wpdb

 */

if (!function_exists('baganuur_ut_get_wpdb')) {

    function baganuur_ut_get_wpdb() {
        global $wpdb;

        return $wpdb;
    }

}

/*
  Get Current Post Type 2

 */

if (!function_exists('baganuur_ut_get_current_post_type2')) {

    function baganuur_ut_get_current_post_type2() {
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
  Get primary color

 */

if (!function_exists('baganuur_ut_get_primary_color2')) {

    function baganuur_ut_get_primary_color2() {

        global $baganuur_ut_get_options;

        if (isset($baganuur_ut_get_options[BAGANUUR_UT_T_OPTIONS . 'primary_color'])) {
            return $baganuur_ut_get_options[BAGANUUR_UT_T_OPTIONS . 'primary_color'];
        } else {
            return '#ffb504';
        }

        return false;
    }

}

if (function_exists("register_field_group") && class_exists("baganuur_ut_config")) {

    $post_type = baganuur_ut_get_current_post_type2();
    $primary_color = baganuur_ut_get_primary_color2();

    $page_title_type_choice = array(
        'title' => esc_html__('Title', 'baganuur'),
        'featured_image' => esc_html__('Featured Image', 'baganuur'),
        'google_map' => esc_html__('Google Map', 'baganuur'),
        'none' => esc_html__('None', 'baganuur'),
    );

    /*
      Check if plugin activated.

     */

    $revolution_sliders = $layer_sliders = $master_sliders = array();

    /*
      Revolution Slider Plugin

     */

    if (is_plugin_active('revslider/revslider.php')) {
        $wpdb = baganuur_ut_get_wpdb();
        $page_title_type_choice = array(
            'title' => esc_html__('Title', 'baganuur'),
            'slider_revolution' => esc_html__('Revolution Slider', 'baganuur'),
            'featured_image' => esc_html__('Featured Image', 'baganuur'),
            'google_map' => esc_html__('Google Map', 'baganuur'),
            'none' => esc_html__('None', 'baganuur'),
        );

        $result = $wpdb->get_results( $wpdb->prepare(
            "SELECT id, title, alias FROM " . $wpdb->prefix . "revslider_sliders WHERE type != %s ORDER BY %s ASC LIMIT 999",
            array('template', 'id')
        ));
        
        $revolution_sliders = array();
        if ($result) {
            foreach ($result as $slider) {
                $revolution_sliders[] = array(
                    '[rev_slider ' . $slider->id . ']' => esc_attr($slider->title)
                );
            }
        } else {
            $revolution_sliders[] = array(
                '' => esc_html__('No sliders found', 'baganuur')
            );
        }
    } else {
        $slider_revolution = $revolution_sliders = '';
    }

    /*
      LayerSlider Plugin

     */

    if (is_plugin_active('layerslider/layerslider.php')) {
        $wpdb = baganuur_ut_get_wpdb();
        $page_title_type_choice = array(
            'title' => esc_html__('Title', 'baganuur'),
            'slider_layer' => esc_html__('LayerSlider', 'baganuur'),
            'featured_image' => esc_html__('Featured Image', 'baganuur'),
            'google_map' => esc_html__('Google Map', 'baganuur'),
            'none' => esc_html__('None', 'baganuur'),
        );

        $result = $wpdb->get_results( $wpdb->prepare(
            "SELECT id, title, alias FROM " . $wpdb->prefix . "revslider_sliders WHERE type != %s ORDER BY %s ASC LIMIT 999",
            array('template', 'id')
        ));

        $layer_sliders = array();
        if ($result) {
            foreach ($result as $slider) {
                $layer_sliders[] = array(
                    "[layerslider id=\'' . $slider->id . '\']" => esc_attr($slider->name)
                );
            }
        } else {
            $layer_sliders[] = array(
                '' => esc_html__('No sliders found', 'baganuur')
            );
        }
    } else {
        $slider_layer = $layer_sliders = '';
    }

    /*
      MasterSlider Plugin

     */

    if (is_plugin_active('masterslider/masterslider.php')) {
        $page_title_type_choice = array(
            'title' => esc_html__('Title', 'baganuur'),
            'slider_master' => esc_html__('MasterSlider', 'baganuur'),
            'featured_image' => esc_html__('Featured Image', 'baganuur'),
            'google_map' => esc_html__('Google Map', 'baganuur'),
            'none' => esc_html__('None', 'baganuur'),
        );

        if (defined('MSWP_AVERTA_VERSION')) {
            $result = get_mastersliders();
        }

        $master_sliders = array();

        if ($result) {
            foreach ($result as $slider) {
                $master_sliders[] = array(
                    "[masterslider id=\'' . $slider->id . '\']" => esc_attr($slider->name)
                );
            }
        } else {
            $master_sliders[] = array(
                '' => esc_html__('No sliders found', 'baganuur')
            );
        }
    } else {
        $slider_master = $master_sliders = '';
    }

    /*
      General Metabox option

     */

    $metabox_option = array(
        array(
            'key' => 'field_56e8c96ea3aaf',
            'label' => esc_html__('Page Title Type', 'baganuur'),
            'name' => 'page_title_type',
            'type' => 'select',
            'choices' => $page_title_type_choice,
            'default_value' => 'title',
            'allow_null' => 0,
            'multiple' => 0,
        ),
        array(
            'key' => 'field_56e8c8c47b777',
            'label' => esc_html__('Subtitle', 'baganuur'),
            'name' => 'subtitle', 
            'type' => 'text',
            'instructions' => esc_html__('If you leave as blank then it will be get value from Theme Options -> Layout -> Page Title -> Subtitle.', 'baganuur'),
            'conditional_logic' => array(
                'status' => 1,
                'rules' => array(
                    array(
                        'field' => 'field_56e8c96ea3aaf',
                        'operator' => '==',
                        'value' => 'title',
                    ),
                    array(
                        'field' => 'field_56e8c8c47b778',
                        'operator' => '==',
                        'value' => 'on',
                    ),
                ),
                'allorany' => 'all',
            ),
            'default_value' => '',
            'placeholder' => esc_html__('Subtitle', 'baganuur'),
            'prepend' => '',
            'append' => '',
            'formatting' => 'html',
            'maxlength' => '',
        ),
        array(
            'key' => 'field_56e9018c8d5c7',
            'label' => esc_html__('Revolution Slider', 'baganuur'),
            'name' => 'baganuur_ut_revolution_slider',
            'type' => 'select',
            'instructions' => esc_html__('Specify the Revolution Slider.', 'baganuur'),
            'conditional_logic' => array(
                'status' => 1,
                'rules' => array(
                    array(
                        'field' => 'field_56e8c96ea3aaf',
                        'operator' => '==',
                        'value' => 'slider_revolution',
                    ),
                ),
                'allorany' => 'all',
            ),
            'choices' => $revolution_sliders,
            'default_value' => '',
            'allow_null' => 0,
            'multiple' => 0,
        ),
        array(
            'key' => 'field_56e902068d5c8',
            'label' => esc_html__('LayerSlider', 'baganuur'),
            'name' => 'baganuur_ut_layer_slider',
            'type' => 'select',
            'instructions' => esc_html__('Specify the LayerSlider.', 'baganuur'),
            'conditional_logic' => array(
                'status' => 1,
                'rules' => array(
                    array(
                        'field' => 'field_56e8c96ea3aaf',
                        'operator' => '==',
                        'value' => 'slider_layer',
                    ),
                ),
                'allorany' => 'all',
            ),
            'choices' => $layer_sliders,
            'default_value' => '',
            'allow_null' => 0,
            'multiple' => 0,
        ),
        array(
            'key' => 'field_56e902398d5c9',
            'label' => esc_html__('MasterSlider', 'baganuur'),
            'name' => 'baganuur_ut_master_slider',
            'type' => 'select',
            'instructions' => esc_html__('Specify the MasterSlider.', 'baganuur'),
            'conditional_logic' => array(
                'status' => 1,
                'rules' => array(
                    array(
                        'field' => 'field_56e8c96ea3aaf',
                        'operator' => '==',
                        'value' => 'slider_master',
                    ),
                ),
                'allorany' => 'all',
            ),
            'choices' => $master_sliders,
            'default_value' => '',
            'allow_null' => 0,
            'multiple' => 0,
        ),
        array(
            'key' => 'field_56e902808d5ca',
            'label' => esc_html__('Google Map', 'baganuur'),
            'name' => 'google_map',
            'type' => 'textarea',
            'conditional_logic' => array(
                'status' => 1,
                'rules' => array(
                    array(
                        'field' => 'field_56e8c96ea3aaf',
                        'operator' => '==',
                        'value' => 'google_map',
                    ),
                ),
                'allorany' => 'all',
            ),
            'default_value' => '',
            'placeholder' => esc_html__('Please paste your google map embed code here.', 'baganuur'),
            'maxlength' => '',
            'rows' => 5,
            'formatting' => 'br',
        ),
    );

    if ( isset($sidebar_position) ) {
        $meta_fields = array_merge($sidebar_position, $metabox_option);
    } else {
        $meta_fields = $metabox_option;
    }

    $other_fields = array(
        array(
            'key' => 'field_56e8cd33dc5cf',
            'label' => esc_html__('General', 'baganuur'),
            'name' => '',
            'type' => 'tab',
            'conditional_logic' => array(
                'status' => 1,
                'rules' => array(
                    array(
                        'field' => 'field_56eb863c1c517',
                        'operator' => '==',
                        'value' => 'on',
                    ),
                ),
                'allorany' => 'all',
            ),
        ),
        array(
            'key' => 'field_56e8caada3ab9',
            'label' => esc_html__('Unique Primary Color?', 'baganuur'),
            'name' => 'unique_primary_color',
            'instructions' => esc_html__('helps to change Primary Color for this page or.', 'baganuur'),
            'type' => 'radio',
            'choices' => array(
                'on' => esc_html('On', 'baganuur'),
                'off' => esc_html('Off', 'baganuur'),
            ),
            'other_choice' => 0,
            'save_other_choice' => 0,
            'default_value' => 'off',
            'layout' => 'horizontal',
        ),
        array(
            'key' => 'field_56e8ce02dc5d3',
            'label' => esc_html__('Primary Color', 'baganuur'),
            'name' => 'primary_color',
            'type' => 'color_picker',
            'instructions' => esc_html__('Note the primary & palette colors are in the bottom of color picker. You can use one of them.', 'baganuur'),
            'conditional_logic' => array(
                'status' => 1,
                'rules' => array(
                    array(
                        'field' => 'field_56e8caada3ab9',
                        'operator' => '==',
                        'value' => 'on',
                    ),
                ),
                'allorany' => 'all',
            ),
            'default_value' => $primary_color,
        ),
        array(
            'key' => 'field_56e8c4187b776',
            'label' => esc_html__('Header Options', 'baganuur'),
            'name' => '',
            'type' => 'tab',
            'conditional_logic' => array(
                'status' => 1,
                'rules' => array(
                    array(
                        'field' => 'field_56eb863c1c517',
                        'operator' => '==',
                        'value' => 'on',
                    ),
                ),
                'allorany' => 'all',
            ),
        ),
        array(
            'key' => 'field_56e900fccddff',
            'label' => esc_html__('Header Visible', 'baganuur'),
            'name' => 'header_visible',
            'type' => 'radio',
            'instructions' => esc_html__('Please use it when you have a situation to disable header. For example: Coming Soon Page.', 'baganuur'),
            'required' => 0,
            'choices' => array(
                'on' => 'Show',
                'off' => 'Hide',
            ),
            'other_choice' => 0,
            'save_other_choice' => 0,
            'default_value' => 'on',
            'layout' => 'horizontal',
        ),
        array(
            'key' => 'field_new900fccddn1',
            'label' => esc_html__('Customize Header Options', 'baganuur'),
            'name' => 'header_customize',
            'type' => 'radio',
            'instructions' => esc_html__('If you enabled it then This option will override the Theme Options > Layout > Header section.', 'baganuur'),
            'required' => 0,
            'choices' => array(
                'on' => 'Enable',
                'off' => 'Disable',
            ),
            'conditional_logic' => array (
                'status' => 1,
                'rules' => array (
                    array (
                        'field' => 'field_56e900fccddff',
                        'operator' => '==',
                        'value' => 'on',
                    ),
                ),
                'allorany' => 'all',
            ),
            'other_choice' => 0,
            'save_other_choice' => 0,
            'default_value' => 'off',
            'layout' => 'horizontal',
        ),
        array(
            'key' => 'field_56e900f18d5c5',
            'label' => esc_html__('Header Layout Style', 'baganuur'),
            'name' => 'header_layout_style',
            'instructions' => esc_html__('Choose header layout style', 'baganuur'),
            'type' => 'select',
            'choices' => array(
                'normal' => esc_html__('Normal', 'baganuur'),
                'classic' => esc_html__('Classic', 'baganuur'),
                'menu-minimal' => esc_html__('Menu Minimal', 'baganuur'),
                'logo-top-center' => esc_html__('Logo Top Center', 'baganuur'),
                'left-side-menu' => esc_html__('Left-Side-Menu', 'baganuur'),
                'header-with-headline' => esc_html__('Header-with-Headline', 'baganuur'),
            ),
            'conditional_logic' => array (
                'status' => 1,
                'rules' => array (
                    array (
                        'field' => 'field_56e900fccddff',
                        'operator' => '==',
                        'value' => 'on',
                    ),
                    array (
                        'field' => 'field_new900fccddn1',
                        'operator' => '==',
                        'value' => 'on',
                    ),
                ),
                'allorany' => 'all',
            ),
            'other_choice' => 0,
            'save_other_choice' => 0,
            'default_value' => 'normal',
        ),
        array(
            'key' => 'field_11a600g11df01',
            'label' => esc_html__('Header Height', 'baganuur'),
            'name' => 'header_height',
            'instructions' => esc_html__('Write header height. If you leave as blank then it will be get value from Theme Options -> Layout -> Header -> Header Height.', 'baganuur'),
            'type' => 'text',
            'conditional_logic' => array(
                'status' => 1,
                'rules' => array(
                    array (
                        'field' => 'field_56e900f18d5c5',
                        'operator' => '!=',
                        'value' => 'left-side-menu',
                    ),
                    array (
                        'field' => 'field_56e900fccddff',
                        'operator' => '==',
                        'value' => 'on',
                    ),
                    array (
                        'field' => 'field_new900fccddn1',
                        'operator' => '==',
                        'value' => 'on',
                    ),
                ),
                'allorany' => 'all',
            ),
            'default_value' => '110',
            'placeholder' => '',
            'prepend' => '',
            'append' => esc_html__('px', 'baganuur'),
            'formatting' => 'html',
            'maxlength' => '',
        ),
        array(
            'key' => 'field_11a600g11df02',
            'label' => esc_html__('Logo-Top-Center Style Height', 'baganuur'),
            'name' => 'logo_top_center_height',
            'instructions' => esc_html__('Write Logo-Top-Center style height. If you leave as blank then it will be get value from Theme Options -> Layout -> Header -> Logo-Top-Center Style Height.', 'baganuur'),
            'type' => 'text',
            'conditional_logic' => array(
                'status' => 1,
                'rules' => array(
                    array (
                        'field' => 'field_56e900f18d5c5',
                        'operator' => '==',
                        'value' => 'logo-top-center',
                    ),
                    array (
                        'field' => 'field_56e900fccddff',
                        'operator' => '==',
                        'value' => 'on',
                    ),
                    array (
                        'field' => 'field_new900fccddn1',
                        'operator' => '==',
                        'value' => 'on',
                    ),
                ),
                'allorany' => 'all',
            ),
            'default_value' => '110',
            'placeholder' => '',
            'prepend' => '',
            'append' => esc_html__('px', 'baganuur'),
            'formatting' => 'html',
            'maxlength' => '',
        ),
        array(
            'key' => 'field_11a600g11df03',
            'label' => esc_html__('Header with Headline\'s Style Height', 'baganuur'),
            'name' => 'header_with_headline_height',
            'instructions' => esc_html__('Write header with headline style height. If you leave as blank then it will be get value from Theme Options -> Layout -> Header -> Header with Headline\'s Menu Height.', 'baganuur'),
            'type' => 'text',
            'conditional_logic' => array(
                'status' => 1,
                'rules' => array(
                    array (
                        'field' => 'field_56e900f18d5c5',
                        'operator' => '==',
                        'value' => 'header-with-headline',
                    ),
                    array (
                        'field' => 'field_56e900fccddff',
                        'operator' => '==',
                        'value' => 'on',
                    ),
                    array (
                        'field' => 'field_new900fccddn1',
                        'operator' => '==',
                        'value' => 'on',
                    ),
                ),
                'allorany' => 'all',
            ),
            'default_value' => '110',
            'placeholder' => '',
            'prepend' => '',
            'append' => esc_html__('px', 'baganuur'),
            'formatting' => 'html',
            'maxlength' => '',
        ),
        array(
            'key' => 'field_11a600g11df89',
            'label' => esc_html__('Headline Text', 'baganuur'),
            'name' => 'header_headline_text',
            'instructions' => esc_html__('Write headline text. If you leave as blank then it will be get value from Theme Options -> Layout -> Header -> Headline Text.', 'baganuur'),
            'type' => 'text',
            'conditional_logic' => array(
                'status' => 1,
                'rules' => array(
                    array (
                        'field' => 'field_56e900f18d5c5',
                        'operator' => '==',
                        'value' => 'header-with-headline',
                    ),
                    array (
                        'field' => 'field_56e900fccddff',
                        'operator' => '==',
                        'value' => 'on',
                    ),
                    array (
                        'field' => 'field_new900fccddn1',
                        'operator' => '==',
                        'value' => 'on',
                    ),
                ),
                'allorany' => 'all',
            ),
            'default_value' => '',
            'placeholder' => '',
            'prepend' => '',
            'append' => esc_html__('px', 'baganuur'),
            'formatting' => 'html',
            'maxlength' => '',
        ),
        array(
            'key' => 'field_56e900f7775c5',
            'label' => esc_html__('Header Background Type', 'baganuur'),
            'name' => 'header_background_type',
            'instructions' => esc_html__('Choose header background type', 'baganuur'),
            'type' => 'radio',
            'choices' => array(
                'header-bg-type-color' => esc_html__('Color Scheme', 'baganuur'),
                'header-bg-type-image' => esc_html__('Image', 'baganuur'),
            ),
            'conditional_logic' => array (
                'status' => 1,
                'rules' => array (
                    array (
                        'field' => 'field_56e900fccddff',
                        'operator' => '==',
                        'value' => 'on',
                    ),
                    array (
                        'field' => 'field_new900fccddn1',
                        'operator' => '==',
                        'value' => 'on',
                    ),
                ),
                'allorany' => 'all',
            ),
            'other_choice' => 0,
            'save_other_choice' => 0,
            'default_value' => 'header-bg-type-color',
            'layout' => 'horizontal',
        ),
        array(
            'key' => 'field_56e900f78d111',
            'label' => esc_html__('Header Background Color Scheme', 'baganuur'),
            'name' => 'header_color_scheme',
            'instructions' => esc_html__('Choose header background color scheme', 'baganuur'),
            'type' => 'radio',
            'choices' => array(
                'header-light' => esc_html__('Light', 'baganuur'),
                'header-dark' => esc_html__('Dark', 'baganuur'),
            ),
            'conditional_logic' => array (
                'status' => 1,
                'rules' => array (
                    array (
                        'field' => 'field_56e900f7775c5',
                        'operator' => '!=',
                        'value' => 'header-bg-type-image',
                    ),
                    array (
                        'field' => 'field_56e900fccddff',
                        'operator' => '==',
                        'value' => 'on',
                    ),
                    array (
                        'field' => 'field_new900fccddn1',
                        'operator' => '==',
                        'value' => 'on',
                    ),
                ),
                'allorany' => 'all',
            ),
            'other_choice' => 0,
            'save_other_choice' => 0,
            'default_value' => 'header-light',
            'layout' => 'horizontal',
        ),
        array(
            'key' => 'field_56e900f8899c5',
            'label' => esc_html__('Header Background', 'baganuur'),
            'name' => 'header_background',
            'type' => 'background',
            'conditional_logic' => array (
                'status' => 1,
                'rules' => array (
                    array (
                        'field' => 'field_56e900f7775c5',
                        'operator' => '!=',
                        'value' => 'header-bg-type-color',
                    ),
                    array (
                        'field' => 'field_56e900fccddff',
                        'operator' => '==',
                        'value' => 'on',
                    ),
                    array (
                        'field' => 'field_new900fccddn1',
                        'operator' => '==',
                        'value' => 'on',
                    ),
                ),
                'allorany' => 'all',
            ),
            'background_color' => 0,
            'background_repeat' => 1,
            'background_size' => 1,
            'background_attachment' => 1,
            'background_position' => 1,
            'background_image' => 1,
            'background_gradient' => 0,
            'background_clip' => 0,
            'background_origin' => 0,
            'preview' => 0,
            'preview_media' => 0,
            'preview_height' => '480px',
            'default' => array(
                'background_repeat'     => 'no-repeat',
                'background_size'      => 'cover',
                'background_attachment'=> 'scroll',
                'background_position'  => 'center center',
            )
        ),
        array(
            'key' => 'field_56e900f98d5c5',
            'label' => esc_html__('Sticky Header Style', 'baganuur'),
            'name' => 'sticky_header',
            'instructions' => esc_html__('Works Header Layout Styles excepting Left-Side-Menu. Choose inherit for theme options\' value.', 'baganuur'),
            'type' => 'radio',
            'choices' => array(
                'sticky-header-none' => esc_html__('None', 'baganuur'),
                'sticky-header-scrollup' => esc_html__('When Scroll Up', 'baganuur'),
                'sticky-header-frequently' => esc_html__('Frequently', 'baganuur'),
                'sticky-header-frequently-with-trans' => esc_html__('Frequently with Background Transparent', 'baganuur'),
            ),
            'conditional_logic' => array (
                'status' => 1,
                'rules' => array (
                    array (
                        'field' => 'field_56e900f18d5c5',
                        'operator' => '!=',
                        'value' => 'left-side-menu',
                    ),
                    array (
                        'field' => 'field_56e900fccddff',
                        'operator' => '==',
                        'value' => 'on',
                    ),
                    array (
                        'field' => 'field_new900fccddn1',
                        'operator' => '==',
                        'value' => 'on',
                    ),
                ),
                'allorany' => 'all',
            ),
            'other_choice' => 0,
            'save_other_choice' => 0,
            'default_value' => 'sticky-header-none',
            'layout' => 'horizontal',
        ),
        array (
            'key' => 'field_56e900h01d5c1',
            'label' => esc_html__('Sticky Header Background Transparent', 'baganuur'),
            'name' => 'sticky_header_transparent',
            'instructions' => esc_html__('Min: 0, Max: 100, step: 1', 'baganuur'),
            'type' => 'number',
            'conditional_logic' => array (
                'status' => 1,
                'rules' => array (
                    array (
                        'field' => 'field_56e900f98d5c5',
                        'operator' => '==',
                        'value' => 'sticky-header-frequently-with-trans',
                    ),
                    array (
                        'field' => 'field_56e900fccddff',
                        'operator' => '==',
                        'value' => 'on',
                    ),
                    array (
                        'field' => 'field_new900fccddn1',
                        'operator' => '==',
                        'value' => 'on',
                    ),
                ),
                'allorany' => 'all',
            ),
            'default_value' => 50,
            'prepend' => '',
            'append' => esc_html__('% transparent', 'baganuur'),
            'formatting' => 'html',
            'min' => 0,
            'max' => 100,
            'step' => 1,      
        ),
        array (
            'key' => 'field_56e900h01d9c1',
            'label' => esc_html__('Left-Side-Menu Header Background Transparent', 'baganuur'),
            'name' => 'lsm_header_transparent',
            'instructions' => esc_html__('Min: 0, Max: 100, step: 1', 'baganuur'),
            'type' => 'number',
            'conditional_logic' => array (
                'status' => 1,
                'rules' => array (
                    array (
                        'field' => 'field_56e900f18d5c5',
                        'operator' => '==',
                        'value' => 'left-side-menu',
                    ),
                    array (
                        'field' => 'field_56e900fccddff',
                        'operator' => '==',
                        'value' => 'on',
                    ),
                    array (
                        'field' => 'field_new900fccddn1',
                        'operator' => '==',
                        'value' => 'on',
                    ),
                ),
                'allorany' => 'all',
            ),
            'default_value' => 50,
            'prepend' => '',
            'append' => esc_html__('% transparent', 'baganuur'),
            'formatting' => 'html',
            'min' => 0,
            'max' => 100,
            'step' => 1,      
        ),
        array(
            'key' => 'field_56e900f99d5c5',
            'label' => esc_html__('Frequently Header Height', 'baganuur'),
            'name' => 'frenquently_header_height',
            'instructions' => esc_html__('Below option helps page title to vertical center. Sum of Header Height, Logo-Top-Center Height and Header-with-Headline. For example: If Logo-Top-Center is selected and Heights are Header Height:110px and Logo-Top-Center Height:80px. Result: 110px + 80px = 190px', 'baganuur'),
            'type' => 'text',
            'conditional_logic' => array(
                'status' => 1,
                'rules' => array(
                    array (
                        'field' => 'field_56e900f18d5c5',
                        'operator' => '!=',
                        'value' => 'left-side-menu',
                    ),
                    array (
                        'field' => 'field_56e900f98d5c5',
                        'operator' => '==',
                        'value' => 'sticky-header-frequently-with-trans',
                    ),
                    array (
                        'field' => 'field_56e900fccddff',
                        'operator' => '==',
                        'value' => 'on',
                    ),
                    array (
                        'field' => 'field_new900fccddn1',
                        'operator' => '==',
                        'value' => 'on',
                    ),
                ),
                'allorany' => 'all',
            ),
            'default_value' => '110',
            'placeholder' => '',
            'prepend' => '',
            'append' => esc_html__('px', 'baganuur'),
            'formatting' => 'html',
            'maxlength' => '',
        ),
        array(
            'key' => 'field_56e8c4187b779',
            'label' => esc_html__('Page Title Options', 'baganuur'),
            'name' => '',
            'type' => 'tab',
            'conditional_logic' => array(
                'status' => 1,
                'rules' => array(
                    array(
                        'field' => 'field_56eb863c1c517',
                        'operator' => '==',
                        'value' => 'on',
                    ),
                ),
                'allorany' => 'all',
            ),
        ),
        array(
            'key' => 'field_new900fccddn2',
            'label' => esc_html__('Customize Page Title Options', 'baganuur'),
            'name' => 'page_title_customize',
            'type' => 'radio',
            'instructions' => esc_html__('If you enabled it then This option will override the Theme Options > Layout > Page Title section.', 'baganuur'),
            'required' => 0,
            'choices' => array(
                'on' => 'Enable',
                'off' => 'Disable',
            ),
            'conditional_logic' => array (
                'status' => 1,
                'rules' => array (
                    array(
                        'field' => 'field_56e8c96ea3aaf',
                        'operator' => '==',
                        'value' => 'title',
                    ),
                ),
                'allorany' => 'all',
            ),
            'other_choice' => 0,
            'save_other_choice' => 0,
            'default_value' => 'off',
            'layout' => 'horizontal',
        ),
        array(
            'key' => 'field_56e8ca76a3ab0',
            'label' => esc_html__('Page Title Height', 'baganuur'),
            'name' => 'page_title_height',
            'instructions' => esc_html__('Note: 0 means no page title. If you leave as blank then it will be get value from Theme Options -> Layout -> Page Title -> Page Title Height.', 'baganuur'),
            'type' => 'text',
            'conditional_logic' => array(
                'status' => 1,
                'rules' => array(
                    array(
                        'field' => 'field_new900fccddn2',
                        'operator' => '==',
                        'value' => 'on',
                    ),
                ),
                'allorany' => 'all',
            ),
            'default_value' => '',
            'placeholder' => esc_html__('Recommended Size: 100-500', 'baganuur'),
            'prepend' => '',
            'append' => esc_html__('px', 'baganuur'),
            'formatting' => 'html',
            'maxlength' => '',
        ),
        array(
            'key' => 'field_56e903338d5ff',
            'label' => esc_html__('Page Title Style', 'baganuur'),
            'name' => 'page_title_style',
            'instructions' => '',
            'type' => 'radio',
            'choices' => array(
                'center' => esc_html__('Center', 'baganuur'),
                'align' => esc_html__('Align', 'baganuur'),
            ),
            'conditional_logic' => array(
                'status' => 1,
                'rules' => array(
                    array(
                        'field' => 'field_new900fccddn2',
                        'operator' => '==',
                        'value' => 'on',
                    ),
                ),
                'allorany' => 'all',
            ),
            'default_value' => 'center',
            'allow_null' => 0,
            'multiple' => 0,
            'layout' => 'horizontal',
        ),
        array(
            'key' => 'field_56e900g123991',
            'label' => esc_html__('Page Title Background Type', 'baganuur'),
            'name' => 'page_title_background_type',
            'instructions' => esc_html__('Choose header background type', 'baganuur'),
            'type' => 'radio',
            'choices' => array(
                'ptitle-bg-type-color' => esc_html__('Color Scheme', 'baganuur'),
                'ptitle-bg-type-image' => esc_html__('Image', 'baganuur'),
            ),
            'conditional_logic' => array (
                'status' => 1,
                'rules' => array (
                    array(
                        'field' => 'field_new900fccddn2',
                        'operator' => '==',
                        'value' => 'on',
                    ),
                ),
                'allorany' => 'all',
            ),
            'other_choice' => 0,
            'save_other_choice' => 0,
            'default_value' => 'header-bg-type-color',
            'layout' => 'horizontal',
        ),
        array(
            'key' => 'field_56e903338d5cc',
            'label' => esc_html__('Page Title Color Scheme', 'baganuur'),
            'name' => 'page_title_color_scheme',
            'instructions' => '',
            'type' => 'radio',
            'choices' => array(
                'pt-light' => esc_html__('Light', 'baganuur'),
                'pt-dark' => esc_html__('Dark', 'baganuur'),
            ),
            'conditional_logic' => array(
                'status' => 1,
                'rules' => array(
                    array(
                        'field' => 'field_new900fccddn2',
                        'operator' => '==',
                        'value' => 'on',
                    ),
                    array(
                        'field' => 'field_56e900g123991',
                        'operator' => '==',
                        'value' => 'ptitle-bg-type-color',
                    ),
                ),
                'allorany' => 'all',
            ),
            'default_value' => 'pt-light',
            'allow_null' => 0,
            'multiple' => 0,
            'layout' => 'horizontal',
        ),
        array(
            'key' => 'field_56e902ee8d5cb',
            'label' => esc_html__('Page Title Background', 'baganuur'),
            'name' => 'page_title_background',
            'instructions' => esc_html__('"Select Color" options is focused to page title text', 'baganuur'),
            'type' => 'background',
            'conditional_logic' => array(
                'status' => 1,
                'rules' => array(
                    array(
                        'field' => 'field_new900fccddn2',
                        'operator' => '==',
                        'value' => 'on',
                    ),
                    array(
                        'field' => 'field_56e900g123991',
                        'operator' => '==',
                        'value' => 'ptitle-bg-type-image',
                    ),
                ),
                'allorany' => 'all',
            ),
            'background_color' => 1,
            'background_repeat' => 1,
            'background_size' => 1,
            'background_attachment' => 1,
            'background_position' => 1,
            'background_image' => 1,
            'background_gradient' => 0,
            'background_clip' => 0,
            'background_origin' => 0,
            'preview' => 0,
            'preview_media' => 0,
            'preview_height' => '480px',
            'default' => array(
                'background-size' => 'cover',
                'background-position' => 'initial',
            )
        ),
        array(
            'key' => 'field_56e904148d5ce',
            'label' => esc_html__('Breadcrumb visible', 'baganuur'),
            'name' => 'breadcrumb_visible',
            'type' => 'radio',
            'instructions' => '',
            'choices' => array(
                'on' => esc_html__('On', 'baganuur'),
                'off' => esc_html__('Off', 'baganuur'),
            ),
            'conditional_logic' => array(
                'status' => 1,
                'rules' => array(
                    array(
                        'field' => 'field_new900fccddn2',
                        'operator' => '==',
                        'value' => 'on',
                    ),
                ),
                'allorany' => 'all',
            ),
            'other_choice' => 0,
            'save_other_choice' => 0,
            'default_value' => 'off',
            'layout' => 'horizontal',
        ),
        array(
            'key' => 'field_56e8cd93dc5d1',
            'label' => esc_html__('Footer Options', 'baganuur'),
            'name' => '',
            'type' => 'tab',
            'conditional_logic' => array(
                'status' => 1,
                'rules' => array(
                    array(
                        'field' => 'field_56eb863c1c517',
                        'operator' => '==',
                        'value' => 'on',
                    ),
                ),
                'allorany' => 'all',
            ),
        ),
        array(
            'key' => 'field_new900fccddn3',
            'label' => esc_html__('Customize Footer Options', 'baganuur'),
            'name' => 'footer_customize',
            'type' => 'radio',
            'instructions' => esc_html__('If you enabled it then This option will override the Theme Options > Layout > Footer section.', 'baganuur'),
            'required' => 0,
            'choices' => array(
                'on' => 'Enable',
                'off' => 'Disable',
            ),
            'other_choice' => 0,
            'save_other_choice' => 0,
            'default_value' => 'off',
            'layout' => 'horizontal',
        ),
        array(
            'key' => 'field_56e8d005dc5da',
            'label' => esc_html__('Footer Enable/Disable', 'baganuur'),
            'name' => 'footer_visible',
            'type' => 'radio',
            'choices' => array(
                'on' => esc_html__('On', 'baganuur'),
                'off' => esc_html__('Off', 'baganuur'),
            ),
            'conditional_logic' => array(
                'status' => 1,
                'rules' => array(
                    array(
                        'field' => 'field_new900fccddn3',
                        'operator' => '==',
                        'value' => 'on',
                    ),
                ),
                'allorany' => 'all',
            ),
            'other_choice' => 0,
            'save_other_choice' => 0,
            'default_value' => 'on',
            'layout' => 'horizontal',
        ),
        array(
            'key' => 'field_56e8d005dc5df',
            'label' => esc_html__('Footer Layout', 'baganuur'),
            'name' => 'footer_layout',
            'type' => 'radio',
            'choices' => array(
                'footer-fullwidth' => esc_html__('Fullwidth', 'baganuur'),
                'footer-boxed' => esc_html__('Boxed', 'baganuur'),
            ),
            'other_choice' => 0,
            'save_other_choice' => 0,
            'default_value' => 'footer-boxed',
            'layout' => 'horizontal',
            'conditional_logic' => array(
                'status' => 1,
                'rules' => array(
                    array(
                        'field' => 'field_56e8d005dc5da',
                        'operator' => '==',
                        'value' => 'on',
                    ),
                    array(
                        'field' => 'field_new900fccddn3',
                        'operator' => '==',
                        'value' => 'on',
                    ),
                ),
                'allorany' => 'all',
            ),
        ),
        array(
            'key' => 'field_56e8d075dc5dc',
            'label' => esc_html__('Footer Widget Columns', 'baganuur'),
            'name' => 'footer_widget_columns',
            'type' => 'select',
            'conditional_logic' => array(
                'status' => 1,
                'rules' => array(
                    array(
                        'field' => 'field_56e8d005dc5da',
                        'operator' => '==',
                        'value' => 'on',
                    ),
                    array(
                        'field' => 'field_new900fccddn3',
                        'operator' => '==',
                        'value' => 'on',
                    ),
                ),
                'allorany' => 'all',
            ),
            'choices' => array(
                '3-3-3-3' => esc_html__('4 columns', 'baganuur'),
                '4-4-4' => esc_html__('3 columns', 'baganuur'),
                '6-6' => esc_html__('2 columns', 'baganuur'),
                '12' => esc_html__('1 column', 'baganuur'),
                'none' => esc_html__('No column', 'baganuur'),
            ),
            'default_value' => '3-3-3-3',
            'allow_null' => 0,
            'multiple' => 0,
        ),
        array(
            'key' => 'field_16e8d075dc5dc',
            'label' => esc_html__('Footer Background Type', 'baganuur'),
            'name' => 'footer_background_type',
            'instructions' => esc_html__('Choose header background type', 'baganuur'),
            'type' => 'radio',
            'choices' => array(
                'footer-bg-type-color' => esc_html__('Color Scheme', 'baganuur'),
                'footer-bg-type-image' => esc_html__('Image', 'baganuur'),
            ),
            'conditional_logic' => array (
                'status' => 1,
                'rules' => array (
                    array (
                        'field' => 'field_56e8d005dc5da',
                        'operator' => '==',
                        'value' => 'on',
                    ),
                    array (
                        'field' => 'field_new900fccddn3',
                        'operator' => '==',
                        'value' => 'on',
                    ),
                ),
                'allorany' => 'all',
            ),
            'other_choice' => 0,
            'save_other_choice' => 0,
            'default_value' => 'footer-bg-type-color',
            'layout' => 'horizontal',
        ),
        array(
            'key' => 'field_56e8d0d4dc5dd',
            'label' => esc_html__('Footer Color Scheme', 'baganuur'),
            'name' => 'footer_color',
            'type' => 'radio',
            'conditional_logic' => array(
                'status' => 1,
                'rules' => array(
                    array(
                        'field' => 'field_56e8d005dc5da',
                        'operator' => '==',
                        'value' => 'on',
                    ),
                    array(
                        'field' => 'field_new900fccddn3',
                        'operator' => '==',
                        'value' => 'on',
                    ),
                    array(
                        'field' => 'field_16e8d075dc5dc',
                        'operator' => '==',
                        'value' => 'footer-bg-type-color',
                    ),
                ),
                'allorany' => 'all',
            ),
            'choices' => array(
                'footer-light' => esc_html__('Light', 'baganuur'),
                'footer-dark' => esc_html__('Dark', 'baganuur'),
            ),
            'other_choice' => 0,
            'save_other_choice' => 0,
            'default_value' => 'footer-dark',
            'layout' => 'horizontal',
        ),
        array(
            'key' => 'field_56e8d0d434ftr',
            'label' => esc_html__('Footer Background', 'baganuur'),
            'name' => 'footer_background',
            'type' => 'background',
            'conditional_logic' => array(
                'status' => 1,
                'rules' => array(
                    array(
                        'field' => 'field_56e8d005dc5da',
                        'operator' => '==',
                        'value' => 'on',
                    ),
                    array(
                        'field' => 'field_new900fccddn3',
                        'operator' => '==',
                        'value' => 'on',
                    ),
                    array(
                        'field' => 'field_16e8d075dc5dc',
                        'operator' => '==',
                        'value' => 'footer-bg-type-image',
                    ),
                ),
                'allorany' => 'all',
            ),
            'background_color' => 0,
            'background_repeat' => 1,
            'background_size' => 1,
            'background_attachment' => 1,
            'background_position' => 1,
            'background_image' => 1,
            'background_gradient' => 0,
            'background_clip' => 0,
            'background_origin' => 0,
            'preview' => 0,
            'preview_media' => 0,
            'preview_height' => '480px',
            'default' => array(
                'background-size' => 'cover',
                'background-position' => 'initial',
            )
        ),
        array(
            'key' => 'field_56e8d119dc5de',
            'label' => esc_html__('Footer Fixed', 'baganuur'),
            'name' => 'footer_fixed',
            'type' => 'radio',
            'conditional_logic' => array(
                'status' => 1,
                'rules' => array(
                    array(
                        'field' => 'field_56e8d005dc5da',
                        'operator' => '==',
                        'value' => 'on',
                    ),
                    array(
                        'field' => 'field_new900fccddn3',
                        'operator' => '==',
                        'value' => 'on',
                    ),
                ),
                'allorany' => 'all',
            ),
            'choices' => array(
                'on' => esc_html__('On', 'baganuur'),
                'off' => esc_html__('Off', 'baganuur'),
            ),
            'other_choice' => 0,
            'save_other_choice' => 0,
            'default_value' => 'off',
            'layout' => 'horizontal',
        ),
        array(
            'key' => 'field_56e8d161dc5df',
            'label' => esc_html__('Footer Copyright Text Visible', 'baganuur'),
            'name' => 'footer_copyright_text_visible',
            'type' => 'radio',
            'conditional_logic' => array(
                'status' => 1,
                'rules' => array(
                    array(
                        'field' => 'field_56e8d005dc5da',
                        'operator' => '==',
                        'value' => 'on',
                    ),
                    array(
                        'field' => 'field_new900fccddn3',
                        'operator' => '==',
                        'value' => 'on',
                    ),
                ),
                'allorany' => 'all',
            ),
            'choices' => array(
                'on' => esc_html__('On', 'baganuur'),
                'off' => esc_html__('Off', 'baganuur'),
            ),
            'other_choice' => 0,
            'save_other_choice' => 0,
            'default_value' => 'on',
            'layout' => 'horizontal',
        ),
        array(
            'key' => 'field_56e8cd93dc5d5',
            'label' => esc_html__('Advertising Management', 'baganuur'),
            'name' => '',
            'type' => 'tab',
            'conditional_logic' => array(
                'status' => 1,
                'rules' => array(
                    array(
                        'field' => 'field_56eb863c1c517',
                        'operator' => '==',
                        'value' => 'on',
                    ),
                ),
                'allorany' => 'all',
            ),
        ),
        array(
            'key' => 'field_11a600g11df04',
            'label' => esc_html__('Customize Advertising Management Options', 'baganuur'),
            'name' => 'ads_customize',
            'type' => 'radio',
            'instructions' => esc_html__('If you enabled it then This option will override the Theme Options > Advertising Management section.', 'baganuur'),
            'required' => 0,
            'choices' => array(
                'on' => 'Enable',
                'off' => 'Disable',
            ),
            'other_choice' => 0,
            'save_other_choice' => 0,
            'default_value' => 'off',
            'layout' => 'horizontal',
        ),
        array(
            'key' => 'field_56e8d005dc5dt',
            'label' => esc_html__('Before Header Visible', 'baganuur'),
            'name' => 'ads_before_header_visible',
            'type' => 'radio',
            'choices' => array(
                'on' => esc_html__('On', 'baganuur'),
                'off' => esc_html__('Off', 'baganuur'),
            ),
            'conditional_logic' => array (
                'status' => 1,
                'rules' => array (
                    array(
                        'field' => 'field_11a600g11df04',
                        'operator' => '==',
                        'value' => 'on',
                    ),
                ),
                'allorany' => 'all',
            ),
            'other_choice' => 0,
            'save_other_choice' => 0,
            'default_value' => 'off',
            'layout' => 'horizontal',
        ),
        array(
            'key' => 'field_56e8d005dcasd',
            'label' => esc_html__('Before Header', 'baganuur'),
            'name' => 'ads_before_header',
            'type' => 'wysiwyg',
            'toolbar' => 'full',
            'media_upload' => 'yes',
            'default_value' => '',
            'conditional_logic' => array(
                'status' => 1,
                'rules' => array(
                    array(
                        'field' => 'field_56e8d005dc5dt',
                        'operator' => '==',
                        'value' => 'on',
                    ),
                    array(
                        'field' => 'field_11a600g11df04',
                        'operator' => '==',
                        'value' => 'on',
                    ),
                ),
                'allorany' => 'all',
            ),
        ),
        array(
            'key' => 'field_56e8d005dc6dt',
            'label' => esc_html__('Before Page Title Visible', 'baganuur'),
            'name' => 'ads_before_page_title_visible',
            'type' => 'radio',
            'choices' => array(
                'on' => esc_html__('On', 'baganuur'),
                'off' => esc_html__('Off', 'baganuur'),
            ),
            'conditional_logic' => array (
                'status' => 1,
                'rules' => array (
                    array(
                        'field' => 'field_11a600g11df04',
                        'operator' => '==',
                        'value' => 'on',
                    ),
                ),
                'allorany' => 'all',
            ),
            'other_choice' => 0,
            'save_other_choice' => 0,
            'default_value' => 'off',
            'layout' => 'horizontal',
        ),
        array(
            'key' => 'field_56e8d005dcas1',
            'label' => esc_html__('Before Page Title', 'baganuur'),
            'name' => 'ads_before_page_title',
            'type' => 'wysiwyg',
            'toolbar' => 'full',
            'media_upload' => 'yes',
            'default_value' => '',
            'conditional_logic' => array(
                'status' => 1,
                'rules' => array(
                    array(
                        'field' => 'field_56e8d005dc6dt',
                        'operator' => '==',
                        'value' => 'on',
                    ),
                    array(
                        'field' => 'field_11a600g11df04',
                        'operator' => '==',
                        'value' => 'on',
                    ),
                ),
                'allorany' => 'all',
            ),
        ),
        array(
            'key' => 'field_56e8d005dc911',
            'label' => esc_html__('Before Main Content Visible', 'baganuur'),
            'name' => 'ads_before_main_content_visible',
            'type' => 'radio',
            'choices' => array(
                'on' => esc_html__('On', 'baganuur'),
                'off' => esc_html__('Off', 'baganuur'),
            ),
            'conditional_logic' => array (
                'status' => 1,
                'rules' => array (
                    array(
                        'field' => 'field_11a600g11df04',
                        'operator' => '==',
                        'value' => 'on',
                    ),
                ),
                'allorany' => 'all',
            ),
            'other_choice' => 0,
            'save_other_choice' => 0,
            'default_value' => 'off',
            'layout' => 'horizontal',
        ),
        array(
            'key' => 'field_56e8d005dqwer',
            'label' => esc_html__('Before Main Content', 'baganuur'),
            'name' => 'ads_before_main_content',
            'type' => 'wysiwyg',
            'toolbar' => 'full',
            'media_upload' => 'yes',
            'default_value' => '',
            'conditional_logic' => array(
                'status' => 1,
                'rules' => array(
                    array(
                        'field' => 'field_56e8d005dc911',
                        'operator' => '==',
                        'value' => 'on',
                    ),
                    array(
                        'field' => 'field_11a600g11df04',
                        'operator' => '==',
                        'value' => 'on',
                    ),
                ),
                'allorany' => 'all',
            ),
        ),
        array(
            'key' => 'field_56e8d005dc933',
            'label' => esc_html__('After Main Content Visible', 'baganuur'),
            'name' => 'ads_after_main_content_visible',
            'type' => 'radio',
            'choices' => array(
                'on' => esc_html__('On', 'baganuur'),
                'off' => esc_html__('Off', 'baganuur'),
            ),
            'conditional_logic' => array (
                'status' => 1,
                'rules' => array (
                    array(
                        'field' => 'field_11a600g11df04',
                        'operator' => '==',
                        'value' => 'on',
                    ),
                ),
                'allorany' => 'all',
            ),
            'other_choice' => 0,
            'save_other_choice' => 0,
            'default_value' => 'off',
            'layout' => 'horizontal',
        ),
        array(
            'key' => 'field_56e8d005dqwio',
            'label' => esc_html__('After Main Content', 'baganuur'),
            'name' => 'ads_after_main_content',
            'type' => 'wysiwyg',
            'toolbar' => 'full',
            'media_upload' => 'yes',
            'default_value' => '',
            'conditional_logic' => array(
                'status' => 1,
                'rules' => array(
                    array(
                        'field' => 'field_56e8d005dc933',
                        'operator' => '==',
                        'value' => 'on',
                    ),
                    array(
                        'field' => 'field_11a600g11df04',
                        'operator' => '==',
                        'value' => 'on',
                    ),
                ),
                'allorany' => 'all',
            ),
        ),
        array(
            'key' => 'field_56e8d005dc944',
            'label' => esc_html__('After Footer Bottom Section Visible', 'baganuur'),
            'name' => 'ads_after_footer_bottom_visible',
            'type' => 'radio',
            'choices' => array(
                'on' => esc_html__('On', 'baganuur'),
                'off' => esc_html__('Off', 'baganuur'),
            ),
            'conditional_logic' => array (
                'status' => 1,
                'rules' => array (
                    array(
                        'field' => 'field_11a600g11df04',
                        'operator' => '==',
                        'value' => 'on',
                    ),
                ),
                'allorany' => 'all',
            ),
            'other_choice' => 0,
            'save_other_choice' => 0,
            'default_value' => 'off',
            'layout' => 'horizontal',
        ),
        array(
            'key' => 'field_56e8d005dqwio',
            'label' => esc_html__('After Footer Bottom Section', 'baganuur'),
            'name' => 'ads_after_footer_bottom',
            'type' => 'wysiwyg',
            'toolbar' => 'full',
            'media_upload' => 'yes',
            'default_value' => '',
            'conditional_logic' => array(
                'status' => 1,
                'rules' => array(
                    array(
                        'field' => 'field_56e8d005dc944',
                        'operator' => '==',
                        'value' => 'on',
                    ),
                    array(
                        'field' => 'field_11a600g11df04',
                        'operator' => '==',
                        'value' => 'on',
                    ),
                ),
                'allorany' => 'all',
            ),
        ),
        array(
            'key' => 'field_56e8d005dc955',
            'label' => esc_html__('After Footer Copyright Section Visible', 'baganuur'),
            'name' => 'ads_after_footer_copyright_visible',
            'type' => 'radio',
            'choices' => array(
                'on' => esc_html__('On', 'baganuur'),
                'off' => esc_html__('Off', 'baganuur'),
            ),
            'conditional_logic' => array (
                'status' => 1,
                'rules' => array (
                    array(
                        'field' => 'field_11a600g11df04',
                        'operator' => '==',
                        'value' => 'on',
                    ),
                ),
                'allorany' => 'all',
            ),
            'other_choice' => 0,
            'save_other_choice' => 0,
            'default_value' => 'off',
            'layout' => 'horizontal',
        ),
        array(
            'key' => 'field_56e8d005dqwpl',
            'label' => esc_html__('After Footer Copyright Section', 'baganuur'),
            'name' => 'ads_after_footer_copyright',
            'type' => 'wysiwyg',
            'toolbar' => 'full',
            'media_upload' => 'yes',
            'default_value' => '',
            'conditional_logic' => array(
                'status' => 1,
                'rules' => array(
                    array(
                        'field' => 'field_56e8d005dc955',
                        'operator' => '==',
                        'value' => 'on',
                    ),
                    array(
                        'field' => 'field_11a600g11df04',
                        'operator' => '==',
                        'value' => 'on',
                    ),
                ),
                'allorany' => 'all',
            ),
        ),
        array(
            'key' => 'field_56e8d005dc966',
            'label' => esc_html__('Before Default Sidebar Visible', 'baganuur'),
            'name' => 'ads_before_sidebar_visible',
            'type' => 'radio',
            'choices' => array(
                'on' => esc_html__('On', 'baganuur'),
                'off' => esc_html__('Off', 'baganuur'),
            ),
            'conditional_logic' => array (
                'status' => 1,
                'rules' => array (
                    array(
                        'field' => 'field_11a600g11df04',
                        'operator' => '==',
                        'value' => 'on',
                    ),
                ),
                'allorany' => 'all',
            ),
            'other_choice' => 0,
            'save_other_choice' => 0,
            'default_value' => 'off',
            'layout' => 'horizontal',
        ),
        array(
            'key' => 'field_56e8d005dqwkj',
            'label' => esc_html__('Before Default Sidebar', 'baganuur'),
            'name' => 'ads_before_sidebar',
            'type' => 'wysiwyg',
            'toolbar' => 'full',
            'media_upload' => 'yes',
            'default_value' => '',
            'conditional_logic' => array(
                'status' => 1,
                'rules' => array(
                    array(
                        'field' => 'field_56e8d005dc966',
                        'operator' => '==',
                        'value' => 'on',
                    ),
                    array(
                        'field' => 'field_11a600g11df04',
                        'operator' => '==',
                        'value' => 'on',
                    ),
                ),
                'allorany' => 'all',
            ),
        ),
    );

    $meta_fields = array_merge($meta_fields, $other_fields);

    $baganuur_ut_core_woo_enabled = class_exists( 'woocommerce' ) ? true : false;

    if ( $baganuur_ut_core_woo_enabled ) {
        $woo_fields = array(
            array(
                'key' => 'field_56e8d005dc977',
                'label' => esc_html__('WooCommerce Before Shop Page Sidebar Visible', 'baganuur'),
                'name' => 'ads_before_woo_page_sidebar_visible',
                'type' => 'radio',
                'choices' => array(
                    'on' => esc_html__('On', 'baganuur'),
                    'off' => esc_html__('Off', 'baganuur'),
                ),
                'conditional_logic' => array(
                    'status' => 1,
                    'rules' => array(
                        array(
                            'field' => 'field_11a600g11df04',
                            'operator' => '==',
                            'value' => 'on',
                        ),
                    ),
                    'allorany' => 'all',
                ),
                'other_choice' => 0,
                'save_other_choice' => 0,
                'default_value' => 'off',
                'layout' => 'horizontal',
            ),
            array(
                'key' => 'field_56e8d005dqwdf',
                'label' => esc_html__('WooCommerce Before Shop Page Sidebar', 'baganuur'),
                'name' => 'ads_before_woo_page_sidebar',
                'type' => 'wysiwyg',
                'toolbar' => 'full',
                'media_upload' => 'yes',
                'default_value' => '',
                'conditional_logic' => array(
                    'status' => 1,
                    'rules' => array(
                        array(
                            'field' => 'field_56e8d005dc977',
                            'operator' => '==',
                            'value' => 'on',
                        ),
                        array(
                            'field' => 'field_11a600g11df04',
                            'operator' => '==',
                            'value' => 'on',
                        ),
                    ),
                    'allorany' => 'all',
                ),
            ),
            array(
                'key' => 'field_56e8d005dc988',
                'label' => esc_html__('WooCommerce Before Shop Single Sidebar Visible', 'baganuur'),
                'name' => 'ads_before_woo_single_sidebar_visible',
                'type' => 'radio',
                'choices' => array(
                    'on' => esc_html__('On', 'baganuur'),
                    'off' => esc_html__('Off', 'baganuur'),
                ),
                'conditional_logic' => array(
                    'status' => 1,
                    'rules' => array(
                        array(
                            'field' => 'field_11a600g11df04',
                            'operator' => '==',
                            'value' => 'on',
                        ),
                    ),
                    'allorany' => 'all',
                ),
                'other_choice' => 0,
                'save_other_choice' => 0,
                'default_value' => 'off',
                'layout' => 'horizontal',
            ),
            array(
                'key' => 'field_56e8d005dqwad',
                'label' => esc_html__('WooCommerce Before Shop Single Sidebar', 'baganuur'),
                'name' => 'ads_before_woo_single_sidebar',
                'type' => 'wysiwyg',
                'toolbar' => 'full',
                'media_upload' => 'yes',
                'default_value' => '',
                'conditional_logic' => array(
                    'status' => 1,
                    'rules' => array(
                        array(
                            'field' => 'field_56e8d005dc988',
                            'operator' => '==',
                            'value' => 'on',
                        ),
                        array(
                            'field' => 'field_11a600g11df04',
                            'operator' => '==',
                            'value' => 'on',
                        ),
                    ),
                    'allorany' => 'all',
                ),
            ),
        );

        $meta_fields = array_merge($meta_fields, $woo_fields);

    }

    register_field_group(array(
        'id' => 'acf_metabox',
        'title' => esc_html__('General & Advanced Options', 'baganuur'),
        'fields' => $meta_fields,
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'post',
                    'order_no' => 1,
                    'group_no' => 0,
                ),
            ),
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'page',
                    'order_no' => 1,
                    'group_no' => 0,
                ),
            )
        ),
        'options' => array(
            'position' => 'normal',
            'layout' => 'default',
            'hide_on_screen' => array(
                0 => 'discussion',
                1 => 'comments',
                2 => 'revisions',
                3 => 'slug',
                4 => 'author',
                5 => 'send-trackbacks',
            ),
        ),
        'menu_order' => 8,
            )
    );
}