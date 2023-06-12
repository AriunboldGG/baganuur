<?php
    $title = $pt_class = $pt_class1 = $pt_class2 = '';
    $class = $data = $secondData = '';

    $featured_text = baganuur_ut_featured_text();
    var_dump('sdlfksdl');
    $subtitle = baganuur_ut_ptitle_get_subtitle();

    if ( baganuur_ut_core_check_singular_and_metabox() ) {
        if ( is_page() ) {
            $title = "<h1 class='page-title ut-page'>" . get_the_title() . "</h1>";
        } else if ( is_single() ) {
            $title = "<h1 class='page-title ut-post'>" . get_the_title() . "</h1>";
        }
    } else if ( !empty($featured_text) ) {
        $title = "<h1 class='page-title'>" . esc_attr($featured_text) . "</h1>";
        $subtitle = '';
    } else if ( baganuur_ut_core_check_singular() ) {
        $get_the_title = get_the_title();
        $pre_title = !empty($get_the_title) ? $get_the_title : esc_html__('(no title)', 'baganuur');
        $title = "<h1 class='page-title'>" . esc_attr($pre_title) . "</h1>";
    } else if ( baganuur_ut_core_woo_enabled() && get_post_type() == 'product' ) {
        ob_start();
        echo "<h1 class='page-title'>";
        woocommerce_page_title();
        echo "</h1>";
        $title = ob_get_clean();
    } else {
        $title = "<h1 class='page-title'>" . esc_attr(baganuur_ut_get_options(BAGANUUR_UT_T_OPTIONS . 'blog_page_title')) . "</h1>";
    }

    if (isset($title)) {
        $pt_style = baganuur_ut_ptitle_get_style();
        
        $pt_class .= 'ut-flex-align-center ut-full-height';

        $pt_class1 .= 'col-md-12';
        ?>
        <section id="baganuur-ut-title" class="<?php echo esc_attr($class); ?> baganuur-ut-title"<?php echo ($data); ?>>
            <div class="container ut-full-height">
                <div class="row <?php echo esc_attr($pt_class); ?>">
                    <div class="<?php echo esc_html($pt_class1); ?>"<?php echo ($secondData); ?>>
                        <?php
                        echo balanceTags($title);
                        ?>
                    </div>
                    <?php
                    if (function_exists('bcn_display') && $breadcrumb_visible === 'on') {
                        echo '<div class="baganuur-ut-breadcrumbs' . $pt_class2 . '"' . $secondData . '>';
                        echo balanceTags($ebreadcrumb);
                        echo '</div>';
                    }
                    ?>
                </div> 
            </div>
        </section>
        <?php
    }