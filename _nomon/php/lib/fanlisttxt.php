<?php
/** 
 * Creates an xml file storing the profile's concerts attending
 */

class fanlist{	
		
	private $filename;	
	//private $file;		
	private $fid;
	private $artistList;
	/**	 
	 * @param $fid the unique facebook id
	 */	
	public function __construct($fid){		

		//chdir("home/ubuntu/public_html/ev");
		/* Check if the file exists yet - if not create it, if it exists load it */
		$this->fid = $fid;
		$this->filename = "profiledata/" . $fid . "-list.txt";

		//$this->file = fopen($this->filename, "r+");
		$this->artistList = explode("/AND/", file_get_contents($this->filename));
		
			
	}		
	//public function __destruct(){	
		
		//if(is_dir("home/ubuntu/public_html/ev")){ chdir("home/ubuntu/public_html/ev");}
		//$filedata = implode("/AND/", $this->artistList);
		//file_put_contents($this->filename, $filedata);
		//fclose($this->file);
	//}	
	
	/*
	 * Should be enough to uniquely identify the concert we are trying to delete
	 */
	/*public function removeArtist($artistName)
	{
		foreach($this->artistList as $key=>$artist) {
			if($artist == $artistName) {
				unset($this->artistList[$key]);
				return true;
			}
		}
		/* Couldn't find the artist to delete */ 
		/*return false; 
	}
	/**	
	 * Add a concert to the file	 
	 * */	
/*	public function addArtist($artistName = ''){		
			
			array_push($this->artistList, $artistName);
	}

	public function artistExists($artistName) {
		foreach($this->artistList as $artist) {
			if($artist == $artistName) {
				return true;
				break;
			}
		}
		
		return false; 
		
	}*/
	public function getArtistList() {
		return $this->artistList;
	}
}
?>