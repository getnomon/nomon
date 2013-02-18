<?php 
require_once("tamberartistpage.php");
require_once("tambermethods.php");

function generateArtistPage($artistName)
{
	
	require_once("concertlist.php");
	$suggestion = new getConcertSuggestions();
	
	$url = "http://ws.audioscrobbler.com/2.0/?method=artist.getinfo&artist="
	. $artistName ."&autocorrect=1&api_key=b25b959554ed76058ac220b7b2e0a026&format=json";
	
	$result = file_get_contents($url, 0, null, null);
	$jsonData = json_decode($result)->artist;
	
	$artistName = $jsonData->name;
	$similarArtists = array();
	
	if(isset($jsonData->similar->artist))
	{
		foreach($jsonData->similar->artist as $artist)
		{
			array_push($similarArtists, $artist->name);	
		}
	}
	else 
	{
		error("You truly are a hipster; there are no similar artists!");
	}
	
	$artistBioSummary = $jsonData->bio->summary;

	
		
	//$artistBioContent = $jsonData->bio->content;
	
	$artistConcerts = $suggestion->lastfmGetEvents($artistName);
	
	$artistPage = new TamberArtistPage
	($artistName, $artistBioSummary, null, //$artistBioContent, 
	$similarArtists, $artistConcerts);
	

	return $artistPage;	
	
	
}





?>