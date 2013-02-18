<?php 

require_once("tambertickets.php");
/**
 * provides a structure to store tamber concert
 */
class GeoPoint
{
	private $latitude;
	private $longitude;
	private $city;	 	
	private $country;
	private $street; 

	/**
	 * Construct a GeoPoint coordinate
	 * @param $latitude the latitude point
	 * @param $longitude the longitude point
	 * @param $city the city of the point
	 * @param $country the country of the point
	 * @param $street the street address
	 */
	
	public function __construct($latitude = 0, $longitude = 0, $city = "", $country = "", $street = "")
	{
		// the longitude and latitude is mostly for internal calculation
		$this->latitude = $latitude;
		$this->longitude = $longitude; 
		
		// display this crap
		$this->city = $city;
		$this->country = $country;
		$this->street = $street;
		
	}
	
	/**
	 * Setters and Getters
	 */
	public function getLatitude(){ return $this->latitude; }
	public function getLongitude(){ return $this->longitude; }
	public function getCity(){ return $this->city; }
	public function getCountry(){ return $this->country; }
	public function getStreet(){ return $this->street; }
	
}
class TamberConcertVenue
{
	private $lastfmID;
	private $name;
	private $location; 
	private $website;
	
	/**
	 * Construct the ConcertVenue object
	 * @param $lastfmID the lastfm id of the concert
	 * @param $name the name of the venue
	 * @param $location GeoPoint class of the venue 
	 * @param $website the url for their website
	 */
	public function __construct( $lastfmID = 0, $name = "", $location = null, $website = "")
	{
		$this->lastfmID = $lastfmID;
		$this->name = $name;
		$this->location = $location; 
		$this->website = $website;
	}
	
	public function getLastfmID(){ return $this->lastfmID; }
	public function getName(){ return $this->name; }	
	public function getLocation(){ return $this->location;}
	public function getWebsite(){ return $this->website; }
}

class TamberConcert
{
    private $lastfmID;
    private $title; 
    private $artists; 
    private $venue; 
    private $date;
    private $time;
    private $dateObject = array();
	private $timeObject = array();
	private $ticketMaster;
   
    
    /** 
     * Construct a new user given neccessary data.
     * @param $lastfmID last fm event id
     * @param $title title of event 
     * @param $artist a tamberArtist thats playing 
     * @param $venue a concertVenue class
     */
    public function __construct($lastfmID =0, $title = "", $artists = null, $venue = null, $date = "")
    {
	
		$this->lastfmID = $lastfmID;
		$this->title = $title;
		$this->artists = $artists;
		$this->venue = $venue;
		$this->date = $date;		
		
		
		$dateTime = explode(" ", $this->date);
    	switch($dateTime[0])
    	{
    		case "Sun,":
    			$dateTime[0] = "Sunday";
    			break;
    		
    		case "Mon,":
    			$dateTime[0] = "Monday";
    			break;
    		
    		case "Tue,":
    			$dateTime[0] = "Tuesday";
    			break;
    			
    		case "Wed,":
    			$dateTime[0] = "Wednesday";
    			break;
    			
    		case "Thu,":
    			$dateTime[0] = "Thursday";
    			break;
    			
    		case "Fri,":
    			$dateTime[0] = "Friday";
    			break;
    			
    		case "Sat,":
    			$dateTime[0] = "Saturday";
    			break;
    		
    		default:
    			$dateTime[0] = "You Divided by 0";

    	}
    	array_push($this->dateObject, $dateTime[0]);
    	array_push($this->dateObject, $dateTime[1]);
    	array_push($this->dateObject, $dateTime[2]);
    	
    	
    	$eventTime = explode(":", $dateTime[4]);
    	if((int)$eventTime[0] < 12)
    	{
    		if((int)$eventTime[0] == 0)
    		{
    			array_push($this->timeObject, "12");
    		}
    		else
    		{
    			array_push($this->timeObject, $eventTime[0]);	
    		}
    		
    		array_push($this->timeObject,$eventTime[1]);
    		array_push($this->timeObject,"AM");		
    	}
    	
    	if((int)$eventTime[0] == 12)
    	{
    		array_push($this->timeObject, $eventTime[0]);
    		array_push($this->timeObject, $eventTime[1]);
    		array_push($this->timeObject, "PM");
    	}
    	
    	if((int)$eventTime[0]>12)
    	{
    		$convertedTime = (int)$eventTime[0] - 12;
    		array_push($this->timeObject, $convertedTime);
    		array_push($this->timeObject, $eventTime[1]);
    		array_push($this->timeObject, "PM");
    		
    	}
    	
    	
    	     
    }    
    /** 
     * Setters and getters.
     */
    public function getLastfmID(){ return $this->lastfmID; }
    public function getTitle(){ return $this->title; }
    public function getVenue(){ return $this->venue; }
    public function getArtists(){ return $this->artists; }
   	public function getDayOfWeek(){ return $this->dateObject[0]; }
   	public function getDateNumber(){ return $this->dateObject[1]; }
   	public function getMonth(){ return $this->dateObject[2]; }
   	public function getSgDate(){
   	$dateTime = explode(" ", $this->date);
	   	switch($this->dateObject[2])
	    	{
	    		case "Jan":
	    			$ticketMonth = "01";
	    			break;
	    		case "Feb":
	    			$ticketMonth = "02";
	    			break;
	    		case "Mar":
	    			$ticketMonth = "03";
	    			break;
	    		case "Apr":
	    			$ticketMonth = "04";
	    			break;
	    		case "May":
	    			$ticketMonth = "05";
	    			break;
	    		case "Jun":
	    			$ticketMonth = "06";
	    			break;
	    		case "Jul":
	    			$ticketMonth = "07";
	    			break;
	    		case "Aug":
	    			$ticketMonth = "08";
	    			break;
	    		case "Sep":
	    			$ticketMonth = "09";
	    			break;
	    		case "Oct":
	    			$ticketMonth = "10";
	    			break;
	    		case "Nov":
	    			$ticketMonth = "11";
	    			break;
	    		case "Dec":
	    			$ticketMonth = "12";
	    			break;
	    		default:
	    			$ticketMonth = "00";
	    	}
	    	return (string)$dateTime[3]."-".(string)$ticketMonth."-".(string)$this->dateObject[1];
   		
   	}
   	public function getTime()
   	{
   		return (string)$this->timeObject[0].":".(string)$this->timeObject[1]." ".$this->timeObject[2];
   	}
   	public function getTicket($sg_id)
   	{ return new TamberTicket( $this->getSgDate(),$sg_id); }
}
?>