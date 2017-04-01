/**
 * Copyright (c) 2017. Volodumur Hryvinskyi
 * @author   Volodumur Hryvinskyi <script@email.ua>
 * @package  scriptua\lp
 */

(function ($) {
    'use strict';

    var Site = function () {

        // IE mode
        var isRTL = false;
        var isIE8 = false;
        var isIE9 = false;
        var isIE10 = false;

        var resizeHandlers = [];

        /**
         * initializes main settings
         */
        var handleInit = function () {

            if ($('body').css('direction') === 'rtl') {
                isRTL = true;
            }

            isIE8 = !!navigator.userAgent.match(/MSIE 8.0/);
            isIE9 = !!navigator.userAgent.match(/MSIE 9.0/);
            isIE10 = !!navigator.userAgent.match(/MSIE 10.0/);

            if (isIE10) {
                $('html').addClass('ie10');
            }

            if (isIE10 || isIE9 || isIE8) {
                $('html').addClass('ie');
            }
        };

        /**
         * runs callback functions set by [Site.addResponsiveHandler()].
         */
        var _runResizeHandlers = function () {
            for (var i = 0; i < resizeHandlers.length; i++) {
                var each = resizeHandlers[i];
                each.call();
            }
        };

        /* BEGIN:CORE HANDLERS */
        /**
         * handle the layout reinitialization on window resize
         */
        var handleOnResize = function () {
            var resize;
            if (isIE8) {
                var currheight;
                $(window).resize(function () {
                    if (currheight == document.documentElement.clientHeight) {
                        return;
                    }
                    if (resize) {
                        clearTimeout(resize);
                    }
                    resize = setTimeout(function () {
                        _runResizeHandlers();
                    }, 50);
                    currheight = document.documentElement.clientHeight;
                });
            } else {
                $(window).resize(function () {
                    if (resize) {
                        clearTimeout(resize);
                    }
                    resize = setTimeout(function () {
                        _runResizeHandlers();
                    }, 50);
                });
            }
        };

        /**
         * Fix input placeholder issue for IE8 and IE9
         */
        var handleFixInputPlaceholderForIE = function() {
            if (isIE8 || isIE9) {
                $('input[placeholder]:not(.placeholder-no-fix), textarea[placeholder]:not(.placeholder-no-fix)').each(function() {
                    var input = $(this);

                    if (input.val() === '' && input.attr("placeholder") !== '') {
                        input.addClass("placeholder").val(input.attr('placeholder'));
                    }

                    input.focus(function() {
                        if (input.val() == input.attr('placeholder')) {
                            input.val('');
                        }
                    });

                    input.blur(function() {
                        if (input.val() === '' || input.val() == input.attr('placeholder')) {
                            input.val(input.attr('placeholder'));
                        }
                    });
                });
            }
        };

        /* END:CORE HANDLERS */

        return {

            /**
             * Main function to initiate the theme
             * */
            init: function () {

                // Core handlers
                handleInit(); // initialize core variables
                handleOnResize(); // set and handle responsive

                // Hacks
                handleFixInputPlaceholderForIE(); //IE8 & IE9 input placeholder issue fix
            },

            /**
             * Main function to initiate core javascript after ajax complete
             */
            initAjax: function () {

            },

            /**
             * init main components
             */
            initComponents: function () {
                this.initAjax();
            },

            /**
             * public function to add callback a function which will be called on window resize
             * @param func
             */
            addResizeHandler: function (func) {
                resizeHandlers.push(func);
            },

            /**
             * public functon to call _runresizeHandlers
             */
            runResizeHandlers: function () {
                _runResizeHandlers();
            },

            /**
             * public function to get a paremeter by name from URL
             * @param paramName
             * @returns {string|null}
             */
            getURLParameter: function (paramName) {
                var searchString = window.location.search.substring(1),
                    i, val, params = searchString.split("&");

                for (i = 0; i < params.length; i++) {
                    val = params[i].split("=");
                    if (val[0] == paramName) {
                        return unescape(val[1]);
                    }
                }
                return null;
            },

            /**
             * check for device touch support
             */
            isTouchDevice: function () {
                try {
                    document.createEvent("TouchEvent");
                    return true;
                } catch (e) {
                    return false;
                }
            },

            /**
             * To get the correct viewport width based on  http://andylangton.co.uk/articles/javascript/get-viewport-size-javascript/
             * @returns {{width: *, height: *}}
             */
            getViewPort: function () {
                var e = window,
                    a = 'inner';
                if (!('innerWidth' in window)) {
                    a = 'client';
                    e = document.documentElement || document.body;
                }

                return {
                    width: e[a + 'Width'],
                    height: e[a + 'Height']
                };
            },

            getUniqueID: function (prefix) {
                return prefix + '_' + Math.floor(Math.random() * (new Date()).getTime());
            },

            // check IE8 mode
            isIE8: function () {
                return isIE8;
            },

            // check IE9 mode
            isIE9: function () {
                return isIE9;
            },

            //check RTL mode
            isRTL: function () {
                return isRTL;
            },

            // check IE8 mode
            isAngularJsApp: function () {
                return (typeof angular == 'undefined') ? false : true;
            },

            getResponsiveBreakpoint: function (size) {
                var sizes = {
                    'xs': 480,     // extra small
                    'sm': 768,     // small
                    'md': 992,     // medium
                    'lg': 1200     // large
                };
                return sizes[size] ? sizes[size] : 0;
            }
        };
    }();

    Site.init();
})(jQuery);
