<?php

require_once ("api.php");

$GLOBALS['page'] = "";

function _generate($file){
	$GLOBALS['page'] .= file_get_contents('templates/' . $file . '.html');
}

function _renderPage(){
	print $GLOBALS['page'];
}

?>