<?php
/* if txt file exists read it */
if(file_exists("userloc/" . $profile["id"] . ".txt")) {
	$file = fopen("userloc/" . $profile["id"] . ".txt", "r");
	$location = fgets($file);
	fclose($file);
	$citystate = explode(',', $location);
	$s->assign("citystate", $citystate[0]);
}
/*else {
	require_once("php/lib/userxml.php");
	$userLoc = new userLoc($profile["id"]);
	$userLoc->addUserLocation($profile['location']['name']);
	$citystate = explode(',', $profile['location']['name']);
	$s->assign("citystate", $citystate[0]);
}*/
	$s->assign("logoutURL", $facebook->getLogoutUrl());
?>