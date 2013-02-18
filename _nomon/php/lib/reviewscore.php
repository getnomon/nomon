<?php
/*
 * Review scores by Geoffrey
 * Table name will be artistname_scores 
 */


function displayRating($score) {
	$rating_index = array('1'=>'Thumbs Down', '2'=>'Okay', '3'=>'Good', '4'=>'Fantastic', '5'=>'Killed It' );	
	return $rating_index[$score];
}


/**
 * @param: $score the half-integer (out of 4) of stars to display
 * @param: $aggregate set to true if we are passing a float in general and not an exact half-integer
 */
function drawStars($score, $aggregate = true) {
	
	$star_display = "<div class='str-src'>";
	
	if($aggregate === true){
		// The number of half stars cast as an int 
		// TODO: (check rounding errors)
		$score = round($score * 2); 
		
		$score = (float) $score/2; 
		// Guaranteed now that $score is a half integer
	}
	
	// explode the score at decimal so we can read the integer and fractional parts
	$decimal_rep = explode(".", (string)$score);
	
	$integer_part = $decimal_rep[0];
	
	for($i = 1; $i <= 5; $i++) {
		
		// display filled in star if the rating exceeds the current position of the star
		if($i <= (int)$integer_part) {
			$star_display = $star_display . "<img src='/img/str-large.png'/>";
		}
		
		// if we've already displayed enough filled in stars, check if we need to display half a filled in one
		else {
			if(isset($decimal_rep[1]) && (int) $decimal_rep[1] != 0) {
				$star_display = $star_display . "<img src='/img/str-largehalf.png'/>";
				unset($decimal_rep[1]);
			}
			else {
				$star_display = $star_display . "<img src='/img/gstr-large.png'/>";	
			}			
		}
		
	}
	$star_display = $star_display . "</div>";
	
	return $star_display;
}

function getAggregate($artist) {
	if(isset($GLOBALS['tamberConnection'])){
		$tc = $GLOBALS['tamberConnection'];
	}
	else {
		require_once("tamberconnect.php");
		$tc = new TamberConnection;
	}
	$scores = $tc->query("SELECT * FROM commentator_comments WHERE page='$artist'");
	$i = (float) 0;
	$j = (float) 0;
	if($scores->num_rows > 0) {
		while($row = $scores->fetch_object()) {
			if(isset($row->rating)) {
				$i += 1;
				$j += $row->rating;
			}
		}
		return (float) $j/$i;
			
	}
	else {
		return -1;
	}
}	

?>