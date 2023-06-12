<?php
/*
   404 Not Found Page

 */
get_header();
?>
<div id="error404-container" class="error404-container ut-flex-align-center ut-flex-justify-center">
    <h5 class="error404-title"><?php esc_html_e("OOPS,", 'baganuur'); ?></h5>
    <h5 class="error404-content"><?php esc_html_e("This Page Not Found!", 'baganuur'); ?></h5>
    <h5 class="error404-title"><?php esc_html_e("404", 'baganuur'); ?></h5>
</div>

<?php get_footer(); ?>