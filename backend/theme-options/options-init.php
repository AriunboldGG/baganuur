<?php

/*
  Redux Framework Configuration.

 */

if (!class_exists('baganuur_ut_config')) {

    class baganuur_ut_config {

        public $args = array();
        public $sections = array();
        public $theme;
        public $Redux;
        public $vc_enabled = false;
        public $extension_installed = false;

        public function __construct() {

            if (!class_exists('ReduxFramework')) {
                return;
            }

            $this->extension_installed = is_plugin_active( 'baganuur-core/baganuur-core.php' ) ? true : false;
            $this->vc_enabled = is_plugin_active( 'js_composer/js_composer.php' ) ? true : false;

            if (true == Redux_Helpers::isTheme(__FILE__)) {
                $this->init_settings();
            } else {
                add_action('plugins_loaded', array($this, 'init_settings'), 10);
            }

            add_action('init', array($this, 'redux_baganuur_remove_demo'));
            add_action('init', array($this, 'remove_demo'));

        }

        public function init_settings() {

            $this->theme = wp_get_theme();
            $this->setArguments();
            $this->setHelpTabs();
            $this->setSections();


            if (!isset($this->args['opt_name'])) {
                return;
            }
            $this->Redux = new ReduxFramework($this->sections, $this->args);

            if ( $this->extension_installed ) {
                $this->setCustomExtensionLoader();
            }

        }

        public function redux_baganuur_remove_demo() {
            if (class_exists('ReduxFrameworkPlugin')) {
                remove_filter('plugin_row_meta', array(ReduxFrameworkPlugin::get_instance(), 'plugin_metalinks'), null, 2);
            }
            if (class_exists('ReduxFrameworkPlugin')) {
                remove_action('admin_notices', array(ReduxFrameworkPlugin::get_instance(), 'admin_notices'));
            }
        }

        public function remove_demo() {
            // Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.
            if (class_exists('ReduxFrameworkPlugin')) {
                remove_filter('plugin_row_meta', array(
                    ReduxFrameworkPlugin::instance(),
                    'plugin_metalinks'
                        ), null, 2);

                // Used to hide the activation notice informing users of the demo panel. Only used when Redux is a plugin.
                remove_action('admin_notices', array(ReduxFrameworkPlugin::instance(), 'admin_notices'));
            }
        }

        public function setHelpTabs() {

            $this->args['help_tabs'][] = array(
                'id' => 'theme-support',
                'title' => esc_html__('Support', 'baganuur'),
                'content' => esc_html__('Our theme supported via our Themeforest Author Comment section.', 'baganuur')
            );
            $this->args['help_tabs'][] = array(
                'id' => 'theme-documentation',
                'title' => esc_html__('Documentation', 'baganuur'),
                'content' => esc_html__('Documentation included on your All Files ZIP file and you need to extract it and then there is located.', 'baganuur')
            );
        }

        /**
         * All the possible arguments for Redux.
         * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
         * */
        public function setArguments() {

            // This is your option name where all the Redux data is stored.
            $opt_name = "baganuur_ut_get_options";

            $this->args = array(
                'opt_name' => 'baganuur_ut_get_options',
                'dev_mode' => FALSE,
                'use_cdn' => FALSE,
                'display_name' => esc_html__('baganuur Theme Options', 'baganuur'),
                'display_version' => '1.0.0',
                'page_slug' => 'baganuur_ut_options',
                'page_title' =>  esc_html__('baganuur Theme Options', 'baganuur'),
                'update_notice' => FALSE,
                'admin_bar' => TRUE,
                'menu_type' => 'menu',
                'menu_title' =>  esc_html__('Theme Options', 'baganuur'),
                'allow_sub_menu' => TRUE,
                'page_parent_post_type' => 'your_post_type',
                'customizer' => TRUE,
                'google_api_key' => 'AIzaSyCpCAYe_Qebu4h_4USU58q9luOLcd7c-Ec',//<-- PASTE YOUR GOOGLE API KEY HERE
                'class' => 'baganuur_ut',
                'hints' => array(
                    'icon' => 'el el-question-sign',
                    'icon_position' => 'left',
                    'icon_color' => 'lightgray',
                    'icon_size' => 'normal',
                    'tip_style' => array(
                        'color' => 'light',
                    ),
                    'tip_position' => array(
                        'my' => 'top left',
                        'at' => 'bottom right',
                    ),
                    'tip_effect' => array(
                        'show' => array(
                            'duration' => '500',
                            'event' => 'mouseover',
                        ),
                        'hide' => array(
                            'duration' => '500',
                            'event' => 'mouseleave unfocus',
                        ),
                    ),
                ),
                'output' => TRUE,
                'output_tag' => TRUE,
                'settings_api' => TRUE,
                'cdn_check_time' => '1440',
                'compiler' => TRUE,
                'page_permissions' => 'manage_options',
                'save_defaults' => TRUE,
                'show_import_export' => TRUE,
                'database' => 'options',
                'transient_time' => '3600',
                'network_sites' => TRUE,
                'disable_tracking' => TRUE,
            );

            // SOCIAL ICONS -> Setup custom links in the footer for quick links in your panel footer icons.
            $this->args['share_icons'][] = array(
                'url' => 'https://www.facebook.com/uniontheme',
                'title' => 'Like us on Facebook',
                'icon' => 'el el-facebook'
            );
            $this->args['share_icons'][] = array(
                'url' => 'http://twitter.com/uniontheme',
                'title' => 'Follow us on Twitter',
                'icon' => 'el el-twitter'
            );
        }

        public function setSections() {

            $this->sections[] = array(
                'title' => esc_html__('General', 'baganuur'),
                'id' => 'general_options',
                'desc' => '',
                'icon' => 'el el-home'
            );

            $this->sections[] = array(
                'title' => esc_html__('Logo & Favicon', 'baganuur'),
                'desc' => '',
                'id' => 'tab_general_logo',
                'subsection' => true,
                'fields' => array(
                    array(
                        'id' => 'tab_general_sub_logo_start',
                        'title' => esc_html__('Logo', 'baganuur'),
                        'type' => 'section',
                        'indent' => true,
                    ),
                    array(
                        'id' => 'tab_general_sub_logo_end',
                        'type' => 'section',
                        'indent' => true,
                    ),
                    array(
                        'id' => BAGANUUR_UT_T_OPTIONS . 'upload_top_logo',
                        'type' => 'media',
                        'url' => false,
                        'title' => esc_html__('Top Logo', 'baganuur'),
                        'subtitle' => esc_html__('Recommended Size: 130x20', 'baganuur'),
                        'compiler' => 'true',
                        'desc' => esc_html__('If you chosen the Header Color Scheme to Dark then this Logo wil display.', 'baganuur'),
                        'default' => array(
                            'url' => BAGANUUR_UT_THEME_DIR . '/backend/assets/img/header-1-img-white.png'
                        ),
                        'library_filter'  => array('gif','jpg','png','svg'),
                    ),
                    array(
                        'id' => BAGANUUR_UT_T_OPTIONS . 'upload_bottom_logo',
                        'type' => 'media',
                        'url' => false,
                        'title' => esc_html__('Bottom Logo', 'baganuur'),
                        'subtitle' => esc_html__('Recommended Size: 130x20', 'baganuur'),
                        'compiler' => 'true',
                        'desc' => esc_html__('If you chosen the Header Color Scheme to Dark then this Logo wil display.', 'baganuur'),
                        'default' => array(
                            'url' => BAGANUUR_UT_THEME_DIR . '/backend/assets/img/header-2-img-white.png'
                        ),
                        'library_filter'  => array('gif','jpg','png','svg'),
                    ),
                    array(
                        'id' => BAGANUUR_UT_T_OPTIONS . 'upload_core_logo',
                        'type' => 'media',
                        'url' => false,
                        'title' => esc_html__('Upload Light Logo', 'baganuur'),
                        'subtitle' => esc_html__('If your Header Background is Dark then This logo will displayed. Recommended Size: 130x20', 'baganuur'),
                        'compiler' => 'true',
                        'desc' => '',
                        'default' => array(
                            'url' => BAGANUUR_UT_THEME_DIR . '/backend/assets/img/logo-light.png'
                        ),
                    ),
                    array(
                        'id' => 'tab_general_sub_favicon_start',
                        'title' => esc_html__('Favicon', 'baganuur'),
                        'type' => 'section',
                        'indent' => true,
                    ),
                    array(
                        'id' => BAGANUUR_UT_T_OPTIONS . 'upload_favicon',
                        'type' => 'media',
                        'url' => false,
                        'title' => esc_html__('Upload Favicon', 'baganuur'),
                        'subtitle' => '',
                        'compiler' => 'true',
                        'desc' => esc_html__('Supported file Types: ICO, PNG, JPEG', 'baganuur'),
                        'default' => array(
                            'url' => BAGANUUR_UT_THEME_DIR . '/backend/assets/img/favicon.ico'
                        ),
                    ),
                    array(
                        'id' => 'tab_general_sub_favicon_end',
                        'type' => 'section',
                        'indent' => true,
                    ),
                )
            );

            $this->sections[] = array(
                'title' => esc_html__('Retina Ready?', 'baganuur'),
                'desc' => '',
                'id' => 'tab_general_retina',
                'subsection' => true,
                'fields' => array(
                    array(
                        'id' => 'tab_general_sub_retina_start',
                        'type' => 'section',
                        'indent' => true,
                    ),
                    array(
                        'id' => BAGANUUR_UT_T_OPTIONS . 'retina_logo_ready',
                        'type' => 'switch',
                        'title' => esc_html__('Retina Logo Enable/Disable', 'baganuur'),
                        'subtitle' => esc_html__('Display retina logo & favicon for high resolution monitor.', 'baganuur'),
                        'desc' => '',
                        'off' => 'Disable',
                        'on' => 'Enable',
                        'default' => false
                    ),
                    array(
                        'id' => BAGANUUR_UT_T_OPTIONS . 'retina_dark_logo',
                        'type' => 'media',
                        'url' => false,
                        'title' => esc_html__('Retina Dark Logo', 'baganuur'),
                        'subtitle' => esc_html__('2x bigger than normal', 'baganuur'),
                        'compiler' => 'true',
                        'desc' => '',
                        'default' => array(
                            'url' => BAGANUUR_UT_THEME_DIR . '/backend/assets/img/retina-logo-dark.png'
                        ),
                        'required' => array(BAGANUUR_UT_T_OPTIONS . 'retina_logo_ready', '=', true),
                    ),
                    array(
                        'id' => BAGANUUR_UT_T_OPTIONS . 'retina_light_logo',
                        'type' => 'media',
                        'url' => false,
                        'title' => esc_html__('Retina Light Logo', 'baganuur'),
                        'subtitle' => esc_html__('2x bigger than normal', 'baganuur'),
                        'compiler' => 'true',
                        'desc' => '',
                        'default' => array(
                            'url' => BAGANUUR_UT_THEME_DIR . '/backend/assets/img/retina-logo-light.png'
                        ),
                        'required' => array(BAGANUUR_UT_T_OPTIONS . 'retina_logo_ready', '=', true),
                    ),
                    array(
                        'id' => BAGANUUR_UT_T_OPTIONS . 'retina_favicon',
                        'type' => 'media',
                        'url' => false,
                        'title' => esc_html__('Retina Favicon', 'baganuur'),
                        'subtitle' => esc_html__('2x bigger than normal', 'baganuur'),
                        'compiler' => 'true',
                        'desc' => '',
                        'default' => array(
                            'url' => BAGANUUR_UT_THEME_DIR . '/backend/assets/img/retina-favicon.ico'
                        ),
                        'required' => array(BAGANUUR_UT_T_OPTIONS . 'retina_logo_ready', '=', true),
                    ),
                )
            );

            $this->sections[] = array(
                'title' => esc_html__('Additional', 'baganuur'),
                'desc' => '',
                'id' => 'tab_general_additional_options',
                'subsection' => true,
                'fields' => array(
                    array(
                        'id' => 'tab_general_sub_additional_start',
                        'type' => 'section',
                        'indent' => true,
                    ),
                    array(
                        'id' => BAGANUUR_UT_T_OPTIONS . 'smooth_scrolling',
                        'type' => 'switch',
                        'title' => esc_html__('Smooth Scrolling', 'baganuur'),
                        'subtitle' => esc_html__('Enable to have smooth scrolling for your site.', 'baganuur'),
                        'desc' => '',
                        'default' => false
                    ),
                    array(
                        'id' => BAGANUUR_UT_T_OPTIONS . 'copyright_text',
                        'type' => 'text',
                        'title' => esc_html__('Copyright Text', 'baganuur'),
                        'subtitle' => esc_html__('Please type your copyright information.', 'baganuur'),
                        'desc' => '',
                        'default' => esc_html__('ᠮᠣᠩᠭᠣᠯ ᠤᠯᠤᠰ ᠤᠨ ᠶᠡᠷᠦᠩᠬᠡᠶᠢᠯᠡᠭᠴᠢ ᠬᠠᠯᠲᠠᠮ᠎ᠠ ᠶᠢᠨ ᠪᠠᠲᠤᠲᠤᠯᠭ᠎ᠠ', 'baganuur'),
                    ),
                    array(
                        'id' => BAGANUUR_UT_T_OPTIONS . 'mn_url',
                        'type' => 'text',
                        'title' => esc_html__('MN site url', 'baganuur'),
                        'desc' => '',
                        'default' => esc_html__('http://www.baganuur.mn', 'baganuur'),
                    ),
                    array(
                        'id' => BAGANUUR_UT_T_OPTIONS . 'mn_text',
                        'type' => 'text',
                        'title' => esc_html__('MN site text', 'baganuur'),
                        'desc' => '',
                        'default' => esc_html__('MN', 'baganuur'),
                    ),
                    array(
                        'id' => BAGANUUR_UT_T_OPTIONS . 'en_url',
                        'type' => 'text',
                        'title' => esc_html__('EN site url', 'baganuur'),
                        'desc' => '',
                        'default' => esc_html__('http://www.baganuur.mn/en', 'baganuur'),
                    ),
                    array(
                        'id' => BAGANUUR_UT_T_OPTIONS . 'en_text',
                        'type' => 'text',
                        'title' => esc_html__('EN site text', 'baganuur'),
                        'desc' => '',
                        'default' => esc_html__('EN', 'baganuur'),
                    ),
                    array(
                        'id' => BAGANUUR_UT_T_OPTIONS . 'footer_page',
                        'type' => 'select',
                        'title' => esc_html__('Page footer', 'baganuur'),
                        'data' => 'page',
                    ),
                )
            );

            $this->sections[] = array(
                'title' => esc_html__('Color', 'baganuur'),
                'id' => 'color_options',
                'desc' => esc_html__('The Following Options will be help you to set color. And also the Visual Composer Color Palettes will be Changed.', 'baganuur'),
                'icon' => 'el el-brush',
                'fields' => array(
                    array(
                        'title' => esc_html__('General Colors', 'baganuur'),
                        'id' => 'tab_color_sub_general_start',
                        'type' => 'section',
                        'indent' => true,
                    ),
                    array(
                        'id' => BAGANUUR_UT_T_OPTIONS . 'primary_color',
                        'type' => 'color',
                        'title' => esc_html__('Primary color', 'baganuur'),
                        'subtitle' => esc_html__('Choose primary color.', 'baganuur'),
                        'default' => '#ffb504',
                        'output' => array('color' => 'body.header-dark .sf-menu .baganuur-ut-menu-children li:hover > a,'
                            . 'body.header-dark ul.sf-mega li ul.mega-menu-items li:hover > a,'
                            . 'body.header-light .sf-menu .baganuur-ut-menu-children li:hover > a,'
                            . 'body.header-light ul.sf-mega li ul.mega-menu-items li:hover > a,'
                            . 'body.header-light .sf-menu li.current-menu-ancestor ul.baganuur-ut-menu-children li.current-menu-item > a,'
                            . 'body.header-light .sf-menu li.current-menu-ancestor ul.sf-mega li.current-menu-ancestor ul.mega-menu-items li.current-menu-item > a,'
                            . 'body.header-dark .sf-menu li.current-menu-ancestor ul.baganuur-ut-menu-children li.current-menu-item > a,'
                            . 'body.header-dark .sf-menu li.current-menu-ancestor ul.sf-mega li.current-menu-ancestor ul.mega-menu-items li.current-menu-item > a'),
                        'validate' => 'color',
                        'transparent' => false,
                    ),
                    array(
                        'id' => BAGANUUR_UT_T_OPTIONS . 'body_color',
                        'type' => 'color',
                        'title' => esc_html__('Body Text Color', 'baganuur'),
                        'subtitle' => esc_html__('Choose body text color.', 'baganuur'),
                        'default' => '#808080',
                        'validate' => 'color',
                        'transparent' => false,
                    ),
                    array(
                        'id' => BAGANUUR_UT_T_OPTIONS . 'body_bg_color',
                        'type' => 'color',
                        'title' => esc_html__('Body Background Color', 'baganuur'),
                        'subtitle' => esc_html__('Choose body background color.', 'baganuur'),
                        'default' => '#fff',
                        'validate' => 'color',
                        'transparent' => false,
                    ),
                    array(
                        'id' => BAGANUUR_UT_T_OPTIONS . 'img_overlay_color',
                        'type' => 'color',
                        'title' => esc_html__('Image Overlay Background Color', 'baganuur'),
                        'subtitle' => esc_html__('use only Blog element.', 'baganuur'),
                        'default' => '#ffb504',
                        'validate' => 'color',
                        'transparent' => false,
                    ),
                    array(
                        'id' => BAGANUUR_UT_T_OPTIONS . 'img_overlay_color_opacity',
                        'type' => 'slider',
                        'title' => esc_html__('Image Overlay Background Color Opacity', 'baganuur'),
                        'subtitle' => esc_html__('use only Blog element.', 'baganuur'),
                        'desc' => esc_html__('Min: 0, max: 1, step: 0.01, default value: 0.8', 'baganuur'),
                        "default" => 0.8,
                        "min" => 0,
                        "step" => 0.01,
                        "max" => 1,
                        'resolution' => 0.01,
                        'display_value' => 'text'
                    ),
                    array(
                        'id' => 'tab_color_sub_general_end',
                        'type' => 'section',
                        'indent' => false,
                    ),
                    array(
                        'title' => esc_html__('Palette Colors', 'baganuur'),
                        'id' => 'tab_color_sub_palette_start',
                        'type' => 'section',
                        'indent' => true,
                    ),
                    array(
                        'id' => BAGANUUR_UT_T_OPTIONS . 'palette_color_1',
                        'type' => 'color',
                        'title' => esc_html__('Palette color 1', 'baganuur'),
                        'subtitle' => esc_html__('Choose palette color.', 'baganuur'),
                        'default' => '#96bf48',
                        'validate' => 'color',
                        'transparent' => false,
                    ),
                    array(
                        'id' => BAGANUUR_UT_T_OPTIONS . 'palette_color_2',
                        'type' => 'color',
                        'title' => esc_html__('Palette color 2', 'baganuur'),
                        'subtitle' => esc_html__('Choose palette color.', 'baganuur'),
                        'default' => '#121714',
                        'validate' => 'color',
                        'transparent' => false,
                    ),
                    array(
                        'id' => BAGANUUR_UT_T_OPTIONS . 'palette_color_3',
                        'type' => 'color',
                        'title' => esc_html__('Palette color 3', 'baganuur'),
                        'subtitle' => esc_html__('Choose palette color.', 'baganuur'),
                        'default' => '#666666',
                        'validate' => 'color',
                        'transparent' => false,
                    ),
                    array(
                        'id' => BAGANUUR_UT_T_OPTIONS . 'palette_color_4',
                        'type' => 'color',
                        'title' => esc_html__('Palette color 4', 'baganuur'),
                        'subtitle' => esc_html__('Choose palette color.', 'baganuur'),
                        'default' => '#f2f7fa',
                        'validate' => 'color',
                        'transparent' => false,
                    ),
                    array(
                        'id' => BAGANUUR_UT_T_OPTIONS . 'palette_color_5',
                        'type' => 'color',
                        'title' => esc_html__('Palette color 5', 'baganuur'),
                        'subtitle' => esc_html__('Choose palette color.', 'baganuur'),
                        'default' => '#f5f5f5',
                        'validate' => 'color',
                        'transparent' => false,
                    ),
                    array(
                        'id' => 'info_normal',
                        'type' => 'info',
                        'style' => 'success',
                        'color' => '#ffb504',
                        'title' => esc_html__('Note', 'baganuur'),
                        'desc' => esc_html__('Above palettes and Primary color are availble to choose on Pagebuilder Elements color options.', 'baganuur'),
                    ),
                    array(
                        'id' => 'tab_color_sub_palette_end',
                        'type' => 'section',
                        'indent' => false,
                    ),
                )
            );

            $this->sections[] = array(
                'title' => esc_html__('Fonts', 'baganuur'),
                'id' => 'tab_typography_body',
                'desc' => '',
                'icon' => 'el el-font',
                'fields' => array(
                    array(
                        'title' => esc_html__('Main Font', 'baganuur'),
                        'id' => 'tab_typography_sub_body_start',
                        'type' => 'section',
                        'indent' => true,
                    ),
                    array(
                        'id' => BAGANUUR_UT_T_OPTIONS . 'body_font',
                        'type' => 'typography',
                        'title' => esc_html__('Body Font', 'baganuur'),
                        'subtitle' => esc_html__('Choose the body font.', 'baganuur'),
                        'google' => true,
                        'text-align' => false,
                        'line-height' => false,
                        'letter-spacing' => true,
                        'subsets' => false,
                        'color' => false,
                        'output' => array(''),
                        'units' => 'px',
                        'font-backup' => true,
                        'preview' => array(
                            'always_display' => true,
                            'font-size' => '14px',
                            'letter-spacing' => '0.025em',
                            'text' => 'The quick brown fox jumps over the lazy dog. 1 2 3 4 5 6 7 8 9 0',
                        ),
                        'default' => array(
                            'font-family' => 'Playfair Display',
                            'font-size' => '14px',
                            'letter-spacing' => '0.025',
                            'font-weight' => '400',
                            'font-style' => '',
                            'google' => true,
                        ),
                    ),
                    array(
                        'id' => 'info_normal',
                        'type' => 'info',
                        'style' => 'success',
                        'title' => esc_html__('Note', 'baganuur'),
                        'desc' => esc_html__('Above letter-spacing option of Blog Meta Font is availble to write in em unit.', 'baganuur'),
                    ),
                )
            );

            $this->sections[] = array(
                'title' => esc_html__('Google & Twitter API', 'baganuur'),
                'id' => 'twitter_api',
                'desc' => '',
                'icon' => 'el el-twitter',
                'fields' => array(
                    array(
                        'title' => esc_html__('Google map API', 'baganuur'),
                        'id' => 'tab_twitter_sub_general_start',
                        'type' => 'section',
                        'desc' => esc_html__('The following options will be help you to access Google Map by API.', 'baganuur'),
                        'indent' => true,
                    ),
                    array(
                        'id' => BAGANUUR_UT_T_OPTIONS . 'google_api',
                        'type' => 'text',
                        'title' => esc_html__('Google API', 'baganuur'),
                        'subtitle' => esc_html__('NOTE: Please copy/paste your Google API Key to themes/baganuur/backend/theme-options/options-init.php Line #120 instead of PASTE YOUR GOOGLE API KEY HERE.', 'baganuur'),
                        'desc' => '',
                        'default' => '',
                    ),
                    array(
                        'title' => esc_html__('Twitter API', 'baganuur'),
                        'id' => 'tab_twitter_sub_general_start',
                        'type' => 'section',
                        'desc' => esc_html__('The following options will be help you to access Twitter application by API. Register your APP on https://dev.twitter.com/', 'baganuur'),
                        'indent' => true,
                    ),
                    array(
                        'id' => BAGANUUR_UT_T_OPTIONS . 'consumer_key',
                        'type' => 'text',
                        'title' => esc_html__('Consumer Key', 'baganuur'),
                        'subtitle' => wp_kses(__('You need to create your Twitter APP and <a href="https://dev.twitter.com/apps" target="_blank">', 'baganuur'), array('a' => array('href' => array(), 'target' => array()))),
                        'desc' => '',
                        'default' => '',
                    ),
                    array(
                        'id' => BAGANUUR_UT_T_OPTIONS . 'consumer_secret',
                        'type' => 'text',
                        'title' => esc_html__('Consumer Secret', 'baganuur'),
                        'subtitle' => esc_html__('Please type your consumer secret.', 'baganuur'),
                        'desc' => '',
                        'default' => '',
                    ),
                    array(
                        'id' => BAGANUUR_UT_T_OPTIONS . 'access_token',
                        'type' => 'text',
                        'title' => esc_html__('Access Token', 'baganuur'),
                        'subtitle' => esc_html__('Please type your access token.', 'baganuur'),
                        'desc' => '',
                        'default' => '',
                    ),
                    array(
                        'id' => BAGANUUR_UT_T_OPTIONS . 'access_token_secret',
                        'type' => 'text',
                        'title' => esc_html__('Access Token Secret', 'baganuur'),
                        'subtitle' => esc_html__('Please type your access token secret.', 'baganuur'),
                        'desc' => '',
                        'default' => '',
                    ),
                    array(
                        'id' => 'tab_twitter_sub_general_end',
                        'type' => 'section',
                        'indent' => false,
                    ),
                )
            );

            $this->sections[] = array(
                'title' => esc_html__('Custom Translations', 'baganuur'),
                'id' => 'translations',
                'icon' => 'el el-file-edit-alt',
                'fields' => array(
                    array(
                        'id' => BAGANUUR_UT_T_OPTIONS . 'translation_enabled',
                        'type' => 'switch',
                        'title' => esc_html__('Use Custom Translation?', 'baganuur'),
                        'subtitle' => esc_html__('If you want to change custom translations, you need to enable this option.', 'baganuur'),
                        'desc' => '',
                        'off' => 'Disable',
                        'on' => 'Enable',
                        'default' => false
                    ),
                    array(
                        'id' => BAGANUUR_UT_T_OPTIONS . 'is_category',
                        'type' => 'text',
                        'title' => esc_html__('Category Text', 'baganuur'),
                        'subtitle' => esc_html__('add custom text on Page Title.', 'baganuur'),
                        'default' => esc_html__('Category', 'baganuur'),
                        'required' => array(BAGANUUR_UT_T_OPTIONS . 'translation_enabled', '=', true),
                    ),
                    array(
                        'id' => BAGANUUR_UT_T_OPTIONS . 'is_tag',
                        'type' => 'text',
                        'title' => esc_html__('Tag Text', 'baganuur'),
                        'subtitle' => esc_html__('add custom text on Page Title.', 'baganuur'),
                        'default' => esc_html__('Tag', 'baganuur'),
                        'required' => array(BAGANUUR_UT_T_OPTIONS . 'translation_enabled', '=', true),
                    ),
                    array(
                        'id' => BAGANUUR_UT_T_OPTIONS . 'is_404',
                        'type' => 'text',
                        'title' => esc_html__('Page 404 Text', 'baganuur'),
                        'subtitle' => esc_html__('add custom text on Page Title.', 'baganuur'),
                        'default' => esc_html__('Nothing found!', 'baganuur'),
                        'required' => array(BAGANUUR_UT_T_OPTIONS . 'translation_enabled', '=', true),
                    ),
                    array(
                        'id' => BAGANUUR_UT_T_OPTIONS . 'is_author',
                        'type' => 'text',
                        'title' => esc_html__('Author Text', 'baganuur'),
                        'subtitle' => esc_html__('add custom text on Page Title.', 'baganuur'),
                        'default' => esc_html__('Author', 'baganuur'),
                        'required' => array(BAGANUUR_UT_T_OPTIONS . 'translation_enabled', '=', true),
                    ),
                    array(
                        'id' => BAGANUUR_UT_T_OPTIONS . 'is_archive',
                        'type' => 'text',
                        'title' => esc_html__('Archives Text', 'baganuur'),
                        'subtitle' => esc_html__('add custom text on Page Title.', 'baganuur'),
                        'default' => esc_html__('Blog Archives', 'baganuur'),
                        'required' => array(BAGANUUR_UT_T_OPTIONS . 'translation_enabled', '=', true),
                    ),
                    array(
                        'id' => BAGANUUR_UT_T_OPTIONS . 'is_day',
                        'type' => 'text',
                        'title' => esc_html__('Daily Archives Text', 'baganuur'),
                        'subtitle' => esc_html__('add custom text on Page Title.', 'baganuur'),
                        'default' => esc_html__('Daily Archives', 'baganuur'),
                        'required' => array(BAGANUUR_UT_T_OPTIONS . 'translation_enabled', '=', true),
                    ),
                    array(
                        'id' => BAGANUUR_UT_T_OPTIONS . 'is_month',
                        'type' => 'text',
                        'title' => esc_html__('Monthly Archives Text', 'baganuur'),
                        'subtitle' => esc_html__('add custom text on Page Title.', 'baganuur'),
                        'default' => esc_html__('Monthly Archives', 'baganuur'),
                        'required' => array(BAGANUUR_UT_T_OPTIONS . 'translation_enabled', '=', true),
                    ),
                    array(
                        'id' => BAGANUUR_UT_T_OPTIONS . 'is_year',
                        'type' => 'text',
                        'title' => esc_html__('Yearly Archives Text', 'baganuur'),
                        'subtitle' => esc_html__('add custom text on Page Title.', 'baganuur'),
                        'default' => esc_html__('Yearly Archives', 'baganuur'),
                        'required' => array(BAGANUUR_UT_T_OPTIONS . 'translation_enabled', '=', true),
                    ),
                    array(
                        'id' => BAGANUUR_UT_T_OPTIONS . 'is_search',
                        'type' => 'text',
                        'title' => esc_html__('Search Text', 'baganuur'),
                        'subtitle' => esc_html__('add custom text on Page Title.', 'baganuur'),
                        'default' => esc_html__('Search results for', 'baganuur'),
                        'required' => array(BAGANUUR_UT_T_OPTIONS . 'translation_enabled', '=', true),
                    ),
                )
            );

            $this->sections[] = array(
                'title' => esc_html__('Custom CSS', 'baganuur'),
                'id' => 'custom_css',
                'icon' => 'el el-css',
                'fields' => array(
                    array(
                        'id' => BAGANUUR_UT_T_OPTIONS . 'custom_css',
                        'type' => 'ace_editor',
                        'title' => '',
                        'subtitle' => esc_html__('Please paste your custom CSS code here.', 'baganuur'),
                        'mode' => 'css',
                        'theme' => 'chrome',
                        'desc' => '',
                        'default' => ''
                    ),
                )
            );
        }

        public function setCustomExtensionLoader() {
            $path = BAGANUUR_UT_PLUGIN_PATH . 'redux-extensions/';
            $folders = scandir($path, 1);
            foreach ($folders as $folder) {
                if ($folder === '.' or $folder === '..' or ! is_dir($path . $folder)) {
                    continue;
                }
                $extension_class = 'ReduxFramework_Extension_' . $folder;
                if (!class_exists($extension_class)) {
                    // In case you wanted override your override, hah.
                    $class_file = $path . $folder . '/extension_' . $folder . '.php';
                    $class_file = apply_filters('redux/extension/' . $this->args['opt_name'] . '/' . $folder, $class_file);
                    if ($class_file) {
                        require_once $class_file;
                        $extension = new $extension_class($this->Redux);
                    }
                }
            }
        }

    }

    $baganuur_ut_config = new baganuur_ut_config();
}
