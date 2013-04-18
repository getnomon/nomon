<?php

require_once ("api/api.php");

$nomon = new nomon();

$GLOBALS['page'] = "";

function _generate($file){
	$GLOBALS['page'] .= file_get_contents('templates/' . $file . '.html');
}

function _renderPage(){
	print $GLOBALS['page'];
}


#Track state of user with cookies
/*
-Address
-User (double hashed )

*/

#Create a SECURE cookie
function bake($name, $value){
	setcookie($name, $value, 0, '/', 'getnomon.com', isset($_SERVER["HTTPS"]), true);
}

#This is for hashing sessionids
#ini_set('session.hash_function', 1);


?>