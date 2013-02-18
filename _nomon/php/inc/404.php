<?php
#404 PAGE
#RULES: This file is included after the old template variable is assigned
header("HTTP/1.0 404 Not Found");
$template = "404";
$title = "Error 404";

if(isset($arg[0]) && $arg[0] == "artist"){
	if(isset($arg[1])){
		$s->assign("artist", $arg[1]);
	}
}elseif(isset($arg[0]) && $arg[0] == "404"){
	$s->assign("page", $arg[0]);
}else{
#This is the 404 page
}
?>