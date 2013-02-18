<?php

/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     function.checklogin.php
 * Type:     function
 * Name:     checklogin
 * Purpose:  checks if we are logged into facebook for the menu button
 * -------------------------------------------------------------
 */

function smarty_function_checklogin($params, Smarty_Internal_Template $template) {
	$facebook = $GLOBALS['facebook'];
	$user = $facebook->getUser();	
	
	/* We are not logged in, print the login url */
	if(!isset($user)) {
		$loginurl = $facebook->getLoginUrl(array('scope'=>'user_likes, friends_likes, user_location', 
									'redirect_uri'=>'http://tambermusic.com/me',
									'display'=>'page'));
		return '<a id="login" href="' . $loginurl . '"><h4>Login</h4></a>';
		
	}else{/* We are logged in, print the logout url */
		$logouturl = $facebook->getLogoutUrl();
		return '<a id="logout" href="'. $logouturl. '"><h4>Logout</h4></a>';
	}
}
