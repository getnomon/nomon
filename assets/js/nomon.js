/*
# NAME: nomON.js
# AUTHOR: Evan Cohen
# DATE: September 2012
# USAGE: Powers the mighty application known as nomON
# REQUIREMENTS: Extreme hunger
*/

$(function() {
	var isMobile = navigator.userAgent.match(/(iPhone|iPod|iPad|Android|BlackBerry|webOS)/);
	var pathname = $(location).attr('pathname');
	//Capture click/taps

	//This is app specific code
	if(pathname == '/app'){
        $('.masthead').css('height', '30px');
        $('.mini-logo').hide();
        //Hide rest of page inicially
        $('#price, #allergies, #pay, #thanks, #review').hide();

        $('.btn').not('#location').on('click', function(){
            console.log("ID: "+$(this).attr('id'));
            if($(this).attr('id') == "getnomon"){
                $.get(geoValidate($('#address').val())).done(function(data) { 
                    //got data, now what?
                    console.log(data);
                }).fail(function(){ alert('Could not validate address.'); return false;});
            }
            var target = $(this).attr('href').substr(1);
            console.log('Target: ' + target);
            //hide all
            if(target != ''){
                $('#index, #price, #allergies, #pay, #thanks, #review').hide();
                $('.masthead').css('height', '55px');
                $('.mini-logo').show();
                $('#'+target).show();
            }
        	return false;
        });

        $('#getnomon').on('click', function(){
            //validate address! 
            //We might want to keep this somwhere on the page so the user knows
            //if they want to change it... And we could display the number of
            //restaurants delivering along side it. Maybe in a menu? Could be red 
            //top menu (which ties in with button collor). This menu would also let
            //the user navagete back and forth on the pages.

        });

        $('.mini-logo a').on('click', function(){
    		$('#price, #allergies, #pay, #thanks, #review').css('display', 'none');
    		$('.masthead').css('height', '30px');
    		$('.mini-logo').hide();
    		$('#index').show();
    		return false;
        });

    }else{
    	//Non App Code
    	$("a").on('click', function (event) {
			if($(this).attr("target") != "_blank" ||"_external"){
			    event.preventDefault();
			    window.location = $(this).attr("href");
		    }
		});
    }

    //Genaric Cross app/web code

	$('#location').on('click', function(){
		navigator.geolocation.getCurrentPosition(getLocation, getLocationFail, {enableHighAccuracy: true});
    });

    if(pathname != '/' && pathname != '/test' && pathname != "/app"){
        $('.masthead').css('height', '55px');
        $('.mini-logo').css('display', 'inline-block');
    }

    function getLocation(location){
    	$.get(geoURL(location)).done(function(data) { 
			$('#address').val(data.results[0].formatted_address);
		}).fail(function(){ alert('Could not find your location.');});
    }

    function getLocationFail(location){
    	alert('Could not find you! Make sure location services are enabled for nomON.');
    }

    function geoURL(location){
    	return 'https://maps.googleapis.com/maps/api/geocode/json?latlng='+
				location.coords.latitude+','+location.coords.longitude+
				'&sensor='+((isMobile) ? 'true' : 'false');
    }

    function geoValidate(address){
        http://maps.googleapis.com/maps/api/geocode/json?address=1600+Amphitheatre+Parkway,+Mountain+View,+CA&sensor=true_or_false
        return 'https://maps.googleapis.com/maps/api/geocode/json?address='+
                address+'&sensor='+((isMobile) ? 'true' : 'false');
    }

    resizeTitle();
    $(window).resize(function() {
  		resizeTitle();
	});

	function resizeTitle(){
		size = window.innerWidth/6;
		fontSize = (size > 82) ? 82 + 'px':  size + 'px';
		$('h1.title-front').css('font-size', fontSize);
	}
 

});