//============================================================================
// 
// Author      : Li, Yuan
// File        : main.js
// email       : yuan.li@student.emw.hs-anhalt.de
// Version     : 3.0
// Copyright   : All rights reserved by Anhalt University of Applied Sciences
// Description : 
//     Main Javascript for supporting foreend HTML pages. This script now only 
// defined the animation of "dropdown-menu".
//
//============================================================================

$(document).ready(function() {
	// trigged when mouse hovered over
	$('.navbar-nav .dropdown').hover(function() {
		// mouse hovered in
	  $(this).find('.dropdown-menu').first().stop(true, true).delay(250).slideDown();
	}, function() {
		// mouse hovered out
	  $(this).find('.dropdown-menu').first().stop(true, true).delay(100).slideUp()
	});
	// trigged when mouse hovered over
	$('.input-group-btn').hover(function() {
		// mouse hovered in
	  $(this).find('.dropdown-menu').first().stop(true, true).delay(250).slideDown();
	}, function() {
		// mouse hovered out
	  $(this).find('.dropdown-menu').first().stop(true, true).delay(100).slideUp()
	});
});

// get scrollbar width in order to recalculate the table-cell width
function getScrollbarWidth() {
    var outer = document.createElement("div");
    outer.style.visibility = "hidden";
    outer.style.width = "100px";
    document.body.appendChild(outer);

    var widthNoScroll = outer.offsetWidth;
    // force scrollbars
    outer.style.overflow = "scroll";

    // add innerdiv
    var inner = document.createElement("div");
    inner.style.width = "100%";
    outer.appendChild(inner);        

    var widthWithScroll = inner.offsetWidth;

    // remove divs
    outer.parentNode.removeChild(outer);

    return widthNoScroll - widthWithScroll;
}

// check whether the element has a scrollbar 
(function($) {
    $.fn.hasScrollBar = function() {
        return this.get(0).scrollHeight > this.height();
    }
})(jQuery);

// get current datetime or somedays before
function getDate(day) {
    var date = new Date();
    date.setDate(date.getDate()+day);
    return date.toISOString();
}

