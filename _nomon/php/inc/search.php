<?php
//error_reporting(E_ALL);
//ini_set('display_errors', '1');

require_once("php/lib/backend.php");
// TO MOTHERFUCKIN' DO:
// cancel the native submit with return false; and
// $(form).on('submit', function() { redirect to /artist/queryname }
// and also this way you can send the GET async for speed
if($_POST["artistName"]) {
  $artistName = $_POST["artistName"];
  $matches = explode("/AND/", call_backend("SRCH", $artistName));
  $matchArray = array();
  $rest = False;
  $matchID = 0;
  foreach ($matches as $match) {
  	if ($matchID >= 4) break;
    $matchID++;
    if(true){
	    if ($rest == False) {
	    	$rest = True;
	    	$img = getImageUrl($match);
		    if (strpos($img, "error-dog.jpg")) {
		      $img = "NONE";
		    }
	    } else {
	    	$img = "NONE";
	    }
	    $info = lastfmArtistInfoQuery($match);
	    $bio = $info["bio"];
	    $bioSummary = $bio["summary"];
	    $bioContent = $bio["content"];
	    if ($bioSummary == "" or $bioContent == "") {
	      $bioSummary = "No description available.";
	      $bioContent = "";
	    }
	    $tmp = array("matchName"=>$match, 
			 "matchImageLink"=>$img,
			 "matchID"=>$matchID,
			 "matchBioSummary"=>$bioSummary,
			 "matchBioContent"=>$bioContent);
	    
	    array_push($matchArray, $tmp);	
	  }
  }

$s->assign("matches", $matchArray);
}

else {
	echo "Some error";
}



?>
