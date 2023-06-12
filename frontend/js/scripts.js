/*
 * jQuery Superfish Menu Plugin - v1.7.7
 * Copyright (c) 2015
 *
 * Dual licensed under the MIT and GPL licenses:
 *	http://www.opensource.org/licenses/mit-license.php
 *	http://www.gnu.org/licenses/gpl.html
 */

(function ($) {
    $.fn.superfish = function (op) {
        var sf = $.fn.superfish,
            c = sf.c,
            $arrow = $(
                ['<span class="', c.arrowClass, '"> &#187;</span>'].join('')
            ),
            over = function () {
                var $$ = $(this),
                    menu = getMenu($$);
                clearTimeout(menu.sfTimer);
                $$.showSuperfishUl().siblings().hideSuperfishUl();
            },
            out = function () {
                var $$ = $(this),
                    menu = getMenu($$),
                    o = sf.op;
                clearTimeout(menu.sfTimer);
                menu.sfTimer = setTimeout(function () {
                    o.retainPath = $.inArray($$[0], o.$path) > -1;
                    $$.hideSuperfishUl();
                    if (
                        o.$path.length &&
                        $$.parents(['li.', o.hoverClass].join('')).length < 1
                    ) {
                        over.call(o.$path);
                    }
                }, o.delay);
            },
            getMenu = function ($menu) {
                var menu = $menu.parents(
                    ['ul.', c.menuClass, ':first'].join('')
                )[0];
                sf.op = sf.o[menu.serial];
                return menu;
            },
            addArrow = function ($a) {
                $a.addClass(c.anchorClass).append($arrow.clone());
            };
        return this.each(function () {
            var s = (this.serial = sf.o.length);
            var o = $.extend({}, sf.defaults, op);
            o.$path = $('li.' + o.pathClass, this)
                .slice(0, o.pathLevels)
                .each(function () {
                    $(this)
                        .addClass([o.hoverClass, c.bcClass].join(' '))
                        .filter('li:has(ul)')
                        .removeClass(o.pathClass);
                });
            sf.o[s] = sf.op = o;
            $('li:has(ul)', this)
                [$.fn.hoverIntent && !o.disableHI ? 'hoverIntent' : 'hover'](
                    over,
                    out
                )
                .each(function () {
                    if (o.autoArrows) addArrow($('>a:first-child', this));
                })
                .not('.' + c.bcClass)
                .hideSuperfishUl();
            var $a = $('a', this);
            $a.each(function (i) {
                var $li = $a.eq(i).parents('li');
                $a.eq(i)
                    .focus(function () {
                        over.call($li);
                    })
                    .blur(function () {
                        out.call($li);
                    });
            });
            o.onInit.call(this);
        }).each(function () {
            var menuClasses = [c.menuClass];
            if (sf.op.dropShadows && !($.browser.msie && $.browser.version < 7))
                menuClasses.push(c.shadowClass);
            $(this).addClass(menuClasses.join(' '));
        });
    };
    var sf = $.fn.superfish;
    sf.o = [];
    sf.op = {};
    sf.IE7fix = function () {
        var o = sf.op;
        if (
            $.browser.msie &&
            $.browser.version > 6 &&
            o.dropShadows &&
            o.animation.opacity != undefined
        )
            this.toggleClass(sf.c.shadowClass + '-off');
    };
    sf.c = {
        bcClass: 'sf-breadcrumb',
        menuClass: 'sf-js-enabled',
        anchorClass: 'sf-with-ul',
        arrowClass: 'sf-sub-indicator',
        shadowClass: 'sf-shadow',
    };
    sf.defaults = {
        hoverClass: 'sfHover',
        pathClass: 'overideThisToUse',
        pathLevels: 1,
        delay: 800,
        animation: { opacity: 'show' },
        speed: 'normal',
        autoArrows: true,
        dropShadows: true,
        disableHI: false,
        onInit: function () {},
        onBeforeShow: function () {},
        onShow: function () {},
        onHide: function () {},
    };
    $.fn.extend({
        hideSuperfishUl: function () {
            var o = sf.op,
                not = o.retainPath === true ? o.$path : '';
            o.retainPath = false;
            var $ul = $(['li.', o.hoverClass].join(''), this)
                .add(this)
                .not(not)
                .removeClass(o.hoverClass)
                .find('>ul')
                .hide()
                .css('visibility', 'hidden');
            o.onHide.call($ul);
            return this;
        },
        showSuperfishUl: function () {
            var o = sf.op,
                sh = sf.c.shadowClass + '-off',
                $ul = this.addClass(o.hoverClass)
                    .find('>ul:hidden')
                    .css('visibility', 'visible');
            sf.IE7fix.call($ul);
            o.onBeforeShow.call($ul);
            $ul.animate(o.animation, o.speed, function () {
                sf.IE7fix.call($ul);
                o.onShow.call($ul);
            });
            return this;
        },
    });
})(jQuery);

/*!
 *  FluidVids.js v2.1.0
 *  Responsive and fluid YouTube/Vimeo video embeds.
 *  Project: https://github.com/toddmotto/fluidvids
 *  by Todd Motto: http://toddmotto.com
 *
 *  Copyright 2013 Todd Motto. MIT licensed.
 */
window.Fluidvids = (function (a, b) {
    'use strict';
    var c,
        d,
        e = b.head || b.getElementsByTagName('head')[0],
        f =
            '.fluidvids-elem{position:absolute;top:0px;left:0px;width:100%;height:100%;}.fluidvids{width:100%;position:relative;}',
        g = function (a) {
            return (
                (c = new RegExp(
                    '^(https?:)?//(?:' + d.join('|') + ').*$',
                    'i'
                )),
                c.test(a)
            );
        },
        h = function (a) {
            var c = b.createElement('div'),
                d = a.parentNode,
                e =
                    100 *
                    (parseInt(a.height ? a.height : a.offsetHeight, 10) /
                        parseInt(a.width ? a.width : a.offsetWidth, 10));
            d.insertBefore(c, a),
                (a.className += ' fluidvids-elem'),
                (c.className += ' fluidvids'),
                (c.style.paddingTop = e + '%'),
                c.appendChild(a);
        },
        i = function () {
            var a = b.createElement('div');
            (a.innerHTML = '<p>x</p><style>' + f + '</style>'),
                e.appendChild(a.childNodes[1]);
        },
        j = function (a) {
            var c = a || {},
                e = c.selector || 'iframe';
            d = c.players || ['www.youtube.com', 'player.vimeo.com'];
            for (var f = b.querySelectorAll(e), j = 0; j < f.length; j++) {
                var k = f[j];
                g(k.src) && h(k);
            }
            i();
        };
    return { init: j };
})(window, document);

/* ------------------------------------------------------------------------
Class: prettyPhoto
Use: Lightbox clone for jQuery
Author: Stephane Caron (http://www.no-margin-for-errors.com)
Version: 3.1.5
------------------------------------------------------------------------- */
(function (e) {
    function t() {
        var e = location.href;
        hashtag =
            e.indexOf('#prettyPhoto') !== -1
                ? decodeURI(
                      e.substring(e.indexOf('#prettyPhoto') + 1, e.length)
                  )
                : false;
        return hashtag;
    }
    function n() {
        if (typeof theRel == 'undefined') return;
        location.hash = theRel + '/' + rel_index + '/';
    }
    function r() {
        if (location.href.indexOf('#prettyPhoto') !== -1)
            location.hash = 'prettyPhoto';
    }
    function i(e, t) {
        e = e.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
        var n = '[\\?&]' + e + '=([^&#]*)';
        var r = new RegExp(n);
        var i = r.exec(t);
        return i == null ? '' : i[1];
    }
    e.prettyPhoto = { version: '3.1.5' };
    e.fn.prettyPhoto = function (s) {
        function g() {
            e('.pp_loaderIcon').hide();
            projectedTop =
                scroll_pos['scrollTop'] + (d / 2 - a['containerHeight'] / 2);
            if (projectedTop < 0) projectedTop = 0;
            $ppt.fadeTo(settings.animation_speed, 1);
            $pp_pic_holder
                .find('.pp_content')
                .animate(
                    { height: a['contentHeight'], width: a['contentWidth'] },
                    settings.animation_speed
                );
            $pp_pic_holder.animate(
                {
                    top: projectedTop,
                    left:
                        v / 2 - a['containerWidth'] / 2 < 0
                            ? 0
                            : v / 2 - a['containerWidth'] / 2,
                    width: a['containerWidth'],
                },
                settings.animation_speed,
                function () {
                    $pp_pic_holder
                        .find('.pp_hoverContainer,#fullResImage')
                        .height(a['height'])
                        .width(a['width']);
                    $pp_pic_holder
                        .find('.pp_fade')
                        .fadeIn(settings.animation_speed);
                    if (isSet && S(pp_images[set_position]) == 'image') {
                        $pp_pic_holder.find('.pp_hoverContainer').show();
                    } else {
                        $pp_pic_holder.find('.pp_hoverContainer').hide();
                    }
                    if (settings.allow_expand) {
                        if (a['resized']) {
                            e('a.pp_expand,a.pp_contract').show();
                        } else {
                            e('a.pp_expand').hide();
                        }
                    }
                    if (settings.autoplay_slideshow && !m && !f)
                        e.prettyPhoto.startSlideshow();
                    settings.changepicturecallback();
                    f = true;
                }
            );
            C();
            s.ajaxcallback();
        }
        function y(t) {
            $pp_pic_holder
                .find('#pp_full_res object,#pp_full_res embed')
                .css('visibility', 'hidden');
            $pp_pic_holder
                .find('.pp_fade')
                .fadeOut(settings.animation_speed, function () {
                    e('.pp_loaderIcon').show();
                    t();
                });
        }
        function b(t) {
            t > 1 ? e('.pp_nav').show() : e('.pp_nav').hide();
        }
        function w(e, t) {
            resized = false;
            E(e, t);
            (imageWidth = e), (imageHeight = t);
            if ((p > v || h > d) && doresize && settings.allow_resize && !u) {
                (resized = true), (fitting = false);
                while (!fitting) {
                    if (p > v) {
                        imageWidth = v - 200;
                        imageHeight = (t / e) * imageWidth;
                    } else if (h > d) {
                        imageHeight = d - 200;
                        imageWidth = (e / t) * imageHeight;
                    } else {
                        fitting = true;
                    }
                    (h = imageHeight), (p = imageWidth);
                }
                if (p > v || h > d) {
                    w(p, h);
                }
                E(imageWidth, imageHeight);
            }
            return {
                width: Math.floor(imageWidth),
                height: Math.floor(imageHeight),
                containerHeight: Math.floor(h),
                containerWidth: Math.floor(p) + settings.horizontal_padding * 2,
                contentHeight: Math.floor(l),
                contentWidth: Math.floor(c),
                resized: resized,
            };
        }
        function E(t, n) {
            t = parseFloat(t);
            n = parseFloat(n);
            $pp_details = $pp_pic_holder.find('.pp_details');
            $pp_details.width(t);
            detailsHeight =
                parseFloat($pp_details.css('marginTop')) +
                parseFloat($pp_details.css('marginBottom'));
            $pp_details = $pp_details
                .clone()
                .addClass(settings.theme)
                .width(t)
                .appendTo(e('body'))
                .css({ position: 'absolute', top: -1e4 });
            detailsHeight += $pp_details.height();
            detailsHeight = detailsHeight <= 34 ? 36 : detailsHeight;
            $pp_details.remove();
            $pp_title = $pp_pic_holder.find('.ppt');
            $pp_title.width(t);
            titleHeight =
                parseFloat($pp_title.css('marginTop')) +
                parseFloat($pp_title.css('marginBottom'));
            $pp_title = $pp_title
                .clone()
                .appendTo(e('body'))
                .css({ position: 'absolute', top: -1e4 });
            titleHeight += $pp_title.height();
            $pp_title.remove();
            l = n + detailsHeight;
            c = t;
            h =
                l +
                titleHeight +
                $pp_pic_holder.find('.pp_top').height() +
                $pp_pic_holder.find('.pp_bottom').height();
            p = t;
        }
        function S(e) {
            if (e.match(/youtube\.com\/watch/i) || e.match(/youtu\.be/i)) {
                return 'youtube';
            } else if (e.match(/vimeo\.com/i)) {
                return 'vimeo';
            } else if (e.match(/\b.mov\b/i)) {
                return 'quicktime';
            } else if (e.match(/\b.swf\b/i)) {
                return 'flash';
            } else if (e.match(/\biframe=true\b/i)) {
                return 'iframe';
            } else if (e.match(/\bajax=true\b/i)) {
                return 'ajax';
            } else if (e.match(/\bcustom=true\b/i)) {
                return 'custom';
            } else if (e.substr(0, 1) == '#') {
                return 'inline';
            } else {
                return 'image';
            }
        }
        function x() {
            if (doresize && typeof $pp_pic_holder != 'undefined') {
                scroll_pos = T();
                (contentHeight = $pp_pic_holder.height()),
                    (contentwidth = $pp_pic_holder.width());
                projectedTop =
                    d / 2 + scroll_pos['scrollTop'] - contentHeight / 2;
                if (projectedTop < 0) projectedTop = 0;
                if (contentHeight > d) return;
                $pp_pic_holder.css({
                    top: projectedTop,
                    left: v / 2 + scroll_pos['scrollLeft'] - contentwidth / 2,
                });
            }
        }
        function T() {
            if (self.pageYOffset) {
                return {
                    scrollTop: self.pageYOffset,
                    scrollLeft: self.pageXOffset,
                };
            } else if (
                document.documentElement &&
                document.documentElement.scrollTop
            ) {
                return {
                    scrollTop: document.documentElement.scrollTop,
                    scrollLeft: document.documentElement.scrollLeft,
                };
            } else if (document.body) {
                return {
                    scrollTop: document.body.scrollTop,
                    scrollLeft: document.body.scrollLeft,
                };
            }
        }
        function N() {
            (d = e(window).height()), (v = e(window).width());
            if (typeof $pp_overlay != 'undefined')
                $pp_overlay.height(e(document).height()).width(v);
        }
        function C() {
            if (
                isSet &&
                settings.overlay_gallery &&
                S(pp_images[set_position]) == 'image'
            ) {
                itemWidth = 52 + 5;
                navWidth =
                    settings.theme == 'facebook' ||
                    settings.theme == 'pp_default'
                        ? 50
                        : 30;
                itemsPerPage = Math.floor(
                    (a['containerWidth'] - 100 - navWidth) / itemWidth
                );
                itemsPerPage =
                    itemsPerPage < pp_images.length
                        ? itemsPerPage
                        : pp_images.length;
                totalPage = Math.ceil(pp_images.length / itemsPerPage) - 1;
                if (totalPage == 0) {
                    navWidth = 0;
                    $pp_gallery
                        .find('.pp_arrow_next,.pp_arrow_previous')
                        .hide();
                } else {
                    $pp_gallery
                        .find('.pp_arrow_next,.pp_arrow_previous')
                        .show();
                }
                galleryWidth = itemsPerPage * itemWidth;
                fullGalleryWidth = pp_images.length * itemWidth;
                $pp_gallery
                    .css('margin-left', -(galleryWidth / 2 + navWidth / 2))
                    .find('div:first')
                    .width(galleryWidth + 5)
                    .find('ul')
                    .width(fullGalleryWidth)
                    .find('li.selected')
                    .removeClass('selected');
                goToPage =
                    Math.floor(set_position / itemsPerPage) < totalPage
                        ? Math.floor(set_position / itemsPerPage)
                        : totalPage;
                e.prettyPhoto.changeGalleryPage(goToPage);
                $pp_gallery_li
                    .filter(':eq(' + set_position + ')')
                    .addClass('selected');
            } else {
                $pp_pic_holder
                    .find('.pp_content')
                    .unbind('mouseenter mouseleave');
            }
        }
        function k(t) {
            if (settings.social_tools)
                facebook_like_link = settings.social_tools.replace(
                    '{location_href}',
                    encodeURIComponent(location.href)
                );
            settings.markup = settings.markup.replace('{pp_social}', '');
            e('body').append(settings.markup);
            ($pp_pic_holder = e('.pp_pic_holder')),
                ($ppt = e('.ppt')),
                ($pp_overlay = e('div.pp_overlay'));
            if (isSet && settings.overlay_gallery) {
                currentGalleryPage = 0;
                toInject = '';
                for (var n = 0; n < pp_images.length; n++) {
                    if (!pp_images[n].match(/\b(jpg|jpeg|png|gif)\b/gi)) {
                        classname = 'default';
                        img_src = '';
                    } else {
                        classname = '';
                        img_src = pp_images[n];
                    }
                    toInject +=
                        "<li class='" +
                        classname +
                        "'><a href='#'><img src='" +
                        img_src +
                        "' width='50' alt='' /></a></li>";
                }
                toInject = settings.gallery_markup.replace(
                    /{gallery}/g,
                    toInject
                );
                $pp_pic_holder.find('#pp_full_res').after(toInject);
                ($pp_gallery = e('.pp_pic_holder .pp_gallery')),
                    ($pp_gallery_li = $pp_gallery.find('li'));
                $pp_gallery.find('.pp_arrow_next').click(function () {
                    e.prettyPhoto.changeGalleryPage('next');
                    e.prettyPhoto.stopSlideshow();
                    return false;
                });
                $pp_gallery.find('.pp_arrow_previous').click(function () {
                    e.prettyPhoto.changeGalleryPage('previous');
                    e.prettyPhoto.stopSlideshow();
                    return false;
                });
                $pp_pic_holder.find('.pp_content').hover(
                    function () {
                        $pp_pic_holder
                            .find('.pp_gallery:not(.disabled)')
                            .fadeIn();
                    },
                    function () {
                        $pp_pic_holder
                            .find('.pp_gallery:not(.disabled)')
                            .fadeOut();
                    }
                );
                itemWidth = 52 + 5;
                $pp_gallery_li.each(function (t) {
                    e(this)
                        .find('a')
                        .click(function () {
                            e.prettyPhoto.changePage(t);
                            e.prettyPhoto.stopSlideshow();
                            return false;
                        });
                });
            }
            if (settings.slideshow) {
                $pp_pic_holder
                    .find('.pp_nav')
                    .prepend('<a href="#" class="pp_play">Play</a>');
                $pp_pic_holder.find('.pp_nav .pp_play').click(function () {
                    e.prettyPhoto.startSlideshow();
                    return false;
                });
            }
            $pp_pic_holder.attr('class', 'pp_pic_holder ' + settings.theme);
            $pp_overlay
                .css({
                    opacity: 0,
                    height: e(document).height(),
                    width: e(window).width(),
                })
                .bind('click', function () {
                    if (!settings.modal) e.prettyPhoto.close();
                });
            e('a.pp_close').bind('click', function () {
                e.prettyPhoto.close();
                return false;
            });
            if (settings.allow_expand) {
                e('a.pp_expand').bind('click', function (t) {
                    if (e(this).hasClass('pp_expand')) {
                        e(this)
                            .removeClass('pp_expand')
                            .addClass('pp_contract');
                        doresize = false;
                    } else {
                        e(this)
                            .removeClass('pp_contract')
                            .addClass('pp_expand');
                        doresize = true;
                    }
                    y(function () {
                        e.prettyPhoto.open();
                    });
                    return false;
                });
            }
            $pp_pic_holder
                .find('.pp_previous, .pp_nav .pp_arrow_previous')
                .bind('click', function () {
                    e.prettyPhoto.changePage('previous');
                    e.prettyPhoto.stopSlideshow();
                    return false;
                });
            $pp_pic_holder
                .find('.pp_next, .pp_nav .pp_arrow_next')
                .bind('click', function () {
                    e.prettyPhoto.changePage('next');
                    e.prettyPhoto.stopSlideshow();
                    return false;
                });
            x();
        }
        s = jQuery.extend(
            {
                hook: 'rel',
                animation_speed: 'fast',
                ajaxcallback: function () {},
                slideshow: 5e3,
                autoplay_slideshow: false,
                opacity: 0.8,
                show_title: true,
                allow_resize: true,
                allow_expand: true,
                default_width: 500,
                default_height: 344,
                counter_separator_label: '/',
                theme: 'pp_default',
                horizontal_padding: 20,
                hideflash: false,
                wmode: 'opaque',
                autoplay: true,
                modal: false,
                deeplinking: true,
                overlay_gallery: true,
                overlay_gallery_max: 30,
                keyboard_shortcuts: true,
                changepicturecallback: function () {},
                callback: function () {},
                ie6_fallback: true,
                markup: '<div class="pp_pic_holder"> 						<div class="ppt"> </div> 						<div class="pp_top"> 							<div class="pp_left"></div> 							<div class="pp_middle"></div> 							<div class="pp_right"></div> 						</div> 						<div class="pp_content_container"> 							<div class="pp_left"> 							<div class="pp_right"> 								<div class="pp_content"> 									<div class="pp_loaderIcon"></div> 									<div class="pp_fade"> 										<a href="#" class="pp_expand" title="Expand the image">Expand</a> 										<div class="pp_hoverContainer"> 											<a class="pp_next" href="#">next</a> 											<a class="pp_previous" href="#">previous</a> 										</div> 										<div id="pp_full_res"></div> 										<div class="pp_details"> 											<div class="pp_nav"> 												<a href="#" class="pp_arrow_previous">Previous</a> 												<p class="currentTextHolder">0/0</p> 												<a href="#" class="pp_arrow_next">Next</a> 											</div> 											<p class="pp_description"></p> 											<div class="pp_social">{pp_social}</div> 											<a class="pp_close" href="#">Close</a> 										</div> 									</div> 								</div> 							</div> 							</div> 						</div> 						<div class="pp_bottom"> 							<div class="pp_left"></div> 							<div class="pp_middle"></div> 							<div class="pp_right"></div> 						</div> 					</div> 					<div class="pp_overlay"></div>',
                gallery_markup:
                    '<div class="pp_gallery"> 								<a href="#" class="pp_arrow_previous">Previous</a> 								<div> 									<ul> 										{gallery} 									</ul> 								</div> 								<a href="#" class="pp_arrow_next">Next</a> 							</div>',
                image_markup: '<img id="fullResImage" src="{path}" />',
                flash_markup:
                    '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="{width}" height="{height}"><param name="wmode" value="{wmode}" /><param name="allowfullscreen" value="true" /><param name="allowscriptaccess" value="always" /><param name="movie" value="{path}" /><embed src="{path}" type="application/x-shockwave-flash" allowfullscreen="true" allowscriptaccess="always" width="{width}" height="{height}" wmode="{wmode}"></embed></object>',
                quicktime_markup:
                    '<object classid="clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B" codebase="http://www.apple.com/qtactivex/qtplugin.cab" height="{height}" width="{width}"><param name="src" value="{path}"><param name="autoplay" value="{autoplay}"><param name="type" value="video/quicktime"><embed src="{path}" height="{height}" width="{width}" autoplay="{autoplay}" type="video/quicktime" pluginspage="http://www.apple.com/quicktime/download/"></embed></object>',
                iframe_markup:
                    '<iframe src ="{path}" width="{width}" height="{height}" frameborder="no"></iframe>',
                inline_markup: '<div class="pp_inline">{content}</div>',
                custom_markup: '',
                social_tools:
                    '<div class="twitter"><a href="http://twitter.com/share" class="twitter-share-button" data-count="none">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script></div><div class="facebook"><iframe src="//www.facebook.com/plugins/like.php?locale=en_US&href={location_href}&layout=button_count&show_faces=true&width=500&action=like&font&colorscheme=light&height=23" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:500px; height:23px;" allowTransparency="true"></iframe></div>',
            },
            s
        );
        var o = this,
            u = false,
            a,
            f,
            l,
            c,
            h,
            p,
            d = e(window).height(),
            v = e(window).width(),
            m;
        (doresize = true), (scroll_pos = T());
        e(window)
            .unbind('resize.prettyphoto')
            .bind('resize.prettyphoto', function () {
                x();
                N();
            });
        if (s.keyboard_shortcuts) {
            e(document)
                .unbind('keydown.prettyphoto')
                .bind('keydown.prettyphoto', function (t) {
                    if (typeof $pp_pic_holder != 'undefined') {
                        if ($pp_pic_holder.is(':visible')) {
                            switch (t.keyCode) {
                                case 37:
                                    e.prettyPhoto.changePage('previous');
                                    t.preventDefault();
                                    break;
                                case 39:
                                    e.prettyPhoto.changePage('next');
                                    t.preventDefault();
                                    break;
                                case 27:
                                    if (!settings.modal) e.prettyPhoto.close();
                                    t.preventDefault();
                                    break;
                            }
                        }
                    }
                });
        }
        e.prettyPhoto.initialize = function () {
            settings = s;
            if (settings.theme == 'pp_default')
                settings.horizontal_padding = 16;
            theRel = e(this).attr(settings.hook);
            galleryRegExp = /\[(?:.*)\]/;
            isSet = galleryRegExp.exec(theRel) ? true : false;
            pp_images = isSet
                ? jQuery.map(o, function (t, n) {
                      if (e(t).attr(settings.hook).indexOf(theRel) != -1)
                          return e(t).attr('href');
                  })
                : e.makeArray(e(this).attr('href'));
            pp_titles = isSet
                ? jQuery.map(o, function (t, n) {
                      if (e(t).attr(settings.hook).indexOf(theRel) != -1)
                          return e(t).find('img').attr('alt')
                              ? e(t).find('img').attr('alt')
                              : '';
                  })
                : e.makeArray(e(this).find('img').attr('alt'));
            pp_descriptions = isSet
                ? jQuery.map(o, function (t, n) {
                      if (e(t).attr(settings.hook).indexOf(theRel) != -1)
                          return e(t).attr('title') ? e(t).attr('title') : '';
                  })
                : e.makeArray(e(this).attr('title'));
            if (pp_images.length > settings.overlay_gallery_max)
                settings.overlay_gallery = false;
            set_position = jQuery.inArray(e(this).attr('href'), pp_images);
            rel_index = isSet
                ? set_position
                : e('a[' + settings.hook + "^='" + theRel + "']").index(
                      e(this)
                  );
            k(this);
            if (settings.allow_resize)
                e(window).bind('scroll.prettyphoto', function () {
                    x();
                });
            e.prettyPhoto.open();
            return false;
        };
        e.prettyPhoto.open = function (t) {
            if (typeof settings == 'undefined') {
                settings = s;
                pp_images = e.makeArray(arguments[0]);
                pp_titles = arguments[1]
                    ? e.makeArray(arguments[1])
                    : e.makeArray('');
                pp_descriptions = arguments[2]
                    ? e.makeArray(arguments[2])
                    : e.makeArray('');
                isSet = pp_images.length > 1 ? true : false;
                set_position = arguments[3] ? arguments[3] : 0;
                k(t.target);
            }
            if (settings.hideflash)
                e('object,embed,iframe[src*=youtube],iframe[src*=vimeo]').css(
                    'visibility',
                    'hidden'
                );
            b(e(pp_images).size());
            e('.pp_loaderIcon').show();
            if (settings.deeplinking) n();
            if (settings.social_tools) {
                facebook_like_link = settings.social_tools.replace(
                    '{location_href}',
                    encodeURIComponent(location.href)
                );
                $pp_pic_holder.find('.pp_social').html(facebook_like_link);
            }
            if ($ppt.is(':hidden')) $ppt.css('opacity', 0).show();
            $pp_overlay
                .show()
                .fadeTo(settings.animation_speed, settings.opacity);
            $pp_pic_holder
                .find('.currentTextHolder')
                .text(
                    set_position +
                        1 +
                        settings.counter_separator_label +
                        e(pp_images).size()
                );
            if (
                typeof pp_descriptions[set_position] != 'undefined' &&
                pp_descriptions[set_position] != ''
            ) {
                $pp_pic_holder
                    .find('.pp_description')
                    .show()
                    .html(unescape(pp_descriptions[set_position]));
            } else {
                $pp_pic_holder.find('.pp_description').hide();
            }
            movie_width = parseFloat(i('width', pp_images[set_position]))
                ? i('width', pp_images[set_position])
                : settings.default_width.toString();
            movie_height = parseFloat(i('height', pp_images[set_position]))
                ? i('height', pp_images[set_position])
                : settings.default_height.toString();
            u = false;
            if (movie_height.indexOf('%') != -1) {
                movie_height = parseFloat(
                    (e(window).height() * parseFloat(movie_height)) / 100 - 150
                );
                u = true;
            }
            if (movie_width.indexOf('%') != -1) {
                movie_width = parseFloat(
                    (e(window).width() * parseFloat(movie_width)) / 100 - 150
                );
                u = true;
            }
            $pp_pic_holder.fadeIn(function () {
                settings.show_title &&
                pp_titles[set_position] != '' &&
                typeof pp_titles[set_position] != 'undefined'
                    ? $ppt.html(unescape(pp_titles[set_position]))
                    : $ppt.html(' ');
                imgPreloader = '';
                skipInjection = false;
                switch (S(pp_images[set_position])) {
                    case 'image':
                        imgPreloader = new Image();
                        nextImage = new Image();
                        if (isSet && set_position < e(pp_images).size() - 1)
                            nextImage.src = pp_images[set_position + 1];
                        prevImage = new Image();
                        if (isSet && pp_images[set_position - 1])
                            prevImage.src = pp_images[set_position - 1];
                        $pp_pic_holder.find('#pp_full_res')[0].innerHTML =
                            settings.image_markup.replace(
                                /{path}/g,
                                pp_images[set_position]
                            );
                        imgPreloader.onload = function () {
                            a = w(imgPreloader.width, imgPreloader.height);
                            g();
                        };
                        imgPreloader.onerror = function () {
                            alert(
                                'Image cannot be loaded. Make sure the path is correct and image exist.'
                            );
                            e.prettyPhoto.close();
                        };
                        imgPreloader.src = pp_images[set_position];
                        break;
                    case 'youtube':
                        a = w(movie_width, movie_height);
                        movie_id = i('v', pp_images[set_position]);
                        if (movie_id == '') {
                            movie_id =
                                pp_images[set_position].split('youtu.be/');
                            movie_id = movie_id[1];
                            if (movie_id.indexOf('?') > 0)
                                movie_id = movie_id.substr(
                                    0,
                                    movie_id.indexOf('?')
                                );
                            if (movie_id.indexOf('&') > 0)
                                movie_id = movie_id.substr(
                                    0,
                                    movie_id.indexOf('&')
                                );
                        }
                        movie = 'http://www.youtube.com/embed/' + movie_id;
                        i('rel', pp_images[set_position])
                            ? (movie +=
                                  '?rel=' + i('rel', pp_images[set_position]))
                            : (movie += '?rel=1');
                        if (settings.autoplay) movie += '&autoplay=1';
                        toInject = settings.iframe_markup
                            .replace(/{width}/g, a['width'])
                            .replace(/{height}/g, a['height'])
                            .replace(/{wmode}/g, settings.wmode)
                            .replace(/{path}/g, movie);
                        break;
                    case 'vimeo':
                        a = w(movie_width, movie_height);
                        movie_id = pp_images[set_position];
                        var t = /http(s?):\/\/(www\.)?vimeo.com\/(\d+)/;
                        var n = movie_id.match(t);
                        movie =
                            'http://player.vimeo.com/video/' +
                            n[3] +
                            '?title=0&byline=0&portrait=0';
                        if (settings.autoplay) movie += '&autoplay=1;';
                        vimeo_width =
                            a['width'] + '/embed/?moog_width=' + a['width'];
                        toInject = settings.iframe_markup
                            .replace(/{width}/g, vimeo_width)
                            .replace(/{height}/g, a['height'])
                            .replace(/{path}/g, movie);
                        break;
                    case 'quicktime':
                        a = w(movie_width, movie_height);
                        a['height'] += 15;
                        a['contentHeight'] += 15;
                        a['containerHeight'] += 15;
                        toInject = settings.quicktime_markup
                            .replace(/{width}/g, a['width'])
                            .replace(/{height}/g, a['height'])
                            .replace(/{wmode}/g, settings.wmode)
                            .replace(/{path}/g, pp_images[set_position])
                            .replace(/{autoplay}/g, settings.autoplay);
                        break;
                    case 'flash':
                        a = w(movie_width, movie_height);
                        flash_vars = pp_images[set_position];
                        flash_vars = flash_vars.substring(
                            pp_images[set_position].indexOf('flashvars') + 10,
                            pp_images[set_position].length
                        );
                        filename = pp_images[set_position];
                        filename = filename.substring(0, filename.indexOf('?'));
                        toInject = settings.flash_markup
                            .replace(/{width}/g, a['width'])
                            .replace(/{height}/g, a['height'])
                            .replace(/{wmode}/g, settings.wmode)
                            .replace(/{path}/g, filename + '?' + flash_vars);
                        break;
                    case 'iframe':
                        a = w(movie_width, movie_height);
                        frame_url = pp_images[set_position];
                        frame_url = frame_url.substr(
                            0,
                            frame_url.indexOf('iframe') - 1
                        );
                        toInject = settings.iframe_markup
                            .replace(/{width}/g, a['width'])
                            .replace(/{height}/g, a['height'])
                            .replace(/{path}/g, frame_url);
                        break;
                    case 'ajax':
                        doresize = false;
                        a = w(movie_width, movie_height);
                        doresize = true;
                        skipInjection = true;
                        e.get(pp_images[set_position], function (e) {
                            toInject = settings.inline_markup.replace(
                                /{content}/g,
                                e
                            );
                            $pp_pic_holder.find('#pp_full_res')[0].innerHTML =
                                toInject;
                            g();
                        });
                        break;
                    case 'custom':
                        a = w(movie_width, movie_height);
                        toInject = settings.custom_markup;
                        break;
                    case 'inline':
                        myClone = e(pp_images[set_position])
                            .clone()
                            .append('<br clear="all" />')
                            .css({ width: settings.default_width })
                            .wrapInner(
                                '<div id="pp_full_res"><div class="pp_inline"></div></div>'
                            )
                            .appendTo(e('body'))
                            .show();
                        doresize = false;
                        a = w(e(myClone).width(), e(myClone).height());
                        doresize = true;
                        e(myClone).remove();
                        toInject = settings.inline_markup.replace(
                            /{content}/g,
                            e(pp_images[set_position]).html()
                        );
                        break;
                }
                if (!imgPreloader && !skipInjection) {
                    $pp_pic_holder.find('#pp_full_res')[0].innerHTML = toInject;
                    g();
                }
            });
            return false;
        };
        e.prettyPhoto.changePage = function (t) {
            currentGalleryPage = 0;
            if (t == 'previous') {
                set_position--;
                if (set_position < 0) set_position = e(pp_images).size() - 1;
            } else if (t == 'next') {
                set_position++;
                if (set_position > e(pp_images).size() - 1) set_position = 0;
            } else {
                set_position = t;
            }
            rel_index = set_position;
            if (!doresize) doresize = true;
            if (settings.allow_expand) {
                e('.pp_contract')
                    .removeClass('pp_contract')
                    .addClass('pp_expand');
            }
            y(function () {
                e.prettyPhoto.open();
            });
        };
        e.prettyPhoto.changeGalleryPage = function (e) {
            if (e == 'next') {
                currentGalleryPage++;
                if (currentGalleryPage > totalPage) currentGalleryPage = 0;
            } else if (e == 'previous') {
                currentGalleryPage--;
                if (currentGalleryPage < 0) currentGalleryPage = totalPage;
            } else {
                currentGalleryPage = e;
            }
            slide_speed =
                e == 'next' || e == 'previous' ? settings.animation_speed : 0;
            slide_to = currentGalleryPage * itemsPerPage * itemWidth;
            $pp_gallery.find('ul').animate({ left: -slide_to }, slide_speed);
        };
        e.prettyPhoto.startSlideshow = function () {
            if (typeof m == 'undefined') {
                $pp_pic_holder
                    .find('.pp_play')
                    .unbind('click')
                    .removeClass('pp_play')
                    .addClass('pp_pause')
                    .click(function () {
                        e.prettyPhoto.stopSlideshow();
                        return false;
                    });
                m = setInterval(
                    e.prettyPhoto.startSlideshow,
                    settings.slideshow
                );
            } else {
                e.prettyPhoto.changePage('next');
            }
        };
        e.prettyPhoto.stopSlideshow = function () {
            $pp_pic_holder
                .find('.pp_pause')
                .unbind('click')
                .removeClass('pp_pause')
                .addClass('pp_play')
                .click(function () {
                    e.prettyPhoto.startSlideshow();
                    return false;
                });
            clearInterval(m);
            m = undefined;
        };
        e.prettyPhoto.close = function () {
            if ($pp_overlay.is(':animated')) return;
            e.prettyPhoto.stopSlideshow();
            $pp_pic_holder
                .stop()
                .find('object,embed')
                .css('visibility', 'hidden');
            e('div.pp_pic_holder,div.ppt,.pp_fade').fadeOut(
                settings.animation_speed,
                function () {
                    e(this).remove();
                }
            );
            $pp_overlay.fadeOut(settings.animation_speed, function () {
                if (settings.hideflash)
                    e(
                        'object,embed,iframe[src*=youtube],iframe[src*=vimeo]'
                    ).css('visibility', 'visible');
                e(this).remove();
                e(window).unbind('scroll.prettyphoto');
                r();
                settings.callback();
                doresize = true;
                f = false;
                delete settings;
            });
        };
        if (!pp_alreadyInitialized && t()) {
            pp_alreadyInitialized = true;
            hashIndex = t();
            hashRel = hashIndex;
            hashIndex = hashIndex.substring(
                hashIndex.indexOf('/') + 1,
                hashIndex.length - 1
            );
            hashRel = hashRel.substring(0, hashRel.indexOf('/'));
            setTimeout(function () {
                e(
                    'a[' + s.hook + "^='" + hashRel + "']:eq(" + hashIndex + ')'
                ).trigger('click');
            }, 50);
        }
        return this.unbind('click.prettyphoto').bind(
            'click.prettyphoto',
            e.prettyPhoto.initialize
        );
    };
})(jQuery);
var pp_alreadyInitialized = false;

/*!
 * Modernizr v2.8.3
 * www.modernizr.com
 *
 * Copyright (c) Faruk Ates, Paul Irish, Alex Sexton
 * Available under the BSD and MIT licenses: www.modernizr.com/license/
 */

/*
 * Modernizr tests which native CSS3 and HTML5 features are available in
 * the current UA and makes the results available to you in two ways:
 * as properties on a global Modernizr object, and as classes on the
 * <html> element. This information allows you to progressively enhance
 * your pages with a granular level of control over the experience.
 *
 * Modernizr has an optional (not included) conditional resource loader
 * called Modernizr.load(), based on Yepnope.js (yepnopejs.com).
 * To get a build that includes Modernizr.load(), as well as choosing
 * which tests to include, go to www.modernizr.com/download/
 *
 * Authors        Faruk Ates, Paul Irish, Alex Sexton
 * Contributors   Ryan Seddon, Ben Alman
 */

window.Modernizr = (function (window, document, undefined) {
    var version = '2.8.3',
        Modernizr = {},
        /*>>cssclasses*/
        // option for enabling the HTML classes to be added
        enableClasses = true,
        /*>>cssclasses*/

        docElement = document.documentElement,
        /**
         * Create our "modernizr" element that we do most feature tests on.
         */
        mod = 'modernizr',
        modElem = document.createElement(mod),
        mStyle = modElem.style,
        /**
         * Create the input element for various Web Forms feature tests.
         */
        inputElem /*>>inputelem*/ =
            document.createElement('input') /*>>inputelem*/,
        /*>>smile*/
        smile = ':)',
        /*>>smile*/

        toString = {}.toString,
        /*>>prefixes*/
        // List of property values to set for css tests. See ticket #21
        prefixes = ' -webkit- -moz- -o- -ms- '.split(' '),
        /*>>prefixes*/

        /*>>domprefixes*/
        // Following spec is to expose vendor-specific style properties as:
        //   elem.style.WebkitBorderRadius
        // and the following would be incorrect:
        //   elem.style.webkitBorderRadius

        // Webkit ghosts their properties in lowercase but Opera & Moz do not.
        // Microsoft uses a lowercase `ms` instead of the correct `Ms` in IE8+
        //   erik.eae.net/archives/2008/03/10/21.48.10/

        // More here: github.com/Modernizr/Modernizr/issues/issue/21
        omPrefixes = 'Webkit Moz O ms',
        cssomPrefixes = omPrefixes.split(' '),
        domPrefixes = omPrefixes.toLowerCase().split(' '),
        /*>>domprefixes*/

        /*>>ns*/
        ns = { svg: 'http://www.w3.org/2000/svg' },
        /*>>ns*/

        tests = {},
        inputs = {},
        attrs = {},
        classes = [],
        slice = classes.slice,
        featureName, // used in testing loop
        /*>>teststyles*/
        // Inject element with style element and some CSS rules
        injectElementWithStyles = function (rule, callback, nodes, testnames) {
            var style,
                ret,
                node,
                docOverflow,
                div = document.createElement('div'),
                // After page load injecting a fake body doesn't work so check if body exists
                body = document.body,
                // IE6 and 7 won't return offsetWidth or offsetHeight unless it's in the body element, so we fake it.
                fakeBody = body || document.createElement('body');

            if (parseInt(nodes, 10)) {
                // In order not to give false positives we create a node for each test
                // This also allows the method to scale for unspecified uses
                while (nodes--) {
                    node = document.createElement('div');
                    node.id = testnames ? testnames[nodes] : mod + (nodes + 1);
                    div.appendChild(node);
                }
            }

            // <style> elements in IE6-9 are considered 'NoScope' elements and therefore will be removed
            // when injected with innerHTML. To get around this you need to prepend the 'NoScope' element
            // with a 'scoped' element, in our case the soft-hyphen entity as it won't mess with our measurements.
            // msdn.microsoft.com/en-us/library/ms533897%28VS.85%29.aspx
            // Documents served as xml will throw if using &shy; so use xml friendly encoded version. See issue #277
            style = [
                '&#173;',
                '<style id="s',
                mod,
                '">',
                rule,
                '</style>',
            ].join('');
            div.id = mod;
            // IE6 will false positive on some tests due to the style element inside the test div somehow interfering offsetHeight, so insert it into body or fakebody.
            // Opera will act all quirky when injecting elements in documentElement when page is served as xml, needs fakebody too. #270
            (body ? div : fakeBody).innerHTML += style;
            fakeBody.appendChild(div);
            if (!body) {
                //avoid crashing IE8, if background image is used
                fakeBody.style.background = '';
                //Safari 5.13/5.1.4 OSX stops loading if ::-webkit-scrollbar is used and scrollbars are visible
                fakeBody.style.overflow = 'hidden';
                docOverflow = docElement.style.overflow;
                docElement.style.overflow = 'hidden';
                docElement.appendChild(fakeBody);
            }

            ret = callback(div, rule);
            // If this is done after page load we don't want to remove the body so check if body exists
            if (!body) {
                fakeBody.parentNode.removeChild(fakeBody);
                docElement.style.overflow = docOverflow;
            } else {
                div.parentNode.removeChild(div);
            }

            return !!ret;
        },
        /*>>teststyles*/

        /*>>mq*/
        // adapted from matchMedia polyfill
        // by Scott Jehl and Paul Irish
        // gist.github.com/786768
        testMediaQuery = function (mq) {
            var matchMedia = window.matchMedia || window.msMatchMedia;
            if (matchMedia) {
                return (matchMedia(mq) && matchMedia(mq).matches) || false;
            }

            var bool;

            injectElementWithStyles(
                '@media ' + mq + ' { #' + mod + ' { position: absolute; } }',
                function (node) {
                    bool =
                        (window.getComputedStyle
                            ? getComputedStyle(node, null)
                            : node.currentStyle)['position'] == 'absolute';
                }
            );

            return bool;
        },
        /*>>mq*/

        /*>>hasevent*/
        //
        // isEventSupported determines if a given element supports the given event
        // kangax.github.com/iseventsupported/
        //
        // The following results are known incorrects:
        //   Modernizr.hasEvent("webkitTransitionEnd", elem) // false negative
        //   Modernizr.hasEvent("textInput") // in Webkit. github.com/Modernizr/Modernizr/issues/333
        //   ...
        isEventSupported = (function () {
            var TAGNAMES = {
                select: 'input',
                change: 'input',
                submit: 'form',
                reset: 'form',
                error: 'img',
                load: 'img',
                abort: 'img',
            };

            function isEventSupported(eventName, element) {
                element =
                    element ||
                    document.createElement(TAGNAMES[eventName] || 'div');
                eventName = 'on' + eventName;

                // When using `setAttribute`, IE skips "unload", WebKit skips "unload" and "resize", whereas `in` "catches" those
                var isSupported = eventName in element;

                if (!isSupported) {
                    // If it has no `setAttribute` (i.e. doesn't implement Node interface), try generic element
                    if (!element.setAttribute) {
                        element = document.createElement('div');
                    }
                    if (element.setAttribute && element.removeAttribute) {
                        element.setAttribute(eventName, '');
                        isSupported = is(element[eventName], 'function');

                        // If property was created, "remove it" (by setting value to `undefined`)
                        if (!is(element[eventName], 'undefined')) {
                            element[eventName] = undefined;
                        }
                        element.removeAttribute(eventName);
                    }
                }

                element = null;
                return isSupported;
            }
            return isEventSupported;
        })(),
        /*>>hasevent*/

        // hasOwnProperty shim by kangax needed for Safari 2.0 support
        _hasOwnProperty = {}.hasOwnProperty,
        hasOwnProp;

    if (
        !is(_hasOwnProperty, 'undefined') &&
        !is(_hasOwnProperty.call, 'undefined')
    ) {
        hasOwnProp = function (object, property) {
            return _hasOwnProperty.call(object, property);
        };
    } else {
        hasOwnProp = function (object, property) {
            /* yes, this can give false positives/negatives, but most of the time we don't care about those */
            return (
                property in object &&
                is(object.constructor.prototype[property], 'undefined')
            );
        };
    }

    // Adapted from ES5-shim https://github.com/kriskowal/es5-shim/blob/master/es5-shim.js
    // es5.github.com/#x15.3.4.5

    if (!Function.prototype.bind) {
        Function.prototype.bind = function bind(that) {
            var target = this;

            if (typeof target != 'function') {
                throw new TypeError();
            }

            var args = slice.call(arguments, 1),
                bound = function () {
                    if (this instanceof bound) {
                        var F = function () {};
                        F.prototype = target.prototype;
                        var self = new F();

                        var result = target.apply(
                            self,
                            args.concat(slice.call(arguments))
                        );
                        if (Object(result) === result) {
                            return result;
                        }
                        return self;
                    } else {
                        return target.apply(
                            that,
                            args.concat(slice.call(arguments))
                        );
                    }
                };

            return bound;
        };
    }

    /**
     * setCss applies given styles to the Modernizr DOM node.
     */
    function setCss(str) {
        mStyle.cssText = str;
    }

    /**
     * setCssAll extrapolates all vendor-specific css strings.
     */
    function setCssAll(str1, str2) {
        return setCss(prefixes.join(str1 + ';') + (str2 || ''));
    }

    /**
     * is returns a boolean for if typeof obj is exactly type.
     */
    function is(obj, type) {
        return typeof obj === type;
    }

    /**
     * contains returns a boolean for if substr is found within str.
     */
    function contains(str, substr) {
        return !!~('' + str).indexOf(substr);
    }

    /*>>testprop*/

    // testProps is a generic CSS / DOM property test.

    // In testing support for a given CSS property, it's legit to test:
    //    `elem.style[styleName] !== undefined`
    // If the property is supported it will return an empty string,
    // if unsupported it will return undefined.

    // We'll take advantage of this quick test and skip setting a style
    // on our modernizr element, but instead just testing undefined vs
    // empty string.

    // Because the testing of the CSS property names (with "-", as
    // opposed to the camelCase DOM properties) is non-portable and
    // non-standard but works in WebKit and IE (but not Gecko or Opera),
    // we explicitly reject properties with dashes so that authors
    // developing in WebKit or IE first don't end up with
    // browser-specific content by accident.

    function testProps(props, prefixed) {
        for (var i in props) {
            var prop = props[i];
            if (!contains(prop, '-') && mStyle[prop] !== undefined) {
                return prefixed == 'pfx' ? prop : true;
            }
        }
        return false;
    }
    /*>>testprop*/

    /**
     * testDOMProps is a generic DOM property test; if a browser supports
     *   a certain property, it won't return undefined for it.
     */
    function testDOMProps(props, obj, elem) {
        for (var i in props) {
            var item = obj[props[i]];
            if (item !== undefined) {
                // return the property name as a string
                if (elem === false) return props[i];

                // let's bind a function
                if (is(item, 'function')) {
                    // default to autobind unless override
                    return item.bind(elem || obj);
                }

                // return the unbound function or obj or value
                return item;
            }
        }
        return false;
    }

    /*>>testallprops*/
    /**
     * testPropsAll tests a list of DOM properties we want to check against.
     *   We specify literally ALL possible (known and/or likely) properties on
     *   the element including the non-vendor prefixed one, for forward-
     *   compatibility.
     */
    function testPropsAll(prop, prefixed, elem) {
        var ucProp = prop.charAt(0).toUpperCase() + prop.slice(1),
            props = (
                prop +
                ' ' +
                cssomPrefixes.join(ucProp + ' ') +
                ucProp
            ).split(' ');

        // did they call .prefixed('boxSizing') or are we just testing a prop?
        if (is(prefixed, 'string') || is(prefixed, 'undefined')) {
            return testProps(props, prefixed);

            // otherwise, they called .prefixed('requestAnimationFrame', window[, elem])
        } else {
            props = (
                prop +
                ' ' +
                domPrefixes.join(ucProp + ' ') +
                ucProp
            ).split(' ');
            return testDOMProps(props, prefixed, elem);
        }
    }
    /*>>testallprops*/

    /**
     * Tests
     * -----
     */

    // The *new* flexbox
    // dev.w3.org/csswg/css3-flexbox

    tests['flexbox'] = function () {
        return testPropsAll('flexWrap');
    };

    // The *old* flexbox
    // www.w3.org/TR/2009/WD-css3-flexbox-20090723/

    tests['flexboxlegacy'] = function () {
        return testPropsAll('boxDirection');
    };

    // On the S60 and BB Storm, getContext exists, but always returns undefined
    // so we actually have to call getContext() to verify
    // github.com/Modernizr/Modernizr/issues/issue/97/

    tests['canvas'] = function () {
        var elem = document.createElement('canvas');
        return !!(elem.getContext && elem.getContext('2d'));
    };

    tests['canvastext'] = function () {
        return !!(
            Modernizr['canvas'] &&
            is(
                document.createElement('canvas').getContext('2d').fillText,
                'function'
            )
        );
    };

    // webk.it/70117 is tracking a legit WebGL feature detect proposal

    // We do a soft detect which may false positive in order to avoid
    // an expensive context creation: bugzil.la/732441

    tests['webgl'] = function () {
        return !!window.WebGLRenderingContext;
    };

    /*
     * The Modernizr.touch test only indicates if the browser supports
     *    touch events, which does not necessarily reflect a touchscreen
     *    device, as evidenced by tablets running Windows 7 or, alas,
     *    the Palm Pre / WebOS (touch) phones.
     *
     * Additionally, Chrome (desktop) used to lie about its support on this,
     *    but that has since been rectified: crbug.com/36415
     *
     * We also test for Firefox 4 Multitouch Support.
     *
     * For more info, see: modernizr.github.com/Modernizr/touch.html
     */

    tests['touch'] = function () {
        var bool;

        if (
            'ontouchstart' in window ||
            (window.DocumentTouch && document instanceof DocumentTouch)
        ) {
            bool = true;
        } else {
            injectElementWithStyles(
                [
                    '@media (',
                    prefixes.join('touch-enabled),('),
                    mod,
                    ')',
                    '{#modernizr{top:9px;position:absolute}}',
                ].join(''),
                function (node) {
                    bool = node.offsetTop === 9;
                }
            );
        }

        return bool;
    };

    // geolocation is often considered a trivial feature detect...
    // Turns out, it's quite tricky to get right:
    //
    // Using !!navigator.geolocation does two things we don't want. It:
    //   1. Leaks memory in IE9: github.com/Modernizr/Modernizr/issues/513
    //   2. Disables page caching in WebKit: webk.it/43956
    //
    // Meanwhile, in Firefox < 8, an about:config setting could expose
    // a false positive that would throw an exception: bugzil.la/688158

    tests['geolocation'] = function () {
        return 'geolocation' in navigator;
    };

    tests['postmessage'] = function () {
        return !!window.postMessage;
    };

    // Chrome incognito mode used to throw an exception when using openDatabase
    // It doesn't anymore.
    tests['websqldatabase'] = function () {
        return !!window.openDatabase;
    };

    // Vendors had inconsistent prefixing with the experimental Indexed DB:
    // - Webkit's implementation is accessible through webkitIndexedDB
    // - Firefox shipped moz_indexedDB before FF4b9, but since then has been mozIndexedDB
    // For speed, we don't test the legacy (and beta-only) indexedDB
    tests['indexedDB'] = function () {
        return !!testPropsAll('indexedDB', window);
    };

    // documentMode logic from YUI to filter out IE8 Compat Mode
    //   which false positives.
    tests['hashchange'] = function () {
        return (
            isEventSupported('hashchange', window) &&
            (document.documentMode === undefined || document.documentMode > 7)
        );
    };

    // Per 1.6:
    // This used to be Modernizr.historymanagement but the longer
    // name has been deprecated in favor of a shorter and property-matching one.
    // The old API is still available in 1.6, but as of 2.0 will throw a warning,
    // and in the first release thereafter disappear entirely.
    tests['history'] = function () {
        return !!(window.history && history.pushState);
    };

    tests['draganddrop'] = function () {
        var div = document.createElement('div');
        return 'draggable' in div || ('ondragstart' in div && 'ondrop' in div);
    };

    // FF3.6 was EOL'ed on 4/24/12, but the ESR version of FF10
    // will be supported until FF19 (2/12/13), at which time, ESR becomes FF17.
    // FF10 still uses prefixes, so check for it until then.
    // for more ESR info, see: mozilla.org/en-US/firefox/organizations/faq/
    tests['websockets'] = function () {
        return 'WebSocket' in window || 'MozWebSocket' in window;
    };

    // css-tricks.com/rgba-browser-support/
    tests['rgba'] = function () {
        // Set an rgba() color and check the returned value

        setCss('background-color:rgba(150,255,150,.5)');

        return contains(mStyle.backgroundColor, 'rgba');
    };

    tests['hsla'] = function () {
        // Same as rgba(), in fact, browsers re-map hsla() to rgba() internally,
        //   except IE9 who retains it as hsla

        setCss('background-color:hsla(120,40%,100%,.5)');

        return (
            contains(mStyle.backgroundColor, 'rgba') ||
            contains(mStyle.backgroundColor, 'hsla')
        );
    };

    tests['multiplebgs'] = function () {
        // Setting multiple images AND a color on the background shorthand property
        //  and then querying the style.background property value for the number of
        //  occurrences of "url(" is a reliable method for detecting ACTUAL support for this!

        setCss('background:url(https://),url(https://),red url(https://)');

        // If the UA supports multiple backgrounds, there should be three occurrences
        //   of the string "url(" in the return value for elemStyle.background

        return /(url\s*\(.*?){3}/.test(mStyle.background);
    };

    // this will false positive in Opera Mini
    //   github.com/Modernizr/Modernizr/issues/396

    tests['backgroundsize'] = function () {
        return testPropsAll('backgroundSize');
    };

    tests['borderimage'] = function () {
        return testPropsAll('borderImage');
    };

    // Super comprehensive table about all the unique implementations of
    // border-radius: muddledramblings.com/table-of-css3-border-radius-compliance

    tests['borderradius'] = function () {
        return testPropsAll('borderRadius');
    };

    // WebOS unfortunately false positives on this test.
    tests['boxshadow'] = function () {
        return testPropsAll('boxShadow');
    };

    // FF3.0 will false positive on this test
    tests['textshadow'] = function () {
        return document.createElement('div').style.textShadow === '';
    };

    tests['opacity'] = function () {
        // Browsers that actually have CSS Opacity implemented have done so
        //  according to spec, which means their return values are within the
        //  range of [0.0,1.0] - including the leading zero.

        setCssAll('opacity:.55');

        // The non-literal . in this regex is intentional:
        //   German Chrome returns this value as 0,55
        // github.com/Modernizr/Modernizr/issues/#issue/59/comment/516632
        return /^0.55$/.test(mStyle.opacity);
    };

    // Note, Android < 4 will pass this test, but can only animate
    //   a single property at a time
    //   goo.gl/v3V4Gp
    tests['cssanimations'] = function () {
        return testPropsAll('animationName');
    };

    tests['csscolumns'] = function () {
        return testPropsAll('columnCount');
    };

    tests['cssgradients'] = function () {
        /**
         * For CSS Gradients syntax, please see:
         * webkit.org/blog/175/introducing-css-gradients/
         * developer.mozilla.org/en/CSS/-moz-linear-gradient
         * developer.mozilla.org/en/CSS/-moz-radial-gradient
         * dev.w3.org/csswg/css3-images/#gradients-
         */

        var str1 = 'background-image:',
            str2 =
                'gradient(linear,left top,right bottom,from(#9f9),to(white));',
            str3 = 'linear-gradient(left top,#9f9, white);';

        setCss(
            // legacy webkit syntax (FIXME: remove when syntax not in use anymore)
            (
                str1 +
                '-webkit- '.split(' ').join(str2 + str1) +
                // standard syntax             // trailing 'background-image:'
                prefixes.join(str3 + str1)
            ).slice(0, -str1.length)
        );

        return contains(mStyle.backgroundImage, 'gradient');
    };

    tests['cssreflections'] = function () {
        return testPropsAll('boxReflect');
    };

    tests['csstransforms'] = function () {
        return !!testPropsAll('transform');
    };

    tests['csstransforms3d'] = function () {
        var ret = !!testPropsAll('perspective');

        // Webkit's 3D transforms are passed off to the browser's own graphics renderer.
        //   It works fine in Safari on Leopard and Snow Leopard, but not in Chrome in
        //   some conditions. As a result, Webkit typically recognizes the syntax but
        //   will sometimes throw a false positive, thus we must do a more thorough check:
        if (ret && 'webkitPerspective' in docElement.style) {
            // Webkit allows this media query to succeed only if the feature is enabled.
            // `@media (transform-3d),(-webkit-transform-3d){ ... }`
            injectElementWithStyles(
                '@media (transform-3d),(-webkit-transform-3d){#modernizr{left:9px;position:absolute;height:3px;}}',
                function (node, rule) {
                    ret = node.offsetLeft === 9 && node.offsetHeight === 3;
                }
            );
        }
        return ret;
    };

    tests['csstransitions'] = function () {
        return testPropsAll('transition');
    };

    /*>>fontface*/
    // @font-face detection routine by Diego Perini
    // javascript.nwbox.com/CSSSupport/

    // false positives:
    //   WebOS github.com/Modernizr/Modernizr/issues/342
    //   WP7   github.com/Modernizr/Modernizr/issues/538
    tests['fontface'] = function () {
        var bool;

        injectElementWithStyles(
            '@font-face {font-family:"font";src:url("https://")}',
            function (node, rule) {
                var style = document.getElementById('smodernizr'),
                    sheet = style.sheet || style.styleSheet,
                    cssText = sheet
                        ? sheet.cssRules && sheet.cssRules[0]
                            ? sheet.cssRules[0].cssText
                            : sheet.cssText || ''
                        : '';

                bool =
                    /src/i.test(cssText) &&
                    cssText.indexOf(rule.split(' ')[0]) === 0;
            }
        );

        return bool;
    };
    /*>>fontface*/

    // CSS generated content detection
    tests['generatedcontent'] = function () {
        var bool;

        injectElementWithStyles(
            [
                '#',
                mod,
                '{font:0/0 a}#',
                mod,
                ':after{content:"',
                smile,
                '";visibility:hidden;font:3px/1 a}',
            ].join(''),
            function (node) {
                bool = node.offsetHeight >= 3;
            }
        );

        return bool;
    };

    // These tests evaluate support of the video/audio elements, as well as
    // testing what types of content they support.
    //
    // We're using the Boolean constructor here, so that we can extend the value
    // e.g.  Modernizr.video     // true
    //       Modernizr.video.ogg // 'probably'
    //
    // Codec values from : github.com/NielsLeenheer/html5test/blob/9106a8/index.html#L845
    //                     thx to NielsLeenheer and zcorpan

    // Note: in some older browsers, "no" was a return value instead of empty string.
    //   It was live in FF3.5.0 and 3.5.1, but fixed in 3.5.2
    //   It was also live in Safari 4.0.0 - 4.0.4, but fixed in 4.0.5

    tests['video'] = function () {
        var elem = document.createElement('video'),
            bool = false;

        // IE9 Running on Windows Server SKU can cause an exception to be thrown, bug #224
        try {
            if ((bool = !!elem.canPlayType)) {
                bool = new Boolean(bool);
                bool.ogg = elem
                    .canPlayType('video/ogg; codecs="theora"')
                    .replace(/^no$/, '');

                // Without QuickTime, this value will be `undefined`. github.com/Modernizr/Modernizr/issues/546
                bool.h264 = elem
                    .canPlayType('video/mp4; codecs="avc1.42E01E"')
                    .replace(/^no$/, '');

                bool.webm = elem
                    .canPlayType('video/webm; codecs="vp8, vorbis"')
                    .replace(/^no$/, '');
            }
        } catch (e) {}

        return bool;
    };

    tests['audio'] = function () {
        var elem = document.createElement('audio'),
            bool = false;

        try {
            if ((bool = !!elem.canPlayType)) {
                bool = new Boolean(bool);
                bool.ogg = elem
                    .canPlayType('audio/ogg; codecs="vorbis"')
                    .replace(/^no$/, '');
                bool.mp3 = elem.canPlayType('audio/mpeg;').replace(/^no$/, '');

                // Mimetypes accepted:
                //   developer.mozilla.org/En/Media_formats_supported_by_the_audio_and_video_elements
                //   bit.ly/iphoneoscodecs
                bool.wav = elem
                    .canPlayType('audio/wav; codecs="1"')
                    .replace(/^no$/, '');
                bool.m4a = (
                    elem.canPlayType('audio/x-m4a;') ||
                    elem.canPlayType('audio/aac;')
                ).replace(/^no$/, '');
            }
        } catch (e) {}

        return bool;
    };

    // In FF4, if disabled, window.localStorage should === null.

    // Normally, we could not test that directly and need to do a
    //   `('localStorage' in window) && ` test first because otherwise Firefox will
    //   throw bugzil.la/365772 if cookies are disabled

    // Also in iOS5 Private Browsing mode, attempting to use localStorage.setItem
    // will throw the exception:
    //   QUOTA_EXCEEDED_ERRROR DOM Exception 22.
    // Peculiarly, getItem and removeItem calls do not throw.

    // Because we are forced to try/catch this, we'll go aggressive.

    // Just FWIW: IE8 Compat mode supports these features completely:
    //   www.quirksmode.org/dom/html5.html
    // But IE8 doesn't support either with local files

    tests['localstorage'] = function () {
        try {
            localStorage.setItem(mod, mod);
            localStorage.removeItem(mod);
            return true;
        } catch (e) {
            return false;
        }
    };

    tests['sessionstorage'] = function () {
        try {
            sessionStorage.setItem(mod, mod);
            sessionStorage.removeItem(mod);
            return true;
        } catch (e) {
            return false;
        }
    };

    tests['webworkers'] = function () {
        return !!window.Worker;
    };

    tests['applicationcache'] = function () {
        return !!window.applicationCache;
    };

    // Thanks to Erik Dahlstrom
    tests['svg'] = function () {
        return (
            !!document.createElementNS &&
            !!document.createElementNS(ns.svg, 'svg').createSVGRect
        );
    };

    // specifically for SVG inline in HTML, not within XHTML
    // test page: paulirish.com/demo/inline-svg
    tests['inlinesvg'] = function () {
        var div = document.createElement('div');
        div.innerHTML = '<svg/>';
        return (div.firstChild && div.firstChild.namespaceURI) == ns.svg;
    };

    // SVG SMIL animation
    tests['smil'] = function () {
        return (
            !!document.createElementNS &&
            /SVGAnimate/.test(
                toString.call(document.createElementNS(ns.svg, 'animate'))
            )
        );
    };

    // This test is only for clip paths in SVG proper, not clip paths on HTML content
    // demo: srufaculty.sru.edu/david.dailey/svg/newstuff/clipPath4.svg

    // However read the comments to dig into applying SVG clippaths to HTML content here:
    //   github.com/Modernizr/Modernizr/issues/213#issuecomment-1149491
    tests['svgclippaths'] = function () {
        return (
            !!document.createElementNS &&
            /SVGClipPath/.test(
                toString.call(document.createElementNS(ns.svg, 'clipPath'))
            )
        );
    };

    /*>>webforms*/
    // input features and input types go directly onto the ret object, bypassing the tests loop.
    // Hold this guy to execute in a moment.
    function webforms() {
        /*>>input*/
        // Run through HTML5's new input attributes to see if the UA understands any.
        // We're using f which is the <input> element created early on
        // Mike Taylr has created a comprehensive resource for testing these attributes
        //   when applied to all input types:
        //   miketaylr.com/code/input-type-attr.html
        // spec: www.whatwg.org/specs/web-apps/current-work/multipage/the-input-element.html#input-type-attr-summary

        // Only input placeholder is tested while textarea's placeholder is not.
        // Currently Safari 4 and Opera 11 have support only for the input placeholder
        // Both tests are available in feature-detects/forms-placeholder.js
        Modernizr['input'] = (function (props) {
            for (var i = 0, len = props.length; i < len; i++) {
                attrs[props[i]] = !!(props[i] in inputElem);
            }
            if (attrs.list) {
                // safari false positive's on datalist: webk.it/74252
                // see also github.com/Modernizr/Modernizr/issues/146
                attrs.list = !!(
                    document.createElement('datalist') &&
                    window.HTMLDataListElement
                );
            }
            return attrs;
        })(
            'autocomplete autofocus list placeholder max min multiple pattern required step'.split(
                ' '
            )
        );
        /*>>input*/

        /*>>inputtypes*/
        // Run through HTML5's new input types to see if the UA understands any.
        //   This is put behind the tests runloop because it doesn't return a
        //   true/false like all the other tests; instead, it returns an object
        //   containing each input type with its corresponding true/false value

        // Big thanks to @miketaylr for the html5 forms expertise. miketaylr.com/
        Modernizr['inputtypes'] = (function (props) {
            for (
                var i = 0, bool, inputElemType, defaultView, len = props.length;
                i < len;
                i++
            ) {
                inputElem.setAttribute('type', (inputElemType = props[i]));
                bool = inputElem.type !== 'text';

                // We first check to see if the type we give it sticks..
                // If the type does, we feed it a textual value, which shouldn't be valid.
                // If the value doesn't stick, we know there's input sanitization which infers a custom UI
                if (bool) {
                    inputElem.value = smile;
                    inputElem.style.cssText =
                        'position:absolute;visibility:hidden;';

                    if (
                        /^range$/.test(inputElemType) &&
                        inputElem.style.WebkitAppearance !== undefined
                    ) {
                        docElement.appendChild(inputElem);
                        defaultView = document.defaultView;

                        // Safari 2-4 allows the smiley as a value, despite making a slider
                        bool =
                            defaultView.getComputedStyle &&
                            defaultView.getComputedStyle(inputElem, null)
                                .WebkitAppearance !== 'textfield' &&
                            // Mobile android web browser has false positive, so must
                            // check the height to see if the widget is actually there.
                            inputElem.offsetHeight !== 0;

                        docElement.removeChild(inputElem);
                    } else if (/^(search|tel)$/.test(inputElemType)) {
                        // Spec doesn't define any special parsing or detectable UI
                        //   behaviors so we pass these through as true
                        // Interestingly, opera fails the earlier test, so it doesn't
                        //  even make it here.
                    } else if (/^(url|email)$/.test(inputElemType)) {
                        // Real url and email support comes with prebaked validation.
                        bool =
                            inputElem.checkValidity &&
                            inputElem.checkValidity() === false;
                    } else {
                        // If the upgraded input compontent rejects the :) text, we got a winner
                        bool = inputElem.value != smile;
                    }
                }

                inputs[props[i]] = !!bool;
            }
            return inputs;
        })(
            'search tel url email datetime date month week time datetime-local number range color'.split(
                ' '
            )
        );
        /*>>inputtypes*/
    }
    /*>>webforms*/

    // End of test definitions
    // -----------------------

    // Run through all tests and detect their support in the current UA.
    for (var feature in tests) {
        if (hasOwnProp(tests, feature)) {
            // run the test, throw the return value into the Modernizr,
            //   then based on that boolean, define an appropriate className
            //   and push it into an array of classes we'll join later.
            featureName = feature.toLowerCase();
            Modernizr[featureName] = tests[feature]();

            classes.push((Modernizr[featureName] ? '' : 'no-') + featureName);
        }
    }

    /*>>webforms*/
    // input tests need to run.
    Modernizr.input || webforms();
    /*>>webforms*/

    /**
     * addTest allows the user to define their own feature tests
     * the result will be added onto the Modernizr object,
     * as well as an appropriate className set on the html element
     *
     * @param feature - String naming the feature
     * @param test - Function returning true if feature is supported, false if not
     */
    Modernizr.addTest = function (feature, test) {
        if (typeof feature == 'object') {
            for (var key in feature) {
                if (hasOwnProp(feature, key)) {
                    Modernizr.addTest(key, feature[key]);
                }
            }
        } else {
            feature = feature.toLowerCase();

            if (Modernizr[feature] !== undefined) {
                // we're going to quit if you're trying to overwrite an existing test
                // if we were to allow it, we'd do this:
                //   var re = new RegExp("\\b(no-)?" + feature + "\\b");
                //   docElement.className = docElement.className.replace( re, '' );
                // but, no rly, stuff 'em.
                return Modernizr;
            }

            test = typeof test == 'function' ? test() : test;

            if (typeof enableClasses !== 'undefined' && enableClasses) {
                docElement.className += ' ' + (test ? '' : 'no-') + feature;
            }
            Modernizr[feature] = test;
        }

        return Modernizr; // allow chaining.
    };

    // Reset modElem.cssText to nothing to reduce memory footprint.
    setCss('');
    modElem = inputElem = null;

    /*>>shiv*/
    /**
     * @preserve HTML5 Shiv prev3.7.1 | @afarkas @jdalton @jon_neal @rem | MIT/GPL2 Licensed
     */
    (function (window, document) {
        /*jshint evil:true */
        /** version */
        var version = '3.7.0';

        /** Preset options */
        var options = window.html5 || {};

        /** Used to skip problem elements */
        var reSkip =
            /^<|^(?:button|map|select|textarea|object|iframe|option|optgroup)$/i;

        /** Not all elements can be cloned in IE **/
        var saveClones =
            /^(?:a|b|code|div|fieldset|h1|h2|h3|h4|h5|h6|i|label|li|ol|p|q|span|strong|style|table|tbody|td|th|tr|ul)$/i;

        /** Detect whether the browser supports default html5 styles */
        var supportsHtml5Styles;

        /** Name of the expando, to work with multiple documents or to re-shiv one document */
        var expando = '_html5shiv';

        /** The id for the the documents expando */
        var expanID = 0;

        /** Cached data for each document */
        var expandoData = {};

        /** Detect whether the browser supports unknown elements */
        var supportsUnknownElements;

        (function () {
            try {
                var a = document.createElement('a');
                a.innerHTML = '<xyz></xyz>';
                //if the hidden property is implemented we can assume, that the browser supports basic HTML5 Styles
                supportsHtml5Styles = 'hidden' in a;

                supportsUnknownElements =
                    a.childNodes.length == 1 ||
                    (function () {
                        // assign a false positive if unable to shiv
                        document.createElement('a');
                        var frag = document.createDocumentFragment();
                        return (
                            typeof frag.cloneNode == 'undefined' ||
                            typeof frag.createDocumentFragment == 'undefined' ||
                            typeof frag.createElement == 'undefined'
                        );
                    })();
            } catch (e) {
                // assign a false positive if detection fails => unable to shiv
                supportsHtml5Styles = true;
                supportsUnknownElements = true;
            }
        })();

        /*--------------------------------------------------------------------------*/

        /**
         * Creates a style sheet with the given CSS text and adds it to the document.
         * @private
         * @param {Document} ownerDocument The document.
         * @param {String} cssText The CSS text.
         * @returns {StyleSheet} The style element.
         */
        function addStyleSheet(ownerDocument, cssText) {
            var p = ownerDocument.createElement('p'),
                parent =
                    ownerDocument.getElementsByTagName('head')[0] ||
                    ownerDocument.documentElement;

            p.innerHTML = 'x<style>' + cssText + '</style>';
            return parent.insertBefore(p.lastChild, parent.firstChild);
        }

        /**
         * Returns the value of `html5.elements` as an array.
         * @private
         * @returns {Array} An array of shived element node names.
         */
        function getElements() {
            var elements = html5.elements;
            return typeof elements == 'string' ? elements.split(' ') : elements;
        }

        /**
         * Returns the data associated to the given document
         * @private
         * @param {Document} ownerDocument The document.
         * @returns {Object} An object of data.
         */
        function getExpandoData(ownerDocument) {
            var data = expandoData[ownerDocument[expando]];
            if (!data) {
                data = {};
                expanID++;
                ownerDocument[expando] = expanID;
                expandoData[expanID] = data;
            }
            return data;
        }

        /**
         * returns a shived element for the given nodeName and document
         * @memberOf html5
         * @param {String} nodeName name of the element
         * @param {Document} ownerDocument The context document.
         * @returns {Object} The shived element.
         */
        function createElement(nodeName, ownerDocument, data) {
            if (!ownerDocument) {
                ownerDocument = document;
            }
            if (supportsUnknownElements) {
                return ownerDocument.createElement(nodeName);
            }
            if (!data) {
                data = getExpandoData(ownerDocument);
            }
            var node;

            if (data.cache[nodeName]) {
                node = data.cache[nodeName].cloneNode();
            } else if (saveClones.test(nodeName)) {
                node = (data.cache[nodeName] =
                    data.createElem(nodeName)).cloneNode();
            } else {
                node = data.createElem(nodeName);
            }

            // Avoid adding some elements to fragments in IE < 9 because
            // * Attributes like `name` or `type` cannot be set/changed once an element
            //   is inserted into a document/fragment
            // * Link elements with `src` attributes that are inaccessible, as with
            //   a 403 response, will cause the tab/window to crash
            // * Script elements appended to fragments will execute when their `src`
            //   or `text` property is set
            return node.canHaveChildren &&
                !reSkip.test(nodeName) &&
                !node.tagUrn
                ? data.frag.appendChild(node)
                : node;
        }

        /**
         * returns a shived DocumentFragment for the given document
         * @memberOf html5
         * @param {Document} ownerDocument The context document.
         * @returns {Object} The shived DocumentFragment.
         */
        function createDocumentFragment(ownerDocument, data) {
            if (!ownerDocument) {
                ownerDocument = document;
            }
            if (supportsUnknownElements) {
                return ownerDocument.createDocumentFragment();
            }
            data = data || getExpandoData(ownerDocument);
            var clone = data.frag.cloneNode(),
                i = 0,
                elems = getElements(),
                l = elems.length;
            for (; i < l; i++) {
                clone.createElement(elems[i]);
            }
            return clone;
        }

        /**
         * Shivs the `createElement` and `createDocumentFragment` methods of the document.
         * @private
         * @param {Document|DocumentFragment} ownerDocument The document.
         * @param {Object} data of the document.
         */
        function shivMethods(ownerDocument, data) {
            if (!data.cache) {
                data.cache = {};
                data.createElem = ownerDocument.createElement;
                data.createFrag = ownerDocument.createDocumentFragment;
                data.frag = data.createFrag();
            }

            ownerDocument.createElement = function (nodeName) {
                //abort shiv
                if (!html5.shivMethods) {
                    return data.createElem(nodeName);
                }
                return createElement(nodeName, ownerDocument, data);
            };

            ownerDocument.createDocumentFragment = Function(
                'h,f',
                'return function(){' +
                    'var n=f.cloneNode(),c=n.createElement;' +
                    'h.shivMethods&&(' +
                    // unroll the `createElement` calls
                    getElements()
                        .join()
                        .replace(/[\w\-]+/g, function (nodeName) {
                            data.createElem(nodeName);
                            data.frag.createElement(nodeName);
                            return 'c("' + nodeName + '")';
                        }) +
                    ');return n}'
            )(html5, data.frag);
        }

        /*--------------------------------------------------------------------------*/

        /**
         * Shivs the given document.
         * @memberOf html5
         * @param {Document} ownerDocument The document to shiv.
         * @returns {Document} The shived document.
         */
        function shivDocument(ownerDocument) {
            if (!ownerDocument) {
                ownerDocument = document;
            }
            var data = getExpandoData(ownerDocument);

            if (html5.shivCSS && !supportsHtml5Styles && !data.hasCSS) {
                data.hasCSS = !!addStyleSheet(
                    ownerDocument,
                    // corrects block display not defined in IE6/7/8/9
                    'article,aside,dialog,figcaption,figure,footer,header,hgroup,main,nav,section{display:block}' +
                        // adds styling not present in IE6/7/8/9
                        'mark{background:#FF0;color:#000}' +
                        // hides non-rendered elements
                        'template{display:none}'
                );
            }
            if (!supportsUnknownElements) {
                shivMethods(ownerDocument, data);
            }
            return ownerDocument;
        }

        /*--------------------------------------------------------------------------*/

        /**
         * The `html5` object is exposed so that more elements can be shived and
         * existing shiving can be detected on iframes.
         * @type Object
         * @example
         *
         * // options can be changed before the script is included
         * html5 = { 'elements': 'mark section', 'shivCSS': false, 'shivMethods': false };
         */
        var html5 = {
            /**
             * An array or space separated string of node names of the elements to shiv.
             * @memberOf html5
             * @type Array|String
             */
            elements:
                options.elements ||
                'abbr article aside audio bdi canvas data datalist details dialog figcaption figure footer header hgroup main mark meter nav output progress section summary template time video',

            /**
             * current version of html5shiv
             */
            version: version,

            /**
             * A flag to indicate that the HTML5 style sheet should be inserted.
             * @memberOf html5
             * @type Boolean
             */
            shivCSS: options.shivCSS !== false,

            /**
             * Is equal to true if a browser supports creating unknown/HTML5 elements
             * @memberOf html5
             * @type boolean
             */
            supportsUnknownElements: supportsUnknownElements,

            /**
             * A flag to indicate that the document's `createElement` and `createDocumentFragment`
             * methods should be overwritten.
             * @memberOf html5
             * @type Boolean
             */
            shivMethods: options.shivMethods !== false,

            /**
             * A string to describe the type of `html5` object ("default" or "default print").
             * @memberOf html5
             * @type String
             */
            type: 'default',

            // shivs the document according to the specified `html5` object options
            shivDocument: shivDocument,

            //creates a shived element
            createElement: createElement,

            //creates a shived documentFragment
            createDocumentFragment: createDocumentFragment,
        };

        /*--------------------------------------------------------------------------*/

        // expose html5
        window.html5 = html5;

        // shiv the document
        shivDocument(document);
    })(this, document);
    /*>>shiv*/

    // Assign private properties to the return object with prefix
    Modernizr._version = version;

    // expose these for the plugin API. Look in the source for how to join() them against your input
    /*>>prefixes*/
    Modernizr._prefixes = prefixes;
    /*>>prefixes*/
    /*>>domprefixes*/
    Modernizr._domPrefixes = domPrefixes;
    Modernizr._cssomPrefixes = cssomPrefixes;
    /*>>domprefixes*/

    /*>>mq*/
    // Modernizr.mq tests a given media query, live against the current state of the window
    // A few important notes:
    //   * If a browser does not support media queries at all (eg. oldIE) the mq() will always return false
    //   * A max-width or orientation query will be evaluated against the current state, which may change later.
    //   * You must specify values. Eg. If you are testing support for the min-width media query use:
    //       Modernizr.mq('(min-width:0)')
    // usage:
    // Modernizr.mq('only screen and (max-width:768)')
    Modernizr.mq = testMediaQuery;
    /*>>mq*/

    /*>>hasevent*/
    // Modernizr.hasEvent() detects support for a given event, with an optional element to test on
    // Modernizr.hasEvent('gesturestart', elem)
    Modernizr.hasEvent = isEventSupported;
    /*>>hasevent*/

    /*>>testprop*/
    // Modernizr.testProp() investigates whether a given style property is recognized
    // Note that the property names must be provided in the camelCase variant.
    // Modernizr.testProp('pointerEvents')
    Modernizr.testProp = function (prop) {
        return testProps([prop]);
    };
    /*>>testprop*/

    /*>>testallprops*/
    // Modernizr.testAllProps() investigates whether a given style property,
    //   or any of its vendor-prefixed variants, is recognized
    // Note that the property names must be provided in the camelCase variant.
    // Modernizr.testAllProps('boxSizing')
    Modernizr.testAllProps = testPropsAll;
    /*>>testallprops*/

    /*>>teststyles*/
    // Modernizr.testStyles() allows you to add custom styles to the document and test an element afterwards
    // Modernizr.testStyles('#modernizr { position:absolute }', function(elem, rule){ ... })
    Modernizr.testStyles = injectElementWithStyles;
    /*>>teststyles*/

    /*>>prefixed*/
    // Modernizr.prefixed() returns the prefixed or nonprefixed property name variant of your input
    // Modernizr.prefixed('boxSizing') // 'MozBoxSizing'

    // Properties must be passed as dom-style camelcase, rather than `box-sizing` hypentated style.
    // Return values will also be the camelCase variant, if you need to translate that to hypenated style use:
    //
    //     str.replace(/([A-Z])/g, function(str,m1){ return '-' + m1.toLowerCase(); }).replace(/^ms-/,'-ms-');

    // If you're trying to ascertain which transition end event to bind to, you might do something like...
    //
    //     var transEndEventNames = {
    //       'WebkitTransition' : 'webkitTransitionEnd',
    //       'MozTransition'    : 'transitionend',
    //       'OTransition'      : 'oTransitionEnd',
    //       'msTransition'     : 'MSTransitionEnd',
    //       'transition'       : 'transitionend'
    //     },
    //     transEndEventName = transEndEventNames[ Modernizr.prefixed('transition') ];

    Modernizr.prefixed = function (prop, obj, elem) {
        if (!obj) {
            return testPropsAll(prop, 'pfx');
        } else {
            // Testing DOM property e.g. Modernizr.prefixed('requestAnimationFrame', window) // 'mozRequestAnimationFrame'
            return testPropsAll(prop, obj, elem);
        }
    };
    /*>>prefixed*/

    /*>>cssclasses*/
    // Remove "no-js" class from <html> element, if it exists:
    docElement.className =
        docElement.className.replace(/(^|\s)no-js(\s|$)/, '$1$2') +
        // Add the new classes to the <html> element.
        (enableClasses ? ' js ' + classes.join(' ') : '');
    /*>>cssclasses*/

    return Modernizr;
})(this, this.document);
/*! jQuery Mobile v1.4.5 | Copyright 2010, 2014 jQuery Foundation, Inc. | jquery.org/license */

(function (e, t, n) {
    typeof define == 'function' && define.amd
        ? define(['jquery'], function (r) {
              return n(r, e, t), r.mobile;
          })
        : n(e.jQuery, e, t);
})(this, document, function (e, t, n, r) {
    (function (e, t, n, r) {
        function T(e) {
            while (e && typeof e.originalEvent != 'undefined')
                e = e.originalEvent;
            return e;
        }
        function N(t, n) {
            var i = t.type,
                s,
                o,
                a,
                l,
                c,
                h,
                p,
                d,
                v;
            (t = e.Event(t)),
                (t.type = n),
                (s = t.originalEvent),
                (o = e.event.props),
                i.search(/^(mouse|click)/) > -1 && (o = f);
            if (s) for (p = o.length, l; p; ) (l = o[--p]), (t[l] = s[l]);
            i.search(/mouse(down|up)|click/) > -1 && !t.which && (t.which = 1);
            if (i.search(/^touch/) !== -1) {
                (a = T(s)),
                    (i = a.touches),
                    (c = a.changedTouches),
                    (h = i && i.length ? i[0] : c && c.length ? c[0] : r);
                if (h)
                    for (d = 0, v = u.length; d < v; d++)
                        (l = u[d]), (t[l] = h[l]);
            }
            return t;
        }
        function C(t) {
            var n = {},
                r,
                s;
            while (t) {
                r = e.data(t, i);
                for (s in r) r[s] && (n[s] = n.hasVirtualBinding = !0);
                t = t.parentNode;
            }
            return n;
        }
        function k(t, n) {
            var r;
            while (t) {
                r = e.data(t, i);
                if (r && (!n || r[n])) return t;
                t = t.parentNode;
            }
            return null;
        }
        function L() {
            g = !1;
        }
        function A() {
            g = !0;
        }
        function O() {
            (E = 0), (v.length = 0), (m = !1), A();
        }
        function M() {
            L();
        }
        function _() {
            D(),
                (c = setTimeout(function () {
                    (c = 0), O();
                }, e.vmouse.resetTimerDuration));
        }
        function D() {
            c && (clearTimeout(c), (c = 0));
        }
        function P(t, n, r) {
            var i;
            if ((r && r[t]) || (!r && k(n.target, t)))
                (i = N(n, t)), e(n.target).trigger(i);
            return i;
        }
        function H(t) {
            var n = e.data(t.target, s),
                r;
            !m &&
                (!E || E !== n) &&
                ((r = P('v' + t.type, t)),
                r &&
                    (r.isDefaultPrevented() && t.preventDefault(),
                    r.isPropagationStopped() && t.stopPropagation(),
                    r.isImmediatePropagationStopped() &&
                        t.stopImmediatePropagation()));
        }
        function B(t) {
            var n = T(t).touches,
                r,
                i,
                o;
            n &&
                n.length === 1 &&
                ((r = t.target),
                (i = C(r)),
                i.hasVirtualBinding &&
                    ((E = w++),
                    e.data(r, s, E),
                    D(),
                    M(),
                    (d = !1),
                    (o = T(t).touches[0]),
                    (h = o.pageX),
                    (p = o.pageY),
                    P('vmouseover', t, i),
                    P('vmousedown', t, i)));
        }
        function j(e) {
            if (g) return;
            d || P('vmousecancel', e, C(e.target)), (d = !0), _();
        }
        function F(t) {
            if (g) return;
            var n = T(t).touches[0],
                r = d,
                i = e.vmouse.moveDistanceThreshold,
                s = C(t.target);
            (d = d || Math.abs(n.pageX - h) > i || Math.abs(n.pageY - p) > i),
                d && !r && P('vmousecancel', t, s),
                P('vmousemove', t, s),
                _();
        }
        function I(e) {
            if (g) return;
            A();
            var t = C(e.target),
                n,
                r;
            P('vmouseup', e, t),
                d ||
                    ((n = P('vclick', e, t)),
                    n &&
                        n.isDefaultPrevented() &&
                        ((r = T(e).changedTouches[0]),
                        v.push({ touchID: E, x: r.clientX, y: r.clientY }),
                        (m = !0))),
                P('vmouseout', e, t),
                (d = !1),
                _();
        }
        function q(t) {
            var n = e.data(t, i),
                r;
            if (n) for (r in n) if (n[r]) return !0;
            return !1;
        }
        function R() {}
        function U(t) {
            var n = t.substr(1);
            return {
                setup: function () {
                    q(this) || e.data(this, i, {});
                    var r = e.data(this, i);
                    (r[t] = !0),
                        (l[t] = (l[t] || 0) + 1),
                        l[t] === 1 && b.bind(n, H),
                        e(this).bind(n, R),
                        y &&
                            ((l.touchstart = (l.touchstart || 0) + 1),
                            l.touchstart === 1 &&
                                b
                                    .bind('touchstart', B)
                                    .bind('touchend', I)
                                    .bind('touchmove', F)
                                    .bind('scroll', j));
                },
                teardown: function () {
                    --l[t],
                        l[t] || b.unbind(n, H),
                        y &&
                            (--l.touchstart,
                            l.touchstart ||
                                b
                                    .unbind('touchstart', B)
                                    .unbind('touchmove', F)
                                    .unbind('touchend', I)
                                    .unbind('scroll', j));
                    var r = e(this),
                        s = e.data(this, i);
                    s && (s[t] = !1),
                        r.unbind(n, R),
                        q(this) || r.removeData(i);
                },
            };
        }
        var i = 'virtualMouseBindings',
            s = 'virtualTouchID',
            o =
                'vmouseover vmousedown vmousemove vmouseup vclick vmouseout vmousecancel'.split(
                    ' '
                ),
            u = 'clientX clientY pageX pageY screenX screenY'.split(' '),
            a = e.event.mouseHooks ? e.event.mouseHooks.props : [],
            f = e.event.props.concat(a),
            l = {},
            c = 0,
            h = 0,
            p = 0,
            d = !1,
            v = [],
            m = !1,
            g = !1,
            y = 'addEventListener' in n,
            b = e(n),
            w = 1,
            E = 0,
            S,
            x;
        e.vmouse = {
            moveDistanceThreshold: 10,
            clickDistanceThreshold: 10,
            resetTimerDuration: 1500,
        };
        for (x = 0; x < o.length; x++) e.event.special[o[x]] = U(o[x]);
        y &&
            n.addEventListener(
                'click',
                function (t) {
                    var n = v.length,
                        r = t.target,
                        i,
                        o,
                        u,
                        a,
                        f,
                        l;
                    if (n) {
                        (i = t.clientX),
                            (o = t.clientY),
                            (S = e.vmouse.clickDistanceThreshold),
                            (u = r);
                        while (u) {
                            for (a = 0; a < n; a++) {
                                (f = v[a]), (l = 0);
                                if (
                                    (u === r &&
                                        Math.abs(f.x - i) < S &&
                                        Math.abs(f.y - o) < S) ||
                                    e.data(u, s) === f.touchID
                                ) {
                                    t.preventDefault(), t.stopPropagation();
                                    return;
                                }
                            }
                            u = u.parentNode;
                        }
                    }
                },
                !0
            );
    })(e, t, n),
        (function (e) {
            e.mobile = {};
        })(e),
        (function (e, t) {
            var r = { touch: 'ontouchend' in n };
            (e.mobile.support = e.mobile.support || {}),
                e.extend(e.support, r),
                e.extend(e.mobile.support, r);
        })(e),
        (function (e, t, r) {
            function l(t, n, i, s) {
                var o = i.type;
                (i.type = n),
                    s ? e.event.trigger(i, r, t) : e.event.dispatch.call(t, i),
                    (i.type = o);
            }
            var i = e(n),
                s = e.mobile.support.touch,
                o = 'touchmove scroll',
                u = s ? 'touchstart' : 'mousedown',
                a = s ? 'touchend' : 'mouseup',
                f = s ? 'touchmove' : 'mousemove';
            e.each(
                'touchstart touchmove touchend tap taphold swipe swipeleft swiperight scrollstart scrollstop'.split(
                    ' '
                ),
                function (t, n) {
                    (e.fn[n] = function (e) {
                        return e ? this.bind(n, e) : this.trigger(n);
                    }),
                        e.attrFn && (e.attrFn[n] = !0);
                }
            ),
                (e.event.special.scrollstart = {
                    enabled: !0,
                    setup: function () {
                        function s(e, n) {
                            (r = n), l(t, r ? 'scrollstart' : 'scrollstop', e);
                        }
                        var t = this,
                            n = e(t),
                            r,
                            i;
                        n.bind(o, function (t) {
                            if (!e.event.special.scrollstart.enabled) return;
                            r || s(t, !0),
                                clearTimeout(i),
                                (i = setTimeout(function () {
                                    s(t, !1);
                                }, 50));
                        });
                    },
                    teardown: function () {
                        e(this).unbind(o);
                    },
                }),
                (e.event.special.tap = {
                    tapholdThreshold: 750,
                    emitTapOnTaphold: !0,
                    setup: function () {
                        var t = this,
                            n = e(t),
                            r = !1;
                        n.bind('vmousedown', function (s) {
                            function a() {
                                clearTimeout(u);
                            }
                            function f() {
                                a(),
                                    n.unbind('vclick', c).unbind('vmouseup', a),
                                    i.unbind('vmousecancel', f);
                            }
                            function c(e) {
                                f(),
                                    !r && o === e.target
                                        ? l(t, 'tap', e)
                                        : r && e.preventDefault();
                            }
                            r = !1;
                            if (s.which && s.which !== 1) return !1;
                            var o = s.target,
                                u;
                            n.bind('vmouseup', a).bind('vclick', c),
                                i.bind('vmousecancel', f),
                                (u = setTimeout(function () {
                                    e.event.special.tap.emitTapOnTaphold ||
                                        (r = !0),
                                        l(
                                            t,
                                            'taphold',
                                            e.Event('taphold', { target: o })
                                        );
                                }, e.event.special.tap.tapholdThreshold));
                        });
                    },
                    teardown: function () {
                        e(this)
                            .unbind('vmousedown')
                            .unbind('vclick')
                            .unbind('vmouseup'),
                            i.unbind('vmousecancel');
                    },
                }),
                (e.event.special.swipe = {
                    scrollSupressionThreshold: 30,
                    durationThreshold: 1e3,
                    horizontalDistanceThreshold: 30,
                    verticalDistanceThreshold: 30,
                    getLocation: function (e) {
                        var n = t.pageXOffset,
                            r = t.pageYOffset,
                            i = e.clientX,
                            s = e.clientY;
                        if (
                            (e.pageY === 0 &&
                                Math.floor(s) > Math.floor(e.pageY)) ||
                            (e.pageX === 0 &&
                                Math.floor(i) > Math.floor(e.pageX))
                        )
                            (i -= n), (s -= r);
                        else if (s < e.pageY - r || i < e.pageX - n)
                            (i = e.pageX - n), (s = e.pageY - r);
                        return { x: i, y: s };
                    },
                    start: function (t) {
                        var n = t.originalEvent.touches
                                ? t.originalEvent.touches[0]
                                : t,
                            r = e.event.special.swipe.getLocation(n);
                        return {
                            time: new Date().getTime(),
                            coords: [r.x, r.y],
                            origin: e(t.target),
                        };
                    },
                    stop: function (t) {
                        var n = t.originalEvent.touches
                                ? t.originalEvent.touches[0]
                                : t,
                            r = e.event.special.swipe.getLocation(n);
                        return {
                            time: new Date().getTime(),
                            coords: [r.x, r.y],
                        };
                    },
                    handleSwipe: function (t, n, r, i) {
                        if (
                            n.time - t.time <
                                e.event.special.swipe.durationThreshold &&
                            Math.abs(t.coords[0] - n.coords[0]) >
                                e.event.special.swipe
                                    .horizontalDistanceThreshold &&
                            Math.abs(t.coords[1] - n.coords[1]) <
                                e.event.special.swipe.verticalDistanceThreshold
                        ) {
                            var s =
                                t.coords[0] > n.coords[0]
                                    ? 'swipeleft'
                                    : 'swiperight';
                            return (
                                l(
                                    r,
                                    'swipe',
                                    e.Event('swipe', {
                                        target: i,
                                        swipestart: t,
                                        swipestop: n,
                                    }),
                                    !0
                                ),
                                l(
                                    r,
                                    s,
                                    e.Event(s, {
                                        target: i,
                                        swipestart: t,
                                        swipestop: n,
                                    }),
                                    !0
                                ),
                                !0
                            );
                        }
                        return !1;
                    },
                    eventInProgress: !1,
                    setup: function () {
                        var t,
                            n = this,
                            r = e(n),
                            s = {};
                        (t = e.data(this, 'mobile-events')),
                            t ||
                                ((t = { length: 0 }),
                                e.data(this, 'mobile-events', t)),
                            t.length++,
                            (t.swipe = s),
                            (s.start = function (t) {
                                if (e.event.special.swipe.eventInProgress)
                                    return;
                                e.event.special.swipe.eventInProgress = !0;
                                var r,
                                    o = e.event.special.swipe.start(t),
                                    u = t.target,
                                    l = !1;
                                (s.move = function (t) {
                                    if (!o || t.isDefaultPrevented()) return;
                                    (r = e.event.special.swipe.stop(t)),
                                        l ||
                                            ((l =
                                                e.event.special.swipe.handleSwipe(
                                                    o,
                                                    r,
                                                    n,
                                                    u
                                                )),
                                            l &&
                                                (e.event.special.swipe.eventInProgress =
                                                    !1)),
                                        Math.abs(o.coords[0] - r.coords[0]) >
                                            e.event.special.swipe
                                                .scrollSupressionThreshold &&
                                            t.preventDefault();
                                }),
                                    (s.stop = function () {
                                        (l = !0),
                                            (e.event.special.swipe.eventInProgress =
                                                !1),
                                            i.off(f, s.move),
                                            (s.move = null);
                                    }),
                                    i.on(f, s.move).one(a, s.stop);
                            }),
                            r.on(u, s.start);
                    },
                    teardown: function () {
                        var t, n;
                        (t = e.data(this, 'mobile-events')),
                            t &&
                                ((n = t.swipe),
                                delete t.swipe,
                                t.length--,
                                t.length === 0 &&
                                    e.removeData(this, 'mobile-events')),
                            n &&
                                (n.start && e(this).off(u, n.start),
                                n.move && i.off(f, n.move),
                                n.stop && i.off(a, n.stop));
                    },
                }),
                e.each(
                    {
                        scrollstop: 'scrollstart',
                        taphold: 'tap',
                        swipeleft: 'swipe.left',
                        swiperight: 'swipe.right',
                    },
                    function (t, n) {
                        e.event.special[t] = {
                            setup: function () {
                                e(this).bind(n, e.noop);
                            },
                            teardown: function () {
                                e(this).unbind(n);
                            },
                        };
                    }
                );
        })(e, this);
});
