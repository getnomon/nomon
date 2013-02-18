<?php 
/*
 * Twitter library for Tamber
 */

class TamberTwitter
{
	public function __construct()
	{ $this->base = "https://api.twitter.com/"; }
	
	public function getScreenName($artist){
		
		$handle = null; 
		
		$artistJSON = 
			json_decode(file_get_contents("xml/". urlencode($artist) . ".json"));
		
		if(isset($artistJSON->twitter)){
			$handle = $artistJSON->twitter;
		}
		
		
		return $handle;
	}
	
	public function requestStatusId($handle){
		
		$id = null;
		
			
		$url = $this->base . "1/users/lookup.json?screen_name=$handle&include_entities=false";
		$result = @file_get_contents($url, 0, null);
		if($result != false) {
			$data = json_decode($result);
				
			if(property_exists($data[0], "status")){
				$id = $data[0]->status->id_str;
			}
		}
		return $id;
	}
	
	/**
	 * This is pretty much the only method you are ever going to call
	 * It returns the twitter-formatted html code 
	 * if we decide on custom skins (i.e. non-twitter), I will change this
	 * accordingly
	 */
	public function renderStatus($id){
		
		$html = null;
		
		$url = $this->base . "1/statuses/oembed.json?id=$id";
		$result = file_get_contents($url, 0, null);
		$data = json_decode($result);
		$html = $data->html;
		
		
		return $html;
	}	
}
?>