<?php
function formatConcert($concert, $fid){
	$list = "";
	$artistNames = explode("/AND/", $concert['artistNames']);
	$name = $artistNames[0];
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
							
	//GET THE SONG
	$backendSong = explode('/AND/', call_backend("GTOS", $name));
	$songURL = $backendSong[0];						
						
	$names = explode("/AND/", $concert["artistNames"]);	
	$name = $names[0];
					
	$imageURL = getImageURL($name);
	if($imageURL == "/home/ubuntu/public_html/ev/img/error-dog.jpg"){
		$imageURL = "/img/error-dog.jpg";
	}
					
	$list = $list . 
	"<span class='span2 ticket-tall'>
		<div class='ticket-tall-upper'>
		<a href='/artist/" . urlencode($name) . "'>
		<div class='artist-img' style=\"background-image: url('$imageURL'); background-size: cover; height: 150px;\"></div>
		</a>";
			
	if($songURL != "0"){
		$songTitle = $backendSong[1];
		$list = $list . 
		"<div class='single-song'>
			<a href='$songURL' title='$songTitle' type='audio/mpeg' rel='nofollow'><img src='$imageURL' alt='' style='display:none' /></a>
		</div>";
	}
					
	$list = $list . 	
		"<div class='name'><a href='/artist/" . urlencode($name) . "'>" .$name ."</a></div>
		<div class='date'>". $concert["concertMonth"]. " ". $concert["concertDate"] ."</div>
		<div class='day'>". $concert["concertDayOfWeek"]."</div>
		<div class='venue'>". $concert["concertVenue"]. "</div>
		<div class='location'>". $concert["venueCity"]. "</div>
		</div><div class='ticket-tall-stub'>";
									
	$ticketLink = $concert["ticketLink"];
	if($ticketLink != ""){
			$list = $list . 
				"<a href='$ticketLink' rel='no-follow' target='_blank'>
				<div class='tix-src'><img src='/img/tix-medium.png'/></div></a>";
	}else{
		$list = $list . 
			"<div class='tix-src'><img src='/img/tixgrey-medium.png'/></div>";
	}
	$lastfmID = $concert["lastfmID"];
	$list = $list . 
		"<a class='plus-concert' fid='$fid' lfid='$lastfmID' artist='$name'><div class='plus-small'></div></a>"
		. "</div></span>";
	
	return $list;
}	


#Me page
$title = "For You";	
	
$user = $GLOBALS['user'];
	
if(!$user){
	header('Location: /');
}else{
	if(isset($_REQUEST['state'])){
		header('Location: /me');
	}
	$profile = $GLOBALS['profile'];
	$fid = $profile['id'];
	$s->assign("fid", $fid);
		
	if(!file_exists("userdata/" . $fid . ".json")) {
		require_once("php/lib/writeme.php");	
		writeMe($profile);
	}
		
	/*
	 * Read file;
	 */
	// some haxxx in case the php gets here too fast...
	if(!file_exists("userdata/$fid" . ".json")){
		header("Location: /generating/" . $fid);
	}
	if(file_exists("userdata/" . $fid . ".json")){
		$userdatastring = file_get_contents("userdata/" . $fid . ".json");
			
		if ($userdatastring == "Waiting..."){
				
			header("Location: /generating/" . $fid);
		}
		else {
			$title = "For You";
				
			/* Make our hash table interestedConcerts */
			$userPage =  json_decode(file_get_contents("userdata/". $fid  . ".json"),true);
				
			$suggestionList = "<div class='row row-tickets'>";
			$genericSuggestionList = "<div class='row row-tickets'>";
				
			$skip = false;
				
			if(!empty($userPage['suggested-concert'])){
				$headlineConcert = $userPage['suggested-concert'][0];
				$names = explode("/AND/", $headlineConcert["artistNames"]);	
				$nextName = $names[0]; 	
				$nextConcertDate = $headlineConcert["concertDayOfWeek"]." ". 	
				$headlineConcert["concertMonth"]. " " . $headlineConcert["concertDate"];	
				$nextConcertNameLoc = $headlineConcert["concertVenue"];
				$nextLfid = $headlineConcert["lastfmID"];
				

				$nextArtistLink = null;
				if($nextName != "No Suggestions For You"){
					$nextArtistLink = '/artist/' . urlencode($nextName);
				}

				$imageURL = getImageURL($nextName);
				if(isset($headlineConcert["ticketPrice"])) {
					$nextConcertTicketPrice = $headlineConcert["ticketPrice"];
				}else{
					$nextConcertTicketPrice = -1;
				}
				if(isset($headlineConcert["ticketLink"])) {
					$nextConcertTicketLink = $headlineConcert["ticketLink"];
				}else{
					$nextConcertTicketLink = "";
				}

				$skip = true;
			}
				
			else{
				$nextName = "No Suggestions For You";
				$nextConcertDate = "Try adding more artists you like";
				$nextConcertNameLoc = "Or change your location";
				$imageURL = "img/error-dog.jpg";
				$nextConcertTicketPrice = "-1";
				$nextConcertTicketLink = "none";
			}
				
			$s->assign("name", $nextName);	
			$backendTopSong = explode("/AND/", call_backend("GTOS", $nextName));
			$songURL = $backendTopSong[0];
			if($songURL != "0"){
			$songTitle = $backendTopSong[1];
			$topsong = 
			"<div class='song-wrapper'><div class='single-song'>
				<a href='$songURL' title='$songTitle' type='audio/mpeg' rel='nofollow'><img src='$imageURL' alt='' style='display:none' /></a>
			</div></div>";
			$s->assign("play", $topsong);
		}
			$s->assign("nextConcertDate", $nextConcertDate);	
			$s->assign("nextConcertNameLoc", $nextConcertNameLoc);
			$s->assign("nextConcertImage", $imageURL);
			$s->assign("nextConcertTicketPrice", $nextConcertTicketPrice);
			$s->assign("nextConcertTicketLink", $nextConcertTicketLink);
	
			if($nextName != "No Suggestions For You"){
				$s->assign("nextLink", '/artist/' . urlencode($nextName));
			}

			
			if(isset($nextLfid)){
				$s->assign("lfid", $nextLfid);
			}

			if(isset($nextArtistLink)){
				$s->assign("nextArtistLink", $nextArtistLink);
			}

			// Generic concerts first b/c easier
			if(!empty($userPage['generic-concert']))
			{
				foreach($userPage['generic-concert'] as $concert){
					$genericSuggestionList .= formatConcert($concert, $fid);
				}
			}
	
			$genericSuggestionList .= "</div>";
				
			foreach($userPage['suggested-concert'] as $concert){
				if(!$skip){
					$suggestionList .= formatConcert($concert, $fid);
					
				}
				else{
					$skip = false;
				}
				
			}
			$suggestionList = $suggestionList . "</div>";
			$s->assign('suggestionList', $suggestionList);
			$s->assign('genericSuggestionList', $genericSuggestionList);
		}
	}
}
?>