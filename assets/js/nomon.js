/*
# NAME: nomON
# AUTHOR: Evan Cohen
# DATE: September 2012
# USAGE: Powers the mighty application known as nomON
# REQUIREMENTS: Extreme hunger
*/

$(function() {
	var isMobile = navigator.userAgent.match(/(iPhone|iPod|iPad|Android|BlackBerry|webOS)/);
	//Capture click/taps
	$("a").on('click', function (event) {
		if($(this).attr("target") != "_blank"){
		    event.preventDefault();
		    window.location = $(this).attr("href");
	    }
	});

	$('#location').on('click', function(){
		//http://maps.googleapis.com/maps/api/geocode/json?latlng=40.714224,-73.961452&sensor=true_or_false
		navigator.geolocation.getCurrentPosition(getLocation, getLocationFail);
    });

    if($(location).attr('pathname') != '/' && $(location).attr('pathname') != '/test'){
        $('.mini-logo').attr('style', 'display: inline-block');
    }

    function getLocation(location){
    	$.get('http://maps.googleapis.com/maps/api/geocode/json?latlng='+
				location.coords.latitude+','+location.coords.longitude+
				'&sensor='+((isMobile) ? 'true' : 'false'), function(data) {
			//console.log(data);
			//console.log('Formatted Address: ' + data.results[0].formatted_address);
			$('#address').val(data.results[0].formatted_address);
			alert('Is mobile: '+((isMobile) ? 'true' : 'false'));
			//$('.result').html(data);
			//alert('Load was performed.');
		});
    }

    function getLocationFail(location){
    	alert('Could not find your location...');
    }
});