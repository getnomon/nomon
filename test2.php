<?php

/**
 * Ordr.in Test API interface.
 *
 * @author   Evan Cohen <evanbtcohen@gmail.com | @3vanc>
 * @license  http://creativecommons.org/licenses/MIT/ MIT
 */
echo '<h4>Document loaded!<h4>';

require_once('ordrin/OrdrinApi.php');

#Date Time (Either set or ASAP)
$dt = (isset($_REQUEST['dT'])) ? $_REQUEST['dT'] : 'ASAP';

$ordrin = new OrdrinApi("e2ZK67T9HAFW3uVhDtKFVbO33dmUnHgWzMMZNgAlPwE", OrdrinApi::TEST_SERVERS);

if(!isset($_REQUEST['func'])) {
  $_REQUEST['func'] = 'ord'; #Order already processed
}

try{
	switch ($_REQUEST["func"]) {
	#Restaurant API
	  case "dl": #Delivery List
	    $addr = $ordrin::address($_REQUEST["addr"], $_REQUEST["city"], $_REQUEST["state"], $_REQUEST["zip"], "");
	    $print = $ordrin->restaurant->getDeliveryList($dt, $addr);
	    $randomIndex = array_rand($print, 1);

	    echo '<pre>';
	    $randomRestaurant = $print[$randomIndex];
	    print_r($randomRestaurant);
	    $restaurant = $ordrin->restaurant->details($randomRestaurant->id);
	    $menu = $restaurant->menu;
	    print_r($menu);
	    echo '</pre>';
	    /*foreach ($print as $restaurant) {
	    	print($restaurant->id . " - " . $restaurant->na);
	    	echo '<pre>';
		    print_r($restaurant);
		    echo '</pre>';
	    }*/
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
	    $print = $ordrin->restaurant->details($_REQUEST["rid"]);
	    echo json_encode($print);
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

/*Acceps an array of allergie IDs*/
function genNote($allergies){
	$note = "[NomON]\n Please note, this person has the following food alergies/prefrences:\n";
	foreach ($allergies as $allergie) {
		$note .= "- $allergie\n";
	}
	$note .= "If the order contains any of thse alergies/prefrences ";
	$note .= "please substitute the order for an item of equal value from your menu.\n";
	$note .= "Thanks!\n -NomON | nomon.co";
}

?>