<?php
/*
  Register Fonts
*/

function creative_ut_redux_fonts_url() {
    $font_url = '';
    
    /*
    Translators: If there are characters in your language that are not supported
    by chosen font(s), translate this to 'off'. Do not translate into your own language.
     */
    if ( 'off' !== _x( 'on', 'Google font: on or off', 'baganuur' ) ) {
        $font_url = add_query_arg( 'family', urlencode( 'Playfair Display|:400,400italic,700italic,700&subset=latin,latin-ext' ), "//fonts.googleapis.com/css" );
    }
    return $font_url;
}
/*
Enqueue scripts and styles.
*/
function creative_ut_redux_fonts() {
    wp_enqueue_style( 'baganuur-ut-fonts', creative_ut_redux_fonts_url(), array(), '1.0.0' );
}
add_action( 'wp_enqueue_scripts', 'creative_ut_redux_fonts' );