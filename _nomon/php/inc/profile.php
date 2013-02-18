<?php
#Profile page
require_once("php/lib/backend.php");

$facebook = $GLOBALS['facebook']; 
$user = $GLOBALS['user'];

if(!$user) {
	header( 'Location: /' );
}

$fbProfile = $GLOBALS['profile'];
$fid = $fbProfile['id'];

/* Generate profile list */
if(!file_exists("profiledata/" . $fid . "-list.txt")){
	// Generate the /me page too
	
	$like = $facebook->syncUserWithTamber();
	/* Code underneath is copied from writeme.php we eventually will just want a backend method to write to the txt file */
	
	if(file_exists("userloc/" . $fid . ".txt")) {
		$file = fopen("userloc/" . $fid . ".txt", "r");
		$location = fgets($file);
	}
	else {
			
		if(!isset($fbProfile["location"]["name"]))
		{ 
			error("Cannot process location; assuming San Francisco"); 
			$location = "San Francisco, California";
		}
		else {
			$location = $fbProfile["location"]["name"];
		}
	}
	
	$iLike = trim(implode("/AND/", $like));
	call_backend("MUSR" , $fid . "/AND/" . $location . "/AND/" . $iLike);
	header( 'Location: http://tambermusic.com/profile' );
}

$s->assign("name", $fbProfile['first_name'] . " " . $fbProfile['last_name']);
$s->assign("profilePicture", "https://graph.facebook.com/" . $fid . "/picture");

/* Begin the formatting */
$formattedConcerts = "<table class='table'><tbody>";
$artistFanFormat = "";


/* Load artists */
if(file_exists("profiledata/" . $fid . "-list.txt")){

	$list = explode("/AND/", file_get_contents("profiledata/$fid" . "-list.txt"));

	for($i = 0; $i < count($list); $i++){
		if($list[$i]!=""){
			$artist = $list[$i];
			$artistLink = "/artist/" . urlencode($artist);
			$sanitizedArtist = htmlspecialchars($artist, ENT_QUOTES);
			$artistFanFormat .= 
				"<span class='label hideable' fid='$fid' name='" . $sanitizedArtist . "'><i class='icon-remove icon-white'></i> <a href='$artistLink' alt='artist profile'>" . $artist . "</a></span> ";
		}
	}
}
$s->assign("fanList", $artistFanFormat);

$artistDislikeFormat = "";

if(file_exists("userdata/$fid" . ".json")){
	
	$data = json_decode(file_get_contents("userdata/$fid" . ".json"),true);
	$dislikes = $data["disliked-artist"];
	
	for($i = 0; $i < count($dislikes); $i++ ){
		if($dislikes[$i]!=""){
			$dislike = $dislikes[$i];
			$dislikeLink = "/artist/" . urlencode($dislike);
			$sanitizedDislike = htmlspecialchars($dislike, ENT_QUOTES);
			$artistDislikeFormat .= 
				"<span class='label hideable' fid='$fid' name='" . $sanitizedDislike . "'><i class='icon-remove icon-white'></i> <a href='$dislikeLink' alt='artist profile'>" . $dislike . "</a></span> ";
		}
	}
}
$s->assign("dislikeList", $artistDislikeFormat);

/* Load concerts */
if(file_exists("profiledata/" . $fid . ".json" )) {
	
	$profilePage = json_decode(file_get_contents("profiledata/" . $fid . ".json"), true);
	
	if(!empty($profilePage['attending-concert'])){
		foreach($profilePage['attending-concert'] as $concert){
			$artistNames = explode('/AND/', $concert['artistNames']);
			$artistName = $artistNames[0];
			$concertDayOfWeek = $concert['concertDayOfWeek'];
			$concertDate = $concert['concertDate'];
			$concertMonth = $concert['concertMonth'];
			$concertTime = $concert['concertTime'];
			$concertVenue = $concert['concertVenue'];
			$venueLink = $concert['venueLink'];
			$venueCity = $concert['venueCity'];
			$venueCountry = $concert['venueCountry'];
			$ticketLink = $concert['ticketLink'];			
			$lowestPrice = $concert['lowestPrice'];
			$lastfmID = $concert['lastfmID'];
			$formattedConcerts = $formattedConcerts . 
				"<tr class='ticket-wide'>
						<td class='date-time'>
							<div class='date'>" . $concertMonth . $concertDate . "</div>
							<div class='day'>" . $concertDayOfWeek . "</div>
							<div class='time'>" . $concertTime . "</div>
						</td>
						<td class='name-loc'>
							<div class='artist'><a href='/artist/". urlencode($artistName) ."'>$artistName</a></div>
							<div class='name'>" . $concertVenue . "</div>
							<div class='city'>" . $venueCity . "</div>
						</td>
						
						<td class='plus-tix'>
								<a class='minus-concert' fid='$fid' lfid='$lastfmID'><div class='minus-medium'></div></a>";								
						
			if(isset($ticketLink) && $ticketLink != "") {
				$formattedConcerts = $formattedConcerts . 
					"<a href='" . $ticketLink . "' rel='no-follow' target='_blank'><div class='tix-medium'></div></a>
						</td>
					</tr>";
			}
			else {
				$formattedConcerts = $formattedConcerts . 
					"<div class='tix-medium-grey'></div>
						</td></tr>";
			}
		}
	}

	$formattedConcerts = $formattedConcerts . "</tbody></table>";
	$s->assign("formattedConcerts" , $formattedConcerts);
}
?>