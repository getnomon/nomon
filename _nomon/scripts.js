// Evan Cohen
// Tamber Music
// This js file provides the js scripts for the artist,
// and possibly other pages in the future


var SIGNUP = "signup.php";
var CREATE = "create.php";
var MAIL = "mail.php";
var SETTINGS = "groceries/settings.php";

var container = $("container");

document.observe('dom:loaded', function () {	
	$("clean").observe("click", cleanDB);
	if($('body').width() < $('container').width()){
			$('container').width($('body').width());
	}
		
	/*$(window).resize(function() {
		$('#log').append('<div>Handler for .resize() called.</div>');
		$('body').width(screen.width);
		$(window).resize(function() {
			$('body').width(screen.width);
		});
	
		if($('body').height() < 417){
			$('body').height("417px")
		}
	});*/
});



function cleanDB(){
	new Ajax.Request("clean.php",
		{
		method: "get",
		onSuccess: clearComplete,
		onFailure: ajaxFailure,
		onException: ajaxFailure
		}
	);
}
function clearComplete(ajax){
	injectOutput(ajax, $("cleaned"));
}

function signUp(){
	new Ajax.Request(CREATE,
		{
		method: "post",
		parameters: {
			"name" : $("name").value, 
			"pass" : $("pass").value
		},
		onSuccess: createComplete,
		onFailure: ajaxFailure,
		onException: ajaxFailure
		}
	);
}

function saveSettings(){
	new Ajax.Request(SETTINGS,
		{
		method: "post",
		parameters: {
			"save" : "true",
			"title" : $("name").value, 
			"password" : $("pass").value
		},
		onFailure: ajaxFailure,
		onException: ajaxFailure
		}
	);
}

function createComplete(ajax){
	//saveSettings();
	injectOutput(ajax, $("innercontent"));
	getMail();
}

//Retreves the mail form
function getMail(){
	new Ajax.Request(MAIL,
		{
			method: "get",
			onSuccess: injectMail,
			onFailure: ajaxFailure,
			onException: ajaxFailure
		}
	);
}

//inject mail form
function injectMail(ajax){
	injectOutput(ajax, $("mailblock"));
}

function sendMail(){
	new Ajax.Request(MAIL,
		{
		method: "post",
		parameters: {
			"email" : $("email").value
		},
		onSuccess: mailSendComplete,
		onFailure: ajaxFailure,
		onException: ajaxFailure
		}
	);
}

function mailSendComplete(ajax){
	//var newurl = $("redirect").href();
	injectOutput(ajax, $("innerform"));
	$('sendmail').setStyle({ display: 'none' });
	/*setTimeout(function(){
		window.location.href = newurl;
	}, 3000); */
}
//Barf all responce text
function injectOutput(ajax, element) {
	if(ajax.responseText != ""){
		element.innerHTML = ajax.responseText;
	}
}

// provided Ajax failure code (displays error in "error" id tag in names.html)
function ajaxFailure(ajax, exception) {
	var alert = ("Error making Ajax request:" + 
		"\n\nServer status:\n" + ajax.status + " " + ajax.statusText + 
		"\n\nServer response text:\n" + ajax.responseText);
	if (exception) {
		throw exception;
	}
	$('errors').innerHTML = alert;
}