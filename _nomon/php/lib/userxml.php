<?php
/** 
 * Creates an xml file so that the artist page bullshit isn't slow as FUUUUUUCK 
 */
class userLoc{
	private $txtfilename;
	private $fid;
	private $file;
	
	public function __construct($fid) {
		$this->fid = $fid;
		/* Handle when the user input sets location */
		if(substr(getcwd(), -3) == "php"){ 
			
			$this->txtfilename = "../userloc/" . $this->fid . ".txt";
		}
		else {
			$this->txtfilename = "userloc/" . $this->fid . ".txt";
		}
	}
	
	/**
	 * Add user location to the /userloc xml file
	 */
	public function addUserLocation($location)
	{		
		$this->file = fopen($this->txtfilename, "w");
		fwrite($this->file, $location);		
		fclose($this->file);
	}
	
	
	
}
class userXML{	
		
	private $xmlfilename;	
	private $xmlfile;		
	private $xmlConcerts;
	private $customized;
	private $fid;
	/**	 
	 * @param $fid the unique facebook id
	 */	
	public function __construct($fid){		
				
		$this->xmlfilename = "userdata/" . $fid . ".xml";		
		$this->xmlfile = new SimpleXMLElement("<fid-". $fid . "></fid-". $fid. ">");	
		$this->xmlConcerts = $this->xmlfile;
		$this->customized = false;
		$this->fid = $fid;
	}		
	public function __destruct(){	
		if(file_exists($this->xmlfilename)) { unlink($this->xmlfilename); }
		$file = fopen($this->xmlfilename, "w");	
		$tidy_options = array('input-xml'=> true,'output-xml'=>true,'indent'=> true,'wrap'=> false);	
		//echo tidy_repair_string($this->xmlfile->asXML(), $tidy_options);
		file_put_contents($this->xmlfilename, tidy_repair_string($this->xmlfile->asXML(), $tidy_options));	
		fclose($file);
	}	
	
	/**	
	 * Add a concert to the xml file	 
	 * */	
	public function escape($string) {
		return str_replace("&", "&amp;", $string);
		
	}
	public function addSuggestedConcert($artistName = '', $concertDayOfWeek = '', $venueCity = '', 
			$concertDate = '',$concertMonth = '',$concertVenue = '', $sg_date = '', $sg_id = '', $rating = 0){		
			
			$concert = $this->xmlConcerts->addChild("suggested-concert");
			$concert->addChild('artistName', $this->escape($artistName));
			$concert->addChild('concertVenue', $this->escape($concertVenue));	
		
			$concert->addChild('concertDayOfWeek', $concertDayOfWeek);		
			$concert->addChild('concertDate', $concertDate);		
			$concert->addChild('concertMonth', $concertMonth);	
			$concert->addChild('venueCity', $venueCity);
			$concert->addChild('sgDate', $sg_date);			
			$concert->addChild('sgId', $sg_id);			
	}	
	public function addGenericConcert($artistName = '', $concertDayOfWeek = '', $venueCity = '', 
			$concertDate = '',$concertMonth = '',$concertVenue = '', $sg_date = '', $sg_id = '', $rating = 0){		
			
			$concert = $this->xmlConcerts->addChild("generic-concert");
			$concert->addChild('artistName', $this->escape($artistName));
			$concert->addChild('concertVenue', $this->escape($concertVenue));
		
			$concert->addChild('concertDayOfWeek', $concertDayOfWeek);		
			$concert->addChild('concertDate', $concertDate);		
			$concert->addChild('concertMonth', $concertMonth);
			$concert->addChild('venueCity', $venueCity);
			$concert->addChild('sgDate', $sg_date);			
			$concert->addChild('sgId', $sg_id);			
	}	
	
	
	
}
?>