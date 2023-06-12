<?php

if (!class_exists('baganuur_ut_setup')) {

    class baganuur_ut_setup {

        private $is_admin = false;
        private $is_mobile = false;
        public $theme_name;
        public $theme_version;
        public $has_warning = false;

        public function __construct() {

            $this->is_admin = is_admin();
            $this->is_mobile = wp_is_mobile();

            $this->init();
            $this->constants();
            $this->required_plugins();
            $this->include_files();

            /*
              Actions

             */

            add_action('after_setup_theme', array($this, 'after_setup_theme'));
            add_action('wp_head', array($this, 'meta_viewport'), 1);
            add_action('wp_head', array($this, 'wp_head'));
            add_action('comment_form_before', array($this, 'baganuur_ut_comment_form_before'));
            add_action('comment_form_after', array($this, 'baganuur_ut_comment_form_after'));
            add_action('admin_menu', array($this, 'baganuur_ut_remove_acf_menu'), 999); //Remove Custom Fields Menu in Admin Panel
            add_action('wp_ajax_nopriv_baganuur-ut-post-like', 'baganuur_ut_post_like');
            add_action('wp_ajax_baganuur-ut-post-like', 'baganuur_ut_post_like');
            add_action('pt-ocdi/after_import', array($this, 'baganuur_ut_import_setup'));
            // function wpdocs_theme_add_editor_styles() {
                // add_editor_style( BAGANUUR_UT_THEME_PATH . '/backend/assets/css/custom-editor-style.css' );
            // }
            // add_editor_style( 'css/custom-editor-style.css' );
            // add_action( 'admin_init', 'wpdocs_theme_add_editor_styles' );

            /*
              Filters

             */

            add_filter('wp_nav_menu', array($this, 'baganuur_ut_add_nav_class'));
            add_filter('wp_nav_menu', array($this, 'baganuur_ut_add_class_to_submenu'));
            add_filter('img_caption_shortcode', array($this, 'baganuur_ut_caption_shortcode'), 10, 3);
            add_filter( 'pt-ocdi/import_files', array($this, 'baganuur_ut_import_files'));
            
        }

        public function constants() {

            /*
              Theme constants

             */

            define('BAGANUUR_UT_THEMENAME', $this->theme_name);
            define('BAGANUUR_UT_THEMEVERSION', $this->theme_version);
            define('BAGANUUR_UT_THEME_PATH', get_template_directory());
            define('BAGANUUR_UT_THEME_DIR', get_template_directory_uri());
            define('BAGANUUR_UT_STYLESHEET_PATH', get_stylesheet_directory());
            define('BAGANUUR_UT_STYLESHEET_DIR', get_stylesheet_directory_uri());
            define('BAGANUUR_UT_PLUGIN_PATH', trailingslashit(WP_PLUGIN_DIR . '/baganuur-core'));
            define('BAGANUUR_UT_PLUGIN_DIR', plugins_url() . '/baganuur-core');
            define('BAGANUUR_UT_T_OPTIONS', "apdatgtdw_"); //baganuur => apdatgtdw --- writen in mobile 3x4 keypad
        }

        public function init() {
            if (is_child_theme()) {
                $temp_obj = wp_get_theme();
                $theme_obj = wp_get_theme($temp_obj->get('Template'));
            } else {
                $theme_obj = wp_get_theme();
            }
            $this->theme_name = $theme_obj->get('Name');
            $this->theme_version = $theme_obj->get('Version');
        }

        public function after_setup_theme() {
            add_editor_style();

            add_theme_support('post-thumbnails');
            add_theme_support('post-formats', array('video', 'audio', 'gallery', 'image', 'quote', 'link'));
            add_theme_support('title-tag');
            add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption',));
            add_theme_support('automatic-feed-links');
            add_theme_support('custom-header');
            add_theme_support('custom-background');

            load_theme_textdomain('baganuur', BAGANUUR_UT_THEME_PATH . '/languages/');

            register_nav_menus(array(
                'baganuur-ut-main' => esc_html__('Main Menu', 'baganuur')
            ));
        }

        public function required_plugins() {

            /*
              Redux Framework Plugin

             */

            include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
            if ( is_plugin_active( 'redux-framework/redux-framework.php' ) ) {
                if ( !isset( $redux_demo ) && file_exists( BAGANUUR_UT_THEME_PATH . '/backend/theme-options/options-init.php' ) ) {
                    require_once( BAGANUUR_UT_THEME_PATH . '/backend/theme-options/options-init.php' );   
                }
            } else {
                require_once( BAGANUUR_UT_THEME_PATH . '/backend/theme-options/options-default.php' );
            }

            /*
              Advanced Custom Fields Plugin (ACF)

             */

            if (is_plugin_active('advanced-custom-fields/acf.php')) {
                require_once BAGANUUR_UT_THEME_PATH . '/backend/metabox-options/post-format.php';
                require_once BAGANUUR_UT_THEME_PATH . '/backend/metabox-options/metabox.php';
                require_once BAGANUUR_UT_THEME_PATH . '/backend/metabox-options/blog.php';
            }

        }

        public function include_files() {
            $this->theme_functions();
        }

        private function theme_functions() {

            if ($this->is_admin) {
                require_once BAGANUUR_UT_THEME_PATH . "/backend/tgm-plugins.php";

                /*
                  Load Gallery

                */

                require_once BAGANUUR_UT_THEME_PATH . "/backend/metabox-options/gallery.php";
            }

            /*
              Load Core Functions

             */

            require_once BAGANUUR_UT_THEME_PATH . '/backend/functions/core-functions.php';

            /*
              Load Core Hooks

             */

            require_once BAGANUUR_UT_THEME_PATH . '/backend/hooks/core-hooks.php';

            /*
              Load Core Actions

             */

            require_once BAGANUUR_UT_THEME_PATH . '/backend/hooks/core-actions.php';

            /*
              Load Admin Customize

             */

            require_once BAGANUUR_UT_THEME_PATH . "/backend/functions/admin-customize.php";

            /*
              Load UnionTheme Globals

             */

            require_once BAGANUUR_UT_THEME_PATH . '/backend/functions/globals.php';
            
            /*
              Load Helper Functions

             */

            require_once BAGANUUR_UT_THEME_PATH . '/backend/helper-functions.php';
            require_once BAGANUUR_UT_THEME_PATH . '/backend/functions/header-functions.php';
            require_once BAGANUUR_UT_THEME_PATH . '/backend/functions/footer-functions.php';
            require_once BAGANUUR_UT_THEME_PATH . '/backend/functions/blog-functions.php';
            require_once BAGANUUR_UT_THEME_PATH . '/backend/functions/vc-functions.php';

            /*
              Load the logo & favicon

             */

            require_once BAGANUUR_UT_THEME_PATH . '/backend/functions/logo.php';

            /*
              Load the search

             */

            require_once BAGANUUR_UT_THEME_PATH . '/backend/functions/search.php';

            /*
              Load the Sripts & Style files

             */

            require_once BAGANUUR_UT_THEME_PATH . '/backend/enqueue-scripts.php';

            /*
              Load necessery theme css

             */

            require_once BAGANUUR_UT_THEME_PATH . '/backend/theme-css.php';

            /*
              Load the baganuur_ut_custom_menu

             */

            require_once BAGANUUR_UT_THEME_PATH . '/backend/functions/custom-menu.php';

            /*
              Load the template-tags

             */

            require_once BAGANUUR_UT_THEME_PATH . '/backend/template-tags.php';

            /*
              Other Helpful Functions

             */

            require_once BAGANUUR_UT_THEME_PATH . '/backend/functions/aq-resizer.php';
            require_once BAGANUUR_UT_THEME_PATH . '/backend/functions/comment-walker.php';

        }

        public function meta_viewport() {

            if ($this->is_mobile) {
                $viewport = '<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">';
            } else {
                $viewport = '<meta name="viewport" content="width=device-width, initial-scale=1">';
            }

            echo apply_filters('baganuur_ut_meta_viewport', $viewport);
        }

        public function wp_head() {
            $this->meta_http();
        }

        public function meta_http() {
            echo '<meta http-equiv="X-UA-Compatible" content="IE=edge">';
        }

        public function baganuur_ut_add_nav_class($output) {
            $output = preg_replace('/<a/', '<a class="baganuur-ut-menu-link"', $output);
            return $output;
        }

        public function baganuur_ut_add_class_to_submenu($output) {
            $output = preg_replace('/<ul class="sub-menu"/', '<ul class="baganuur-ut-menu-children"', $output);
            return $output;
        }

        /*
          Replace h3 tag with p tag in reply-title of post comment.

         */

        public function baganuur_ut_comment_form_before() {
            ob_start();
        }

        /*
          Comment - replace h3 with p tag

         */

        public function baganuur_ut_comment_form_after() {
            $html = ob_get_clean();
            $html = preg_replace(
                    '/<h3 id="reply-title"(.*)>(.*)<\/h3>/', '<p id="reply-title"\1>\2</p>', $html
            );
            echo balanceTags($html);
        }

        public function baganuur_ut_caption_shortcode($val, $attr, $content = null) {

            $id = '';
            $align = '';
            $width = '';
            $caption = '';
            extract(shortcode_atts(array(
                'id' => '',
                'align' => '',
                'width' => '',
                'caption' => ''
                            ), $attr));

            if (1 > (int) $width || empty($caption)) {
                return $val;
            }

            $capid = '';
            if (isset($id)) {
                $id = esc_attr($id);
                $capid = 'id="figcaption_' . $id . '" ';
                $id = 'id="figure-' . $id . '" aria-labelledby="figcaption_' . $id . '" ';
            }

            $new_figure = '<figure ' . $id . 'class="wp-caption ' . esc_attr($align) . '">' . "\n";
            $new_figure .= do_shortcode($content) . "\n";
            $new_figure .= '<figcaption ' . $capid . ' class="wp-caption-text" ><span>' . "\n";
            $new_figure .= $caption . '</span></figcaption>' . "\n";
            /**
             * (optional) the "image.png" below could be a 1px transparent .png file
             * with some CSS styles (absolute positioning, height and width to 100% the size of the original image) 
             * it can cover the actual image and discourage getting the actual image with right-click save
             */
            //$new_figure .= '<img src="' . get_template_directory_uri() . 'your-path-here' . image.png" class="void" />' . "\n";
            $new_figure .= '</figure>' . "\n";

            return $new_figure;
        }

        public function baganuur_ut_remove_acf_menu() {
            remove_menu_page('edit.php?post_type=acf');
        }
        
        public function baganuur_ut_import_files() {
            return array(
                array(
                    'import_file_name'           => esc_html__( 'Main Demo', 'baganuur' ),
                    'import_file_url'            => BAGANUUR_UT_THEME_DIR . '/dummy-data/demo-main.xml',
                    'import_widget_file_url'     => BAGANUUR_UT_THEME_DIR . '/dummy-data/widget-main.json',
                    'import_preview_image_url'   => BAGANUUR_UT_THEME_DIR . '/dummy-data/preview-main.jpg',
                    'import_notice'              => esc_html__( 'After you imported demo, you need to 1. Check "Main Menu" from Theme locations of Menu Settings on Appearance panel > Menus. 2. Import Sliders one by one manually. ( If "Record not found" warning is displaying in your front, you need to import all the used sliders ) 4. Install Contact Form 7 Manually ( if neccessary). NOTES: Please read the documentation where is in your downloaded folder from themeforest.net site. ', 'baganuur' ),
                ),
            );
        }
        
        function baganuur_ut_import_setup() {

            // Assign menus to their locations.
            $main_menu = get_term_by( 'name', 'Main Menu', 'nav_menu' );

            set_theme_mod( 'nav_menu_locations', array(
                    'main-menu' => $main_menu->term_id,
                )
            );

            // Assign front page and posts page (blog page).
            $front_page_id = get_page_by_title( 'Creative Home' );

            update_option( 'show_on_front', 'page' );
            update_option( 'page_on_front', $front_page_id->ID );

        }

    }

}

/*
  Load baganuur_ut_setup class

 */

$baganuur_ut_setup = new baganuur_ut_setup;

if (!isset($content_width)) {
    $content_width = 1170;
}