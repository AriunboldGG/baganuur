<?php
/*
  Get/Set global variables

 */

if ( !class_exists('baganuur_ut_globals')) {
    return ;
}

class baganuur_ut_globals {

    public static function get( $name = '' ) {
        if ( empty( $name ) ) {
            return null;
        }

        switch( $name ) {
            case 'wp_query':
                global $wp_query;
                return $wp_query;
            case 'author':
                global $author;
                return $author;
            case 'post':
                global $post;
                return $post;
            case 'fonticon':
                global $fonticon;
                return $fonticon;
            case 'baganuur_ut_get_options':
                global $baganuur_ut_get_options;
                return $baganuur_ut_get_options;
            case 'baganuur_ut_like_time_before_revote':
                global $baganuur_ut_like_time_before_revote;
                return $baganuur_ut_like_time_before_revote;
            default:
                return null;
        }
    }

    public static function set( $name = '', $new_val = '' ) {

        if ( empty( $name ) ) {
            return null;
        }
        
        if ( empty( $new_val ) ) {
            return null;
        }
        
        switch( $name ) {
            case 'fonticon':
                global $fonticon;
                $fonticon = $new_val;
                break;
            case 'baganuur_ut_like_time_before_revote':
                global $baganuur_ut_like_time_before_revote;
                $baganuur_ut_like_time_before_revote = $new_val;
                break;
        }
    }
}
