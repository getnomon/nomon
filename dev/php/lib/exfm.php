<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');
/*
 * ex.fm methods to get the album information
 * may eventually want to integrate with tambermethods?
 */

/**
 * Returns an array of songs featuring artist
 * @param: the artist we want to search
 * @return: a list of songs
 */


if(isset($_REQUEST['artist'])){
	print_r(exFmSongsByArtist($_REQUEST['artist']));
}

function exFmSongsByArtist($artist) {
	$url = "http://ex.fm/api/v3/song/search/" . urlencode($artist);
	
	$result = file_get_contents($url, 0, NULL);
	$result = json_decode($result);
	$songs = array();
	$i=0;
	
	foreach($result->songs as $song) {
		if($i>4) break;
		array_push($songs, array('title'=>$song->title, 'url'=>$song->url));
		$i++;	
	}
	return $songs;	
}

?>