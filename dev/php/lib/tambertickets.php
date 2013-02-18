<?php
/**
 * Provides a method to pull ticket information about
 * events from various sources. 
 * Currently we pull from:
 *      SeatGeek
 *
 * @author    Ellis Ratner <ellis.ratner@gmail.com>
 * @copyright Tamber 2012 
 */

class TamberTicket
{
    // The SeatGeek Partner Program "aid".
    const SEATGEEK_AID = 729;
    private $date;
    //private $artist_name;
    private $ticket_link;
    private $concert_data;

    /**
     * Constructs a SeatGeek-linked ticket using the artists name
     * and the date of the concert.
     *
     * @param $artist the name of the performer.
     * @param $day the date of the concert (format is YYYY-MM-DD.)
     */
    public function __construct($day, $sg_id)
    {
	$this->date = $day;
	//$this->artist_name = $artist_name;

	$this->concert_data = $this->queryTickets($day, $sg_id);
    }

    /**
     * Queries the SeatGeek API with the appropriate partner id
     * and returns the JSON object with the first event listed.
     *
     * @param $day is the day of the event (format is YYYY-MM-DD.)
     * @param $sg_id is the seatgeek id of the artist
     */
    public function queryTickets($day, $sg_id)
    {
	/*
    // First, we must query the API to figure out the given
	// artist's id on SeatGeek.
	//$words = explode(" ", $artist);
	$url = "http://api.seatgeek.com/2/performers?q=";
	
	//foreach($words as $w)
	//{
	    $url .= urlencode($artist);
	    //$url .= "+";
	//}	
	
	$url .= "&format=json&aid=729";

	$result = file_get_contents($url, 0, NULL, NULL);

	$jsonData = json_decode($result);

	//var_dump($jsonData);

	// Most likely id of the desired artist.
	$sg_id = $jsonData->performers[0]->id;
	

	//echo("ID=".$sg_id);*/
    
    //The fact that the above was called several times just ruins speed

	// Now query events for the appropriate one.
	$url = "http://api.seatgeek.com/2/events?performers.id=" . $sg_id 
					                         . "&datetime_local=" 
					                         . $day
					                         . "&aid=729";

	//echo($url);

	$result = file_get_contents($url, 0, NULL, NULL);

	$jsonData = json_decode($result);

	//$ticketLink = $jsonData->events[0]->url;
	//var_dump($jsonData->events[0]);
	if($jsonData->events != null){
		return $jsonData->events[0];
	}
	else{ return null; }
    }

    public function updateConcertData() 
    {
	$this->concert_data = $this->queryTickets($this->getArtistName(),
						  $this->getDate());
    }

    /**
     * Setters and getters.
     */
   // public function getArtistName() { return $this->artist_name; }

    //public function setArtistName($name) { $this->artist_name = $name; }
    
    // Note that the date here is returned in the format
    // YYYY-MM-DD, as a string.
    public function getDate() { return $this->date; }
   
    /**
     * @return the url to buy the ticket.
     */
    public function getTicketLink() 
    { 
	if($this->concert_data == NULL)
	    return "none";
	else
	    return $this->concert_data->url; 
    }

    /**
     * @return the lowest ticket price listed (or -1 if 
     * none listed.)
     */
    public function getLowestPrice()
    {
	if($this->concert_data == NULL)
	    return -1;
	else
	    return $this->concert_data->stats->lowest_price;
    }

    /**
     * @return the highest ticket price listed (or -1 if
     * non listed.)
     */
    public function getHighestPrice()
    {
	if($this->concert_data == NULL)
	    return -1;
	else
	    return $this->concert_data->stats->highest_price;
    }

    /**
     * @return the average ticket price listed (or -1 if
     * non listed.)
     */
    public function getAveragePrice()
    {
	if($this->concert_data == NULL)
	    return -1;
	else
	    return $this->concert_data->stats->average_price;	
    }

}

/*
 * Superceded as of 4-5-12 by Geoff's edits
 * Example usage:
 *    //$tt = new TamberTicket("2012-04-01", "deadmau5");
 *    $tt = new TamberTicket("2012-06-07", "phantogram");
 *    $link = $tt->getTicketLink();
 *    $lowest = $tt->getLowestPrice();
 *
 *    echo($link);
 *    echo("|");
 *    echo($lowest);
 */
?>