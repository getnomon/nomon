/*
# NAME: nomON.js
# AUTHOR: Evan Cohen
# DATE: September 2012
# USAGE: Powers the mighty application known as nomON
# REQUIREMENTS: Extreme hunger!
*/

$(function() {
	var isMobile = navigator.userAgent.match(/(iPhone|iPod|iPad|Android|BlackBerry|webOS)/);
	var pathname = $(location).attr('pathname');
    var add_comp = []; //address components
    var validates = true;
    var email = "";
    var password = "";
	//Capture click/taps

	//This is app specific code
	if(pathname == '/old-app'){
        $('.masthead').css('height', '30px');
        $('.mini-logo').hide();
        //Hide rest of page inicially
        $('.page').hide();
        $('#index').show();
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
                if(errorThrown.error != null){
                    console.log(errorThrown.error.text);
                    alert('Wrong username and/or password');
                }else{
                    alert('Check your internet connection');
                }
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

    $('#create-user').submit(function(){
        //Pass info to server and get session!
        //validate
        validates = true;
        email = $('#createEmail').val();
        password = $('#createPassword').val();

        console.log(validateEmail($('#createEmail').val()));
        if(!validateEmail($('#createEmail').val())){
            alert('You must enter a valid email'); validates = false;
        }else if($('#createPassword').val().length < 5){
            alert('Password Must be at least 5 characters'); validates = false;
        }else if($('#createfName').val() == ""){
            alert('Please enter your first name'); validates = false;
        }else if($('#createlName').val() == ""){
            alert('Please enter your last name'); validates = false;
        }else if($('#createAddress').val() == ""){
            alert('Please enter your last name'); validates = false;
        }else if($('#createPhone').val() == ""){
            alert('Please enter your last name'); validates = false;
        }
        
        //Create Account
        if(validates){
            $.ajax(api('r'), {
                type : 'post',
                dataType: "json",
                data: {
                    func  : 'macc',
                    email : email,
                    pass  : password,
                    fName : $('#createfName').val(),
                    lName : $('#createlName').val()
                }
            }).done(function(result){
                console.log(result);
                if(result.error != null){
                    console.log(result.error.text);
                    alert('Fill out the form completely!\n Emails must be valid and passwords must be at least 5 characters');
                    return false;
                }else{
                  console.log($('#address').val());
                  $.get(geoValidate($('#address').val())).done(function(data) { 
                        //got data, now what?
                        //console.log(data.results);
                        $.each(data.results[0].address_components, function(index, addr){
                            add_comp[addr.types[0]] = addr.short_name;
                        });
                        console.log(add_comp);
                        //make delivery request based on address
                        $.ajax(api('u'), {
                            type : 'post',
                            dataType: "json",
                            data: {
                                func : 'uaddr',
                                email: email,
                                pass : password,
                                addrNick : 'Home',
                                addr : add_comp.street_number+" "+add_comp.route,
                                addr2: '',
                                city : add_comp.locality,
                                state: add_comp.administrative_area_level_1,
                                zip  : add_comp.postal_code,
                                phone: $('#createPhone').val()
                            }
                        }).done(function(result){
                            console.log(result);
                            console.log('Now we should save this info to the database!');
                            $.ajax("/register.php", {
                                type : 'post',
                                dataType: "json",
                                data: {
                                    action : 'add',
                                    email: email,
                                    pass : password,
                                    addrNick : 'Home',
                                    addr : add_comp.street_number+" "+add_comp.route,
                                    addr2: '',
                                    city : add_comp.locality,
                                    state: add_comp.administrative_area_level_1,
                                    zip  : add_comp.postal_code,
                                    phone: $('#createPhone').val()
                                }
                            }).done(function(result){
                                console.log(result);
                                /*begin jank type population*/
                                alert('Thanks! Your account has been created :)');
                                console.log('Now we should save this info to the database!');
                            }).fail(function(jqXHR, textStatus, errorThrown){
                                alert('Something went wrong... Try again!');
                            });
                        }).fail(function(jqXHR, textStatus, errorThrown){
                            alert('Something went wrong... Try again!');
                        });
                    }).fail(function(jqXHR, textStatus, errorThrown){ 
                        alert('Could not validate address.'); 
                        return false;
                    });
                }
                
                //console.log('account created');
            }).fail(function(jqXHR, textStatus, errorThrown){
                console.log(errorThrown);
                    alert('Can not create an account. Please try again!');
            });
        }
        return false;
    });

    //Genaric Cross app/web code

	$('#location').on('click', function(){
		navigator.geolocation.getCurrentPosition(getLocation, getLocationFail, {enableHighAccuracy: true});
    });

    if(pathname != '/' && pathname != '/test' && pathname != "/old-app"){
        $('.masthead').css('height', '55px');
        $('.mini-logo').css('display', 'inline-block');
    }

    resizeTitle();
    $(window).resize(function() {
        resizeTitle();
    });

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

    function resizeTitle(){
        size = window.innerWidth/6;
        fontSize = (size > 82) ? 82 + 'px':  size + 'px';
        $('h1.title-front').css('font-size', fontSize);
    }

    function unique(array){
        return array.filter(function(el,index,arr){
            return index == arr.indexOf(el);
        });
    }

});

function api(type){
    return '/api-active.php?api=' + type;
}

function validateEmail(emailAddress) {
    var pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
    return pattern.test(emailAddress);
};