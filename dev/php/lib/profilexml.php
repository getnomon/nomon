<?php
/** 
 * Creates an xml file storing the profile's concerts attending
 */

class profileXML{	
		
	private $xmlfilename;	
	private $xmlfile;		
	private $xmlConcertsAttending;
	private $fid;
	/**	 
	 * @param $fid the unique facebook id
	 */	
	public function __construct($fid){		

		if(is_dir("home/ubuntu/public_html/ev")){
			chdir("home/ubuntu/public_html/ev");
		}
		/* Check if the file exists yet - if not create it, if it exists load it */
		$this->fid = $fid;
		$this->xmlfilename = "profiledata/" . $fid . ".xml";

		if(!file_exists($this->xmlfilename)) {
			$this->xmlfile = new SimpleXMLElement("<fid-". $fid . "></fid-". $fid. ">");	
			$this->xmlConcertsAttending = $this->xmlfile;
		}
		else {
			$this->xmlfile = simplexml_load_file($this->xmlfilename);
			$this->xmlConcertsAttending = $this->xmlfile; 
		}
		
	}		
	public function __destruct(){	
		$file = fopen($this->xmlfilename, "w");	
		//$tidy_options = array('input-xml'=> true,'output-xml'=>true,'indent'=> true,'wrap'=> false);	
		//echo tidy_repair_string($this->xmlfile->asXML(), $tidy_options);
		file_put_contents($this->xmlfilename, $this->xmlfile->asXML());
		// tidy_repair_string($this->xmlfile->asXML(), $tidy_options));	
		fclose($file);
	}	
	
	public function escape($string) {
		return str_replace("&", "&amp;", $string);
		
	}
	/*
	 * Should be enough to uniquely identify the concert we are trying to delete
	 */
	public function removeAttendingConcert($artistName, $concertDayOfWeek, $concertDate, $concertMonth)
	{
		foreach($this->xmlConcertsAttending->children() as $child) {
			if($child->getName() == 'attending-concert') {
				$flaggedForDeletion = 1;
				foreach($child->children() as $concertProperty) {
					switch($concertProperty->getName()) {
						case 'artistName': 
							if($concertProperty != $this->escape($artistName)) {
								$flgagedForDeletion = $flaggedForDeletion * 0;
							}
							break;
						case 'concertDayOfWeek':
							if($concertProperty != $concertDayOfWeek) {
								$flaggedForDeletion = $flaggedForDeletion * 0;
							}
							break;
						case 'concertDate':
							if($concertProperty != $concertDate) {
								$flaggedForDeletion = $flaggedForDeletion * 0;
							}
							break;
						case 'concertMonth':
							if($concertProperty != $concertMonth) {
								$flaggedForDeletion = $flaggedForDeletion * 0;
							}
							break;
					}
				}
			
				if($flaggedForDeletion == 1) {
					$dom = dom_import_simplexml($child);
					$dom->parentNode->removeChild($dom);
					return true;
					
				}
			}	
		}
		/* Coudln't find the concert to delete */ 
		return false; 
	}
	/**	
	 * Add a concert to the xml file	 
	 * */	
	public function addAttendingConcert($artistName = '', $concertDayOfWeek = '', $venueCity = '', 
			$concertDate = '',$concertMonth = '',$concertVenue = '', $ticketLink='', $time = '', $rating = 0){		
			
			$concert = $this->xmlConcertsAttending->addChild("attending-concert");
			$concert->addChild('artistName', $this->escape($artistName));
			$concert->addChild('concertVenue', $this->escape($concertVenue));	
		
			$concert->addChild('concertDayOfWeek', $concertDayOfWeek);		
			$concert->addChild('concertDate', $concertDate);		
			$concert->addChild('concertMonth', $concertMonth);	
			$concert->addChild('venueCity', $venueCity);
			$concert->addChild('ticketLink', $ticketLink);		
			$concert->addChild('time', $time);	
	}

	public function concertExists($artistName, $concertDayOfWeek, $concertDate, $concertMonth) {
		foreach($this->xmlConcertsAttending->children() as $child) {
			if($child->getName() == 'attending-concert') {
				$found = 1;
				foreach($child->children() as $concertProperty) {
					switch($concertProperty->getName()) {
						case 'artistName':
							if($concertProperty != $this->escape($artistName)) {
								$found = $found * 0;
							}
							break;
						case 'concertDayOfWeek':
							if($concertProperty != $concertDayOfWeek) {
								$found = $found * 0;
							}
							break;
						case 'concertDate':
							if($concertProperty != $concertDate) {
								$found= $found * 0;
							}
							break;
						case 'concertMonth':
							if($concertProperty != $concertMonth) {
								$found = $found * 0;
							}
							break;
					}
				}
					
				if($found == 1) {
					return true;
						
				}
			}
		}
		/* Couldn't find it */
		return false;
	}
}
?>