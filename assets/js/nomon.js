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