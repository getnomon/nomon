<?php
ini_set('display_errors',1); 
error_reporting(E_ALL);
/**
 * Info 340 Database Project
 *
 * @author   Evan Cohen <evanbtcohen@gmail.com | @3vanc>
 * @license  http://creativecommons.org/licenses/MIT/ MIT
 * 
 * This database creation script is a bit tricky to use, it has to be hooked up to a
 * database and have a valid Ordrin API key (secrit) in order to run.
 * Population in controlled by URL paramaters. I used my home address as a base for
 * my import of Seattle. For instance this set of paramaters will load up the importer:
 * populate.php?addr=4308%20Place%20NE&city=Seattle&state=WA&zip=98105
 *
 * In order to actually begin to import data you have to follow a specific order (In 
 * order to have primary keys function properly). The first command you need to run
 * is as follows:
 *
 * func=dl&pop=tbl_restaurant
 *
 * This will populate the restaurant and restaurant type table. You can then open each 
 * Restaurant and import their Menu and dish items by clicking the linked ID of the
 * restaurant. You now have 5 of the 8 tables populated. Good job!
 */

/*#array of whitelisted functions
$functionWhitelist = array("foo", "bar");
if(function_exists($function_name) && in_array($function_name, $functionWhitelist) ){
	call_user_func($function_name, $function_data);
}*/

	$mtime = microtime(); 
	$mtime = explode(" ",$mtime); 
	$mtime = $mtime[1] + $mtime[0]; 
	$starttime = $mtime; 

	$menuid = 0;


echo '<h4>Document loaded!<h4>';

require_once('ordrin/OrdrinApi.php');

#Date Time (Either set or ASAP)
$dt = (isset($_REQUEST['dT'])) ? $_REQUEST['dT'] : 'ASAP';


# DEV : Ff8tzeriI0SGq9xiNBzbIkuhMdbar7Mml8SKrd9cKD0
# SITE: e2ZK67T9HAFW3uVhDtKFVbO33dmUnHgWzMMZNgAlPwE
$ordrin = new OrdrinApi("M4CEY61LCIGUUaOpzF4Jc_TKaHvuOVzb50ZdOYRhMPE", OrdrinApi::TEST_SERVERS);


#Connect to DB
$GLOBALS['con'] = mysqli_connect("localhost","nomon","iloveapples","nomon");
$con = $GLOBALS['con'];
// Check connection
if (mysqli_connect_errno($con)){
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

if(!isset($_REQUEST['func'])) {
  $_REQUEST['func'] = 'fin'; #Order already processed
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
	    	echo "ID: " . "<a href='/test2.php?func=rd&rid=$restaurant->id' target='_blank'>" . $restaurant->id . "</a>\n";
	    	echo "Name: " . $restaurant->na . "\n";
	    	echo "Phone: " . $restaurant->cs_phone . "\n";
	    	echo "Minimum Order: $" . $restaurant->mino . "\n";
	    	if (isset($restaurant->cu[0])) {
	    		echo "Type: " . $restaurant->cu[0] . "\n";
	    	}
	    	$address = explode(',',$restaurant->ad);
	    	echo "Address: " . $address[0] . "\n";
	    	if (isset($restaurant->city)) {
 	    		echo "City: " . $restaurant->city . "\n";
	    	}
	    	echo "\n";
	    	
	    	#This goes into the database
	    	if(isset($_REQUEST['pop'])){
	    		if(!isset($restaurant->cu[0])){
					$restaurant->cu[0] = "Specialty";
    			}

				$result = mysqli_fetch_array(getRestaurantTypeID($con, $restaurant->cu[0]));
    			$typeID = $result['RestTypeID'];
    			echo "TypeID: $typeID\n";
    			if($_REQUEST['pop'] == "tbl_restaurant"){
		    		$sql = "INSERT INTO tbl_restaurant
		    		VALUES ('".$restaurant->id."', '".$typeID."', '".
		    			mysql_real_escape_string($restaurant->na)."','".$restaurant->mino."', '".
		    			mysql_real_escape_string($address[0])."', '".$restaurant->cs_phone."')";
		    		$query = mysqliQuery($con,$sql);
	    		}

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
	    print_r($menu);
	    //parse menu
	    getDishes($con, $_REQUEST["rid"], $menu);
	    echo '</pre>';
	  break;
	#User API
	  case "gacc": #Account Info
	    $print = $ordrin->user->getAccountInfo();
	    echo json_encode($print);
	  break;
	  case "macc": #Create Account
	    /*$print = $ordrin->user->create($_REQUEST["email"], hash('sha256',$_REQUEST["pass"]), $_REQUEST["fName"], $_REQUEST["lName"]);
	    echo json_encode($print);*/
	  	if(isset($_REQUEST['email']) && isset($_REQUEST['fName']) && 
	  	  isset($_REQUEST['lName']) && isset($_REQUEST['address']) && 
	  	  isset($_REQUEST['zip-code']) && isset($_REQUEST['phone'])){
	  		$email = mysql_real_escape_string($_REQUEST['email']);
	  		$fname = mysql_real_escape_string($_REQUEST['fName']);
	  		$lname = mysql_real_escape_string($_REQUEST['lName']);
	  		$addr = mysql_real_escape_string($_REQUEST['address']);
	  		$zip = mysql_real_escape_string($_REQUEST['zip-code']);
	  		$phone = mysql_real_escape_string($_REQUEST['phone']);
	  		$sql = "INSERT INTO tbl_customer (CustEmail, CustFname, CustLname, CustStreet, CustZip)
	  		('".$email."', '".$fname."', '".$lname."', '".$addr."', '".$zip."', '".$phone."')";
	  		$query = mysqliQuery($con,$sql);
	  		echo "<h4>User added...<h4>";
	  	}
	    ?>
	    <form action="populate.php?func=macc" method="get">
	    	<style type="text/css">
	    		lable{
	    			width: 200px;
	    		}
	    	</style>
			<lable>Email:</lable> <input name="email" type="text" size="20" value=""> <br />
		    <lable>First name:</lable> <input name="fName" type="text" size="12" value=""> Last name: <input name="lName" type="text" size="12" value=""><br />
		    <lable>Street Address:</lable> <input name="address" type="text" size="20" value="">
		    <lable>ZIP:</lable> <input name="zip-code" type="text" size="5" value=""><br />
		    <lable>Phone number:</lable> <input name="phone" type="text" size="10" value=""><br />
		    <button type="submit" value="Submit">Submit</button>
  			<button type="reset" value="Reset">Clear</button>
	    </form>
	    <?php
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
	  #########
	  case "ordr":

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
function getDishes($con, $rid, $item, $depth = -1, $menuid = 0, $parentid = 0){
	#item[children] is each of the children, if it has children it is a parent. duh.
	if(is_array($item)){
		for ($i=0; $i < count($item); $i++) { 
			#Contains a bunch of stdClass Objects
			getDishes($con, $rid, $item[$i], $depth+1, $menuid, $parentid);
		}
	}else{
		#is an stdObject -> check for children
		if(!isset($item->children) && $parentid = 0){
			echo "We are about to experience turbulance...";
		}
		if (isset($item->children)) {
			#is sub menu/item (or dish with options)
			if($depth == 0){
				echo "!Parent menu [$item->id] $item->name\n";
				$sql = "INSERT INTO tbl_menu
	    			VALUES ('".
	    				$item->id."', '".
	    				$rid."', '".
	    				mysql_real_escape_string($item->name)."', '".
	    				mysql_real_escape_string($item->descrip)."')";
	    		$result = mysqliQuery($con,$sql);
	    		getDishes($con, $rid, $item->children, $depth+1, $item->id + 0);
			}else{
				#is a menu item with children
				for($j=0; $j<$depth; $j++){
					echo "=";
				}
				echo '!('. $parentid.')[' . $item->id . ']' . " $" . $item->price . " " . $item->name;
				echo " - " . $item->descrip . "\n";
				$sql = "INSERT INTO tbl_dish (DishID, MenuID, DishName, DishDescr, DishPrice, DishOrderable)
		    		VALUES ('".
		    			$item->id."', '".
		    			$menuid."', '".
		    			mysql_real_escape_string($item->name)."', '".
		    			mysql_real_escape_string($item->descrip)."', '".
		    			$item->price."', '".
		    			$item->is_orderable."')";
		    	$result = mysqliQuery($con,$sql);

		    	getDishes($con, $rid, $item->children, $depth+1, $menuid + 0, $item->id + 0);
			}
		}else{
			#is a dish - save shit shit
			for($j=0; $j<$depth; $j++){
				echo "=";
			}
				echo '('. $parentid.')[' . $item->id . ']' . " $" . $item->price . " " . $item->name;
				echo " - " . $item->descrip . "\n";
			if($parentid != 0){
				$sql = "INSERT INTO tbl_dish
		    		VALUES ('".
		    			$item->id."', '".
		    			$menuid."', '".
		    			$parentid."', '".
		    			mysql_real_escape_string($item->name)."', '".
		    			mysql_real_escape_string($item->descrip)."', '".
		    			$item->price."', '".
						$item->is_orderable."')";
		    	$result = mysqliQuery($con,$sql);
	    	}elseif ($menuid != 0) {
	    		#ignore all empty menus, becuase fuck that! (They would serve no purpose exept to pollute the db)
	    		$sql = "INSERT INTO tbl_dish (DishID, MenuID, DishName, DishDescr, DishPrice, DishOrderable)
			    		VALUES ('".
			    			$item->id."', '".
			    			$menuid."', '".
			    			mysql_real_escape_string($item->name)."', '".
			    			mysql_real_escape_string($item->descrip)."', '".
			    			$item->price."', '".
			    			$item->is_orderable."')";
			    	$result = mysqliQuery($con,$sql);
	    	}

		}
	}
}

function getRestaurantTypeID($con, $type){
	$sql = "SELECT RestTypeID FROM tbl_restaurant_type WHERE RestTypeName='".$type."'";
	$result = mysqliQuery($con,$sql);
	echo "\n";
	if($result->num_rows == 0){
		$sql2 = "INSERT INTO tbl_restaurant_type (RestTypeName)
		VALUES ('".$type."')";
		$retult = mysqliQuery($con,$sql2);
		echo 'Created new type: ' . $retult . "\n";
		$result = mysqliQuery($con,$sql);
	}
	return $result;
}

//Runs the given query on the given connection
//Returns an array of results
function mysqliQuery($con, $sql){
	if(!$result = $con->query($sql)){
    	die('There was an error running the query [' . $con->error . ']');
	}
	return $result;
}


//Returns an array of all leaf dishes
//Item is the parent menu object
function buildPlatter($item, $target, $depth = -1, $price = 0, $combinations = null){
	if($price < $target){ #Assure that possibilities 
		if(is_array($item)){
			for ($i=0; $i < count($item); $i++) { 
				#Contains a bunch of stdClass Objects
				buildPlatter($item[$i], $depth+1);
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
				buildPlatter($item->children, $target, $depth+1, $price+$item->price);
			}else{
				#is a dish - save shit shit - leaf
				for($j=0; $j<$depth; $j++){
					echo "=";
				}

				echo '[' . $item->id . ']' . " $" . $item->price . " " . $item->name;
				echo " - " . $item->descrip . "\n";
				//print_r($item);
			}
		}
	}
}

# Extract All Unique Conbinations
function extractList($array, &$list, $temp = array()) {
    if (count($temp) > 0 && ! in_array($temp, $list))
        $list[] = $temp;
    for($i = 0; $i < sizeof($array); $i ++) {
        $copy = $array;
        $elem = array_splice($copy, $i, 1);
        if (sizeof($copy) > 0) {
            $add = array_merge($temp, array($elem[0]));
            sort($add);
            extractList($copy, $list, $add);
        } else {
            $add = array_merge($temp, array($elem[0]));
            sort($add);
            if (! in_array($temp, $list)) {
                $list[] = $add;
            }
        }
    }
}

/*array_filter($list,	function($var) use ($sum) {
		return(array_sum($var) == $sum);
		}
);*/

#Sample Data
/*$data = array(array(2,3,5,10,15),array(4,6,23,15,12),array(23,34,12,1,5));
$maxsum = 25;
print_r(bestsum($data,$maxsum));  //function call*/

/*
*	% data array of arrays or integers
*	% maxsum caps the sum of the data
*/
function bestsum($data,$maxsum){
	$res = array_fill(0, $maxsum + 1, '0');
	$res[0] = array();              //base case
	foreach($data as $group){
		$new_res = $res;               //copy res
		foreach($group as $ele){
			for($i=0;$i<($maxsum-$ele+1);$i++){   
				if($res[$i] != 0){
					$ele_index = $i+$ele;
					$new_res[$ele_index] = $res[$i];
					$new_res[$ele_index][] = $ele;
				}
			}
		}
		$res = $new_res;
	}
	for($i=$maxsum;$i>0;$i--){
		if($res[$i]!=0){
			return $res[$i];
		break;
		}
	}
	return array();
}

#########################################################
# 0-1 Knapsack Problem Solve (with "memo"-ization optimization)
# $w = weight of item
# $v = value of item
# $i = index
# $aW = Available Weight
# $m = 'memo' array
#########################################################

function knapSolveFast($w,$v,$i,$aW,&$m) { // Note: We use &$m because the function writes to the $m array 
 
	global $numcalls;
	$numcalls ++;
	// echo "Called with i=$i, aW=$aW<br>";
 
	// Return memo if we have one
	if (isset($m[$i][$aW])) {
		return $m[$i][$aW];
	} else {
 
		if ($i == 0) {
			if ($w[$i] <= $aW) {
				$m[$i][$aW] = $v[$i]; // save memo
				return $v[$i];
			} else {
				$m[$i][$aW] = 0; // save memo
				return 0;
			}
		}	
 
		$without_i = knapSolveFast($w, $v, $i-1, $aW,$m);
		if ($w[$i] > $aW) {
			$m[$i][$aW] = $without_i; // save memo
			return $without_i;
		} else {
			$with_i = $v[$i] + knapSolveFast($w, $v, ($i-1), ($aW - $w[$i]),$m);
			$res = max($with_i, $without_i); 
			$m[$i][$aW] = $res; // save memo
			return $res;
		}	
	}
}

################ Use Case #############################
/*$w3 = array(1, 1, 1, 2, 2, 2, 4, 4, 4, 44, 96, 96, 96);
$v3 = array(1, 1, 1, 2, 2, 2, 4, 4, 4, 44, 96, 96, 96);
 
$numcalls = 0;
$m = array();
$m3 = knapSolveFast($w3, $v3, sizeof($v3) -1, 54,$m);
print_r($w3); echo "<br>FAST: ";
echo "<b>Max: $m3</b> ($numcalls calls)<br><br>";*/

$mtime = microtime();
$mtime = explode(" ",$mtime); 
$mtime = $mtime[1] + $mtime[0]; 
$endtime = $mtime; 
$totaltime = ($endtime - $starttime); 
echo "This page was created in ".$totaltime." seconds"; 

#close DB connection
mysqli_close($con);
?>