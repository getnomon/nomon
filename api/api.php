<?php

/**
 * Ordr.in and nomON API interface.
 *
 * @author   Evan Cohen < evanbtcohen@gmail.com | @3vanc >
 * @license  http://creativecommons.org/licenses/MIT/ MIT
 */

#Autoload our classes, like a baus
function __autoload($name) {
    require_once($name . '.php');
}

$nomon = new nomon();

$dt = 'ASAP';

if(isset($GLOBALS['dev']) && $GLOBALS['dev']){
	#TODO Use TEST_SERVERS only on dev (after everything is fixed)
}

if (!isset($_GET["api"])) {
	$_GET["api"] = "n";
}

switch ($_GET["api"]) {
  case "r": #Don't do anything
  break;
  case "u": #Authenticate User
  	$hashPass = hash('sha256',$_POST['pass']); //save this cookie?
    $ordrin->user->authenticate($_POST['email'], $hashPass);
  break;
  case "o": #Place Order
  	$nomon->submit();
  break;
}
if(!isset($_POST['func'])) {
  $_POST['func'] = 'ord'; #Order already processed
}

try{
	switch ($_POST["func"]) {
	#Restaurant API
	  case "dl": #Delivery List
	    $addr = $ordrin::address($_POST["addr"], $_POST["city"], $_POST["state"], $_POST["zip"], "");
	    $print = $ordrin->restaurant->getDeliveryList($dt, $addr);
	    echo json_encode($print);
	  break;
	  case "dc": #Delivery Check
	    $addr = $ordrin::address($_POST["addr"], $_POST["city"], $_POST["state"], $_POST["zip"], "");
	    $print = $ordrin->restaurant->deliveryCheck($_POST["rid"], $dt, $addr);
	    echo json_encode($print);
	  break;
	  case "df": #Delivery Fee
	    $sT = $_POST["sT"];
	    $tip = $_POST["tip"];
	    $addr = $ordrin::address($_POST["addr"], $_POST["city"], $_POST["state"], $_POST["zip"], "");
	    $print = $ordrin->restaurant->deliveryFee($_POST["rid"], $sT, $tip, $dt, $addr);
	    echo json_encode($print);
	  break;
	  case "rd": #Restaurant Details
	    $print = $ordrin->restaurant->details($_POST["rid"]);
	    echo json_encode($print);
	  break;
	#User API
	  case "gacc": #Account Info
	    $print = $ordrin->user->getAccountInfo();
	    echo json_encode($print);
	  break;
	  case "macc": #Create Account
	    $print = $ordrin->user->create($_POST["email"], hash('sha256',$_POST["pass"]), $_POST["fName"], $_POST["lName"]);
	    echo json_encode($print);
	  break;
	  case "upass": #Update Password
	    $ordrin->user->authenticate($_POST['email'],hash('sha256',$_POST['oldPass']));
	    $print = $ordrin->user->updatePassword(hash('sha256',$_POST['pass']));
	    echo json_encode($print);
	  break;
	  case "gaddr": #Saved Address(es)
	    $print = $ordrin->user->getAddress($_POST["addrNick"]);
	    echo json_encode($print);
	  break;
	  case "uaddr": #Save/Update Address
	    $a = $ordrin::Address($_POST["addr"], $_POST["city"], $_POST["state"], $_POST["zip"], $_POST["phone"], $_POST["addr2"]);
	    $print = $ordrin->user->setAddress($_POST["addrNick"], $a);
	    echo json_encode($print);
	  break;
	  case "daddr": #Delete Address
	    $print = $ordrin->user->deleteAddress($_POST["addrNick"]);
	    echo json_encode($print);
	  break;
	  case "gcar": #Get Card(s)
	    $print = $ordrin->user->getCard($_POST["cardNick"]);
	    echo json_encode($print);
	  break;
	  case "ucar": #Save/update Card
	    $a = $ordrin::Address($_POST["addr"], $_POST["city"], $_POST["state"], $_POST["zip"], $_POST["phone"], $_POST["addr2"]);
	    $print = $ordrin->user->setCard($_POST["cardNick"], $_POST["fName"] . $_POST["lName"], $_POST["cardNum"], $_POST["csc"], $_POST["expMo"], $_POST["expYr"], $a);
	    echo json_encode($print);
	  break;
	  case "dcar": #Delete Card
	    $print = $ordrin->user->deleteCard($_POST["cardNick"]);
	    echo json_encode($print);
	  break;
	  case "gordr": #Get Previous Order(s)
	    $print = $ordrin->user->getOrderHistory();
	    echo json_encode($print);
	  break;
	  case "gordrs": #Info On Specific Order
	    $print = $ordrin->user->getOrderHistory($_POST["ordrID"]);
	    echo json_encode($print);
	  break;
	}
}catch (Exception $e){
	echo json_encode(errorToJSON($e)); //return error
}


function errorToJSON($e){
	$error['error']['message'] = $e->getMessage();
	$error['error']['code'] = $e->getCode();
	return $error;
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