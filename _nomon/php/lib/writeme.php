<?php 
//require_once("fanlisttxt.php");
//require_once("makelocxml.php");
require_once("backend.php");

function writeMe($profile) {
		$fid = $profile["id"];
		
		$fh = fopen("userdata/" . $fid . ".json", 'w');
		fwrite($fh, "Waiting...");
		fclose($fh);
		
		$location = "San Francisco, California";
		
		
		if(!file_exists("profiledata/" . $fid . "-list.txt")){
	
			require_once("tamberfb.php");
			$facebook = new TamberFacebook();
			$facebook->getUser();
			$like =  $facebook->syncUserWithTamber();
		
		}
		else {
			//$fanList = new fanlist($fid);
			//$like = $fanList->getArtistList();
			$like = explode("/AND/", file_get_contents("profiledata/$fid" . "-list.txt"));
		}
		
		
		if(file_exists("userloc/" . $fid . ".txt")) {
			$file = fopen("userloc/" . $fid . ".txt", "r");
			$location = fgets($file);
		}
		else {
			if(!isset($profile["location"]["name"]))
			{ 
				error("Cannot process location; assuming San Francisco"); 
				$location = "San Francisco, California";
			}
			else {
				$location = $profile["location"]["name"];		
			}
		}
		
		if ($location == "") {
			error("Cannot process location; assuming San Francisco");
			$location = "San Fransisco, California";
		}
		
		/*	 
		 *  Generate location xml 
		 */	
		
		if(!file_exists("locdata/" . sanitize($location) . ".xml")){
			call_backend("MLOC", $location);	
		}
		
		/*
		 * Generate file
		 */

		
		

		$iLike = trim(implode("/AND/", $like));
		call_backend("MUSR" , $fid . "/AND/" . $location . "/AND/" . $iLike, False);	
}
?>