<?php
/**
 * Handles all of the database queries/interactions.
 *
 * @author    Ellis Ratner <ellis.ratner@gmail.com>
 * @copyright Tamber 2012
 */

require_once ("tamberartist.php");
require_once ("tamberuser.php");
require_once("tambermethods.php");
require_once ("tamberconcert.php");

class TamberConnection
{
    const SERVER   = "localhost";
    const USER 	   = "tambermu";
    const PASSWORD = "Pr29uwEq$"; 
    private $database;
    private $connection;

    public function __construct($database = "tambermu_dev")
    {
        $this->database = $database;
		$this->connect();
    }

    public function __destruct()
    {
	if($this->connection)
	    $this->connection->close();
    }

    private function connect()
    {
        $this->connection = new mysqli(TamberConnection::SERVER, TamberConnection::USER, 
			    	       TamberConnection::PASSWORD, $this->database);
	if($this->connection->connect_errno)
	{
	    throw new Exception("Failed to connect to server, " . $this->connection->connect_error);
	}
    }

    public function query($SQL)
    {
	return $this->connection->query($SQL);
    }

    public function getError()
    {
	return $this->connection->error;
    }

    /** 
     * Adds a user to the database. 
     * @param $user a TamberUser to add to the database.
     * @return true on success, otherwise false.
     */
    public function addUser($user)
    { 
        // Make sure the user doesn't already exist.
    	if($result = $this->query("SELECT * FROM user WHERE fid = '" . $user->getFID() . "'"))
    	{
	    if($result->num_rows > 0)
	    {
	        echo "Cannot add user, user already exists!";
	        $result->close();
	        return false;
	    }
	    $result->close();
        }
        else
        {
	    echo "Query failed: " . $this->getError();
	    return false;
        }

        $artistArray = $user->decodeArtists();
        $artists = "";
	
	foreach($artistArray as $artist)
        {
	    $a = lastfmArtistSuggestion($artist);
	    
	    if($artistFound = $this->artistSearch($a))
		$artists = $artists . $artistFound->getAID() . ",";
	    else
	    {
	    	
			$fbMatches = queryGraphFQL("SELECT page_id, pic FROM page WHERE name = '" . $a . "'");
			$fbNumResults = count($fbMatches->data);
		    if($fbNumResults > 0)
		    {
		   		$aid = $this->addArtist($a);
				$artists = $artists . $aid . ",";
		    }
		
	    }
        }
    
        // Add the user to the database.
        if($add = $this->query("INSERT INTO user (fid, first_name, last_name, location,
    	      	  	 lid, artists, gender) VALUES (" . $user->getFID() . ",'" . 
	  	      	 $user->getFirstName() ."','" . $user->getLastName() . "','"
	 	      	 . $user->getLocation() . "'," . $user->getLID() . ",'"
	    	      	 . $artists . "','" . $user->getGender() . "')"))
        {
	    // Success.
	    //echo "User added.";
	}
	else
        {
	    echo "Add user failed: " . $this->getError();
	    return false;
    	}

	return true;
    }

    /**
     * Verifies whether a user currently exists in the database. If so, update
     * location and music data.
     * @param $user a TamberUser containing information about the current user.
     * @return true if the user exists and has been succesfully updated, false
     * 	       if the query returned no results (user does not exist).
     */
    public function verify($user)
    {
        $userExists = false;

    	if($result = $this->query("SELECT * FROM user WHERE fid = '" . $user->getFID() . "'"))
    	{
	    // Query successful, check for records.
	    if($result->num_rows > 0)
	    {
	        $userExists = true;
	    	// Do update.
	    	$row = $result->fetch_object();
	    	// The music fetched from most recent Facebook data.
	    	$musicStrings = $user->decodeArtists();
		$aids = array();
		foreach($musicStrings as $as)
		{
		    $as = lastfmArtistSuggestion($as);
		    $artistFound = $this->artistSearch($as);
		    if($artistFound)
		    {
			array_push($aids, $artistFound->getAID());
		    }
		    else
		    {
			    $fbMatches = queryGraphFQL("SELECT page_id, pic FROM page WHERE name = '" . $as . "'");
	    		$fbNumResults = count($fbMatches->data);
	    		if($fbNumResults > 0)
	    		{
					$aid = $this->addArtist($as);
					array_push($aids, $aid);
	    		}
		    }
		}
	    	// The music fetched from the most recent Tamber database query.
	    	$currMusic = explode(",", $row->artists);
	    	// The running list of the new music.
	    	$newMusic = "";
	    	$updateMusic = false;
	    	if($aids != null)
	    	{
		    foreach($aids as $artistID)
		    {
		        if(!arrayContains($currMusic, $artistID))
		    	{
				$newMusic .= $artistID;
				$newMusic .= ",";

				$updateMusic = true;
		        }
		    }   
	        }

	        $updateSQL = "UPDATE user SET first_name = '" . $user->getFirstName() . "',
	    	                          last_name = '" . $user->getLastName() . "', 
					  location = '" . $user->getLocation() . "',
					  lid = '" . $user->getLID() . "',
					  gender = '" . $user->getGender() . "'";
	        if($updateMusic)
	            $updateSQL = $updateSQL . ", artists = '" . implode(",", $currMusic) . $newMusic . "'";

	        $updateSQL .= " WHERE fid = '" . $user->getFID() . "'";
	    	if($update = $this->query($updateSQL))
	    	{
	            // Success!
	        }
	        else
		    echo "Update failed!";
					  
	    }
	    $result->close();
        } 

        return $userExists;
    } 

    /**
     * Searches the artist table for the artist name string.
     * @param $artistName the string to search for.
     * @return a new TamberArtist object with information from
     * 	       the database, if no artist exists, null.
     */
    public function artistSearch($artistName)
    {
		if($result = $this->query("SELECT * FROM artist WHERE name = '" . $artistName . "'"))
		{
		    if($result->num_rows > 0)
		    {
			    $row = $result->fetch_object();
				// Hold an array of cid (concert id, referenced to the
				// concert table.)
				$concerts = explode(",", $row->concerts);
				// @todo parse array of cid ==> array of strings
		
				return new TamberArtist($row->aid,
							$row->name,					
							$concerts);
			  }
			  else
			  {
			  	return null;
			  }
			  $result->close();
		}
		else
		{
		    echo "Artist search failed: " . $this->getError();
			
		}
    }
    
    /**
     * Adds a new artist to the database by name, pulling
     * as much info as possible from last.fm.
     * @param $artistName the string containing the artists
     *        name.
     * @return the aid on success, -1 otherwise.
     */
    public function addArtist($artistName)
    {
	$aid = -1;
        // Make sure the user doesn't already exist.
    	if($result = $this->query("SELECT * FROM artist WHERE name = '" . $artistName . "'"))
    	{
	    if($result->num_rows > 0)
	    {
	        echo "Cannot add artist, artist already exists!";
	        $result->close();
	        return -1;
	    }
	    $result->close();
        }
        else
        {
	    echo "Artist search failed: " . $this->getError();
	    return -1;
        }
    
	$concerts = "";

        // Add the artist to the database.
        if($add = $this->query("INSERT INTO artist (name, concerts, sanitize) VALUES ('" . $artistName . "','" . 
			       $concerts . "','" . sanitize($artistName) . "')"))
        {
	    // Success.
	    echo "Artist added.";
	    $aid = $this->connection->insert_id;
	}
	else
        {
	    echo "Add artist failed: " . $this->getError();
	    return -1;
    	}

	return $aid;
    }
    
    public function getUser($fid)
    {
    	$result = $this->query("SELECT * FROM user WHERE fid = '" . $fid . "'");
    	if($result->num_rows > 0)
    	{
    		$row = $result->fetch_object();
    		$artistArray = array();
    		foreach(explode(",", $row->artists) as $aid)
    		{
    			$result = $this->query("SELECT * FROM artist WHERE aid ='". $aid ."'");
    			if($result->num_rows > 0)
    			{
	    			$artistRow = $result->fetch_object();
	    			array_push($artistArray, array("name"=>$artistRow->name));
    			}
    		}
    		return new TamberUser($row->first_name, $row->last_name, $row->fid, $row->location, $row->lid, json_encode($artistArray), $row->gender);
    	}
    	else return null; 
    }
}

?>