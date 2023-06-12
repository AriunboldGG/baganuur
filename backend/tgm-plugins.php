<?php
/**
 * This file represents an example of the code that themes would use to register
 * the required plugins.
 *
 * It is expected that theme authors would copy and paste this code into their
 * functions.php file, and amend to suit.
 *
 * @see http://tgmpluginactivation.com/configuration/ for detailed documentation.
 *
 * @package   TGM-Plugin-Activation
 * @version   2.6.1
 * @link      http://tgmpluginactivation.com/
 * @author    Thomas Griffin, Gary Jones, Juliette Reinders Folmer
 * @copyright Copyright (c) 2011, Thomas Griffin
 * @license   GPL-2.0+
 */

/**
 * Include the TGM_Plugin_Activation class.
 */
require_once BAGANUUR_UT_THEME_PATH . '/backend/tgm-plugin-activation.php';

add_action( 'tgmpa_register', 'baganuur_ut_register_required_plugins' );
/**
 * Register the required plugins for this theme.
 *
 * In this example, we register five plugins:
 * - one included with the TGMPA library
 * - two from an external source, one from an arbitrary source, one from a GitHub repository
 * - two from the .org repo, where one demonstrates the use of the `is_callable` argument
 *
 * The variable passed to tgmpa_register_plugins() should be an array of plugin
 * arrays.
 *
 * This function is hooked into tgmpa_init, which is fired within the
 * TGM_Plugin_Activation class constructor.
 */
function baganuur_ut_register_required_plugins() {
    /*
     * Array of plugin arrays. Required keys are name and slug.
     * If the source is NOT from the .org repo, then source is also required.
     */
    $plugins = array(
        array(
            'name'     => esc_html__('01 Redux Framework', 'baganuur'), // The plugin name
            'slug'     => 'redux-framework', // The plugin slug (typically the folder name)
            'required' => true,            // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
            'force_activation'   => false,
        ),
        array(
            'name'     => esc_html__('02 Advanced Custom Fields', 'baganuur'), // The plugin name
            'slug'     => 'advanced-custom-fields', // The plugin slug (typically the folder name)
            'required' => true,            // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
            'force_activation'   => false,
        ),
        array(
            'name'                  => esc_html__('03 ACF Background', 'baganuur'),
            'slug'                  => 'acf-background',
            'source'                => get_template_directory().'/backend/plugins/acf-background.zip',
            'required'              => true,
            'version'               => '1.6.0',
            'force_activation'      => false,
            'force_deactivation'    => true,
            'external_url'          => '',
        ),
        array(
            'name'                  => esc_html__('04 Visual Composer', 'baganuur'),
            'slug'                  => 'js_composer',
            'source'                => get_template_directory().'/backend/plugins/js_composer.zip',
            'required'              => true,
            'version'               => '5.0.1',
            'force_activation'      => false,
            'force_deactivation'    => true,
            'external_url'          => '',
        ),
        array(
            'name'               => esc_html__('05 Revolution Slider', 'baganuur'), // The plugin name
            'slug'               => 'revslider',         // The plugin slug (typically the folder name)
            'source'             => get_template_directory_uri() . '/backend/plugins/revslider.zip', // The plugin source
            'required'           => true,                // If false, the plugin is only 'recommended' instead of required
            'version'            => '5.3.1.5',           // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
            'force_activation'   => false,               // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
            'force_deactivation' => true,                // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
            'external_url'       => '',                  // If set, overrides default API URL and points to an external URL
        ),
        array(
            'name'               => esc_html__('06 baganuur Core', 'baganuur'), // The plugin name
            'slug'               => 'baganuur-core',             // The plugin slug (typically the folder name)
            'source'             => get_template_directory_uri() . '/backend/plugins/baganuur-core.zip', // The plugin source
            'required'           => true,                           // If false, the plugin is only 'recommended' instead of required
            'version'            => '1.1',
            'force_activation'   => false,                          // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
            'force_deactivation' => true,                           // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
            'external_url'       => '',                             // If set, overrides default API URL and points to an external URL
        ),
        array(
            'name'     => esc_html__('07 One Click Demo Import', 'baganuur'), // The plugin name
            'slug'     => 'one-click-demo-import', // The plugin slug (typically the folder name)
            'required' => true,            // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
            'force_activation'   => false,
        ), 
        array(
            'name'     => esc_html__('08 MailChimp for WordPress', 'baganuur'), // The plugin name
            'slug'     => 'mailchimp-for-wp', // The plugin slug (typically the folder name)
            'required' => true,            // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
            'force_activation'   => false,
        ),
    );


    /*
     * Array of configuration settings. Amend each line as needed.
     *
     * TGMPA will start providing localized text strings soon. If you already have translations of our standard
     * strings available, please help us make TGMPA even better by giving us access to these translations or by
     * sending in a pull-request with .po file(s) with the translations.
     *
     * Only uncomment the strings in the config array if you want to customize the strings.
     */
    $config = array(
            'id'           => 'tgmpa',                 // Unique ID for hashing notices for multiple instances of TGMPA.
            'default_path' => '',                      // Default absolute path to bundled plugins.
            'menu'         => 'tgmpa-install-plugins', // Menu slug.
            'parent_slug'  => 'themes.php',            // Parent menu slug.
            'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
            'has_notices'  => true,                    // Show admin notices or not.
            'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
            'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
            'is_automatic' => false,                   // Automatically activate plugins after installation or not.
            'message'      => '',                      // Message to output right before the plugins table.
    );

    tgmpa( $plugins, $config );
}
