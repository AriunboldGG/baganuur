<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js" xmlns="http://www.w3.org/1999/xhtml" prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb#">
    <head>
        <meta charset="<?php bloginfo('charset'); ?>">
        <meta http-equiv="X-Frame-Options" content="deny">
        <link rel="profile" href="http://gmpg.org/xfn/11">
        <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
        <?php baganuur_ut_favicon(); ?>
        <?php wp_head(); ?>
    </head>
    <body <?php body_class(); ?>>
        <div id="theme-layout">
            <?php
                baganuur_ut_hook_header();
            ?>
            <main id="baganuur-ut-main" class="baganuur-ut-content <?php echo is_404() ? 'baganuur-ut-404 ut-flex-align-center' : ''; ?>">