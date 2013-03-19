/*
# NAME: nomON
# AUTHOR: Evan Cohen
# DATE: September 2012
# USAGE: Powers the mighty application known as nomON
# REQUIREMENTS: Extreme hunger
*/


$(function() {
	//Capture click/taps
	$("a").click(function (event) {
		if($(this).attr("target") != "_blank"){
		    event.preventDefault();
		    window.location = $(this).attr("href");
	    }
	});

    if($(location).attr('pathname') != '/' && $(location).attr('pathname') != '/test'){
        $('.mini-logo').attr('style', 'display: inline-block');
    }
});

if (navigator.userAgent.match(/iPhone/i) || navigator.userAgent.match(/iPad/i)) {
    var viewportmeta = document.querySelector('meta[name="viewport"]');
    if (viewportmeta) {
        viewportmeta.content = 'width=device-width, minimum-scale=1.0, maximum-scale=1.0';
        document.body.addEventListener('gesturestart', function () {
            viewportmeta.content = 'width=device-width, minimum-scale=0.25, maximum-scale=1.6';
        }, false);
    }
}