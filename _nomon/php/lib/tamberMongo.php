<?php
#Tamber Mongo Controller :)
#resources: 
# - http://php.net/manual/en/mongo.tutorial.php
# - http://www.mongodb.org/pages/viewpage.action?pageId=589836





#THIS IS NOT DONE & I am likely doing it wrong...


class TamberMongo{
	private $m;
	private $db;

	//different collections
	private $artists, $locations, $concerts, $users, $groups;

	public function __construct(){
        $m = new Mongo();
        $db = $m->tamber; //select database

        //Assign variuables to their collections
        $this->artists   = $db->artists;
        $this->locations = $db->locations;
        $this->concerts  = $db->concertss;
        $this->users     = $db->users;
        $this->groups    = $db->groups;
    }

    public function __destruct(){
		//I think there is an $m->dissconnect() or something7
    }



    #----------------GET MONEY--------------
	//Returns artist from database
	//Null if artist does not exist
	function getArtistByName($artistName){
		$collection = $db->artists;
		return $collection->findOne(array("name" => $artistName));
	}
}
?>