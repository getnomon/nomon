<?php
# logout.php - Evan Cohen
# Makes sure the user is properly logged out of facebook, and then redirects to the homepage.

include_once('php/lib/tamberfb.php');

$logoutFB = new TamberFacebook();

$tamberFB = $logoutFB->getFacebook();
#Ensures that facebook's session has destroyed!
$tamberFB->destroySession();

setcookie('fbs_259718464093079', '', time()-100, '/', 'tambermusic.com');
session_destroy();
header('Location: /');
?>