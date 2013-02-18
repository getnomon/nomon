<?php 
error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once("exfm.php");

/* What the fuck does this shit do?
set_include_path('/usr/share/php/libzend-framework-php');
require_once("Zend/Loader.php");
Zend_Loader::loadClass('Zend_Gdata_YouTube');
*/


class TamberTube{
	
	public function __construct(){
		//$this->yt = new Zend_Gdata_YouTube();
		$this->base = "https://gdata.youtube.com/feeds/api/";
	}
	
	public function getVideo($title, $artist){
		$url = $this->base . "videos/?category=music&q=" . urlencode($title) . "+\"" . urlencode($artist) 
			. "\"&v=2&alt=json";
		$result = file_get_contents($url,0,null);
		$data = json_decode($result);
		$feed = $data->feed;
		
		if(property_exists($feed, "entry")){
			$src = $feed->entry[0]->content->src;
		}
		else{
			$src = null;
		}
		
		return $src; 
	}
	
}
?>