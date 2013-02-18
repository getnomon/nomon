 <?php
 ini_set('display_errors',1); 
 error_reporting(E_ALL);

if(isset($_REQUEST['action'])){
	$action = $_REQUEST['action'];
	//chdir('/home/ubuntu/public_html/ev');
	 require_once("backend.php");

	switch($action){
		case 'explain':
			$fid = $_POST["fid"];
			$artistName = $_POST["artistName"];
			
			$explanation = call_backend("WRCD", $fid . " " . $artistName);
			echo $explanation;
			break;
			
		case 'addConcert': #ARTIST;
			$lastfmID = $_POST["lfid"];
			$fid = $_POST["fid"];		
			$error_code = call_backend("AATN", $fid . " ".  $lastfmID);
				
			if($error_code === "1") {
				echo "Concert already added";
			}
			else echo "1";	
			break;
			
		case 'delConcert':
			$lfid = $_POST["lfid"];
			$fid = $_POST["fid"];

			call_backend("RATN", $fid . " " . $lfid);
			
			echo "1"; #Concert deleted
			break;
			
		case 'fan':
			$fid = $_POST["fid"];
			$artistName = $_POST["artistName"];

			$error = call_backend("ALIK", $fid . " " . $artistName);

			if($error === "1") {
				echo "Artist already added";
			}
			else {
				echo "1";				
			}
			break;
			
		case 'unfan':
			$fid = $_POST["fid"];
			$artistName = $_POST["artistName"];
			call_backend("RLIK", $fid . " " . $artistName);
			
			echo "1";
			break;
		
		case 'delcomment':
			
			$id = $_POST["id"];
			require_once("../soundboard/usercomments.php");
			delComment($id);
			echo 1;
			break;
			
			
		/*
		 * TODO: IMPLEMENT ALL OF THE REST OF THESE ON THE FRONT END 
		 */
			
		
		case 'addDislike':
			$fid = $_POST["fid"];
			$artistName = $_POST["artistName"];

			$error = call_backend("ADIS", $fid . " " . $artistName);

			if($error === "1") {
				echo "Artist already disliked";
			}
			else {
				echo "1";				
			}
			break;
		
		case 'delDislike':
			$fid = $_POST["fid"];
			$artistName = $_POST["artistName"];
			call_backend("RDIS", $fid . " " . $artistName);
			
			echo "1";
			break;
	
		case 'addMeh':
			$fid = $_POST["fid"];
			$artistName = $_POST["artistName"];

			$error = call_backend("AMEH", $fid . " " . $artistName);

			if($error === "1") {
				echo "Artist already meh";
			}
			else {
				echo "1";				
			}
			break;
			
		case 'delMeh':
			$fid = $_POST["fid"];
			$artistName = $_POST["artistName"];
			call_backend("RMEH", $fid . " " . $artistName);
			
			echo "1";
			break;

			
		#SOCIAL
		case 'addFriend':
			$fid = $_POST["fid"];
			$friendfid = $_POST["friendfid"];
			
			$error = call_backend("AFND", $fid . " " . $friendfid);
			switch($error){
				case "0":
					// echoes 1 for success
					echo "1";
					break;
					
				case "1":
					echo "You are already freinds";
					break;
					
				case "2":
					echo "Friend request already sent";
					break;
					
				case "3":
					echo "You have a pending friend request from this user";
					break;
			}
			
			
		case 'delFriend':
			$fid = $_POST["fid"];
			$friendfid = $_POST["friendfid"];
			
			$error = call_backend("RFND", "$fid $friendfid");
			// no error should ever be thrown on this
			echo "1";
			break;
			
		case 'accFriendRequest':
			$fid = $_POST["fid"];
			$friendfid = $_POST["friendfid"];
			
			$error = call_backend("AFRQ", "$fid $friendfid");
			break;
			
		case 'suggestConcert':
			$fid = $_POST["fid"];
			$tofid = $_POST["tofid"];
			$lastfmID = $_POST["lfid"];
			
			$error = call_backend("SUGC", "$fid $tofid $lastfmID");
			if($error == "0"){
				echo "1";
			}
			else{
				echo "Concert already suggested";
			}
			break;
			
		case 'unsuggestConcert':
			$fid = $_POST["fid"];
			$tofid = $_POST["tofid"];
			$lastfmID = $_POST["lfid"];
			
			$error = call_backend("USGC", "$fid $tofid $lastfmID");
			// should not throw error
			echo "1";
			break;
			
		case 'sendMessage':
			$fid = $_POST["fid"];
			$tofid = $_POST["tofid"];
			$msg = $_POST["msg"];
			
			$error = call_backend("SMSG", "$fid $tofid $msg");
			// should not throw error
			echo "1";
			break;
			
		case 'removeFromGroup':
			$fid = $_POST["fid"];
			$gid = $_POST["gid"];
			
			$error = call_backend("RGRP", "$fid $gid");
			// should not throw error
			echo "1";
			break;
			
		case 'addToGroup':
			$fid = $_POST["fid"];
			$gid = $_POST["gid"];
			
			$error = call_backend("RGRP $fid $gid");
			if($error == "1"){
				echo "User already added";
			}
			else{
				echo "1";
			}
			
			break;
			
		case 'makeGroup':
			$name = $_POST["name"];
			$fid = $_POST["fid"];
			
			$error = call_backend("MGRP", "$name $fid");
			// should not throw error
			echo "1";
			break;
			
		case 'suggestGroupConcert':
			$fid = $_POST["fid"];
			$gid = $_POST["gid"];
			$lastfmID = $_POST["lfid"];
			
			$error = call_backend("SCGP", "$gid $fid $lfid");
			if($error == "0"){
				echo "1";
			}
			else{
				echo "Concert already suggested";
			}
			break;
			
		case 'unsuggestGroupConcert':
			$fid = $_POST["fid"];
			$gid = $_POST["gid"];
			$lastfmID = $_POST["lfid"];
			
			$error = call_backend("USCG", "$gid $fid $lfid");
			// should not throw error
			echo "1";
			break;
			
		case 'sendGroupMessage':
			$fid = $_POST["fid"];
			$gid = $_POST["gid"];
			$msg = $_POST["msg"];
			
			$error = call_backend("GMSG", "$gid $fid $msg");
			// should not throw error
			echo "1";
			break;
		case 'getSimmilarImage':
			$name = $_POST["name"];
			echo call_backend("IMAG", $name);
			break;
		case 'postReview':
			$artist = $_POST['artist'];
			$fid = $_POST['fid'];
			$venue = $_POST['venue'];
			$rating = $_POST['rating'];
			$review = $_POST['review'];
			$error = call_backend("ARVW", "$artist/AND/$fid/AND/$venue/AND/$rating/AND/$review");
			
			break;
		default: #PAGE
			echo "Action unrecognized";
			
	}
}else{
	echo '0';
}
 ?>