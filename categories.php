 <div class="baganuur-ut-blog-container">
    <div class="baganuur-ut-blog clearfix baganuur-ut-normal-style">
    <?php
        if (have_posts()) {
            while (have_posts()) { the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?>>

                    <?php
                    if(function_exists("baganuur_ut_blog_loop")) {
                        call_user_func('baganuur_ut_blog_loop', array('excerpt_count'=> 20));
                    }
                    ?>

                </article><?php
            }
            utcore_pagination(array());
        }
    ?>
    </div>    
</div>