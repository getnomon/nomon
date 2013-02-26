<?php
ini_set('display_errors',1); 
error_reporting(E_ALL);
/**
 * Ordr.in Test API interface.
 *
 * @author   Evan Cohen <evanbtcohen@gmail.com | @3vanc>
 * @license  http://creativecommons.org/licenses/MIT/ MIT
 */

	$mtime = microtime(); 
	$mtime = explode(" ",$mtime); 
	$mtime = $mtime[1] + $mtime[0]; 
	$starttime = $mtime; 


echo '<h4>Document loaded!<h4>';

require_once('ordrin/OrdrinApi.php');

#Date Time (Either set or ASAP)
$dt = (isset($_REQUEST['dT'])) ? $_REQUEST['dT'] : 'ASAP';
# DEV : Ff8tzeriI0SGq9xiNBzbIkuhMdbar7Mml8SKrd9cKD0
# SITE: e2ZK67T9HAFW3uVhDtKFVbO33dmUnHgWzMMZNgAlPwE
$ordrin = new OrdrinApi("M4CEY61LCIGUUaOpzF4Jc_TKaHvuOVzb50ZdOYRhMPE", OrdrinApi::TEST_SERVERS);

$MYSQL = "";

#Connect to DB
$con = mysqli_connect("localhost","nomon","iloveapples","nomon");
// Check connection
if (mysqli_connect_errno($con)){
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

if(!isset($_REQUEST['func'])) {
  $_REQUEST['func'] = 'ord'; #Order already processed
}

try{
	switch ($_REQUEST["func"]) {
	#Restaurant API
	  case "dl": #Delivery List
	    $addr = $ordrin::address($_REQUEST["addr"], $_REQUEST["city"], $_REQUEST["state"], $_REQUEST["zip"], "");
	    $print = $ordrin->restaurant->getDeliveryList($dt, $addr);
	    echo "<pre>Extract Data\n";

	    //Getting data on each restaurant
	    foreach ($print as $restaurant) {
	    	$address = explode(',',$restaurant->ad);
	    	
	    	echo "ID: " . "<a href='/test2.php?func=rd&rid=$restaurant->id'>" . $restaurant->id . "</a>\n";
	    	echo "Name: " . $restaurant->na . "\n";
	    	echo "Phone: " . $restaurant->cs_phone . "\n";
	    	echo "Minimum Order: $" . $restaurant->mino . "\n";
	    	if (isset($restaurant->cu[0])) {
	    		echo "Type: " . $restaurant->cu[0] . "\n";
	    	}
	    	echo "Address: " . $address[0] . "\n";
	    	if (isset($restaurant->city)) {
 	    		echo "City: " . $restaurant->city . "\n";
	    	}
	    	echo "\n";
	    	
	    	#RestaurantType
    		if(isset($restaurant->cu[0])){
    			$typeID = getRestaurantTypeID($con, $restaurant->cu[0]);
			}else{
				$typeID = 'None';
			}
	    	#This goes into the database
	    	if(isset($_REQUEST['popr'])){
	    		$sql = "INSERT INTO tbl_restaurant
	    		VALUES ($restaurant->id,  $typeID, $restaurant->na, $restaurant->mino, $address[0], $restaurant->cs_phone);";
	    		$query = mysqli_query($con,$sql);
	    		echo $query;
	    	}elseif(isset($_REQUEST['popt'])){
				$sql2 = "INSERT INTO tbl_restaurant_type (RestTypeName)
				VALUES ($typeID);";
				//mysqli_query($con,$sql2);
				$MYSQL .= $sql2 . "\n";
			}
	    }
	    echo "<pre>";
	  break;
	  case "dc": #Delivery Check
	    $addr = $ordrin::address($_REQUEST["addr"], $_REQUEST["city"], $_REQUEST["state"], $_REQUEST["zip"], "");
	    $print = $ordrin->restaurant->deliveryCheck($_REQUEST["rid"], $dt, $addr);
	    echo json_encode($print);
	  break;
	  case "df": #Delivery Fee
	    $sT = $_REQUEST["sT"];
	    $tip = $_REQUEST["tip"];
	    $addr = $ordrin::address($_REQUEST["addr"], $_REQUEST["city"], $_REQUEST["state"], $_REQUEST["zip"], "");
	    $print = $ordrin->restaurant->deliveryFee($_REQUEST["rid"], $sT, $tip, $dt, $addr);
	    echo json_encode($print);
	  break;
	  case "rd": #Restaurant Details

	    echo '<pre>';
	    $restaurant = $ordrin->restaurant->details($_REQUEST["rid"]);
	    $menu = $restaurant->menu;

	    //parse menu
	    getDishes($con, $_REQUEST["rid"], $menu);

	    //echo '____________________________________________________________________';
	    //print_r($menu);
	    
	    echo '</pre>';
	  break;
	#User API
	  case "gacc": #Account Info
	    $print = $ordrin->user->getAccountInfo();
	    echo json_encode($print);
	  break;
	  case "macc": #Create Account
	    $print = $ordrin->user->create($_REQUEST["email"], hash('sha256',$_REQUEST["pass"]), $_REQUEST["fName"], $_REQUEST["lName"]);
	    echo json_encode($print);
	  break;
	  case "upass": #Update Password
	    $ordrin->user->authenticate($_REQUEST['email'],hash('sha256',$_REQUEST['oldPass']));
	    $print = $ordrin->user->updatePassword(hash('sha256',$_REQUEST['pass']));
	    echo json_encode($print);
	  break;
	  case "gaddr": #Saved Address(es)
	    $print = $ordrin->user->getAddress($_REQUEST["addrNick"]);
	    echo json_encode($print);
	  break;
	  case "uaddr": #Save/Update Address
	    $a = $ordrin::Address($_REQUEST["addr"], $_REQUEST["city"], $_REQUEST["state"], $_REQUEST["zip"], $_REQUEST["phone"], $_REQUEST["addr2"]);
	    $print = $ordrin->user->setAddress($_REQUEST["addrNick"], $a);
	    echo json_encode($print);
	  break;
	  case "daddr": #Delete Address
	    $print = $ordrin->user->deleteAddress($_REQUEST["addrNick"]);
	    echo json_encode($print);
	  break;
	  case "gcar": #Get Card(s)
	    $print = $ordrin->user->getCard($_REQUEST["cardNick"]);
	    echo json_encode($print);
	  break;
	  case "ucar": #Save/update Card
	    $a = $ordrin::Address($_REQUEST["addr"], $_REQUEST["city"], $_REQUEST["state"], $_REQUEST["zip"], $_REQUEST["phone"], $_REQUEST["addr2"]);
	    $print = $ordrin->user->setCard($_REQUEST["cardNick"], $_REQUEST["fName"] . $_REQUEST["lName"], $_REQUEST["cardNum"], $_REQUEST["csc"], $_REQUEST["expMo"], $_REQUEST["expYr"], $a);
	    echo json_encode($print);
	  break;
	  case "dcar": #Delete Card
	    $print = $ordrin->user->deleteCard($_REQUEST["cardNick"]);
	    echo json_encode($print);
	  break;
	  case "gordr": #Get Previous Order(s)
	    $print = $ordrin->user->getOrderHistory();
	    echo json_encode($print);
	  break;
	  case "gordrs": #Info On Specific Order
	    $print = $ordrin->user->getOrderHistory($_REQUEST["ordrID"]);
	    echo json_encode($print);
	  break;
	}
}catch (Exception $e){
	echo "{Swag Exception} " . $e;
}



function calcMeal($targetPrice, $result, $allergies = NULL){
	if($allergies != NULL){
		//If peanut allergy is in $allergies exclude Thai food
		//Dary -> pizza
	}
	
}

#recursivly prints out dishes
#accepts a menu id (menu parent description)
#MUST pass menu object

function getDishes($con, $rid, $item, $depth = -1){
	#item[children] is each of the children, if it has children it is a parent. duh.
	if(is_array($item)){
		for ($i=0; $i < count($item); $i++) { 
			#Contains a bunch of stdClass Objects
			getDishes($con, $rid, $item[$i], $depth+1);
		}
	}else{
		#is an stdObject -> check for children
		if (isset($item->children)) {
			#is sub menu/item (or dish with options)
			if($depth == 0){
				echo "!Parent menu [$item->id] $item->name \n";
			}
			for($j=0; $j<$depth; $j++){
				echo "=";
			}
			echo '![' . $item->id . ']' . " $" . $item->price . " " . $item->name;
			echo " - " . $item->descrip . "\n";
			getDishes($con, $rid, $item->children, $depth+1);
		}else{
			#is a dish - save shit shit
			for($j=0; $j<$depth; $j++){
				echo "=";
			}
			echo '[' . $item->id . ']' . " $" . $item->price . " " . $item->name;
			echo " - " . $item->descrip . "\n";
			//print_r($item);
		}
	}
}

function getRestaurantTypeID($con, $type){
	$sql = "SELECT RestTypeID FROM tbl_restaurant_type WHERE RestTypeName='$type'";
	$query = mysqli_query($con,$sql);
	if($query = null){
		$sql2 = "INSERT INTO tbl_restaurant_type (RestTypeName)
		VALUES ($type)";
		mysqli_query($con,$sql2);
		$query = mysqli_query($con,$sql);
	}
	return $query;
}

$mtime = microtime();
$mtime = explode(" ",$mtime); 
$mtime = $mtime[1] + $mtime[0]; 
$endtime = $mtime; 
$totaltime = ($endtime - $starttime); 
echo "This page was created in ".$totaltime." seconds"; 

#close DB connection
mysqli_close($con);

echo $MYSQL;
?>