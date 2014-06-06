/*
 * jQuery Easing v1.3 - http://gsgd.co.uk/sandbox/jquery/easing/
 *
 * Uses the built in easing capabilities added In jQuery 1.1
 * to offer multiple easing options
 *
 * TERMS OF USE - jQuery Easing
 * 
 * Open source under the BSD License. 
 * 
 * Copyright Â© 2008 George McGinley Smith
 * All rights reserved.
 * 
 * Redistribution and use in source and binary forms, with or without modification, 
 * are permitted provided that the following conditions are met:
 * 
 * Redistributions of source code must retain the above copyright notice, this list of 
 * conditions and the following disclaimer.
 * Redistributions in binary form must reproduce the above copyright notice, this list 
 * of conditions and the following disclaimer in the documentation and/or other materials 
 * provided with the distribution.
 * 
 * Neither the name of the author nor the names of contributors may be used to endorse 
 * or promote products derived from this software without specific prior written permission.
 * 
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY 
 * EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF
 * MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 *  COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL,
 *  EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE
 *  GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED 
 * AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING
 *  NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED 
 * OF THE POSSIBILITY OF SUCH DAMAGE. 
 *
*/
jQuery.easing["jswing"] = jQuery.easing["swing"]; jQuery.extend(jQuery.easing, { def: "easeOutQuad", swing: function (e, t, n, r, i) { return jQuery.easing[jQuery.easing.def](e, t, n, r, i) }, easeInQuad: function (e, t, n, r, i) { return r * (t /= i) * t + n }, easeOutQuad: function (e, t, n, r, i) { return -r * (t /= i) * (t - 2) + n }, easeInOutQuad: function (e, t, n, r, i) { if ((t /= i / 2) < 1) return r / 2 * t * t + n; return -r / 2 * (--t * (t - 2) - 1) + n }, easeInCubic: function (e, t, n, r, i) { return r * (t /= i) * t * t + n }, easeOutCubic: function (e, t, n, r, i) { return r * ((t = t / i - 1) * t * t + 1) + n }, easeInOutCubic: function (e, t, n, r, i) { if ((t /= i / 2) < 1) return r / 2 * t * t * t + n; return r / 2 * ((t -= 2) * t * t + 2) + n }, easeInQuart: function (e, t, n, r, i) { return r * (t /= i) * t * t * t + n }, easeOutQuart: function (e, t, n, r, i) { return -r * ((t = t / i - 1) * t * t * t - 1) + n }, easeInOutQuart: function (e, t, n, r, i) { if ((t /= i / 2) < 1) return r / 2 * t * t * t * t + n; return -r / 2 * ((t -= 2) * t * t * t - 2) + n }, easeInQuint: function (e, t, n, r, i) { return r * (t /= i) * t * t * t * t + n }, easeOutQuint: function (e, t, n, r, i) { return r * ((t = t / i - 1) * t * t * t * t + 1) + n }, easeInOutQuint: function (e, t, n, r, i) { if ((t /= i / 2) < 1) return r / 2 * t * t * t * t * t + n; return r / 2 * ((t -= 2) * t * t * t * t + 2) + n }, easeInSine: function (e, t, n, r, i) { return -r * Math.cos(t / i * (Math.PI / 2)) + r + n }, easeOutSine: function (e, t, n, r, i) { return r * Math.sin(t / i * (Math.PI / 2)) + n }, easeInOutSine: function (e, t, n, r, i) { return -r / 2 * (Math.cos(Math.PI * t / i) - 1) + n }, easeInExpo: function (e, t, n, r, i) { return t == 0 ? n : r * Math.pow(2, 10 * (t / i - 1)) + n }, easeOutExpo: function (e, t, n, r, i) { return t == i ? n + r : r * (-Math.pow(2, -10 * t / i) + 1) + n }, easeInOutExpo: function (e, t, n, r, i) { if (t == 0) return n; if (t == i) return n + r; if ((t /= i / 2) < 1) return r / 2 * Math.pow(2, 10 * (t - 1)) + n; return r / 2 * (-Math.pow(2, -10 * --t) + 2) + n }, easeInCirc: function (e, t, n, r, i) { return -r * (Math.sqrt(1 - (t /= i) * t) - 1) + n }, easeOutCirc: function (e, t, n, r, i) { return r * Math.sqrt(1 - (t = t / i - 1) * t) + n }, easeInOutCirc: function (e, t, n, r, i) { if ((t /= i / 2) < 1) return -r / 2 * (Math.sqrt(1 - t * t) - 1) + n; return r / 2 * (Math.sqrt(1 - (t -= 2) * t) + 1) + n }, easeInElastic: function (e, t, n, r, i) { var s = 1.70158; var o = 0; var u = r; if (t == 0) return n; if ((t /= i) == 1) return n + r; if (!o) o = i * .3; if (u < Math.abs(r)) { u = r; var s = o / 4 } else var s = o / (2 * Math.PI) * Math.asin(r / u); return -(u * Math.pow(2, 10 * (t -= 1)) * Math.sin((t * i - s) * 2 * Math.PI / o)) + n }, easeOutElastic: function (e, t, n, r, i) { var s = 1.70158; var o = 0; var u = r; if (t == 0) return n; if ((t /= i) == 1) return n + r; if (!o) o = i * .3; if (u < Math.abs(r)) { u = r; var s = o / 4 } else var s = o / (2 * Math.PI) * Math.asin(r / u); return u * Math.pow(2, -10 * t) * Math.sin((t * i - s) * 2 * Math.PI / o) + r + n }, easeInOutElastic: function (e, t, n, r, i) { var s = 1.70158; var o = 0; var u = r; if (t == 0) return n; if ((t /= i / 2) == 2) return n + r; if (!o) o = i * .3 * 1.5; if (u < Math.abs(r)) { u = r; var s = o / 4 } else var s = o / (2 * Math.PI) * Math.asin(r / u); if (t < 1) return -.5 * u * Math.pow(2, 10 * (t -= 1)) * Math.sin((t * i - s) * 2 * Math.PI / o) + n; return u * Math.pow(2, -10 * (t -= 1)) * Math.sin((t * i - s) * 2 * Math.PI / o) * .5 + r + n }, easeInBack: function (e, t, n, r, i, s) { if (s == undefined) s = 1.70158; return r * (t /= i) * t * ((s + 1) * t - s) + n }, easeOutBack: function (e, t, n, r, i, s) { if (s == undefined) s = 1.70158; return r * ((t = t / i - 1) * t * ((s + 1) * t + s) + 1) + n }, easeInOutBack: function (e, t, n, r, i, s) { if (s == undefined) s = 1.70158; if ((t /= i / 2) < 1) return r / 2 * t * t * (((s *= 1.525) + 1) * t - s) + n; return r / 2 * ((t -= 2) * t * (((s *= 1.525) + 1) * t + s) + 2) + n }, easeInBounce: function (e, t, n, r, i) { return r - jQuery.easing.easeOutBounce(e, i - t, 0, r, i) + n }, easeOutBounce: function (e, t, n, r, i) { if ((t /= i) < 1 / 2.75) { return r * 7.5625 * t * t + n } else if (t < 2 / 2.75) { return r * (7.5625 * (t -= 1.5 / 2.75) * t + .75) + n } else if (t < 2.5 / 2.75) { return r * (7.5625 * (t -= 2.25 / 2.75) * t + .9375) + n } else { return r * (7.5625 * (t -= 2.625 / 2.75) * t + .984375) + n } }, easeInOutBounce: function (e, t, n, r, i) { if (t < i / 2) return jQuery.easing.easeInBounce(e, t * 2, 0, r, i) * .5 + n; return jQuery.easing.easeOutBounce(e, t * 2 - i, 0, r, i) * .5 + r * .5 + n } })



/**
   * Copyright 2013, GreenTreeLabs
   *
   * @author Diego Imbriani
   * @version 1.8.3
   * @desc unusual tiling gallery
   * @url http://codecanyon.net/item/final-tiles-gallery/4734090?ref=GreenTreeLabs
   *
   */

; (function ($) {

    /**
    * Copyright 2012, Digital Fusion
    * Licensed under the MIT license.
    * http://teamdf.com/jquery-plugins/license/
    *
    * @author Sam Sehnert
    * @desc A small plugin that checks whether elements are within
    *     the user visible viewport of a web browser.
    *     only accounts for vertical position, not horizontal.
    */

    $.fn.visible = function (partial) {

        if (!$(this).offset())
            return true;

        var $t = $(this),
            $w = $(window),
            viewTop = $w.scrollTop(),
            viewBottom = viewTop + $w.height(),
            _top = $t.offset().top,
            _bottom = _top + $t.height(),
            compareTop = partial === true ? _bottom : _top,
            compareBottom = partial === true ? _top : _bottom;

        return ((compareBottom <= viewBottom) && (compareTop >= viewTop));

    };

    $.finalTilesGallery = function (element, options) {
        function supportsTransitions() {

            var b = document.body || document.documentElement;
            var s = b.style;
            var p = 'transition';
            if (typeof s[p] == 'string') { return true; }

            // Tests for vendor specific prop
            v = ['Moz', 'Webkit', 'Khtml', 'O', 'ms'],
            p = p.charAt(0).toUpperCase() + p.substr(1);
            for (var i = 0; i < v.length; i++) {
                if (typeof s[v[i] + p] == 'string') { return true; }
            }
            return false;
        }

        var Slot = function (cell_size, width, height) {
            this.position = { x: 0, y: 0 };
            this.blocks = { h: Math.floor(width / cell_size), v: Math.floor(height / cell_size) };
            this.size = { width: this.blocks.h * cell_size, height: this.blocks.v * cell_size };
            this.px = { width: width, height: height };
            this.cell_size = cell_size;
            this.edge_right = false;
        }

        Slot.prototype.resize = function (blocks, onlyWidth) {
            //nw : nh = w : h => nh = nw * h / w
            var new_width = blocks * this.cell_size;
            var new_height = (new_width * this.px.height) / this.px.width;
            var bv = this.blocks.v;
            this.blocks.h = blocks;
            if (!onlyWidth)
                this.blocks.v = Math.floor(new_height / this.cell_size);
        }

        var Grid = function (cell_size, margin, min_tile_width, width) {
            this.slots = [];
            this.cells = [];
            this.margin = margin;
            this.min_tile_width = min_tile_width;
            this.cell_size = cell_size;
            this.width = width;
            this.hor_size = Math.floor(width / cell_size);
            this.init();
        }

        Grid.prototype.init = function () {
            this.slots.length = 0;
            this.cells.length = 0;
            for (var i = 0; i < this.hor_size * 100; i++) {
                this.cells[i] = 0;
            }
        }

        Grid.prototype.add_slot = function (slot) {
            for (var j = 0; j < slot.blocks.v; j++) {
                for (var i = 0; i < slot.blocks.h; i++) {
                    var row = slot.position.y + j;
                    var column = slot.position.x + i;
                    //if (this.cells.length < row * this.hor_size + column)

                    this.cells[row * this.hor_size + column] = 1;
                    this.cells.push(0);
                }
            }

            this.slots.push(slot);
        }

        Grid.prototype.count_free_cells_on_right = function (index) {
            var line = Math.floor(index / this.hor_size);
            var line_end = (line + 1) * this.hor_size;

            var length = 0;

            for (; index < line_end; index++, length++) {
                if (this.cells[index] == 1) {
                    break;
                }
            }

            return length;
        }

        Grid.prototype.insert = function (width, height, allowEnlargement) {

            var slot = new Slot(this.cell_size, width, height);
            var av_blocks = 0;
            var free_cell = 0;
            var line = 0;

            if (this.slots.length == 0) {
                av_blocks = this.hor_size;
                slot.position.x = 0;
                slot.position.y = 0;
            } else {

                //find first available cell
                var exit = false;
                for (; free_cell < this.cells.length; free_cell++) {
                    if (this.cells[free_cell] == 0) {

                        line = Math.floor(free_cell / this.hor_size);
                        var line_end = (line + 1) * this.hor_size;

                        //available blocks
                        av_blocks = 0;
                        for (var k = 0; k <= line_end - free_cell; k++) {
                            av_blocks = k;
                            if (this.cells[free_cell + k] == 1) {
                                //there's another slot on the right
                                break;
                            }
                        }
                        break;
                    }
                }
            }
            //the slot need to be shrinked
            if (av_blocks < slot.blocks.h) {
                slot.resize(av_blocks);
            } else {
                var free_on_right = this.count_free_cells_on_right(free_cell + slot.blocks.h);
                if (free_on_right * this.cell_size - plugin.settings.margin < this.min_tile_width &&
                        free_on_right > 0) {
                    slot.resize(av_blocks, !allowEnlargement);
                    slot.enlarged = true;
                }
                if (free_on_right == 0)
                    slot.edge_right = true;
            }

            slot.position.x = free_cell % this.hor_size;
            slot.position.y = Math.floor(free_cell / this.hor_size);

            this.add_slot(slot);
            return slot;
        }

        //for debug purpouses
        Grid.prototype.print = function () {
            var log = "";
            for (var i = 1; i <= this.cells.length; i++) {
                log += this.cells[i - 1] == 1 ? "â–ˆâ–ˆ" : "__";
                if (i > 0 && i % this.hor_size == 0)
                    log += "\n";
            }
            $("pre").text(log);
        }

        var defaults = {
            margin: 10,
            minTileWidth: 200,
            autoLoadURL: null,
            autoLoadOffset: 50,
            gridCellSize: 10,
            scrollEffect: 'zoom',
            enableTwitter: false,
            twitterText: '',
            enableFacebook: false,
            facebookText: '',
            enableGplus: false,
            enablePinterest: false,
            allowEnlargement: true,
            hoverEffect: 'fade',
            hoverEasing: 'swing',
            hoverEffectDuration: 250,
            ignoreImageAttributes: true,
            imageSizeFactor: 1,
            captionBehavior: 'hidden',
            onComplete: function () { },
            onUpdate: function () { }
        }

        var plugin = this;
        var grid = null;
        var transitions = supportsTransitions();
        var animateTiles = false;
        var isLoading = false;
        var currentPage = 1;
        var hasSocial = false;
        var maxHeight = 0;
        var totalTiles = 0;
        var loadedTiles = 0;
        var $loadingBar = null;

        plugin.settings = {}

        var $element = $(element),
             element = element;

        var currentWidth = $element.width();

        var completed = false;

        var setupFilters = function () {
            if ($element.find(".ftg-filters").length == 0)
                return;

            $element.find(".ftg-filters a").click(function (e) {
                e.preventDefault();

                animateTiles = true;
                
                maxHeight = 0;

                if ($(this).hasClass("selected"))
                    return;

                $element.find(".ftg-filters .selected").add(this).toggleClass("selected");

                var ft = $(this).attr("href").substr(1);
                var $tiles = $("void");
                grid = null;
                if (ft.length > 0) {
                    $element.find(".tile").addClass("ftg-hidden").hide().css({
                        bottom: 0,
                        left: "50%"
                    });
                    $tiles = $element.find(".ftg-" + ft).show().removeClass("ftg-hidden");
                } else {
                    $tiles = $element.find(".tile").removeClass("ftg-hidden").show();
                }
                entile($tiles);
            });
        }

        plugin.addElements = function (html) {
            var $hidden = $("<div />").hide();
            $hidden.append(html);
            var $tiles = $hidden.find(".tile");
            styleTiles($tiles, { top: $(window).scrollTop() + 500 });
            setupTwitter($tiles);
            $("body").append($hidden);

            $tiles.appendTo($element.find(".ftg-items"));
            $hidden.remove();
            preloadImages($tiles);
        }

        plugin.showLoading = function () {
            var panel = $("<div class='ftg-loading-panel' />");
            panel.append("<p>Loading</p>");
            panel.hide();
            $("body").append(panel);
            panel.fadeIn();
        }

        plugin.hideLoading = function () {
            $(".ftg-loading-panel").fadeOut("fast", function () {
                $(this).remove();
            });
        }

        plugin.init = function () {

            plugin.settings = $.extend({}, defaults, options);

            if (!plugin.settings.captionBehavior)
                plugin.settings.captionBehavior = 'hidden';

            $element.find(".ftg-items").css({
                position: "relative",
                minWidth: plugin.settings.minTileWidth
            }).prepend("<div class='loading-bar'><i /></div>");

            $loadingBar = $element.find(".ftg-items .loading-bar i");

            var $tiles = $element.find(".tile");
            totalTiles = $tiles.length;

	        setupCaptions($tiles);

            styleTiles($tiles);
            setupFilters();
            preloadImages($tiles);

            hasSocial = plugin.settings.enableFacebook || plugin.settings.enableGplus ||
                        plugin.settings.enableTwitter || plugin.settings.enablePinterest;

            if (hasSocial)
                setupSocial($tiles);

            var resTo = 0;

            $(window).resize(function () {
                clearTimeout(resTo);
                if (currentWidth != $element.width()) {
                    resTo = setTimeout(function () {
                        grid = null;
                        maxHeight = 0;
                        entile($element.find(".tile"));
                    }, 200);
                }
            });

            var $modules = $('.tile');
            $(window).scroll(function (event) {
                $modules.each(function (i, el) {
                    var $el = $modules.eq(i);
                    if ($el.visible(true)) {
                        $modules
                          .splice(i, 1);
                        $el
                          .addClass("effect-" + plugin.settings.scrollEffect)
                          .removeClass('module');
                    }
                });
            });


            var ajaxComplete = false;
            if (plugin.settings.autoLoadURL) {
                $(window).scroll(function () {
                    if (!ajaxComplete && !isLoading && $(window).scrollTop() >= $(document).height() - $(window).height() - plugin.settings.autoLoadOffset) {
                        isLoading = true;
                        plugin.showLoading();
                        $.get(plugin.settings.autoLoadURL, { page: ++currentPage }, function (html) {
                            if ($.trim(html).length == 0) {
                                ajaxComplete = true;
                            } else {
                                plugin.addElements(html);
                            }
                        });
                    }
                });
            }
        }

        var setupCaptions = function ($tiles) {
            switch (plugin.settings.captionBehavior) {
                case "hidden":
                    break;
                case "visible":
                    $tiles.find(".caption").css({
                        display: 'block',
                        opacity: 1
                    });
                case "always-visible":
                	$tiles.find(".caption").css({
                        display: 'block',
                        opacity: 1
                    });
                    break;
            }
        }

        var setupSocial = function ($tiles) {
            $tiles.each(function (i, tile) {
                var $tile = $(tile);
                $tile.append("<div class='ftg-social' />");
            });

            if (plugin.settings.enableTwitter)
                setupTwitter($tiles);
            if (plugin.settings.enableFacebook)
                setupFacebook($tiles);
            if (plugin.settings.enableGplus)
                setupGplus($tiles);
            if (plugin.settings.enablePinterest)
                setupPinterest($tiles);
        }

        var addSocialIcon = function ($tiles, cssClass, name) {
            $tiles.find(".ftg-social").each(function (i, tile) {
                var $tile = $(tile);

                var tw = $("<a class='" + cssClass + "' href='#'></a>");
                $tile.append(tw);
            });
        }

        //credits James Padolsey http://james.padolsey.com/
        var qualifyURL = function (url) {
            var img = document.createElement('img');
            img.src = url; // set string url
            url = img.src; // get qualified url
            img.src = null; // no server request
            return url;
        }

        var setupTwitter = function ($tiles) {
            addSocialIcon($tiles, "tw-icon fa fa-twitter", "Twitter");
            $tiles.find(".tw-icon").click(function (e) {
                e.preventDefault();
                var $caption = $(this).parents(".tile:first").find(".caption");
                var text = plugin.settings.twitterText || document.title;
                if (!plugin.settings.twitterText && $caption.length == 1 && $caption.text().length > 0)
                    text = $.trim($caption.text());
                var w = window.open("https://twitter.com/intent/tweet?url=" + encodeURI(location.href.split('#')[0]) + "&text=" + encodeURI(text), "ftgw", "location=1,status=1,scrollbars=1,width=600,height=400");
                w.moveTo((screen.width / 2) - (300), (screen.height / 2) - (200));
            });
        }

        var setupFacebook = function ($tiles) {
            addSocialIcon($tiles, "fb-icon fa fa-facebook", "Facebook");
            $tiles.find(".fb-icon").click(function (e) {
                e.preventDefault();

                var image = $(this).parents(".tile:first").find("img.item");

                var $caption = $(this).parents(".tile:first").find(".caption");
                var text = plugin.settings.facebookText || document.title;
                if (!plugin.settings.facebookText && $caption.length == 1 && $caption.text().length > 0)
                    text = $.trim($caption.text());

                var url = "http://www.facebook.com/sharer.php?u=" + encodeURI(location.href.split('#')[0]) + "&t=" + encodeURI(text);

                if (image.length == 1) {
                    var src = image.attr("src");
                    url += ("&p[images][0]=" + qualifyURL(src));
                }

                var w = window.open(url, "ftgw", "location=1,status=1,scrollbars=1,width=600,height=400");
                w.moveTo((screen.width / 2) - (300), (screen.height / 2) - (200));
            });
        }

        var setupPinterest = function ($tiles) {
            addSocialIcon($tiles, "pi-icon fa fa-pinterest", "Pinterest");
            $tiles.find(".pi-icon").click(function (e) {
                e.preventDefault();

                var image = $(this).parents(".tile:first").find("img.item");

                var $caption = $(this).parents(".tile:first").find(".caption");
                var text = plugin.settings.facebookText || document.title;
                if (!plugin.settings.facebookText && $caption.length == 1 && $caption.text().length > 0)
                    text = $.trim($caption.text());

                var url = "http://pinterest.com/pin/create/button/?url=" + encodeURIComponent(location.href) + "&description=" + encodeURI(text);

                if (image.length == 1) {
                    var src = image.attr("src");
                    url += ("&media=" + encodeURIComponent(qualifyURL(src)));
                }

                var w = window.open(url, "ftgw", "location=1,status=1,scrollbars=1,width=600,height=400");
                w.moveTo((screen.width / 2) - (300), (screen.height / 2) - (200));
            });
        }

        var setupGplus = function ($tiles) {
            addSocialIcon($tiles, "gp-icon fa fa-google-plus", "G+");
            $tiles.find(".gp-icon").click(function (e) {
                e.preventDefault();

                var url = "https://plus.google.com/share?url=" + encodeURI(location.href);

                var w = window.open(url, "ftgw", "location=1,status=1,scrollbars=1,width=600,height=400");
                w.moveTo((screen.width / 2) - (300), (screen.height / 2) - (200));
            });
        }

        var styleTiles = function ($tiles, styles) {
            $tiles.css({
                position: "absolute",
                left: "50%"
            });

            if (styles) {
                for (var style in styles) {
                    $tiles.css(style, styles[style]);
                }
            }

            $tiles.find('.tile-inner').css({ position: "relative" });

            $tiles.find(".item").css({
                width: "100%",
                display: "none"
            });
        }

        var increaseLoadingProgress = function() {
            var perc = ++loadedTiles / totalTiles * 100;
            $loadingBar.css({
                width: perc + "%"
            });
            if (perc >= 100)
                $loadingBar.parent().fadeOut();
        }

        var loadImages = function (stack) {
            var $tile = $(stack.shift());
            if ($tile.data("type") == null || $tile.data("type") == "image") {

                var image = $tile.find(".item");
                var img = new Image();

                if (image.attr("width") && image.attr("height") && !plugin.settings.ignoreImageAttributes) {
                    assignImagesSize($tile);
                    entile($tile);
                    increaseLoadingProgress();
                    
                    //if(plugin.settings.captionBehavior != "always-visible")
	                //    assignHover($tile);
	                    
                    if (stack.length > 0)
                        loadImages(stack);
                    else
                    	animateTiles = true;
                } else {

                    img.onload = function () {
                        $tile.find(".item")
                                .data("width", this.width * plugin.settings.imageSizeFactor)
                                .data("height", this.height * plugin.settings.imageSizeFactor);
                        assignImagesSize($tile);
                        entile($tile);
                        increaseLoadingProgress();
                        
                        //if(plugin.settings.captionBehavior != "always-visible")
		                //    assignHover($tile);
                        
                        if (stack.length > 0)
                            loadImages(stack);
                        else
	                    	animateTiles = true;
                    };
                    img.onerror = function () {
                        assignImagesSize($tile);
                        entile($tile);
                        increaseLoadingProgress();
                        
                        //if(plugin.settings.captionBehavior != "always-visible")
		                //    assignHover($tile);
                        
                        if (stack.length > 0)
                            loadImages(stack);
                    };

                    img.src = image.attr("src");
                }

            } else {
                assignImagesSize($tile);
                entile($tile);
                increaseLoadingProgress();
                //assignHover($tile);
                if (stack.length > 0)
                    loadImages(stack);
            }
        }

        var preloadImages = function ($tiles) {
            var preloadStack = [];
            $tiles.each(function (i, tile) {
                preloadStack.push(tile);
            });

            loadImages(preloadStack);
        }

        var assignHover = function ($tile) {
            var $caption = $tile.find(".caption");

            if ($caption.length > 0) {
                $caption.css({
                    position: "absolute",
                    width: "100%",
                    height: "100%"
                });
                var props = {
                    enter: {},
                    leave: {}
                };
                
                props.enter.opacity = plugin.settings.captionBehavior == 'hidden' ? 1 : 0;
                props.leave.opacity = props.enter.opacity == 1 ? 0 : 1;
                
                $tile.mouseenter(function () {
                	switch (plugin.settings.hoverEffect) {
	                    default:
	                    case "fade":
	                        $caption.css({
	                            left: 0,
	                            top: 0
	                        });
	                        break;
	                    case "slide-top":
	                        var topShown = 0;
	                        var topHidden = 0 - $tile.find(".tile-inner").data('height');
	
	                        $caption.css({
	                            left: 0,
	                            top: plugin.settings.captionBehavior == 'hidden' ? topHidden : topShown
	                        });
	
	                        props.enter.top = plugin.settings.captionBehavior == 'hidden' ? topShown : topHidden;
	                        props.leave.top = plugin.settings.captionBehavior == 'hidden' ? topHidden : topShown;
	
	                        break;
	                    case "slide-bottom":
	                        var bottomShown = 0;
	                        var bottomHidden = 0 - $tile.find(".tile-inner").data('height');
	
	                        $caption.css({
	                            left: 0,
	                            bottom: plugin.settings.captionBehavior == 'hidden' ? bottomHidden : bottomShown
	                        });
	
	                        props.enter.bottom = plugin.settings.captionBehavior == 'hidden' ? bottomShown : bottomHidden;
	                        props.leave.bottom = plugin.settings.captionBehavior == 'hidden' ? bottomHidden : bottomShown;
	                        
	                        break;
	                    case "slide-left":
	                        var leftShown = 0;
	                        var leftHidden = 0 - $tile.find(".tile-inner").data('width');
	
	                        $caption.css({
	                            left: plugin.settings.captionBehavior == 'hidden' ? leftHidden : leftShown,
	                            top: 0
	                        });
	
	                        props.enter.left = plugin.settings.captionBehavior == 'hidden' ? leftShown : leftHidden;
	                        props.leave.left = plugin.settings.captionBehavior == 'hidden' ? leftHidden : leftShown;
	
	                        break;
	                    case "slide-right":
	                        var rightShown = 0;
	                        var rightHidden = 0 - $tile.find(".tile-inner").data('width');
	
	                        $caption.css({
	                            right: plugin.settings.captionBehavior == 'hidden' ? rightHidden : rightShown,
	                            top: 0
	                        });
	
	                        props.enter.right = plugin.settings.captionBehavior == 'hidden' ? rightShown : rightHidden;
	                        props.leave.right = plugin.settings.captionBehavior == 'hidden' ? rightHidden : rightShown;
	
	                        break;
	                }
                    $caption.css('display', 'block');
                    $caption.animate(props.enter,
                            plugin.settings.hoverEffectDuration,
                            plugin.settings.hoverEasing,
                            function () { });
                });
                $tile.mouseleave(function () {                
                    $caption.animate(props.leave,
                            plugin.settings.hoverEffectDuration,
                            plugin.settings.hoverEasing,
                            function () { });
                });
            }
        }

        var assignImagesSize = function ($tiles) {
            $tiles.each(function () {
                var size = {};
                var $item = $(this).find(".item");
                if ($(this).data("type") == null || $(this).data("type") == "image") {
                    if ($item.attr("width")) {
                        size = {
                            width: parseInt($item.attr("width")),
                            height: parseInt($item.attr("height"))
                        }
                    } else {
                        $item.show();
                        size = {
                            width: $item.data("width"),
                            height: $item.data("height")
                        };
                    }
                    $item.hide();
                }
                if ($(this).data("type") == "video") {
                    size = {
                        width: parseInt($(this).find("iframe").attr("width")),
                        height: parseInt($(this).find("iframe").attr("height")),
                    }
                }

                //if (size.width < plugin.settings.minTileWidth) {
                //    //w : h = w1 : h1 => h1 = h * w1 / w
                //    size.height = size.height * plugin.settings.minTileWidth / size.width;
                //    size.width = plugin.settings.minTileWidth;
                //}
                $item.data("size", size);
            });
        }

        var entile = function ($tiles) {
            if (!grid)
                grid = new Grid(plugin.settings.gridCellSize, plugin.settings.margin, plugin.settings.minTileWidth, $element.width());

            var transition = animateTiles ? "all .5s" : "none";

            $tiles.css({
                transition: transition
            });
            $tiles.find(".item").css({
                display: "block"
            });

            $tiles.each(function () {
                if ($(this).hasClass("ftg-hidden"))
                    return;

                $(this).show();
                var size = $(this).find(".item").data("size");

                var slot = grid.insert(
                        size.width + plugin.settings.margin,
                        size.height + plugin.settings.margin,
                        plugin.settings.allowEnlargement);

                $(this).data("enlarged", slot.enlarged);

                $(this).find(".caption").css({
                    width: "100%"
                });

                var top = slot.cell_size * slot.position.y;
                var height = slot.cell_size * slot.blocks.v;

                var tileWidth = slot.cell_size * slot.blocks.h - plugin.settings.margin;
                var tileHeight = slot.cell_size * slot.blocks.v - plugin.settings.margin;

                if (top + tileHeight > maxHeight)
                    maxHeight = top + height + plugin.settings.margin;


                $element.find(".ftg-items").height(maxHeight);

                if (supportsTransitions() || !animateTiles) {
                    $(this).css({
                        top: top,
                        left: slot.cell_size * slot.position.x,
                        width: slot.cell_size * slot.blocks.h,
                        height: height
                    }, 500);
                    $(this).find('.tile-inner').css({
                        display: "block",
                        overflow: "hidden"
                    }).css({
                        width: tileWidth,
                        height: tileHeight
                    })
                    .data("width", tileWidth)
                    .data("height", tileHeight);                    
                } else {
                    $(this).animate({
                        top: top,
                        left: slot.cell_size * slot.position.x,
                        width: slot.cell_size * slot.blocks.h,
                        height: height
                    }, 500);
                    $(this).find('.tile-inner').css({
                        display: "block",
                        overflow: "hidden"
                    }).animate({
                        width: tileWidth,
                        height: tileHeight
                    })
                    .data("width", tileWidth)
                    .data("height", tileHeight);
                }

                $element.find(".ftg-items").height(maxHeight);				
            });           
            $tiles.find("img.item").each(function (i, item) {                
                var $item = $(item);

                var size = $item.data("size");

                $item.css({
                    marginTop: 0,
                    marginLeft: 0,
                    width: "100%",
                    display: "block",
                    fontSize: 10, //against weird rules in some reset.css
                    margin: "auto",
                    maxWidth: "9999em"
                });                

                //TODO aspect ratio parent > aspect ratio img ?
                var ratioImg = size.width / size.height;
                var ratioTile = $item.parent().data("width") / $item.parent().data("height");

                if ($item.parent().parent().data("enlarged") && !plugin.settings.allowEnlargement) {
                    $item.css({
                        height: $item.parent().data("height"),
                        width: size.width,
                        marginTop: 0
                    });
                }

                else if (ratioImg == ratioTile) {
                    $item.css({
                        width: $item.parent().data("width"),
                        height: $item.parent().data("height")
                    });
                    $item.attr("case", "0");
                    return;//continue $.each loop
                }

                else if (ratioImg >= ratioTile) {
                    $item.css({
                        width: "auto",
                        height: $item.parent().data("height")
                    });

                    $item.attr("case", "2");

                    var diff = $item.width() - $item.parent().data("width");
                    $item.css("margin-left", diff / -2);
                } else {

                    //ratioImg < ratioTile
                    $item.css({
                        width: $item.parent().data("width"),
                        height: "auto"
                    });

                    $item.attr("case", "4");

                    var diff = $item.height() - $item.parent().data("height");
                    $item.css("margin-top", diff / -2);
                }

            });
            $tiles.each(function () {
                var el = $(this);
                if (el.visible(true)) {
                    el.addClass("already-visible");
                }
            });
            //animateTiles = true;
            //grid.print();

            currentWidth = $element.width();
            if (!completed) {
                completed = true;
                plugin.settings.onComplete.call(plugin);
            } else {
                plugin.settings.onUpdate.call(plugin);
            }

            isLoading = false;
            plugin.hideLoading();
        }

        plugin.init();
    }

    $.fn.finalTilesGallery = function (options) {
        return this.each(function () {
            if (undefined == $(this).data('finalTilesGallery')) {
                var plugin = new $.finalTilesGallery(this, options);
                $(this).data('finalTilesGallery', plugin);
            }
        });
    }
})(jQuery);
