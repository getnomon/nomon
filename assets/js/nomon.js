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
    var add_comp = []; //address components
	//Capture click/taps

	//This is app specific code
	if(pathname == '/app'){
        $('.masthead').css('height', '30px');
        $('.mini-logo').hide();
        //Hide rest of page inicially
        $('.page').hide();
        $('#index').show();

        $('a, .btn').not('#location, .external').on('click', function(){
            buttonID = $(this).attr('id');
            if(buttonID == "getnomon"){
                if($('#address').val() == ""){
                    alert('Please enter your address');
                    return false;
                }else{
                    $.get(geoValidate($('#address').val())).done(function(data) { 
                        //got data, now what?
                        console.log(data.results);
                        $.each(data.results[0].address_components, function(index, addr){
                            add_comp[addr.types[0]] = addr.short_name;
                        });
                        console.log(add_comp);
                        //make delivery request based on address
                        $.ajax(api('r'), {
                            type : 'post',
                            dataType: "json",
                            data: {
                                func : 'dl',
                                addr : add_comp.street_number+" "+add_comp.route,
                                city : add_comp.locality,
                                state: add_comp.administrative_area_level_1,
                                zip  : add_comp.postal_code
                            }
                        }).done(function(result){
                            console.log(result.length);
                            $('#rest-count').text(result.length);
                            console.log(result);
                            randomRestaurant = result[Math.floor(Math.random()*result.length)];
                            console.log('Random restaurant: '+randomRestaurant.na);
                            $('#restaurant').text(randomRestaurant.na);
                        }).fail(function(jqXHR, textStatus, errorThrown){
                            alert('Could not find any restaurants :(');
                            console.log(textStatus);
                            console.log(errorThrown);
                        });
                    }).fail(function(jqXHR, textStatus, errorThrown){ 
                        alert('Could not validate address.'); 
                        return false;
                    });
                }
            }
            var target = $(this).attr('href').substr(1);
            //console.log('Target: ' + target);
            //hide all
            if(target != ''){
                $('.page').hide();
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

        $('#login-form').submit(function(){
            //Pass info to server and get session!
            //Authenticate user
            $.ajax(api('u'), {
                type : 'post',
                dataType: "json",
                data: {
                    api   : 'u',
                    func  : 'gacc',
                    email : $('#inputEmail').val(),
                    pass  : $('#inputPassword').val()
                }
            }).done(function(result){
                console.log(result);
                if(result.error != null){
                    //user is auth
                }else{
                    //boo boo fail
                }
            }).fail(function(jqXHR, textStatus, errorThrown){
                console.log(errorThrown);
                alert('Could not authenticate');
            });
            return false;
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

    //$('#rest-count').tooltip({placement:'bottom', trigger:'click'});

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

    function api(type){
        return '/api.php?api=' + type;
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