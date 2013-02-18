<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once("/php/lib/tambermethods.php");

if($_POST["artist-name"]) {
	$matches = lastfmArtistNameQuery($_POST["artist-name"]);
	$s->assign("matches", $matches);	
}

else {
	echo "Some error";
}



?>