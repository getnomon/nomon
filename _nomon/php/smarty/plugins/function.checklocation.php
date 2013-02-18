<?php

/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     function.checklocation.php
 * Type:     function
 * Name:     checklocation
 * Purpose:  checks for the user's location
 * -------------------------------------------------------------
 */

function smarty_function_checklocation($params, Smarty_Internal_Template $template) {
	$facebook = $GLOBALS['facebook'];
	$user = $facebook->getUser();	
	
	/* We are not logged in, print the location */
	if(!isset($user)) {
		return 'Your Location';
	}
	/* We are logged in, print the location - prioritize the xml file */
	if(isset($user)) {
		
		$profile = $facebook->queryGraph("/me", null);
		
		/* if txt file exists read it */
		if(file_exists("userloc/" . $profile["id"] . ".txt")) {
			$file = fopen("userloc/" . $profile["id"] . ".txt", "r");
			$location = fgets($file);
			fclose($file);
			$citystate = explode(',', $location);
			return $citystate[0];
		}
		/* if not make the file*/
		else {		
			require_once("php/lib/userxml.php");
			$userLoc = new userLoc($profile["id"]);
			$userLoc->addUserLocation($profile['location']['name']);
			$citystate = explode(',', $profile['location']['name']);
			return $citystate[0];
		}
	}
}
