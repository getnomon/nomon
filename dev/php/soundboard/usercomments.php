<?php 


require_once("friends.php");
require_once("../lib/tamberconnect.php");




/**
 * @param: $fid the fid of the user in question
 * @return: the array of comments this user has posted
 */
function getUserComments($fid){
	$tc = $GLOBALS['tamberConnection'];
	$results = $tc->query("SELECT * FROM commentator_comments WHERE fid=\"$fid\"");
	$comments = array();
	while($row = $results->fetch_object()){
		array_push($comments, $row);
		
	}
	return $comments;
}

/**
 * @param: $fid the fid of the user in question
 * @return: the array of comments this user's friends has posted
 */
function getFriendComments($fid){
	$friends = getFriends($fid);
	$friendComments = array();
	
	foreach($friends as $frfid){
		array_merge($friendComments, getUserComments($frfid));
	}
	
	return $friendComments;
}

/**
 * A method to delete comments
 * @param: $id the unique commentator id of the comment to be removed
 * @return: the success of the SQL query
 */
function delComment($id){
	$tc = new TamberConnection();
	return $tc->query("DELETE FROM commentator_comments WHERE id=\"$id\"");
	
}


?>