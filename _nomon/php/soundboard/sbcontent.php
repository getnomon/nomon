<?php
/*
 * Component of Soundboard v1.0
 * Abstract class for all the stuff we would want to post
 */ 

/*
 * Handles all the review formatting and crap
 */

abstract class BoardContent
{
	abstract public function format();
	
	public function difference($time){
	
	    $time = time() - $time; // to get the time since that moment
	
	    $tokens = array (
	        31536000 => 'year',
	        2592000 => 'month',
	        604800 => 'week',
	        86400 => 'day',
	        3600 => 'hour',
	        60 => 'minute',
	    );
	
	    foreach ($tokens as $unit => $text) {
	        if ($time < $unit) continue;
	        $numberOfUnits = floor($time / $unit);
	        if($text == 'minute' && floor($time/$unit) == 0){
	        	return "Fresh!";
	        }
	        else {
	        	return "Posted " . $numberOfUnits.' '.$text.(($numberOfUnits>1)?'s':'') . " ago";
	        }
	    }
	}
}
	
	
?>