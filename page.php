<?php
/*
  Single Page

*/
    get_header();
    the_post();
    $post = baganuur_ut_globals::get('post');

    if ( is_page() && !is_front_page() ) {
        echo '<h6 class="entry-title baganuur-page-core-title">';
            echo get_the_title( get_the_ID() );
        echo '</h6>';
    }

    echo '<div class="baganuur-ut-main">';
        echo '<div class="entry-content">';
            the_content();
        echo '</div>';
        wp_link_pages();
    echo "</div>";
    get_footer();
