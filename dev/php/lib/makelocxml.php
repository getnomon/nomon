<?php 
require_once("userxml.php");
require_once("tambermethods.php");
require_once("fanlisttxt.php");
require_once("locxml.php");
require_once("concertlist.php");


/**
 * Function to generate the location xml
 * @param: $location the unsanitized location name
 */

function generateLocationXML($location) {
			chdir('home/ubuntu/public_html/ev');
			$xmlfile = new locXML($location);
			$suggestion = new getConcertSuggestions();
			$url = "http://ws.audioscrobbler.com/2.0/?method=geo.getevents&location="	. 
			urlencode(trim($location)) . 
			"&limit=60&distance=34&api_key=b25b959554ed76058ac220b7b2e0a026&format=json";		
			$result = json_decode(file_get_contents($url, 0, NULL, NULL));	
			$attr = "@attr";
			
			foreach($result->events->event as $event)	
			{			
					
				$concert = $suggestion->unpackJSON($event);
					
					$artists = $concert->getArtists();
					
					if(count($artists) > 1){
						$name = $artists[0];
						$artistNames = implode("/AND/", $artists);
					}
					else{ 
						$name = $artists; 
						$artistNames = $artists;
					}
					

					$xmlfile->addConcert(str_replace("&","&amp;amp;",$artistNames),'',  $concert->getDayOfWeek(), $concert->getDateNumber(), 
					$concert->getMonth(), str_replace("&","&amp;amp;",$concert->getVenue()->getName()),'',
					$concert->getVenue()->getLocation()->getCity() , $concert->getSgDate()); 
					
			}	
	
}

?>