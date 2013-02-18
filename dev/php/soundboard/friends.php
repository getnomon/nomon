<?php
require_once("../lib/backend.php"); 
/*
 * A collection of methods for in house Tamber friending
 * May be depreciated and populated in ajax-track!
 */
/**
 * @param: $fid the facebook id of the user who we are trying to get the friends of
 * @return: an array of facebook id's of the user's friends
 */
function getFriends($fid){
	
	$data = json_decode(file_get_contents("profiledata/$fid" . "-list.txt"),true);
	
	// need to test if this works
	return $data["friend"];
	
}

/**
 * @param: $userfid the fid of the user
 * @param: $newfid the fid of the friend to be added
 */
function addFriend($userfid, $newfid){
	
	call_backend("AFND", $userfid . " " . $newfid);
}

/**
 * @param: $userfid the fid of the user
 * @param: $delfid the fid of the friend to be deleted
 */
function delFriend($userfid, $delfid){
	
	call_backend("RFND", $userfid . " " . $newfid);
}

?>