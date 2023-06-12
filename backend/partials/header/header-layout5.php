<?php
/*
  PHP file for displaying header.

 */

get_template_part('backend/partials/header/header', 'layout3');
// $mn_url = baganuur_ut_get_options(BAGANUUR_UT_T_OPTIONS . "mn_url");
$mn_url = '/';
$mn_text = baganuur_ut_get_options(BAGANUUR_UT_T_OPTIONS . "mn_text");
// $en_url = baganuur_ut_get_options(BAGANUUR_UT_T_OPTIONS . "en_url");
$en_url = '/en';
$en_text = baganuur_ut_get_options(BAGANUUR_UT_T_OPTIONS . "en_text");

/* Menu Minimal */
?>
<div id="baganuur-ut-header" class="baganuur-ut-header-container left-side-menu nav-down">
    <div class="baganuur-ut-header-inner">
        <div class="baganuur-ut-header-top">
            <a href="#mobile" class="ut-header-icons mobile-menu-icon ut-full-height">
                <i class="fa fa-bars"></i>
            </a>
            <?php
                echo baganuur_ut_searchmenu();
            ?>
        </div>
        <?php
            baganuur_ut_logo();
        ?>
        <div class="baganuur-ut-header-lang">
            <a href="<?php echo esc_url($mn_url) ?>"><?php echo esc_attr($mn_text) ?></a>
            <a href="<?php echo esc_url($en_url) ?>"><?php echo esc_attr($en_text) ?></a>
        </div>
    </div>
</div>

<div id="baganuur-ut-mobile-header" class="baganuur-ut-header-container">
    <div class="baganuur-ut-header-inner">
        <?php
        baganuur_ut_mobile_logo();
        ?>
        <div class="baganuur-ut-header-lang">
            <a href="<?php echo esc_url($mn_url) ?>"><?php echo esc_attr($mn_text) ?></a>
            <a href="<?php echo esc_url($en_url) ?>"><?php echo esc_attr($en_text) ?></a>
        </div>
        <a href="#mobile" class="ut-header-icons mobile-menu-icon ut-full-height">
            <i class="fa fa-bars"></i>
        </a>
    </div>
</div>
<div class="baganuur-ut-desktop-header-close"></div>
<div class="baganuur-ut-header-menu-outer left-side-menu">
    <div class="baganuur-ut-header-inner">
        <div class="baganuur-ut-mobile-header-close">
            <i class="ion-android-close"></i>
        </div>
        <?php baganuur_ut_mobile_menu(); ?>
    </div>
</div>
<div class="baganuur-ut-mobile-header-menu-back">
    <i class="ion-android-arrow-back"></i>
</div>