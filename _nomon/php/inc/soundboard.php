<?php 
require_once("php/soundboard/soundboard.class.php");
require_once("php/lib/tamberfb.php");

$facebook = $GLOBALS['facebook'];
$prof = $facebook->queryGraph("/me", null);
$fid = $prof['id'];

$sb = new Soundboard($fid);
$contents = $sb->write();

$tweets = array();
$reviews = array();

foreach($contents as $content){
	switch($content["type"]){
		case "review":
			array_push($reviews, $content["content"]);
			break;
			
		case "tweet":
			array_push($tweets, $content["content"]);
			break;
	}
}

$s->assign("reviews", $reviews);
$s->assign("tweets", $tweets);

?>