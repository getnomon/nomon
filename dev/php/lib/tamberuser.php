<?php 

/**
 * provides a structure to store tamber user data
 */

class TamberUser
{
    private $uid;
    private $fid;
    private $first_name;
    private $last_name;
    private $location;
    private $lid;
    private $artists;
    private $gender;
    
    /** 
     * Construct a new user given neccessary data.
     * @param $first_name first name.
     * @param $last_name last name.
     * @param $fid the user's unique Facebook assigned id.
     * @param $location user's current location.
     * @param $lid Facebook location id.
     * @param $artists PHP JSON object containing artist name strings, or null.
     * @param $gender the gender of the user ("male" or "female").
     */
    public function __construct($first_name = "", $last_name = "", $fid = 0, 
    	   	    	        $location = "", $lid = "", $artists = null,
				$gender = "none")
    {
	// Unique user id must be assigned by the server.
	$this->uid = 0;
    $this->first_name = $first_name;
	$this->last_name = $last_name;
	$this->fid = $fid;
	$this->location = $location;
	$this->lid = $lid;
	$this->artists = $artists;
	$this->gender = $gender; 
    }    
    /** 
     * Setters and getters.
     */
    public function getUID() { return $this->uid; }
    
    public function setUID($uid) { $this->uid = $uid; }
    
    public function getFID() { return $this->fid; }
    
    public function setFID($fid) { $this->fid = $fid; }

    public function getFirstName() { return $this->first_name; }

    public function setFirstName($first_name) { $this->first_name = $first_name; }
    
    public function getLastName() { return $this->last_name; }

    public function setLastName($last_name) { $this->last_name = $last_name; }

    public function getLocation() { return $this->location; }

    public function setLocation($location) { $this->location = $location; }

    public function getLID() { return $this->lid; }

    public function setLID($lid) { $this->lid = $lid; }
    
    public function getArtists() { return $this->artists; }

    public function setArtists($artists) { $this->artists = $artists; }

    public function getGender() { return $this->gender; }
   
    public function setGender($gender) { $this->gender = $gender; }
    
    /**
     * Decodes JSON encoded artist data.
     * @return a PHP array of strings corresponding to the names
     * 	       of the artists.
     */
    public function decodeArtists()
    {
	if($this->artists != null)
	{
	    try
	    {	    	
	    	$untrimmedArray = json_decode(stripslashes($this->artists),true);	    		  		
	    	$stringArray = array();	    	
	    	foreach($untrimmedArray as $untrimmedElement)	    	
		    {	    		
		    	array_push($stringArray, trim($untrimmedElement["name"], "'"));	    	
		    }
		    
			$namesArray = array();		
			
			foreach($stringArray as $element)		
			{
			    array_push($namesArray, $element["name"]);		
			}		

			return $namesArray;
	    }
	    catch(Exception $e)
	    {
			echo "Decoding failed!";
			return $this->artists;
	    }
	}
    }
}
?>