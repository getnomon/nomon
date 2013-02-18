<?php
#Artist page
require_once("php/lib/backend.php");
require_once("php/lib/reviewscore.php");
//require_once("php/lib/youtube.php");
	
$facebook = $GLOBALS['facebook'];
$user = $GLOBALS['user'];

if($user) {
	$prof = $GLOBALS['profile'];
	$fid = $prof['id'];
	$s->assign("fid", $fid);
}

$query = $_SERVER['QUERY_STRING'];

if(strpos($query, "&")!= false || strpos($query, "%26")!= false){
	
	
	$query = str_replace("q=artist/", "", $query);
	$query = str_replace("+", " ", $query);

	$v = $query;
	
}
else{
	$v = $arg[1];
}


$explodedName = stripslashes($v);

if(!file_exists("xml/" . urlencode($explodedName) . ".json")){
	/* Check if we need to throw a 404 error */
	// Does artist exist on last.fm? if not throw error
			
	$name = trim(call_backend("FIND", $explodedName));
	if($name == "Unknown" || $name == ""){ include("php/inc/404.php"); }	
	else {

		// if artist does exist continue and redirect
		$artist = call_backend("MART", $name);
		header('Location: http://' . $_SERVER['SERVER_NAME'] . '/artist/' . urlencode($artist));
	}		
}else {
	
	/*
	 * Load from ev/xml/$v.xml if file does exist
	 */
	
	$nextConcertTicketLink = "none";
	$nextConcertTicketPrice = "-1";
	
	$thisPage = 
		json_decode(file_get_contents("xml/". urlencode($explodedName) . ".json"), true);
		
	$formattedConcert = "<table class='table'><tbody>";
	$load = true;
		
	$s->assign("name", $thisPage['artist-name']);
	$artist = $thisPage['artist-name'];
	$title = $artist;
		
	if($thisPage['profile-picture'] == "/home/ubuntu/public_html/ev/img/error-dog.jpg"){
		$s->assign("imageURL", "/img/error-dog.jpg");
	}
	else {
		$s->assign("imageURL", $thisPage['profile-picture']);
	}
		
	if(!empty($thisPage['concert'])){
		foreach($thisPage['concert'] as $concert){
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
			
			if(!isset($nextConcertDate) && !isset($nextConcertNameLoc)){
				$nextConcertDate = $concertMonth . " " . $concertDate;
				$nextConcertDayOfWeek = $concertDayOfWeek;
				$nextConcertVenue = $concertVenue;
				$nextConcertCity = $venueCity;
				$nextConcertLink = $venueLink;
				$nextConcertTicketLink = $ticketLink;
				$nextConcertTicketPrice = $lowestPrice;
				if(isset($fid) && isset($lastfmID)){
					$nextConcertPlus = "<a class='plus-concert plus-concert-large' fid='$fid' lfid='$lastfmID' artist='$artist'><img src='/img/plus-large.png' alt='add concert' /></a>";
				}
				$load = false;
			}
			if($load == true){
				$s->assign("nextConcertDayOfWeek", $nextConcertDayOfWeek);
				
				$formattedConcert = $formattedConcert . 
					"<tr class='ticket-wide'>
					<td class='date-time'>
						<div class='date'>". $concertMonth ." ". $concertDate. "</div>
						<div class='day'>" . $concertDayOfWeek . "</div>
						<div class='time'>" . $concertTime . "</div>
					</td>
					<td class='name-loc'>
						<div class='name'><a href='". $venueLink ."' rel='no-follow' target='_blank'>" . 
						$concertVenue . "</a></div>
						<div class='city'>" . $venueCity ."</div>
					</td>";
						
				if(isset($ticketLink) && $ticketLink != ""){
					$formattedConcert = $formattedConcert . 
						"<td class='plus-tix'>";
					if(isset($fid)) {
						$formattedConcert = $formattedConcert . "<a class='plus-concert' fid='$fid' lfid='$lastfmID' artist='$artist'><div class='plus-medium'></div></a>";
					}else {
						$formattedConcert = $formattedConcert . "<div class='plus-medium'></div>";
					}
						$formattedConcert = 
						$formattedConcert . "<a href='". $ticketLink. "'rel='no-follow' target='_blank'><div class='tix-medium'></div></a>
							</td></tr>";
					}else {
						$formattedConcert = $formattedConcert . 
							"<td class='plus-tix'>";
						if(isset($fid)) {
							$formattedConcert = $formattedConcert . "<a class='plus-concert' fid='$fid' lfid='$lastfmID' artist='$artist'><div class='plus-medium'></div></a>";
						}else {
							$formattedConcert = $formattedConcert . "<div class='plus-medium'></div>";
						}
						$formattedConcert = $formattedConcert . 							
							"<div class='tix-medium-grey'></div>
							</td></tr>";
					}
				
		
			}
			$load = true; 
		}
	}
		
	$formattedConcert = $formattedConcert . "</tbody></table>";
	$s->assign("concerts", $formattedConcert, true);
	
	
  	require_once('php/commentator/commentator.php');
  	$comments = new Commentator($artist, $artist."'s ". "Soundboard" , $artist);
						
	$commentSection = $comments->write();	
						
	$s->assign("comments", $commentSection, true);
	
	
	$isFan = "";
	if(isset($user)) {
		// Don't show fan artist if already fan'd
		$fanlist = explode("/AND/", file_get_contents("profiledata/$fid" . "-list.txt"));
		$data = json_decode(file_get_contents("userdata/$fid" . ".json"),true);
		$dislikes = $data["disliked-artist"];
		if(!in_array($artist,$fanlist) && !in_array($artist, $dislikes)){
			//User is a fan
			$fanButton = "<div id='fan-button' class='thumbs fan' fid='$fid' artist='$artist'><img src='/img/thumb-up.png' class='thumb'/> Fan</div>";
			$downButton = "<div id='thumbs-down' class='thumbs dislike' fid='$fid' artist='$artist'><img src='/img/thumb-down.png' class='thumb'/></div>";
		}elseif(in_array($artist, $dislikes)){
			//If already disliked
			$fanButton = "<div id='fan-button' class='thumbs fan translusent-red' fid='$fid' artist='$artist'><img src='/img/thumb-up.png' class='thumb'/> Fan</div>";
			$downButton = "<div id='thumbs-down' class='thumbs dislike downvoted' fid='$fid' artist='$artist'><img src='/img/thumb-down.png' class='thumb'/></div>";
		}else{
			//User is a fan
			$isFan = "<div class='is-fan'>Fan</div>";
			$fanButton = "<div id='fan-button' class='thumbs fan fanned' fid='$fid' artist='$artist' >Un-Fan</div>";
			$downButton = "<div id='thumbs-down' class='thumbs dislike' fid='$fid' artist='$artist' style='display: none'><img src='/img/thumb-down.png' class='thumb'/> </div>";
		}

		
	}else {
		$fanButton = ""; //<div calss='thumbs' id='fan-button'>Fan</div>";
		$downButton = "";
	}

	$s->assign("isFan", $isFan);
	$s->assign("fanButton", $fanButton);
	$s->assign("downButton", $downButton);

	if(!isset($nextConcertDate)){
		$nextConcertDate = "No Concerts Available";
		$nextConcertVenue = "Try again later...";
		$nextConcertCity = "";
			
	}
		
	
	$s->assign("nextConcertDate", $nextConcertDate);	
	$s->assign("nextConcertVenue", $nextConcertVenue);
	$s->assign("nextConcertCity", $nextConcertCity);
			
	$s->assign("nextConcertTicketLink", $nextConcertTicketLink);						
	$s->assign("nextConcertTicketPrice", $nextConcertTicketPrice);

	$s->assign("nextConcertPlus", $nextConcertPlus);
					
	
	
	$s->assign("aggStars", drawStars(getAggregate($artist)));
	
	
	#Lets handel that music shitnit!
	$playerOutput = "";
	
	
	if($thisPage['songs'] != null) {
		$songs = $thisPage['songs'];
	}

	if(isset($songs)){
	
		$playerOutput = "<div id='songLinks' style='display:none'>";
	
		for ($i=0; $i < count($songs); $i++) { 
			$song = $songs[$i];
	
			$songTitle = $song['title'];
			$songURL = $song['url'];
			$songImg = $thisPage['profile-picture'];
			$playerOutput .= "<div class='songTitle'>
				<a href='$songURL' title='" . htmlspecialchars($songTitle) ."' type='audio/mpeg' rel='nofollow'>
					<img src='$songImg' alt='' style='display:none' />
					<!--$songTitle-->
				</a>
			</div>";
		}
		$playerOutput .= "</div>";
	}
	
	//$playerOutput .= "<a href='/playlist/" . urlencode($explodedName) ."-playlist.xspf' type='application/xspf+xml' title='$explodedName'>My Favorite Playlist</a>";

	$s->assign("playerOutput", $playerOutput);
	$s->assign("YMPexpand", true);
	/*
	addScript('/d2/js/jquery.jplayer.min.js');
	addScript('/d2/js/jplayer.playlist.min.js');
	addScript('/js/player.js');
	*/

	$similarArtists = array();
	$sim = 0;
	$includeSimArtScript = false;
	$imageExists = true;
	foreach($thisPage['similar-artists'] as $artist){
		if($sim >= 4){break;}
		if(call_backend("MARQ", $artist['name']) == ""){
			$simImage = 'http://placehold.it/142x150';
			$includeSimArtScript = true;
			$imageExists = false;
		}else{
			$simImage = call_backend("IMAG", $artist['name']);
		}

		array_push($similarArtists, array("name"=>$artist['name'], "img"=>$simImage, "url"=>urlencode($artist["name"]), "imageExists"=>$imageExists));
		$sim += 1;
		$imageExists = true;
	}
	$s->assign("similarArtists", $similarArtists);

	if($includeSimArtScript){
		addScript('/js/getSimilarArtists.js');
	}

	$s->assign("thisIsTalse", true);
}
?>
