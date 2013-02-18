<?php
/*
 * Component of Soundboard v1.0
 */ 

/*
 * Handles all the review formatting and crap
 */

require_once("php/lib/reviewscore.php");
require_once("sbcontent.php");
class Review extends BoardContent
{
	/**
	 * @param: $sqlObject the objectified version of the sql row
	 */
	public function __construct($sqlObject){
		
		$this->page = $sqlObject->page;
		$this->name = $sqlObject->name;
		
		// LOL HACKY
		$this->venue = $sqlObject->email;
		
		$this->timestamp = $sqlObject->timestamp;
		$this->comment = $sqlObject->comment;
		$this->rating = $sqlObject->rating;
		$this->fid = $sqlObject->fid;		
	}	
	
	public function format(){

		// The sexy front end stuff that we want our output to look like
		 
		$hyperlink = urlencode($this->page);
		
		$heading = "$this->name - Review";
		$reviewTitle = "<a href='/artist/$hyperlink'>$this->page</a> at $this->venue";
		
		$rating = displayRating($this->rating); 
		
		$tDifference = $this->difference($this->timestamp);
		
		// We'd want all the front end wizardry to go here
		return "$heading <br> $reviewTitle <br> $rating <br> $this->comment <br> $tDifference<br>"; 
		
	}
}
?>