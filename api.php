<?php

/**
 * Ordr.in API interface.
 *
 * @author   Evan Cohen <evanbtcohen@gmail.com | @3vanc>
 * @license  http://creativecommons.org/licenses/MIT/ MIT
 */

require_once('ordrin/OrdrinApi.php');

#Date Time (Either set or ASAP)
$dt = (isset($_POST['dT'])) ? $_POST['dT'] : 'ASAP';

if(isset($GLOBALS['dev']) && $GLOBALS['dev']){
	#TODO Use TEST_SERVERS only on dev (after everything is fixed)
}
$ordrin = new OrdrinApi("M4CEY61LCIGUUaOpzF4JcTKaHvuOVzb50ZdOYRhMPE", OrdrinApi::TEST_SERVERS);

if (!isset($_GET["api"])) {
	# code...
	$_GET["api"] = "n";
}

switch ($_GET["api"]) {
  case "r": #Don't do anything
  break;
  case "u": #Authenticate User
    $ordrin->user->authenticate($_POST['email'],hash('sha256',$_POST['pass']));
  break;
  case "o": #Place Order
  	try{
	    if(!empty($_POST['pass'])){
	      $ordrin->user->authenticate($_POST['email'],hash('sha256',$_POST['pass']));
	    }
	    $a = $ordrin::address($_POST["addr"], $_POST["city"], $_POST["state"], $_POST["zip"], $_POST['phone']);
	    $credit_card = $ordrin::creditCard($_POST['fName'] .' '. $_POST['lName'], $_POST['expMo'], $_POST['expYr'], $_POST['cardNum'], $_POST['csc'], $a); 

	    $details = $ordrin->restaurant->details($_POST["rid"]);
	    $items = array();
	    foreach($details->menu as $section) {
	      foreach($section->children as $item) {
	        if($item->price > 5) {
	          $items[] = $ordrin::trayItem($item->id, 6);
	          break;
	        }
	      }
	      if(count($items)) {
	        break;
	      }
	    }

	    $tray = $ordrin::tray($items);
	    
	    $data = array();
	    $data['request'] = array('restaurant_id'=>$_POST['rid'],'tray'=>$tray->_convertForAPI(),'tip'=>$_POST['tip'],'date'=>$dt,'em'=>$_POST['email'],'password'=>$_POST['pass'],"First Name"=>$_POST['fName'],"Last Name"=>$_POST['lName'],"addr"=>$a,"credit_card"=>$credit_card);
	    $addr = $ordrin::address($_POST["addr"], $_POST["city"], $_POST["state"], $_POST["zip"], "");
	    $print = $ordrin->order->submit($_POST["rid"], $tray, $_POST['tip'], $dt, $_POST["email"], $_POST['pass'], $_POST["fName"], $_POST["lName"], $a, $credit_card);
	    $data['response'] = $print;
	    echo json_encode($data);
	}catch(Exception $e){
		echo "{Swag Exception} " . $e;
	}
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