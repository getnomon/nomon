<?php
ini_set('display_errors',1); 
error_reporting(E_ALL);

/*Index file makes nomon HUNGRY*/
//Load Dependencies
//Get Moneyn
$DOMAINEXT = pathinfo($_SERVER['SERVER_NAME'], PATHINFO_EXTENSION);

#FORCE HTTPS
if((!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == "") && $DOMAINEXT != "dev") {
    $redirect = "https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    header("Location: $redirect");
}elseif ($DOMAINEXT == "dev") {
	#This is the dev server... Deal with it...
	$GLOBALS['dev'] = true;
}

require_once('smart.php');

/*
1. Start
2. Price
3. Allergies
*/
_generate('header');

if(isset($GLOBALS['dev']) && $GLOBALS['dev']){
	_generate('dev');
}

if(isset($_REQUEST['q'])){
	$q = explode('/', $_REQUEST['q']);
}else{
	$q[0] = 'index';
}

if ($q[0] == "old-app") {
	//This is the app, load all apropriate pages into DOM
	_generate('test'); //change to index later
	_generate('price');
	_generate('allergies');
	_generate('pay');
	_generate('thanks');
	_generate('review');	
	_generate('settings');
}else{
	//Website
	if (file_exists('templates/' . $q[0] . '.html')) {
		_generate($q[0]);
	}else{
		header("Status: 404 Not Found");
		_generate('404');
	}
}
_generate('footer');

//Output page to screen!
_renderPage();
?>