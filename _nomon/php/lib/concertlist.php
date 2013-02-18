<?php
require_once("tamberconnect.php");
/**
 * Will make all the API calls for us
 */
class getConcertSuggestions
{
	
	public function augment($artistArray)
	{
		
		foreach($artistArray as $artist)
		{
			$url = "http://ws.audioscrobbler.com/2.0/?method=artist.getsimilar&artist=" . urlencode($artist) . 
			"&autocorrect=1&api_key=b25b959554ed76058ac220b7b2e0a026&format=json";
			
			$result = json_decode(file_get_contents($url,0,null,null),true);
			
			$i=0;
			if(array_key_exists("similarartists", $result))
			{
				if(count($result["similarartists"]) > 0 )
				{
					foreach($result["similarartists"]["artist"] as $similarArtist)
					{
						if($i>=2)
						{ break; }
						$i+=1;
						array_push($artistArray,$similarArtist["name"]);	
					}
				}
			}
		}
		return $artistArray;
	}
	public function unpackJSON($jsonEvent)
	{
		// see here for example http://ws.audioscrobbler.com/2.0/?method=artist.getevents&artist=LMFAO&api_key=b25b959554ed76058ac220b7b2e0a026&format=json
		//$connection = new TamberConnection();
		//$geo = "geo:point";
		//$location = (array)$jsonEvent->venue->location->$geo;
		
		#LOCATION
		//$eventLoc = new GeoPoint($location['geo:lat'], $location['geo:long'], 
		$eventLoc = new GeoPoint(null, null, 
		$jsonEvent->venue->location->city,
		$jsonEvent->venue->location->country,
		//$jsonEvent->venue->location->street);
		null);
		
		#VENU INFO
		//$concertVenue = new TamberConcertVenue($jsonEvent->venue->id,
		$concertVenue = new TamberConcertVenue(null,
		$jsonEvent->venue->name,
		$eventLoc,
		$jsonEvent->venue->website);
				
		#COMPILE
		//$tamberConcert = new TamberConcert($jsonEvent->id, $jsonEvent->title, 
		$tamberConcert = new TamberConcert(null, null,
		$jsonEvent->artists->artist, $concertVenue, $jsonEvent->startDate);		
		
		return $tamberConcert;
		
	}
	public function lastfmEventLookup($lastfmEventID)
	{
		$url = "http://ws.audioscrobbler.com/2.0/?method=event.getinfo&event=" . $lastfmEventID . 
		"&api_key=b25b959554ed76058ac220b7b2e0a026&format=json";
		
		$result = file_get_contents($url, 0, NULL, NULL);
		$jsonEvent = json_decode($result)->event;
		return $this->unpackJSON($jsonEvent);
		
		
	}
	public function lastfmGetEvents($artistName)
	{

		$url = "http://ws.audioscrobbler.com/2.0/?method=artist.getevents" . "&artist=" . urlencode($artistName) . 
		"&api_key=b25b959554ed76058ac220b7b2e0a026&format=json";
		
		$result = file_get_contents($url, 0, NULL, NULL);
		
    	$jsonEvents = json_decode($result)->events;
    	
    	$eventArray = array(); 
    	if(isset($jsonEvents->event))
    	{
    		if( count($jsonEvents->event)==1)
	    	{
	    		return $this->unpackJSON($jsonEvents->event);
	    	}
	    	else
	    	{
		    	foreach($jsonEvents->event as $event)
		    	{	
		    		array_push($eventArray, $this->unpackJSON($event));
		    	}
		    	return $eventArray;
	    	} 	
    	}	
	}	
}?>