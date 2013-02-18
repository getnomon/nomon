<?php
/** 
 * Creates an xml file so that the artist page bullshit isn't slow as FUUUUUUCK 
 */
class artistXML{	
	private $artistName;	
	private $xmlfilename;	
	private $xmlfile;		
	private $xmlConcerts;
	/**	 
	 * @param $artistName the sanitized artist name	(name in the url)
	 */	
	public function __construct($artistName){		
		$this->artistName = sanitize(urldecode($artistName));		
		$this->xmlfilename = "xml/" . $artistName . ".xml";		
		$this->xmlfile = new SimpleXMLElement("<". $this->artistName . "></". $this->artistName. ">");	
		$this->xmlConcerts = $this->xmlfile;
	}		
	public function __destruct(){	
		$file = fopen($this->xmlfilename, "w");	
		$tidy_options = array('input-xml'=> true,'output-xml'=>true,'indent'=> true,'wrap'=> false);	
		echo tidy_repair_string($this->xmlfile->asXML(), $tidy_options);
		file_put_contents($this->xmlfilename, tidy_repair_string($this->xmlfile->asXML(), $tidy_options));	
		fclose($file);
	}
	public function escape($string) {
		return str_replace("&", "&amp;", $string);
		
	}	
			
	/**	
	 * Add a concert to the xml file	 
	 * returns false if concert exists	 
	 * */	
	public function addConcert($concertDayOfWeek = '',$concertDate = '',$concertMonth = '',$concertTime = '',
					$concertVenue = '',$venueLink = '',$venueCity = '',$venueCountry = '',		
					$ticketLink = '', $lowestPrice = '-1'){			
		   $concert = $this->xmlConcerts->addChild("concert");
		   
		   $concert->addChild('concertVenue', $this->escape($concertVenue));
		   $concert->addChild('venueCountry', $venueCountry);
		   $concert->addChild('lowestPrice', $lowestPrice);		
		   
		   $concert->addChild("concertDayOfWeek", $concertDayOfWeek);		
		   $concert->addChild('concertDate', $concertDate);		
		   $concert->addChild('concertMonth', $concertMonth);		
		   $concert->addChild('concertTime', $concertTime);		
		   $concert->addChild('venueLink', htmlentities($venueLink));		
		   $concert->addChild('venueCity', $venueCity);		
		   $concert->addChild('ticketLink', $ticketLink);		
		   		
	}	
	public function addBioSummary($artistBioSummary){
		$bio = $this->xmlfile->addChild("bio", $artistBioSummary);
	}
	public function addImageURL($artistImageURL){
		$link = $this->xmlfile->addChild("profile-picture", $artistImageURL);
	}
	public function addArtistName($artistNameMethod)
	{
		$this->xmlfile->addChild("artist-name",  $this->escape($artistNameMethod));
	}
}
?>