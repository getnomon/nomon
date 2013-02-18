<?php
/*
 * Soundboard v1.0
 * Shows last 10 reviews
 */ 

require_once("reviews.class.php");
require_once("php/lib/tambertwit.php");
class Soundboard
{
	public function __construct($fid){
		$this->fid = $fid;
		if(isset($GLOBALS['tamberConnect'])){
			$this->tc = $GLOBALS['tamberConnect'];
		}
		else {
			require_once("php/lib/tamberconnect.php");
			$this->tc = new TamberConnection();
		}
		$this->twitter = new TamberTwitter();
		$this->profile = json_decode(file_get_contents("profiledata/$fid" . ".json"),true);
	}	
	
	public function write(){
		
		// we'll want to extend this to have other types of things as well
		$content = array();
		foreach($this->getReviews() as $review){
			array_push($content, array("type"=>"review", "content"=>$review->format()));
		}
		/* We need to cache this in the backend... too slow man
		foreach($this->getTweets() as $tweet){
			array_push($content, array("type"=>"tweet", "content"=>$tweet));
		}*/
		return $content;
		
	}
	
	/**
	 * Returns the last 10 reviews written - we will eventually want some 
	 * content filtering
	 * @return: the last 10 comments posted
	 */
	public function getReviews(){
		
		$newestReviews = array();
		$result = $this->tc->query("SELECT * FROM commentator_comments ORDER BY id DESC LIMIT 0,10");
		
		while($row = $result->fetch_object()) {
			
			array_push($newestReviews, new Review($row));
		
		}
		return $newestReviews;
	}
	
	
	/**
	 * @return: an array of tweets (html code) by the artists a user fans
	 */
	public function getTweets($artistList = null){
		
		// possibly for future variations?
		if(!isset($artistList)){
			$artistList = explode("/AND/", file_get_contents("profiledata/$this->fid" . "-list.txt"));	
		}
	
		$tweets = array();
		
		foreach($artistList as $artist){
			
			$handle = $this->twitter->getScreenName($artist);
			if(isset($handle)){
				$id = $this->twitter->requestStatusId($handle);
				if(isset($id)){
					array_push($tweets, $this->twitter->renderStatus($id));
				}
			}
		}
		
		return $tweets;
	}
	
	/*
	 * TODO: implement these guys
	 */
	public function getVideos(){
		
	}
	
	public function getAnnouncements(){
		
	}
	
	/**
	 * Gets incoming friend alerts
	 */
	public function getRequests(){
		return $this->profile["friendrequestsin"];
	}
	
	public function getSuggestions(){
		return $this->profile["suggestionsin"];
	}
	
}
?>