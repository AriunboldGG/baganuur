<?php
/*
  PHP file for displaying search on menu.

 */

    $class = $minimal = '';

    switch ( baganuur_ut_header_get_layout_style() ) {
        case 'normal':
            $class .= ' pull-right';
            break;
        
        case 'classic':
            $class .= ' ut-flex-justify-center';
            break;
        
        case 'menu-minimal':
            $class .= ' ';
            $minimal = '<a href="#minimal" class="ut-header-icons ut-full-height"><i class="fa fa-bars menu-minimal"></i></a>';
            break;
        
        case 'logo-top-center':
            $class .= ' ut-flex-justify-center';
            break;
        
        case 'left-side-menu':
            $class .= '';
            break;
    }

    if ( !empty($minimal) ) {
        echo balanceTags($minimal);
    } else {
        echo '<nav class="cd-nav ut-flex-align-center ut-full-height' . $class . '">';
        baganuur_ut_menu();
        echo '</nav>';
    }