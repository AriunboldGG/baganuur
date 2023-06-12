<?php
    if ( baganuur_ut_check_vc_active() ) {

        $content = do_shortcode('[baganuur_ut_blog]');

        echo balanceTags($content);
    } else { ?>
        <div class="baganuur-ut-blog-container">
            <div class="baganuur-ut-blog clearfix baganuur-ut-normal-style">
            <?php
                if (have_posts()) {
                    while (have_posts()) { the_post(); ?>
                        <article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?>>

                            <?php
                            $atts = array(
                                'css' => '',
                                'custom_class' => '',
                                'item_anim' => '',
                                'animated' => 'none',
                                'animation_delay' => '',
                                // VC Padding
                                't_padding' => '',
                                'b_padding' => '',
                                // Element class
                                'element_class' => 'baganuur-ut-element baganuur-ut-blog',
                                // Style
                                'layout' => 'normal',
                                'column' => '',
                                'img_height' => '',
                                'img_width' => '',
                                'grayscale' => '',
                                'pagination' => 'simple',
                                'cats' => '',
                                'count' => '',
                                'excerpt_count' => '',
                                'more_text' => 'ᠳᠡᠯᠭᠡᠷᠡᠩᠭᠦᠢ',
                                'post_margin' => '',
                                // Other
                                'not_in' => '',
                                'type' => 'element',
                            );
                            if(function_exists("baganuur_ut_blog_loop")) {
                                call_user_func('baganuur_ut_blog_loop', $atts);
                            }
                            ?>

                        </article><?php
                    }
                    baganuur_ut_pagination_simple();
                }
            ?>
            </div>    
        </div><?php
    }
?>
