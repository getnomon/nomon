<?php
/** 
 * Creates an xml file so that the artist page bullshit isn't slow as FUUUUUUCK 
 */

require_once("tambermethods.php");
require_once("tambertickets.php");

class locXML{	
	

	private $location; 

	
	private $xmlfilename;	
	private $xmlfile;		
	
	/**	 
	 * @param $firstName the first name
	 * @param $lastName the last name
	 * @param $location the location
	 * @param $gender the gender
	 * @param $fid the unique facebook id
	 */	
	public function __construct($location){		
		
		$this->location = $location;
	
			
		$this->xmlfilename = "locdata/" . sanitize($location) . ".xml";		
		
		$this->xmlfile = new SimpleXMLElement("<locdata></locdata>");	
	}	
		
	public function __destruct(){	
		$file = fopen($this->xmlfilename, "w");	
		$tidy_options = array('input-xml'=> true,'output-xml'=>true,'indent'=> true,'wrap'=> false);	
		//echo tidy_repair_string($this->xmlfile->asXML(), $tidy_options);
		file_put_contents($this->xmlfilename, tidy_repair_string($this->xmlfile->asXML(), $tidy_options));	
		fclose($file);
	}	
			
	/**	
	 * Add a concert to the xml file	 
	 * returns false if concert exists	 
	 * */	
	public function addConcert($artistNames, $imageURL, $concertDayOfWeek = '',$concertDate = '',
	$concertMonth = '', $concertVenue = '',$venueLink = '',$venueCity = '', $sg_date = ''){	
							
		   $concert = $this->xmlfile->addChild("concert");
		   $concert->addChild('artistNames', $artistNames);

		   $concert->addChild('imageURL', $imageURL);
		   $concert->addChild('concertVenue', $concertVenue);
		   
		   $concert->addChild("concertDayOfWeek", $concertDayOfWeek);		
		   $concert->addChild('concertDate', $concertDate);		
		   $concert->addChild('concertMonth', $concertMonth);		
		  	
		   $concert->addChild('venueLink', htmlentities($venueLink));	
		   $concert->addChild('sgDate', $sg_date);	
		   $concert->addChild('venueCity', $venueCity);		
		   //$concert->addChild('ticketLink', $ticketLink);
	}
}
?>