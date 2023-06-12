<?php
/*
  Single Post

 */
get_header(); ?>

<?php
    the_post();

    $content_class = 'col-md-12';

    $feature = $author = $share = false;
    $format = get_post_format() == "" ? "standard" : get_post_format();
    $media = baganuur_ut_blog_standard_media($format, array());
    $image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' );
    $image_width = $image_height = '';
    if ( $image_url[1] ) {
        $image_width = 'width="' . $image_url[1] . '"';
    }
//    if ( $image_url[2] ) {
//        $image_height = 'height="' . $image_url[2] . '"';
//    }

    ?>
    <div class="row">
        <div class="<?php echo esc_attr($content_class); ?>">
            <h4 class="entry-title"><?php the_title(); ?></h4>
            <?php
            
            if (post_password_required()) {
                the_content();
            } else {?>
                <article <?php post_class('single'); ?>>
                    <?php
                        if ($image_url) {
                            echo '<img class="baganuur-ut-single-image" src="' . $image_url[0] . '" '. $image_height . '>';
//                            echo balanceTags($media);
                        }
                    ?>
                    <div class="entry-content">
                        <div class="entry-meta">
                            <div class="post-share">
                                <div class="post-share-socials">
                                    <a class="smedia facebook facebook-share" href="<?php echo esc_url(get_permalink()) ?>" title="Share this"><i class="fa fa-facebook"></i></a>
                                    <a class="smedia twitter twitter-share" href="' . esc_url(get_permalink()) . '" title="Tweet" data-title="' . esc_attr($post_title) . '"><i class="fa fa-twitter"></i></a>
                                    <a class="smedia print print-share" href="javascript:window.print()" title="Print this"><i class="ion-android-print"></i></a>
                                </div>
                            </div>
                            <span class="date"><i class="ion-android-calendar"></i> <a href="#"><?php echo get_the_time('Y-m-d'); ?></a></span> 
                        </div>
                        <?php the_content(); ?>
                        <?php wp_link_pages(); ?>
                    </div>
                </article>
                <?php
            }
            ?>
            
            <?php
                if ( is_single() ) {
                    $footer_page = baganuur_ut_get_options(BAGANUUR_UT_T_OPTIONS . 'footer_page');
                    if ( !empty($footer_page) ) {
                        $post = get_post($footer_page);
                        $content = apply_filters('the_content', $post->post_content);
                        echo '<div class="footer-page">';
                            echo $content;
                        echo '</div>';
                    }
                }
            ?>
        </div>
    </div>
<?php
get_footer();
