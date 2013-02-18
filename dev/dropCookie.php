<?php
ini_set('display_errors',1); 
error_reporting(E_ALL);
 
echo "Calculating... ";

if(isset($_REQUEST['q']) && $_REQUEST['q'] == "remove"){
	setcookie("dev", null);
	echo "cookie removed, access revoked";
}elseif(isset($_REQUEST['q']) && $_REQUEST['q'] == "thu5rePuc9U26est"){
	setcookie("dev", true);
	echo "cookie dropped, access granted";
}else{
	echo "inproper access token, nuthin happens";
}
?>