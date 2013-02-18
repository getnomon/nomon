<?php
#Profile page
require_once("php/soundboard/usercomments.php");

$fid = $arg[1];

// check if user exists
if(!file_exists("profiledata/$fid" . ".json")){
	// if it doesnt redirect
	header("Location: /");
	// Make error handling more fancy later
}

$graph = "https://graph.facebook.com/$fid";
$userdata = json_decode(file_get_contents($graph, 0, null),true);

$s->assign("name", $userdata['name']);
$title = $userdata['name'] . "'s Profile";
$s->assign("profilePicture", "$graph/picture");

$file = fopen("userloc/" . $fid . ".txt", "r");
$location = fgets($file);
fclose($file);
$s->assign("location", $location);

$artistFanFormat = "";


/* Load artists */
if(file_exists("profiledata/" . $fid . "-list.txt")){

	$list = explode("/AND/", file_get_contents("profiledata/$fid" . "-list.txt"));
	for($i = 0; $i < count($list); $i++){
		$artist = $list[$i];
		$artistLink = "/artist/" . urlencode($artist);
		$sanitizedArtist = htmlspecialchars($artist, ENT_QUOTES);
		$artistFanFormat = $artistFanFormat . 
		"<span class='label hideable' name='" . $sanitizedArtist . "'><a href='$artistLink' alt='artist profile'>" . $artist . "</a></span> ";
	}
	
}
$s->assign("fanList", $artistFanFormat);

// Get the users reviews:
require_once("php/lib/reviewscore.php");
require_once("php/soundboard/reviews.class.php");
$comments = getUserComments($fid);

$displayComments = "";

foreach($comments as $comment){
	
	$review = new Review($comment);
	
	$displayComments .= $review->format(); 
		
}
if($displayComments == ""){
	$displayComments = "No reviews written yet";
}
$s->assign("comments", $displayComments);
$s->assign("commentcount", count($comments));

		

if(isset($GLOBALS['user'])){
	$profile = $GLOBALS['profile'];
	$myfid = $profile['id'];
	$addFriend = '<a class="add-friend" fid="'. $myfid. '" friendfid="'. $fid .'">Add Friend</a>';
	$s->assign('addFriend', $addFriend);
}




?>


