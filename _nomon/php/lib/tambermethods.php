<?php 

error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once("backend.php");

/**
 * Sanitize a string to url format
 * @param $string to be sanitized
 * @return a sanitized version of the string
 */
function sanitize($string)
{
  $sanitized = preg_replace("[^a-z^A-Z^0-9^ ^-]", "", $string);
  $sanitized = strtolower($sanitized);	
  $sanitized = preg_replace('/\s+/', " ", $sanitized);
  $sanitized = trim($sanitized);
  $sanitized = str_replace(" ", "-", $sanitized);
  return $sanitized;
}
/**
 * Querys last.fm for the provided artist name.
 * @param $name a string containing an artist name.
 * @return a JSON object of artist matches.
 */
function lastfmArtistNameQuery($name, $returnType = "stdObject")
{
  $url = "http://ws.audioscrobbler.com/2.0/?method=artist.search&artist=" . urlencode($name) . 
    "&api_key=83a91284a919174afca9de8299b69681&format=json";
  $result = file_get_contents($url, 0, NULL, NULL);

  if ($returnType = "stdObject") {
    $jsonData = json_decode($result);
    return $jsonData->results->artistmatches;
  } elseif ($returnType = "array") {
    $jsonData = json_decode($result, true);
    return $jsonData["results"]["artistmatches"];
  }
}

function lastfmArtistInfoQuery($name)
{
  //returns an array, because i like it better that way. -g
  $url = "http://ws.audioscrobbler.com/2.0/?method=artist.getInfo&artist=" . urlencode($name) .
    "&api_key=b25b959554ed76058ac220b7b2e0a026&format=json";
  $result = file_get_contents($url, 0, NULL, NULL);
  $jsonData = json_decode($result, true);
  return $jsonData["artist"];
}





function getImageURL($artistName)
{
  return call_backend("IMAG", $artistName);
}

/**
 * Queries last.fm for artists similar to a given one
 */
function getSimilarArtists($artist)
{
  $url = "http://ws.audioscrobbler.com/2.0/?method=artist.getsimilar" . "&artist=" . urlencode($artist->getName()) . 
    "&api_key=83a91284a919174afca9de8299b69681&format=json";		
  $result = file_get_contents($url, 0, NULL, NULL);
	
  $jsonData = json_decode($result)->similarartists->artist;
  $similarNames = array(); 
  for($i=0; $i<count(jsonData); $i++)
    {
      array_push($similarNames, $jsonData[$i]->name);
    }
  return $similarNames;
	 
}


/**
 * Takes the highest (first) artist suggestion from a 
 * last.fm query.
 * @param $name the artist name string.
 * @return the name of the first artist found, otherwise
 *         "Unknown".
 */
function lastfmArtistSuggestion($name)
{
  return call_backend("FIND", $name);
}

/**
 * Querys the Facebook Graph using FQL.
 * @param $fql a string containing an FQL command.
 * @return a JSON object with the results of the query.
 */
function queryGraphFQL($fql)
{
  // Parse the query appropriately.
  $encodedFQL = urlencode($fql);
  $fqlURL = "https://graph.facebook.com/fql?q=" . $encodedFQL;
  $fqlResult = file_get_contents($fqlURL);
  $jsonResponse = json_decode($fqlResult);
  return $jsonResponse;
} 
/**
 * Get seat geek id
 * @param $name the name of the artist to get the SGID of
 * @return the seat geek id of the artist with that name
 */
function getSg_Id($name)
{
  return call_backend("SGID", $name);
}

/**
 * Given an array, determines whether or not the specified
 * element is contained in it.
 * @param $array the array to search.
 * @param $element the element to search for.
 * @return true if the array contains the element, otherwise
 * 	   false.
 */
function arrayContains($array, $element)
{
  foreach($array as $a)
    {
      if($a == $element)
	return true;
    }
  return false;
}
?>