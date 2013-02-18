<?php 
class TamberArtistPage
{
	private $artistName;
	private $artistBioSummary;
	private $similarArtists;
	private $artistBioContent;
	private $artistConcerts;
	
	

	public function __construct($artistName = "", $artistBioSummary = "", $artistBioContent = "", 
	$similarArtists = "", $artistConcerts = "")
	{
		$this->artistName = $artistName;
		$this->artistBioSummary = $artistBioSummary;
		$this->similarArtists = $similarArtists;
		$this->artistBioContent = $artistBioContent;
		$this->artistConcerts = $artistConcerts;
	}
	
	/**
	 * Getters
	 */
	public function getArtistName(){ return $this->artistName; }
	public function getArtistBioSummary(){ return $this->artistBioSummary; }
	public function getArtistBioContent(){ return $this->artistBioContent; }
	public function getSimilarArtists(){ return $this->similarArtists; }
	public function getArtistConcerts(){ return $this->artistConcerts; }
	public function getImageURL()
	{
		return getImageUrl($this->artistName);

	}
	
	
}
?>