<?php 
require_once("lib/tamberfb.php");
require_once("lib/backend.php");

if(!empty($_POST["location"])){
	
		$facebook = new TamberFacebook();
	
		$location = $_POST["location"];

		$profile = $facebook->queryGraph("/me", null);
	
		//echo $profile["id"];
		
		call_backend("CLOC", $profile["id"] . "/AND/" . $location);
		echo "1";
}
else {
	echo "0";
}
?>