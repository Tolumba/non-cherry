/*add event*/
jQuery(window).bind("resize", height_handler).bind("load", height_handler)
function height_handler() {

    jQuery(".maxheight").equalHeights();

    if (jQuery(window).width() > 767) {
        jQuery(".maxheight1").equalHeights();
    } else {
        jQuery(".maxheight1").css({'height': 'auto'});
    }

    if (jQuery(window).width() > 767) {
        jQuery(".maxheight2").equalHeights();
    } else {
        jQuery(".maxheight2").css({'height': 'auto'});
    }

    if (jQuery(window).width() > 767) {
        jQuery(".maxheight3").equalHeights();
    } else {
        jQuery(".maxheight3").css({'height': 'auto'});
    }
}
/*glob function*/
(function ($) {
    $.fn.equalHeights = function (minHeight, maxHeight) {
        tallest = (minHeight) ? minHeight : 0;
        this.each(function () {
            if ($(">.box_inner", this).outerHeight() > tallest) {
                tallest = $(">.box_inner", this).outerHeight()
            }
        });
        if ((maxHeight) && tallest > maxHeight) tallest = maxHeight;
        return this.each(function () {
            $(this).height(tallest)
        })
    }
})(jQuery)
