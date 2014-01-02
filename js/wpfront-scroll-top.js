/*
 WPFront Scroll Top Plugin
 Copyright (C) 2013, WPFront.com
 Website: wpfront.com
 Contact: syam@wpfront.com
 
 WPFront Scroll Top Plugin is distributed under the GNU General Public License, Version 3,
 June 2007. Copyright (C) 2007 Free Software Foundation, Inc., 51 Franklin
 St, Fifth Floor, Boston, MA 02110, USA
 
 */

(function() {
    var $ = jQuery;

    window.wpfront_scroll_top = function(data) {
        var container = $("#wpfront-scroll-top-container").css("opacity", 0);

        var css = {};
        switch (data.location) {
            case 1:
                css["right"] = data.marginX + "px";
                css["bottom"] = data.marginY + "px";
                break;
            case 2:
                css["left"] = data.marginX + "px";
                css["bottom"] = data.marginY + "px";
                break;
            case 3:
                css["right"] = data.marginX + "px";
                css["top"] = data.marginY + "px";
                break;
            case 4:
                css["left"] = data.marginX + "px";
                css["top"] = data.marginY + "px";
                break;
        }
        container.css(css);

        if (data.button_width == 0)
            data.button_width = "auto";
        else
            data.button_width += "px";
        if (data.button_height == 0)
            data.button_height = "auto";
        else
            data.button_height += "px";
        container.children("img").css({"width": data.button_width, "height": data.button_height});

        $(window).scroll(function() {
            if ($(this).scrollTop() > data.scroll_offset) {
                container.stop().show().fadeTo(data.button_fade_duration, data.button_opacity);
            } else {
                container.stop().fadeTo(data.button_fade_duration, 0, function() {
                    container.hide();
                });
            }
        });

        container
                .hover(function() {
                    $(this).css("opacity", 1);
                }, function() {
                    $(this).css("opacity", data.button_opacity);
                })
                .click(function() {
                    $("html, body").animate({scrollTop: 0}, data.scroll_duration);
                    return false;
                });
    };
})();