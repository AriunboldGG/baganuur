/* Resize */
jQuery(window).resize(function () {
    'use strict';

    /* Background video resize */
    jQuery('.background-video').each(function () {
        var $currBgVid = jQuery(this);
        var $currVid = $currBgVid.children('.fluidvids');
        if ($currVid.length) {
            var $currMar = ($currBgVid.height() - $currVid.outerHeight()) / 2;
            $currVid.css('margin-top', $currMar + 'px');
        }
    });

    jQuery('#menu-main > .menu-item-has-children.menu-item').each(function () {
        var $item_height = jQuery(this).outerHeight();
        var $children = jQuery(this).children('.baganuur-ut-menu-children');
        var $children_height = jQuery(this)
            .children('.baganuur-ut-menu-children')
            .outerHeight();
        var $top = ($children_height - $item_height) / 2;

        if (jQuery(window).width() > 767) {
            $children.css('top', '-' + $top + 'px');
        } else {
            $children.css('top', '100%');
        }
    });

    jQuery('.menu-item-has-children').click(function () {
        if (jQuery(window).width() < 768) {
            jQuery(this).addClass('active');
            jQuery('.baganuur-ut-mobile-header-menu-back').addClass('active');
        }
    });

    jQuery(
        '.baganuur-ut-menu-children > .menu-item > .baganuur-ut-menu-link'
    ).each(function () {
        var $width = jQuery(this).width();
        var $current_width = $width + 20;
        if (jQuery(window).width() > 767) {
            jQuery(this)
                .parent('.menu-item')
                .css('width', $current_width + 'px');
        } else {
            jQuery(this).parent('.menu-item').css('width', 'auto');
        }
    });

    /* Background video resize */
    jQuery('.background-video').each(function () {
        var $currBgVid = jQuery(this);
        var $currWpVid = $currBgVid.children('.wp-video');
        var $currMar = ($currBgVid.height() - $currWpVid.height()) / 2;
        $currWpVid.css('margin-top', $currMar + 'px').addClass($currMar);
    });

    if (jQuery('#wpadminbar').attr('id') === 'wpadminbar') {
        jQuery('html').css(
            'height',
            'calc(100% - ' + jQuery('#wpadminbar').height() + 'px'
        );
        jQuery('#baganuur-ut-header').css(
            'height',
            'calc(100% - ' + jQuery('#wpadminbar').height() + 'px'
        );
        jQuery('#baganuur-ut-mobile-header').css(
            'top',
            jQuery('#wpadminbar').height() + 'px'
        );
        jQuery('.baganuur-ut-header-menu-outer').css(
            'height',
            'calc(100% - ' + jQuery('#wpadminbar').height() + 'px'
        );
        jQuery('.baganuur-ut-header-menu-outer').css(
            'top',
            jQuery('#wpadminbar').height() + 'px'
        );
    }

    if (
        jQuery('body').hasClass('header-leftside') &&
        jQuery('#wpadminbar').attr('id') === 'wpadminbar'
    ) {
        var $adminbarHeight = jQuery('#wpadminbar').height();
        jQuery('.baganuur-ut-header-container.left-side-menu').css(
            'top',
            $adminbarHeight + 'px'
        );
    } else {
        jQuery('.baganuur-ut-header-container.left-side-menu').css('top', '');
    }

    jQuery('#baganuur-ut-mobile-header').each(function () {
        if (jQuery(window).width() < 768) {
            jQuery(this).addClass('active');
            if (jQuery(this).hasClass('active')) {
                jQuery(this).css('width', jQuery(window).width());
                jQuery('#theme-layout').css('padding-top', '60px');
                jQuery('.fixed-footer').css(
                    'top',
                    jQuery(this).height() + 'px'
                );
                jQuery('.fixed-footer').css(
                    'height',
                    'calc(100% - ' + jQuery(this).height() + 'px'
                );
            }
        } else {
            jQuery(this).removeClass('active');
            if (!jQuery(this).hasClass('active')) {
                jQuery('#theme-layout').css('padding-top', '0px');
                jQuery('.fixed-footer').css('top', '0px');
                jQuery('.fixed-footer').css('height', '100%');
            }
        }
    });
});
jQuery(document).ready(function ($) {
    'use strict';

    jQuery('.baganuur-ut-filter-year-month-item .filter-year-month').each(
        function () {
            var $this = jQuery(this);
            $this.on('click', 'li', function () {
                var $text = jQuery(this).text();
                var $selected_li = jQuery(this)
                    .parent()
                    .parent()
                    .children('.baganuur-ut-filter-year-month-selected-item')
                    .children('li');
                $selected_li.text($text);
            });
        }
    );

    jQuery('.search-on-menu-icon').each(function () {
        jQuery(this).click(function () {
            if (!jQuery(this).hasClass('active')) {
                jQuery(this).addClass('active');
                jQuery('.searchmenu').addClass('active');
            }
        });
    });

    jQuery('.search-on-menu-input-close').click(function () {
        if (jQuery('.baganuur-ut-menu-search-style').hasClass('active')) {
            jQuery('.baganuur-ut-menu-search-style').removeClass('active');
            jQuery('.search-on-menu-icon').removeClass('active');
        }
    });

    jQuery('html, body').mousewheel(function (e, delta) {
        if (navigator.appVersion.indexOf('Mac') != -1) {
            this.scrollLeft -= delta * 5;
        } else {
            this.scrollLeft -= delta * 45;
        }
        e.preventDefault();
    });

    jQuery('.baganuur-ut-desktop-header-close').click(function () {
        jQuery('body').removeClass('mobile-opened');
    });

    jQuery('.baganuur-ut-mobile-header-close').click(function () {
        jQuery('body').removeClass('mobile-opened');
        jQuery('.baganuur-ut-mobile-header-menu-back').removeClass('active');
        jQuery('.menu-item-has-children').removeClass('active');
    });

    jQuery('.baganuur-ut-team-item').each(function () {
        var team_modal_btn = jQuery(this).find('.member-modal-btn');
        var team_modal_close_btn = jQuery(this).find('.modal-close');
        var team_modal_id = team_modal_btn.attr('href');
        team_modal_btn.attr('id', team_modal_id + '-btn');
        team_modal_close_btn.attr('id', team_modal_id + '-close-btn');

        // Get the modal
        var modal = jQuery(team_modal_id);

        // Get the button that opens the modal
        var btn = jQuery(team_modal_btn);

        // Get the <span> element that closes the modal
        var $span = jQuery(this).find('.modal-close');

        // When the user clicks the button, open the modal
        btn.click(function () {
            modal.css('display', 'block');
        });

        // When the user clicks on <span> (x), close the modal
        $span.click(function () {
            modal.css('display', 'none');
        });

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function (event) {
            if (event.target == modal) {
                modal.css('display', 'none');
            }
        };
    });

    /* Lazy Load Configuration */
    jQuery('.baganuur-lazy').lazy({
        beforeLoad: function (element) {
            if (jQuery('.baganuur-ut-lazy-container').hasClass('lazy-loaded')) {
                jQuery('.baganuur-ut-lazy-container').removeClass(
                    'lazy-loaded'
                );
            }
        },
        afterLoad: function (element) {
            jQuery('.baganuur-ut-lazy-container').addClass('lazy-loaded');
        },
    });

    /* navigation */
    $('ul.sf-menu').superfish({
        delay: 10,
        speed: 'slow',
        cssArrows: false,
        autoArrows: false,
        dropShadows: false,
    });

    mobNav();

    jQuery('.menu-elements-menu-container > ul > li').hover(
        function () {
            jQuery(this).addClass('change');
        },
        function () {
            jQuery(this).removeClass('change');
        }
    );

    /* Menu */
    jQuery('.sf-menu > li:nth-last-child(1)').addClass('first-last-child');

    jQuery('.dropdown dd ul li a').click(function () {
        var text = jQuery(this).html() + '<i class="fa fa-angle-down"></i>';
        jQuery('.dropdown dt a span').html(text);
        jQuery('.dropdown dd ul').hide();
    });

    if (jQuery('.baganuur-ut-header-container').hasClass('nav-down')) {
        jQuery('.baganuur-ut-header-container')
            .removeClass('nav-down')
            .addClass('relative');
    }

    if (jQuery('#wpadminbar').attr('id') === 'wpadminbar') {
        jQuery(
            '.baganuur-ut-header-container.sticky-header .baganuur-ut-header'
        ).css('top', jQuery('#wpadminbar').height() + 'px');
    }

    if (
        jQuery('body.sticky-header-frequently.header-leftside') &&
        jQuery('#wpadminbar').attr('id') === 'wpadminbar'
    ) {
        var $adminbarHeight = jQuery('#wpadminbar').height();
        jQuery(
            'body.sticky-header-frequently.header-leftside #baganuur-ut-title'
        ).css('margin-top', $adminbarHeight);
    }

    /* facebook */
    $('.post-share a.facebook-share').click(function (e) {
        e.preventDefault();
        window.open(
            'https://www.facebook.com/sharer/sharer.php?u=' +
                jQuery(this).attr('href'),
            'facebookWindow',
            'height=380,width=660,resizable=0,toolbar=0,menubar=0,status=0,location=0,scrollbars=0'
        );
        return false;
    });
    /* facebook  mng*/
    $('.post-share-mng .post-share-socials a.facebook-share').click(function (
        e
    ) {
        e.preventDefault();
        window.open(
            'https://www.facebook.com/sharer/sharer.php?u=' +
                jQuery(this).attr('href'),
            'facebookWindow',
            'height=380,width=660,resizable=0,toolbar=0,menubar=0,status=0,location=0,scrollbars=0'
        );
        return false;
    });

    /* twitter */
    $('.post-share a.twitter-share').click(function (e) {
        e.preventDefault();
        window.open(
            'http://twitter.com/intent/tweet?text=' +
                $(this).data('title') +
                ' ' +
                jQuery(this).attr('href'),
            'twitterWindow',
            'height=380,width=660,resizable=0,toolbar=0,menubar=0,status=0,location=0,scrollbars=0'
        );
        return false;
    });

    /* pinterest */
    $('.post-share a.pinterest-share').click(function (e) {
        e.preventDefault();
        window.open(
            'http://pinterest.com/pin/create/button/?url=' +
                jQuery(this).attr('href') +
                '&media=' +
                $(this).closest('article').find('img').first().attr('src') +
                '&description=' +
                $('.section-title h1').text(),
            'pinterestWindow',
            'height=640,width=660,resizable=0,toolbar=0,menubar=0,status=0,location=0,scrollbars=0'
        );
        return false;
    });

    /* google */
    $('.post-share a.googleplus-share').click(function (e) {
        e.preventDefault();
        window.open(
            'https://plus.google.com/share?url={' +
                jQuery(this).attr('href') +
                '}',
            'googleWindow',
            'height=640,width=660,resizable=0,toolbar=0,menubar=0,status=0,location=0,scrollbars=0'
        );
        return false;
    });

    /* print */
    $('.post-share a.print-share').click(function (e) {
        window.print();
    });

    $(window).resize();
});
jQuery(window).load(function () {
    'use strict';

    baganuurReInit(jQuery('#baganuur-ut-main'));
    baganuur_ut_carousel();

    /* UnionTheme Animate General - Bind */
    jQuery('.baganuur-ut-animate-gen').each(function (i) {
        var $curr = jQuery(this);
        var $currChild = $curr.children().eq(-1);
        var $removeClass = true;
        if (
            $curr.data('animation') === 'pulse' ||
            $curr.data('animation') === 'floating' ||
            $curr.data('animation') === 'tossing'
        ) {
            $removeClass = false;
        }
        if (!$curr.parent().hasClass('not-inited')) {
            $curr.bind('baganuur-ut-animate', function () {
                var $currDelay = parseInt(
                    $curr.attr('data-animation-delay'),
                    10
                );
                if ($currDelay < 0) {
                    $currDelay = 0;
                }
                setTimeout(function () {
                    if ($currChild.hasClass('carousel-anim')) {
                        $currChild
                            .find('ul.baganuur-ut-carousel>li')
                            .each(function (i) {
                                var $currLi = jQuery(this);
                                setTimeout(function () {
                                    $currLi.css('opacity', '');
                                    $currLi.addClass(
                                        'animated ' + $curr.data('animation')
                                    );
                                    if ($removeClass) {
                                        setTimeout(function () {
                                            $currLi.removeClass('animated');
                                            $currLi.removeClass(
                                                $curr.data('animation')
                                            );
                                        }, 3000);
                                    }
                                }, 300 * i);
                            });
                    } else {
                        $curr.css('opacity', '');
                        $curr.addClass('animated ' + $curr.data('animation'));
                        if ($removeClass) {
                            setTimeout(function () {
                                $curr.removeClass('animated');
                                $curr.removeClass($curr.data('animation'));
                            }, 3000);
                        }
                    }
                }, $currDelay * i);
            });
        }
    });

    /* UnionTheme Animate General and Custom */
    jQuery('.baganuur-ut-animate-gen,.baganuur-ut-animate').each(function () {
        var $curr = jQuery(this);
        var $currOffset = $curr.attr('data-animation-offset');
        if (
            $currOffset === '' ||
            $currOffset === 'undefined' ||
            $currOffset === undefined
        ) {
            $currOffset = 'bottom-in-view';
        }
        if ($currOffset === 'none') {
            $curr.trigger('baganuur-ut-animate');
        } else {
            if (
                jQuery().waypoint !== undefined &&
                jQuery().waypoint !== 'undefined'
            ) {
                $curr.waypoint(
                    function () {
                        $curr.trigger('baganuur-ut-animate');
                    },
                    { triggerOnce: true, offset: $currOffset }
                );
            }
        }
    });

    /* Google Map Style */
    jQuery('.baganuur-ut-map').each(function (i) {
        var $currMapID = 'baganuur-ut-map-styled-' + i;
        var $currMap = jQuery(this);
        var $currMapStyle = $currMap.data('style');
        var $currMapMouse = $currMap.data('mouse');
        var $currMapLat = $currMap.data('lat');
        var $currMapLng = $currMap.data('lng');
        var $currMapZoom = $currMap.data('zoom');
        var $currMapArea = $currMap.children('.map').attr('id', $currMapID);

        var $map;
        var $center = new google.maps.LatLng($currMapLat, $currMapLng);
        var MY_MAPTYPE_ID = 'custom_style_' + i;
        $map = new google.maps.Map(document.getElementById($currMapID), {
            zoom: $currMapZoom,
            center: $center,
            mapTypeControlOptions: {
                mapTypeIds: [google.maps.MapTypeId.ROADMAP, MY_MAPTYPE_ID],
            },
            mapTypeId: MY_MAPTYPE_ID,
        });
        $map.setOptions({ scrollwheel: $currMapMouse });
        var $featureOpts = eval($currMap.data('json'));

        $map.mapTypes.set(
            MY_MAPTYPE_ID,
            new google.maps.StyledMapType($featureOpts, { name: $currMapStyle })
        );
        /* markers */
        if (
            jQuery().waypoint !== undefined &&
            jQuery().waypoint !== 'undefined'
        ) {
            $currMap.waypoint(
                function () {
                    $currMapArea
                        .siblings('.map-markers')
                        .children('.map-marker')
                        .each(function (j) {
                            var $currMar = jQuery(this);
                            var $currMarTitle = $currMar.data('title');
                            var $currMarLat = $currMar.data('lat');
                            var $currMarLng = $currMar.data('lng');
                            var $currMarIconSrc = $currMar.data('iconsrc');
                            var $currMarIconWidth = $currMar.data('iconwidth');
                            var $currMarIconHeight =
                                $currMar.data('iconheight');

                            var markerOp = {
                                position: new google.maps.LatLng(
                                    $currMarLat,
                                    $currMarLng
                                ),
                                map: $map,
                                title: $currMarTitle,
                                animation: google.maps.Animation.DROP,
                                zIndex: j,
                            };
                            if (
                                $currMarIconSrc &&
                                $currMarIconWidth &&
                                $currMarIconHeight
                            ) {
                                markerOp.icon = {
                                    url: $currMarIconSrc,
                                    size: new google.maps.Size(
                                        $currMarIconWidth,
                                        $currMarIconHeight
                                    ),
                                    origin: new google.maps.Point(0, 0),
                                    anchor: new google.maps.Point(
                                        parseInt($currMarIconWidth, 10) / 2,
                                        $currMarIconHeight
                                    ),
                                };
                            }
                            setTimeout(function () {
                                var marker = new google.maps.Marker(markerOp);
                                var infowindow = new google.maps.InfoWindow({
                                    content: $currMar.html(),
                                });
                                google.maps.event.addListener(
                                    marker,
                                    'click',
                                    function () {
                                        if (infowindow.getMap()) {
                                            infowindow.close();
                                        } else {
                                            infowindow.open($map, marker);
                                        }
                                    }
                                );
                            }, j * 300);
                        });
                },
                { triggerOnce: true, offset: 'bottom-in-view' }
            );
        }
    });

    jQuery(
        '#baganuur-ut-main span.date, #baganuur-ut-main span.page-numbers, #baganuur-ut-main a.page-numbers'
    ).each(function () {
        var $text = jQuery(this).text();
        if (!jQuery(this).hasClass('next') && !jQuery(this).hasClass('prev')) {
            for (var i = 0; i < $text.length; i++) {
                switch ($text.charAt(i)) {
                    case '0':
                        $text = setCharAt($text, i, '᠐');
                        break;
                    case '1':
                        $text = setCharAt($text, i, '᠑');
                        break;
                    case '2':
                        $text = setCharAt($text, i, '᠒');
                        break;
                    case '3':
                        $text = setCharAt($text, i, '᠓');
                        break;
                    case '4':
                        $text = setCharAt($text, i, '᠔');
                        break;
                    case '5':
                        $text = setCharAt($text, i, '᠕');
                        break;
                    case '6':
                        $text = setCharAt($text, i, '᠖');
                        break;
                    case '7':
                        $text = setCharAt($text, i, '᠗');
                        break;
                    case '8':
                        $text = setCharAt($text, i, '᠘');
                        break;
                    case '9':
                        $text = setCharAt($text, i, '᠙');
                        break;
                }
            }
            jQuery(this).text($text);
        }
    });

    function setCharAt(str, index, chr) {
        if (index > str.length - 1) return str;
        return str.substr(0, index) + chr + str.substr(index + 1);
    }

    jQuery(window).resize();
});

/* ------------------------------------------------------------------- */
function baganuurReInit($selector) {
    'use strict';

    /* Lazy Load Configuration ReInit */
    jQuery('.baganuur-lazy').lazy({
        beforeLoad: function (element) {
            if (jQuery('.baganuur-ut-lazy-container').hasClass('lazy-loaded')) {
                jQuery('.baganuur-ut-lazy-container').removeClass(
                    'lazy-loaded'
                );
            }
        },
        afterLoad: function (element) {
            jQuery('.baganuur-ut-lazy-container').addClass('lazy-loaded');
        },
    });

    /* PrettyPhoto */
    jQuery("a[rel^='prettyPhoto']", $selector).prettyPhoto({
        deeplinking: false,
    });

    /* Background Video */
    var $YTA = false;
    var $VMA = false;
    var $WPV = false;
    jQuery('.background-video.need-init', $selector)
        .each(function () {
            var $bgPlayer = jQuery(this).removeClass('need-init');
            var $bgPlayerType = $bgPlayer.data('type');
            if ($bgPlayerType === 'embed') {
                var $embed = $bgPlayer
                    .find('iframe')
                    .clone()
                    .removeClass('fluidvids-elem');
                var $embedSrc = $embed.attr('src');
                if ($embed.length) {
                    if ($embedSrc.indexOf('youtube.com') !== -1) {
                        $embed
                            .attr(
                                'src',
                                $embedSrc +
                                    ($embedSrc.indexOf('?') === -1
                                        ? '?'
                                        : '&') +
                                    'enablejsapi=1'
                            )
                            .addClass('baganuur-ut-youtube-player');
                        $YTA = true;
                    } else if ($embedSrc.indexOf('vimeo.com') !== -1) {
                        $embed
                            .attr(
                                'src',
                                $embedSrc +
                                    ($embedSrc.indexOf('?') === -1
                                        ? '?'
                                        : '&') +
                                    'api=1&portrait=0&badge=0&byline=0&title=0'
                            )
                            .addClass('baganuur-ut-vimeo-player');
                        $VMA = true;
                    }
                }
                $bgPlayer.html($embed);
            } else {
                $bgPlayer.find('video').addClass('baganuur-ut-wpv-player');
                $WPV = true;
            }
        })
        .promise()
        .done(function () {
            if ($YTA) {
                baganuurYTAPI();
            }
            if ($VMA) {
                baganuurVimeoAPI();
            }
            if ($WPV) {
                baganuurWPV();
            }
        });

    /* Video Responsive */
    jQuery('#baganuur-ut-main iframe').each(function () {
        if (
            !jQuery(this).closest('.ls-slide').hasClass('ls-slide') &&
            !jQuery(this).hasClass('fluidvids-elem')
        ) {
            jQuery(this).addClass('makeFluid');
        }
    });
    Fluidvids.init({
        selector: '#baganuur-ut-main iframe.makeFluid',
        players: ['www.youtube.com', 'player.vimeo.com'],
    });
    jQuery('#baganuur-ut-main iframe').removeClass('makeFluid');
}

function baganuurYTAPI() {
    'use strict';
    jQuery('.baganuur-ut-youtube-player').each(function (i) {
        var $id = 'baganuur-ut-youtube-player-' + i;
        var $bgPlayer = jQuery(this);
        var $bgPauseBtn = $bgPlayer.closest(
            '.background-video-player-container'
        );
        var $currVidEl = $bgPauseBtn.closest('.baganuur-ut-element');
        var $bgPlayBtn = $bgPauseBtn
            .siblings('.bg-video-container')
            .find('.bg-video-play');
        $bgPlayer.attr('id', $id);
        var player = new YT.Player($id, {
            playerVars: {
                autohide: 1,
                autoplay: 0 /*options.autoplay,*/,
                disablekb: 1,
                cc_load_policy: 0,
                controls: 0,
                enablejsapi: 1,
                fs: 0,
                modestbranding: 1,
                iv_load_policy: 3,
                loop: 1 /* Not Working !!! */,
                showinfo: 0,
                rel: 0,
                hd: 1,
            },
            events: {
                onReady: function () {
                    player.setLoop(true); /* Not Working !!! */
                    player.mute();
                    player.playVideo();
                    setTimeout(function () {
                        player.pauseVideo();
                        $bgPlayBtn.click(function () {
                            if ($bgPauseBtn.hasClass('paused')) {
                                player.playVideo();
                                $currVidEl.css(
                                    'height',
                                    $currVidEl.outerHeight() + 'px'
                                );
                                $bgPauseBtn
                                    .removeClass('paused')
                                    .css({ cursor: 'pointer' })
                                    .siblings('.bg-video-container')
                                    .fadeOut();
                            }
                        });
                        $bgPauseBtn.click(function () {
                            if (!$bgPauseBtn.hasClass('paused')) {
                                player.pauseVideo();
                                $currVidEl.css('height', '');
                                $bgPauseBtn
                                    .addClass('paused')
                                    .css({ cursor: '', height: '' })
                                    .siblings('.bg-video-container')
                                    .fadeIn();
                            }
                        });
                    }, 1000);
                },
                onStateChange: function (event) {
                    if (event.data === 0) {
                        player.playVideo();
                    }
                },
            },
        });
    });
}

function baganuurVimeoAPI() {
    'use strict';
    jQuery('.baganuur-ut-vimeo-player').each(function (i) {
        var $id = 'baganuur-ut-vimeo-player-' + i;
        var $bgPlayer = jQuery(this);
        var $bgPauseBtn = $bgPlayer.closest(
            '.background-video-player-container'
        );
        var $currVidEl = $bgPauseBtn.closest('.baganuur-ut-element');
        var $bgPlayBtn = $bgPauseBtn
            .siblings('.bg-video-container')
            .find('.bg-video-play');
        $bgPlayer.attr('id', $id);
        $bgPlayer.attr('src', $bgPlayer.attr('src') + '&player_id=' + $id);
        var player = $f($bgPlayer[0]);
        player.addEvent('ready', function () {
            player.api('setVolume', 0);
            player.api('setLoop', true);
            $bgPlayBtn.click(function () {
                if ($bgPauseBtn.hasClass('paused')) {
                    player.api('play');
                    $currVidEl.css('height', $currVidEl.outerHeight() + 'px');
                    $bgPauseBtn
                        .removeClass('paused')
                        .css({ cursor: 'pointer' })
                        .siblings('.bg-video-container')
                        .fadeOut();
                }
            });
            $bgPauseBtn.click(function () {
                if (!$bgPauseBtn.hasClass('paused')) {
                    player.api('pause');
                    $currVidEl.css('height', '');
                    $bgPauseBtn
                        .addClass('paused')
                        .css({ cursor: '', height: '' })
                        .siblings('.bg-video-container')
                        .fadeIn();
                }
            });
        });
    });
}

function baganuurWPV() {
    'use strict';
    jQuery('.baganuur-ut-wpv-player').each(function () {
        var $bgPlayer = jQuery(this);
        var $bgPauseBtn = $bgPlayer.closest(
            '.background-video-player-container'
        );
        var $currVidEl = $bgPauseBtn.closest('.baganuur-ut-element');
        var $bgPlayBtn = $bgPauseBtn
            .siblings('.bg-video-container')
            .find('.bg-video-play');
        var player = MediaElementPlayer($bgPlayer);
        player.setMuted(true);
        $bgPlayBtn.click(function () {
            if ($bgPauseBtn.hasClass('paused')) {
                player.play();
                $currVidEl.css('height', $currVidEl.outerHeight() + 'px');
                $bgPauseBtn
                    .removeClass('paused')
                    .css({ cursor: 'pointer' })
                    .siblings('.bg-video-container')
                    .fadeOut();
            }
        });
        $bgPauseBtn.click(function () {
            if (!$bgPauseBtn.hasClass('paused')) {
                player.pause();
                $currVidEl.css('height', '');
                $bgPauseBtn
                    .addClass('paused')
                    .css({ cursor: '', height: '' })
                    .siblings('.bg-video-container')
                    .fadeIn();
            }
        });
    });
}

/*
 Mobile Navigation
 
 */

function mobNav() {
    'use strict';
    /*
     Mobile navigation
     
     */

    jQuery('.mobile-menu-icon,i.menu-minimal').click(function () {
        if (!jQuery('body').hasClass('mobile-opened')) {
            jQuery('body').addClass('mobile-opened');
        }
    });

    jQuery('.baganuur-ut-mobile-header-menu-back').click(function () {
        jQuery(this).removeClass('active');
        jQuery('.menu-item-has-children').removeClass('active');
    });

    jQuery('.mobile-close').click(function () {
        if (jQuery('body').hasClass('mobile-opened')) {
            jQuery('body').removeClass('mobile-opened');
        }
    });
}

/* Carousel */
/* ------------------------------------------------------------------- */
function baganuur_ut_carousel() {
    'use strict';
    if (
        jQuery().owlCarousel !== undefined &&
        jQuery().owlCarousel !== 'undefined'
    ) {
        jQuery('.baganuur-ut-carousel-container').each(function () {
            var $currCrslCont = jQuery(this);
            var $items = parseInt($currCrslCont.data('items'), 10)
                ? parseInt($currCrslCont.data('items'), 10)
                : 1;
            var $itemsDesktop = false; /*[1199,4]*/
            var $itemsDesktopSmall = [979, 2]; /*[979,3]*/
            var $itemsTablet = [768, 1]; /*[768,2]*/
            var $itemsTabletSmall = false; /*false or [768,2]*/
            var $itemsMobile = [479, 1]; /*[479,1]*/
            var $itemsCustom = false; /*false or [479,1]*/
            var $singleItem = false;
            var $auto =
                $currCrslCont.data('autoplay') === ''
                    ? false
                    : $currCrslCont.data('autoplay');
            var $navigation = true;
            var $pagination = false;
            var $touchDrag = true;
            var $mouseDrag = true;
            var $transitionStyle = 'backSlide';
            var $is_progress_bar_enabled = false;
            var $navigationText = [
                "<i class='fa fa-angle-left'></i>",
                "<i class='fa fa-angle-right'></i>",
            ];
            var $currentCrsl = $currCrslCont.find('.baganuur-ut-carousel');

            $currentCrsl.owlCarousel({
                items: $items,
                margin: 1,
                itemsDesktop: $itemsDesktop,
                itemsDesktopSmall: $itemsDesktopSmall,
                itemsTablet: $itemsTablet,
                itemsTabletSmall: $itemsTabletSmall,
                itemsMobile: $itemsMobile,
                itemsCustom: $itemsCustom,
                autoPlay: $auto,
                singleItem: $singleItem,
                slideSpeed: 800,
                dots: $pagination,
                paginationSpeed: 900,
                rewindSpeed: 500,
                navigationText: $navigationText,
                autoHeight: true,
                nav: $navigation,
                touchDrag: $touchDrag,
                mouseDrag: $mouseDrag,
                transitionStyle: $transitionStyle,
            });
        });
    }
}
function reload_lazy_load() {
    'use strict';

    /* Lazy Load Configuration */
    jQuery('.baganuur-lazy').lazy({
        beforeLoad: function (element) {
            if (jQuery('.baganuur-ut-lazy-container').hasClass('lazy-loaded')) {
                jQuery('.baganuur-ut-lazy-container').removeClass(
                    'lazy-loaded'
                );
            }
        },
        afterLoad: function (element) {
            jQuery('.baganuur-ut-lazy-container').addClass('lazy-loaded');
        },
    });
}
window.onload = function () {
    jQuery('.baganuur-ut-blog .filter-buttons').click(function () {
        setTimeout(function () {
            reload_lazy_load();
        }, 2000);
    });

    jQuery('.filter-year-month li a').each(function () {
        var $text = jQuery(this).text();
        if (!jQuery(this).hasClass('next') && !jQuery(this).hasClass('prev')) {
            for (var i = 0; i < $text.length; i++) {
                switch ($text.charAt(i)) {
                    case '0':
                        $text = setCharAt($text, i, '᠐');
                        break;
                    case '1':
                        $text = setCharAt($text, i, '᠑');
                        break;
                    case '2':
                        $text = setCharAt($text, i, '᠒');
                        break;
                    case '3':
                        $text = setCharAt($text, i, '᠓');
                        break;
                    case '4':
                        $text = setCharAt($text, i, '᠔');
                        break;
                    case '5':
                        $text = setCharAt($text, i, '᠕');
                        break;
                    case '6':
                        $text = setCharAt($text, i, '᠖');
                        break;
                    case '7':
                        $text = setCharAt($text, i, '᠗');
                        break;
                    case '8':
                        $text = setCharAt($text, i, '᠘');
                        break;
                    case '9':
                        $text = setCharAt($text, i, '᠙');
                        break;
                }
            }
            jQuery(this).text($text);
        }
    });

    function setCharAt(str, index, chr) {
        if (index > str.length - 1) return str;
        return str.substr(0, index) + chr + str.substr(index + 1);
    }
};
