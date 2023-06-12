<?php

/*
  UnionTheme Search Form Customize

 */

function baganuur_ut_searchmenu() {

    $form = '<i class="fa fa-search search-on-menu-icon"></i>'
          . '<div class="searchmenu baganuur-ut-menu-search-style pull-right">'
            . '<form method="get" class="searchform" action="' . esc_url(home_url('/')) . '" >
                    <div class="input">
                        <i class="fa fa-close search-on-menu-input-close"></i>
                        <input type="text" value="' . get_search_query() . '" name="s" placeholder="' . esc_html__('ᠬᠠᠶᠢᠬᠤ', 'baganuur') . '" />
                    </div>
                </form>
            </div>';

    return $form;
}

function baganuur_ut_searchform() {

    $form = '<form method="get" class="searchform" action="' . esc_url(home_url('/')) . '" >
                <div class="input-container">
                    <input type="text" value="' . get_search_query() . '" name="s" autocomplete="off" placeholder="' . esc_html__('Type Here', 'baganuur') . '" />
                    <i class="ion ion-ios-arrow-thin-right"></i>
                </div>
            </form>';

    return $form;
}

add_filter('get_search_form', 'baganuur_ut_searchform');

function baganuur_ut_search_form_on_menu() {
    $form = '<form method="get" class="searchform" action="' . esc_url(home_url('/')) . '" >
                <input type="search" value="' . get_search_query() . '" name="s" autocomplete="off" placeholder="' . esc_html__('Type Here', 'baganuur') . '" />
            </form>';

    return $form;
}