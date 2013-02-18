<?php 

/**
 * Provides a structure to store artist data.
 *
 * @author    Ellis Ratner <ellis.ratner@gmail.com>
 * @copyright Tamber Music
 */
class TamberArtist
{
    private $aid;
    private $name;
    private $concerts;
   
    public function __construct($aid = 0, $name = "", $concerts = array())
    {
	// Unique artist id assigned by the server.
        $this->aid = $aid;
	$this->name = $name;
	$this->concerts = $concerts;
    }

    public function getAID(){ return $this->aid; }     public function getName(){ return $this->name; }
}

?>