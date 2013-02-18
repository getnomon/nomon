<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once("../lib/tambermethods.php");

if($_POST["artist-name"]) {
	
	$matches = lastfmArtistNameQuery($_POST["artist-name"]);
	$s->assign("matches", $matches);

	foreach($matches->artist as $match) {
		if(!strstr($match->name, "/")) {
			echo '<a href="../artist/' . urlencode($match->name) . '">' 
			. $match->name . '</a>' .'</br>';
		}
	}
	
	
}

else {
	echo "Some error";
}



?>