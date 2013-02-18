<?php
ini_set('display_errors',1); 
error_reporting(E_ALL);

/*Index file makes nomon HUNGRY*/
//Load Dependencies
//Get Money

#FORCE HTTPS
if(!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == ""){
    $redirect = "https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    header("Location: $redirect");
}

require_once('smart.php');
/*
1. Start
2. Price
3. Allergies
*/
_generate('header');

if(isset($_REQUEST['q'])){
	$q = explode('/', $_REQUEST['q']);
}else{
	$q[0] = '';
}

switch ($q[0]) {
	case '': //Start
		_generate('index');
		break;
	case 'test': //Start
		_generate('test');
		break;
	case 'about':
		_generate('about');
		break;
	case 'price':
		_generate('price');
		break;
	case 'allergies':
		_generate('allergies');
		break;
	case 'pay':
		_generate('pay');
		break;
	case 'thanks':
		_generate('thanks');
		break;
	case 'review':
		_generate('review');
		break;
	default:
		header("Status: 404 Not Found");
		_generate('404');
		break;
}

_generate('footer');

//Output page to screen!
_renderPage();
?>