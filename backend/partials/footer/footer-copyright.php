<?php
/*
  PHP file for displaying footer copyright section.

*/

$copyright_text = baganuur_ut_footer_get_copyright_text();
?>
    <div class="baganuur-ut-footer">
        <div class="site-copy"><?php echo esc_attr($copyright_text); ?></div>
    </div>