<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once("facebook.php");
require_once("tambermethods.php");
require_once("tamberartist.php");

/**
 * This class provides a relatively comprehensive wrapping of the PHP
 * Facebook API for our purposes. It allows for direct access of 
 * user data as well as well as transferring data from the Facebook
 * to the Tamber database via the TamberConnect class.
 * 
 * @author    Ellis Ratner <ellis.ratner@gmail.com>
 * @copyright Tamber 2012
 */
class TamberFacebook
{
    private $facebook;
    private $user;

    public function __construct()
    {
	$this->facebook = new Facebook(array('appId'  => '259718464093079',
					     'secret' => '706aedc8da5724f8954e3ba20ad5bad6'));
    }
    
    public function getFacebook(){
    	return $this->facebook;
    }

    /**
     * Returns the current user or null.
     */
    public function getUser()
    {
    $this->user = $this->facebook->getUser();
    if(isset($this->user)) {
    	return $this->user;
    }
	else {
		return null;
	}
    }
  
    public function getAccessToken()
    {
    	return $this->facebook->getAccessToken();
    }

    /**
     * Returns a login url if there is not a user currently
     * connected. Otherwise, returns null.
     * @param the parameters to pass (if necessary)
     * format: (scope, redirect_uri, display)
     */
    public function getLoginURL($params = array())
    {
	    return $this->facebook->getLoginUrl($params);
    }

    /**
     * Returns a logout url if there is already a user
     * connected. Otherwise, returns null.
     */
    public function getLogoutUrl()
    {
	
	    return $this->facebook->getLogoutUrl();
	
    }

    /**
     * Querys the Facebook Graph API.
     * @param $query the query string.
     * @param $method generally either "POST" or "GET", but can also be 
     * null.
     * @return returns the result of the query. Returns null
     * on faliure and posts an error message.
     */
    public function queryGraph($query, $method)
    {
	try
	{
	    if($method)
		$result = $this->facebook->api($query, $method);
	    else
		$result = $this->facebook->api($query);

	    return $result;
	}
	catch(FacebookApiException $e)
	{
		
		echo "Facebook API error: ";
	    echo $e->getType();
	    echo "\n";
	    echo $e->getMessage();
	    
	    return null;
	}
    }

    /**
     * To be called on creating the profile for the first time and ONLY the first time
     */
    public function syncUserWithTamber(){
    	
    	$facebookList = array();
    	
		if($this->user){
			$userMusic = $this->queryGraph("/me/music", null);
			foreach($userMusic["data"] as $m){
	
				if($m["category"] == "Musician/band"){
				
					$name = $m["name"];
					$lfmName = lastfmArtistSuggestion($name);
					
					if(sanitize($name) == sanitize($lfmName)) {
						array_push($facebookList, trim($lfmName));
					}
				}   		
			}
		}
			
		return $facebookList;
    }
    
    /**
     * Gives us friends in a array {"name":name, "id":id}
     */
    public function getMyFriends(){
    	$content = $this->queryGraph("/me/friends", null);
    	return $content['data'];
    	
    }

	public function curl_get_file_contents($URL) {
		$c = curl_init();
	    curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt($c, CURLOPT_URL, $URL);
	    $contents = curl_exec($c);
	    $err  = curl_getinfo($c,CURLINFO_HTTP_CODE);
	    curl_close($c);
	    if ($contents) return $contents;
	    else return FALSE;
	}
}


?>