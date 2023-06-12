<?php

/*
  This PHP file contains BLOG functions.
 * prefix: baganuur_ut_blog_

 * Blog
 * Blog Normal Loop
 * Get Blog Media
 * Blog Entry Media
 * Blog - Standard media
 * Get format Image & Gallery
 * Get format Video
 * Get format Audio
 * Get format Quote
 * Get format Link
 * Blog Meta
 * Get baganuur Style
 * Get Blog Content
 * Get Blog Excerpt
 * Get Blog Read More link
 * Sticky Post Filter
 * Get Author Info
 * Get Post Share

 */

/*
  Blog

 */

if (!function_exists('baganuur_ut_blog')) {

    function baganuur_ut_blog($atts) {

        baganuur_ut_vc_enqueue_waypoint();

        $start = $blog_layout = $end = $isotopMargin = $postMargin = $grayScale = '';
        $addClass = '';

        $atts = shortcode_atts(array(
            // Global
            'css'             => '',
            'custom_class'    => '',
            'item_anim'       => '',
            'animated'        => 'none',
            'animation_delay' => '',
            't_padding'       => '',
            'b_padding'       => '',
            'element_class'   => 'baganuur-ut-blog',//element class
            'cats'            => '',
            'count'           => get_option('posts_per_page'),
            'img_width'       => '',
            'img_height'      => '',
            'layout'          => 'normal',
            'excerpt_count'   => '',
            'more_text'       => 'ᠳᠡᠯᠭᠡᠷᠡᠩᠭᠦᠢ',
            'filter'          => 'simple',
            'pagination'      => 'simple',
            'not_in'          => '',
            'element_dark'    => '',
            'primary_color'   => '',
            ), $atts);

        $func = 'baganuur_ut_blog_loop';

        $atts['primary_color'] = baganuur_ut_get_primary_color();

        $atts['img_height'] = '';
        $blog_layout .= ' baganuur-ut-normal-style baganuur-ut-isotope-container';

        $atts['element_class'] .= '' . $blog_layout . '';

        if ( $atts['filter'] === 'simple' ) {
            $atts['count'] = 99999;
            $atts['pagination'] = 'none';
            $cats = empty($atts['cats']) ? false : explode(",", $atts['cats']);
            $primary_color = baganuur_ut_get_primary_color();

            $filter_style = ' baganuur-ut-dropdown-style baganuur-ut-core-style';

            $start .= '<div class="baganuur-ut-filters ' . $filter_style . '">';
                $start .= '<ul class="filters baganuur-ut-active-color-change clearfix ' . esc_attr($atts['filter']) . '" data-option-key="categories">';
                    $start .= '<li><a href="#filter" data-primary-color="' . esc_attr($primary_color) . '" data-option-value="*" class="show-all selected filter-buttons">' . esc_html__('ᠪᠦᠭᠦᠳᠡ', 'baganuur') . '</a></li>';
                    if ( $cats ) {
                        $filters = $cats;
                    } else {
                        $filters = get_terms('category');
                    }
                    foreach ( $filters as $category ) {
                        if ( $cats ) {
                            $category = get_term_by('slug', $category, 'category');
                        }
                        $start .= '<li class="hidden"><a href="#filter" data-primary-color="' . esc_attr($primary_color) . '" data-option-value=".category-' . esc_attr($category->slug) . '" class="filter-buttons" title="' . esc_attr($category->name) . '">' . esc_html($category->name) . '</a></li>';
                    }
                $start .= '</ul>';

                $start .= '<div class="baganuur-ut-filter-year-month">';

                    $start .= '<div class="baganuur-ut-filter-year-month-item">';
                        $start .= '<ul class="baganuur-ut-filter-year-month-selected-item">';
                            $start .= '<li>' . esc_html__('ᠣᠨ', 'baganuur') . '</li>';
                        $start .= '</ul>';
                        $years = wp_get_archives( array( 'type' => 'yearly', 'echo' => 0 ) );
                        $start .= '<ul class="filters filter-year filter-year-month ' . esc_attr($atts['filter']) . '" data-option-key="year">';
                            $start .= '<li><a href="#filter" data-option-value="*" class="show-all selected filter-buttons">' . esc_html__('ᠣᠨ', 'baganuur') . '</a></li>';
                            $start .= $years;
                        $start .= '</ul>';
                    $start .= '</div>';

                    $start .= '<div class="baganuur-ut-filter-year-month-item">';
                        $start .= '<ul class="baganuur-ut-filter-year-month-selected-item">';
                            $start .= '<li>' . esc_html__('ᠰᠠᠷ᠎ᠠ', 'baganuur') . '</li>';
                        $start .= '</ul>';
                        $start .= '<ul class="filters filter-month filter-year-month ' . esc_attr($atts['filter']) . '" data-option-key="date">';
                            $start .= '<li><a href="#filter" data-option-value="*" class="show-all selected filter-buttons">' . esc_html__('ᠰᠠᠷ᠎ᠠ', 'baganuur') . '</a></li>';
                            $start .= '<li class="hidden"><a href="#filter" data-option-value=".filter-month-01" class="filter-buttons">01</a></li>';
                            $start .= '<li class="hidden"><a href="#filter" data-option-value=".filter-month-02" class="filter-buttons">02</a></li>';
                            $start .= '<li class="hidden"><a href="#filter" data-option-value=".filter-month-03" class="filter-buttons">03</a></li>';
                            $start .= '<li class="hidden"><a href="#filter" data-option-value=".filter-month-04" class="filter-buttons">04</a></li>';
                            $start .= '<li class="hidden"><a href="#filter" data-option-value=".filter-month-05" class="filter-buttons">05</a></li>';
                            $start .= '<li class="hidden"><a href="#filter" data-option-value=".filter-month-06" class="filter-buttons">06</a></li>';
                            $start .= '<li class="hidden"><a href="#filter" data-option-value=".filter-month-07" class="filter-buttons">07</a></li>';
                            $start .= '<li class="hidden"><a href="#filter" data-option-value=".filter-month-08" class="filter-buttons">08</a></li>';
                            $start .= '<li class="hidden"><a href="#filter" data-option-value=".filter-month-09" class="filter-buttons">09</a></li>';
                            $start .= '<li class="hidden"><a href="#filter" data-option-value=".filter-month-10" class="filter-buttons">10</a></li>';
                            $start .= '<li class="hidden"><a href="#filter" data-option-value=".filter-month-11" class="filter-buttons">11</a></li>';
                            $start .= '<li class="hidden"><a href="#filter" data-option-value=".filter-month-12" class="filter-buttons">12</a></li>';
                        $start .= '</ul>';
                    $start .= '</div>';

                $start .= '</div>';
            $start .= '</div>';
        }

        $output = baganuur_ut_vc_item( $atts );

        $s = get_search_query();
        if ( $s ) {
            $atts['more_text'] = 'ᠳᠡᠯᠭᠡᠷᠡᠩᠭᠦᠢ';
            $query = array(
                'post_type' => 'post',
                'posts_per_page' => $atts['count'],
                's' => $s
            );
        }else{
            $query = array(
                'post_type' => 'post',
                'posts_per_page' => $atts['count'],
            );
        }

        if ($atts['pagination'] == "simple" || $atts['pagination'] == "infinite") {

            if (get_query_var('paged')) {
                $paged = get_query_var('paged');
            } elseif (get_query_var('page')) {
                $paged = get_query_var('page');
            } else {
                $paged = 1;
            }

            $query['paged'] = $paged;
        }

        if ( $atts['pagination'] === 'infinite' || $atts['filter'] === 'simple' ) {
//            $addClass .= ' not-inited';
            baganuur_ut_vc_enqueue_isotope();

            $atts['element_class'] .= ' baganuur-ut-isotope-container';
            $start .= '<div class="isotope-container clearfix">';
            $end .= '</div>';
        }

        $cats = empty($atts['cats']) ? false : explode(",", $atts['cats']);

        if ( $cats ) {
            $query['tax_query'] = Array(Array(
                    'taxonomy' => 'category',
                    'terms' => $cats,
                    'field' => 'slug'
                )
            );
        }

        ob_start();
        query_posts($query);

        if (have_posts()) {
            echo ($start);
            while (have_posts()) {
                the_post();
                if ( $atts['filter'] != 'none' ) {
                    $upload_date = ' filter-year-' . get_the_time('Y') . ' filter-month-' . get_the_time('m');
                    $addClass .= ' ' . $upload_date;
                }
            ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class($addClass); ?> <?php echo ($postMargin) ?> >
                    <?php call_user_func($func, $atts); ?>
                </article><?php
//                if ( $atts['filter'] != 'none' ) {
//                    if (!empty($upload_date)) {
//                        $addClass = ' not-inited';
//                    }
//                }
            }
            echo ($end);
            if ( $atts['pagination'] == "simple" ) {
                baganuur_ut_pagination_simple();
            } elseif ( $atts['pagination'] == "infinite" ) {
                baganuur_ut_pagination_infinite();
            }

        }
        wp_reset_query();
        $output .= ob_get_clean();
        $output .= '</div>';
        return $output;
    }

}

/*
  Blog Normal Loop

 */

if (!function_exists('baganuur_ut_blog_loop')) {

    function baganuur_ut_blog_loop($atts) {

        $grayScale = $opacity_0 = $data = '';
        $result = baganuur_ut_blog_get_media($atts);

        $format = $result['format'];
        $media = $result['media'];
        $content = $result['content'];

        if (!empty($atts['grayscale']) && $atts['grayscale'] === 'true') {
            $grayScale = ' ut-grayscale-img ';
        }

        if ( isset( $atts['animated'] ) && $atts['animated'] != 'none' ) {
            $opacity_0 = 'style="opacity: 0;"';
            $data = ' data-animation="'.$atts['animated'].'" data-animation-delay="'.$atts['animation_delay'].'" data-animation-offset="90%"';
        }

        echo '<div class="entry-block baganuur-ut-animate-gen baganuur-ut-animate ' . $grayScale . '" ' . $data . ' ' . $opacity_0 . '>';
        echo balanceTags($media);

        if (empty($content)) {
            echo '</div>';
            return;
        }

        ob_start();
        baganuur_ut_blog_get_content($atts);

        if ($format == 'standard' || $format == 'video' || $format == 'audio' || $format == 'gallery' || $format == 'image' || $format == 'sticky') {
            baganuur_ut_blog_get_meta_format($atts);
        } else {
            ob_get_clean();
        }

        echo '</div>';
    }

}

/*
  Get Blog Media - Resize pictures depending on blog media.

 */

if (!function_exists('baganuur_ut_blog_get_media')) {

    function baganuur_ut_blog_get_media($atts) {

        $result = array(
            'format' => '',
            'media' => '',
            'content' => '',
        );

        $content = true;
        $format = ( get_post_format() == "" ) ? "standard" : get_post_format();
        if ( is_sticky() ) {
            $format = "sticky";
        }

        if ($format == 'standard' || $format == 'sticky') {
            $media = baganuur_ut_blog_standard_media($format, $atts);
        } else {
            $media = baganuur_ut_blog_entry_media($format, $atts);
            if ($media && ( $format == 'link' || $format == 'aside' || $format == 'status' )) {
                $content = false;
            } else {
                $media = baganuur_ut_blog_entry_media($format, $atts);
            }
        }

        $result['format'] = $format;
        $result['media'] = $media;
        $result['content'] = $content;

        return $result;
    }

}

/*
  Blog Entry Media

 */

if (!function_exists('baganuur_ut_blog_entry_media')) {

    function baganuur_ut_blog_entry_media($format, $atts) {
        $output = $class = '';
        switch ($format) {
            case 'standard':
                $output .= baganuur_ut_blog_standard_media($format, $atts);
                break;
            case 'image':
                $output .= baganuur_ut_blog_get_format_image_gallery($atts, $format);
                break;
            case 'gallery':
                $output .= baganuur_ut_blog_get_format_image_gallery($atts, $format);
                break;
            case 'video':
                $output .= baganuur_ut_blog_get_format_video($atts);
                break;
            case 'audio':
                $output .= baganuur_ut_blog_get_format_audio($atts);
                break;
            case 'quote':
                $output .= baganuur_ut_blog_get_format_quote();
                break;
            case 'link':
                $output .= baganuur_ut_blog_get_format_link();
                break;
        }
        return $output;
    }

}

/*
  Blog - Standard media

 */

if (!function_exists('baganuur_ut_blog_standard_media')) {

    function baganuur_ut_blog_standard_media($format, $atts) {
        $output = $post_img = $thumbnail_bg_img = $thumbnail_box_height = $thumbnail_style = $add_thumbnail_class = '';

        $post_id = get_the_ID();

        if (has_post_thumbnail($post_id)) {
            $width = '';
            $height = '';
            $post_img1 = baganuur_ut_core_get_lazy_image($width, $height, true);
            $post_lazy_img = baganuur_ut_core_get_lazy_image($width, $height, false, false, false);
            $thumbnail_bg_img = $post_img1['url'];
            // $thumbnail_style = 'style="' . $thumbnail_box_height . '"';
            $thumbnail_style = 'style="background-image: url(' . esc_url($thumbnail_bg_img) . ')"; "display:block"';
            $add_thumbnail_class = 'baganuur-ut-thumbnail-bg-image';
            if ( $post_img1['url'] ) {
                $post_img = '<img src="' . esc_url(BAGANUUR_UT_THEME_DIR . '/backend/assets/img/metro-img.png') . '" alt="' . esc_attr($post_img1['alt']) . '"/>';
            }

            $output .= '<div class="entry-media">';
                $output .= '<div class="baganuur-ut-thumbnail baganuur-lazy ' . esc_attr($add_thumbnail_class) . '" data-src="' . esc_url($thumbnail_bg_img) . '" ' . balanceTags($thumbnail_style) . '>';
                    if ( ( array_key_exists('layout', $atts) && $atts['layout'] === 'normal' ) && isset( $post_lazy_img ) ) {
                        $output .= $post_lazy_img;
                    }
                    $output .= $post_img;
                    if ( is_single() ) {
                        $img = baganuur_ut_core_image(0, 0, true);
                        $output .= '<a class="image-overlay" href="' . esc_url($img['url']) . '" rel="prettyPhoto[' . esc_attr($post_id) . ']"></a>';
                    } else {
                        $output .= '<a class="image-overlay" href="' . esc_url(get_permalink()) . '"></a>';
                    }
                $output .= '</div>';
            $output .= '</div>';
        }
        return $output;
    }

}

/*
  Get format Image & Gallery

 */

if (!function_exists('baganuur_ut_blog_get_format_image_gallery')) {

    function baganuur_ut_blog_get_format_image_gallery($atts, $format, $single = 'blog' ) {

        $owl_data = $blog_gallery_type = '';
        $post_id = get_the_ID();
        $ids = get_post_meta($post_id, 'gallery_image_ids', true);

        if (baganuur_ut_core_check_singular() && has_post_thumbnail($post_id) && count($ids) == 0 ) {
            $output = baganuur_ut_blog_standard_media($format, $atts);
            return $output;
        }

        switch ( $single ) {
            case 'blog':
                $blog_gallery_type = baganuur_ut_acf_get_field('blog_gallery_type') != false ? baganuur_ut_acf_get_field('blog_gallery_type') : 'gallery-carousel';
                if ( $blog_gallery_type === 'gallery-carousel' ) {
                    $transition = baganuur_ut_acf_get_field('blog_gallery_transition') != false ? baganuur_ut_acf_get_field('blog_gallery_transition') : '';
                    $progressbar = baganuur_ut_acf_get_field('blog_gallery_progressbar') != false ? baganuur_ut_acf_get_field('blog_gallery_progressbar') : 'progressbar-off';
                    $owl_data = ' data-transition=' . esc_attr($transition) . ' data-progressbar=' . esc_attr($progressbar);
                }
                break;
        }

        $output = '';
        $AbsMetaIcon = 'ion ion-image';
        $class = 'image-slide-container';
        if ($format == 'gallery') {
            $class = 'image-gallery-container';
            $AbsMetaIcon = 'ion ion-qr-scanner';
        }

        $width = !empty($atts['img_width']) ? $atts['img_width'] : '';
        $height = !empty($atts['img_height']) ? $atts['img_height'] : get_post_meta($post_id, 'format_image_height', true);

        if (!empty($ids) && $ids !== 'false') {
            if ( ( $single === 'blog' && !empty($blog_gallery_type) && $blog_gallery_type === 'gallery-carousel' ) ) {
                wp_enqueue_script('owl-carousel');
            }
            $output .= '<div class="entry-media baganuur-ut-slide-container baganuur-ut-carousel-container ' . $class . ' clearfix">';
            $output .= '<div class="baganuur-ut-carousel"' . esc_attr($owl_data) . '>';
            foreach (explode(',', $ids) as $id) {
                if (!empty($id)) {
                    $lazy_img = baganuur_ut_core_get_lazy_image_by_attachment_id($id);
                    $imagelink = baganuur_ut_core_check_singular() ? wp_get_attachment_url($id) : get_permalink();
                    $prettyPhoto = baganuur_ut_core_check_singular() ? "prettyPhoto['" . $post_id . "']" : "";
                    $output .= '<div class="baganuur-ut-owl-item">';
                        $output .= '<a href=' . esc_url($imagelink) . ' rel="' . esc_attr($prettyPhoto) . '">';
                        $output .= $lazy_img;
                    $output .= '</a></div>';
                }
            }
            $output .= '</div>';
            $output .= '</div>';
        } else if (has_post_thumbnail($post_id)) {
            //in case there are no ids.
            $output = baganuur_ut_blog_standard_media($format, $atts);
        }

        return $output;
    }

}

/*
  Get format Video
 */

if (!function_exists('baganuur_ut_blog_get_format_video')) {

    function baganuur_ut_blog_get_format_video($atts) {

        $output = '';
        $post_id = get_the_ID();

        $embed = get_post_meta($post_id, 'format_video_embed', true);
        $thumb = get_post_meta($post_id, 'format_video_thumb', true);
        $url = get_post_meta($post_id, 'format_video_m4v', true);

        if (!empty($embed) || !empty($url)) {
            $output .= '<div class="entry-media">';
            if (!empty($embed)) {
                $output .= apply_filters("the_content", htmlspecialchars_decode($embed));
            } else {
                if (!empty($url)) {
                    $output .= apply_filters("the_content", '[video src="' . esc_url($url) . '" poster="' . esc_url($thumb) . '" width="1170" height="480"]');
                }
            }
            $output .= '</div>';
        } else if (has_post_thumbnail($post_id)) {
            //in case there are no ids.
            $output = baganuur_ut_blog_standard_media('video', $atts);
        }

        return $output;
    }

}

/*
  Get format Audio
 */

if (!function_exists('baganuur_ut_blog_get_format_audio')) {

    function baganuur_ut_blog_get_format_audio($atts) {

        $output = '';
        $post_id = get_the_ID();

        $url = get_post_meta($post_id, 'format_audio_mp3', true);
        $embed = get_post_meta($post_id, 'format_audio_embed', true);

        if (!empty($embed) || !empty($url)) {
            $output .= '<div class="entry-media">';
            if (!empty($embed)) {
                $output .= apply_filters("the_content", htmlspecialchars_decode($embed));
            } else {
                ob_start();
                the_post_thumbnail();
                echo apply_filters("the_content", '[audio src="' . esc_url($url) . '"]');
                $output .= ob_get_clean();
            }
            $output .= '</div>';
        } else if (has_post_thumbnail($post_id)) {
            //in case there are no ids.
            $output = baganuur_ut_blog_standard_media('audio', $atts);
        }

        return $output;
    }

}

/*
  Get format Quote
 */

if (!function_exists('baganuur_ut_blog_get_format_quote')) {

    function baganuur_ut_blog_get_format_quote() {

        $output = '';
        $post_id = get_the_ID();

        $bg = $class = '';
        if (has_post_thumbnail($post_id)) {
            $img = baganuur_ut_core_image(0, 0, true);
            $bg = '<div class="bg-overlay"></div>';
            $bg .= '<div class="bg baganuur-lazy" data-src="' . esc_url($img['url']) . '" style="position: absolute"></div>';
        } else {
            $bg = '<div class="bg-overlay"></div>';
            $bg .= '<div class="bg baganuur-lazy" data-src="' . esc_url(BAGANUUR_UT_THEME_DIR . "/backend/assets/img/quote-bg.jpg") . '" style="position: absolute"></div>';
        }
        $class .= 'quote-format';

        $quote_text = get_post_meta($post_id, 'format_quote_text', true);
        if (!empty($quote_text)) {
            $output .= '<div class="entry-media">';
                $output .= '<blockquote class="' . $class . '">';
                    $output .= '<div class="quote-content">';
                        $output .= $bg;
                        $quote_author = get_post_meta($post_id, 'format_quote_author', true);
                        $output .= "<div class='quote-text'>" . esc_html($quote_text) . "</div>";
                        if (!empty($quote_author)) {
                            $output .= '<div class="quote-author">';
                                $output .= '<i class="ion ion-quote quote-icon"></i><span>' . esc_html($quote_author) . '</span>';
                            $output .= '</div>';
                        }
                    $output .= '</div>';
                $output .= "</blockquote>";
            $output .= "</div>";
        }

        return $output;
    }

}

/*
  Get format Link
 */

if (!function_exists('baganuur_ut_blog_get_format_link')) {

    function baganuur_ut_blog_get_format_link() {

        $output = $class = $bg = '';
        $post_id = get_the_ID();

        if (has_post_thumbnail($post_id)) {
            $img = baganuur_ut_core_image(0, 0, true);
            $bg = '<div class="bg-overlay"></div>';
            $bg .= '<div class="bg baganuur-lazy" data-src="' . esc_url($img['url']) . '" style="position: absolute"></div>';
        } else {
            $bg = '<div class="bg-overlay"></div>';
            $bg .= '<div class="bg baganuur-lazy" data-src="' . esc_url(BAGANUUR_UT_THEME_DIR . "/backend/assets/img/quote-bg.jpg") . '" style="position: absolute"></div>';
        }
        $class .= 'link-format';

        $link_url = get_post_meta($post_id, 'format_link_url', true);
        if (!empty($link_url)) {
            $output .= '<div class="entry-media">';
                $output .= '<blockquote class="' . $class . '">';
                    $output .= '<div class="quote-content">';
                        $output .= $bg;
                        $output .= '<div class="quote-text">' . get_the_title() . '</div>';
                        $output .= '<div class="quote-author">';
                            $output .= '<i class="ion ion-link quote-icon"></i><span><a href="' . esc_url($link_url) . '" target="_blank">' . esc_url($link_url) . '</a></span>';
                        $output .= '</div>';
                    $output .= '</div>';
                $output .= '</blockquote>';
            $output .= '</div>';
        }

        return $output;
    }

}

/*
  Blog Meta - Template expect for Quote & Link format.

 */

if (!function_exists('baganuur_ut_blog_get_meta_format')) {

    function baganuur_ut_blog_get_meta_format($atts) {

        global $post;

        $btn_html = '';
        $blogcontent = ob_get_clean();

        echo '<div class="entry-content-outer">';
            if ( get_the_title() ) {
                echo '<h6 class="entry-title"><a href="' . esc_url(get_permalink()) . '">' . get_the_title() . '</a></h6>';
            }

            if (!empty($blogcontent)) {
                echo '<div class="entry-content clearfix">';
                    echo balanceTags($blogcontent);
                echo '</div>';
            }

            if (( (bool) preg_match('/<!--more(.*?)?-->/', $post->post_content) || !empty($atts['excerpt_count']) ) && !empty($atts['more_text'])) {
                $primary_color = $atts['primary_color'];
                $btn_html .= '<a href="' . esc_url(get_permalink()) . '" class="btn more-link">';
                    $btn_html .= esc_html($atts['more_text']);
                $btn_html .= '</a>';
            }

            echo '<div class="entry-meta-container clearfix">';
                echo '<div class="entry-meta clearfix">';
                    echo balanceTags($btn_html);
                    echo '<span class="date">' . get_the_time('Y/m/d') . '</span> ';
                echo '</div>';
            echo '</div>';

        echo '</div>';
    }

}

/*
  Get Blog Content

 */

if (!function_exists('baganuur_ut_blog_get_content')) {

    function baganuur_ut_blog_get_content($atts) {

        if (!empty($atts['excerpt_count'])) {
            echo apply_filters("the_content", baganuur_ut_blog_get_excerpt(strip_shortcodes(get_the_content()), $atts['excerpt_count']));
        } elseif (has_excerpt()) {
            the_excerpt();
        } else {
            the_content('');
        }
    }

}

/*
  Get Blog Excerpt

 */

if (!function_exists('baganuur_ut_blog_get_excerpt')) {

    function baganuur_ut_blog_get_excerpt($str, $length) {
        $str = explode(" ", strip_tags($str));
        return implode(" ", array_slice($str, 0, $length));
    }

}

/*
  Get Blog Read More link

 */

add_filter('the_content_more_link', 'baganuur_ut_blog_get_read_more_link', 10, 2);
if (!function_exists('baganuur_ut_blog_get_read_more_link')) {

    function baganuur_ut_blog_get_read_more_link( $content_more_link, $read_more_text ) {
        
        $primary_color = baganuur_ut_get_primary_color();
        $content_more_link = '<p><a class="btn btn-border more-link border-style" href="' . esc_url(get_permalink()) . '">';
            $content_more_link .= $read_more_text;
        $content_more_link .= '</a></p>';
        return $content_more_link;
    }

}

/*
  Sticky Post Filter

 */

add_filter('the_posts', 'baganuur_ut_blog_sticky_posts_to_top');
function baganuur_ut_blog_sticky_posts_to_top($posts) {

    foreach($posts as $i => $post) {
        if(is_sticky($post->ID)) 
        {
            $stickies[] = $post;
            unset($posts[$i]);
        }
    }
    
    if(!empty($stickies)) 
        return array_merge($stickies, $posts);
    
    return $posts;
}

/*
  Check Author Info

 */

if (!function_exists('baganuur_ut_blog_check_author')) {

    function baganuur_ut_blog_check_author() {
        
        $return = false;
        
        $description = get_the_author_meta('description');
        if ($description != '') {
            $return = true;
        }
        
        return $return;
    }

}

/*
  Get Author Info

 */

if (!function_exists('baganuur_ut_blog_author')) {

    function baganuur_ut_blog_author() {
        ?>
        <div class="baganuur-ut-author clearfix">
            <div class="author-image"><?php
                $author_email = get_the_author_meta('email');
                echo get_avatar($author_email, $size = '80');
                ?>
            </div>
            <div class="author-info">
                <span class="author-name"><?php
                    if (is_author()) {
                        the_author();
                    } else {
                        the_author_posts_link();
                    }
                    ?>
                </span>
                <p><?php
                    $description = get_the_author_meta('description');
                    if ($description != '') {
                        echo balanceTags($description);
                    }
                    ?>
                </p>
            </div>

        </div><?php
    }

}

/*
  Get Post Share

 */

if (!function_exists('baganuur_ut_blog_share')) {

    function baganuur_ut_blog_share() {

        $post_title = get_the_title();
        $output = '<div class="post-share">';
            $output .= '<div class="post-share-socials">';
                $output .= '<a class="smedia facebook facebook-share" href="' . esc_url(get_permalink()) . '" title="Share this"><i class="fa fa-facebook"></i></a>';
                $output .= '<a class="smedia twitter twitter-share" href="' . esc_url(get_permalink()) . '" title="Tweet" data-title="' . esc_attr($post_title) . '"><i class="fa fa-twitter"></i></a>';
                $output .= '<a class="smedia googleplus googleplus-share" href="' . esc_url(get_permalink()) . '" title="Share this"><i class="ion-social-googleplus"></i></a>';
                $output .= '<a class="smedia linkedin linkedin-share" href="' . esc_url(get_permalink()) . '" title="Share this"><i class="ion-social-linkedin"></i></a>';
            $output .= '</div>';
        $output .= '</div>';

        echo balanceTags($output);
    }

}

/*
  Get Post Tag

 */

if (!function_exists('baganuur_ut_blog_get_tag')) {

    function baganuur_ut_blog_get_tag() {
        $output = '';
        if ( get_the_tag_list() ) {
            $output = '<div class="baganuur-ut-post-tagbox clearfix">';
                $output .= get_the_tag_list();
            $output .= '</div>';
        }
        echo balanceTags($output);
    }

}
