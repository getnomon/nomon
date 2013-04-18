<?php

require_once ("api.php");

$GLOBALS['page'] = "";

function _generate($file){
	$GLOBALS['page'] .= file_get_contents('templates/' . $file . '.html');
}

function _renderPage(){
	print $GLOBALS['page'];
}


#Track state of user with cookies

#Create a SECURE cookie
function bake($name, $value){
	setcookie($name, $value, 0, '/', 'getnomon.com', isset($_SERVER["HTTPS"]), true);
}

?>