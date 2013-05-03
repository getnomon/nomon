<?php

/**
 * Ordr.in API interface.
 *
 * @author   Evan Cohen < evanbtcohen@gmail.com | @3vanc >
 * @license  http://creativecommons.org/licenses/MIT/ MIT
 *
 * TODO: Find out how to subvert cross domain POST
 * or at least do a secure get request.
 * This is a HUGE security vuniribility and will have
 * to be fixed ASAP
 *
 */

/*if(session_id() == "" && isset($_POST['session_id']) && $_POST['session_id'] != "undefined"){
	session_id($_POST['session_id']);
}*/
session_start();


$username = 'nomon';
$password = 'iloveapples';
$hostname = 'localhost'; // This will always need to be localhost on our server.
$database = 'nomon';

// Create a connection to the database.
$db = new PDO("mysql:dbname=$database;host=$hostname", $username, $password);

// Make any SQL syntax errors result in PHP errors.
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);



$VERSION = 0.87;

#Enable cross domain requests
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
#responce type
header('Content-Type: application/json');


/*get the message of the day! (we don't need the api for this)*/
if(isset($_POST['motd'])){
	$motd['motd'] = "<p style='text-align: center'>This is the message of the day! We can use <strong>html</html> too!</p>";
}

//Log the user out
if(isset($_GET['logout']) && $_GET['logout']){
	if (ini_get("session.use_cookies")) {
    	$params = session_get_cookie_params();
    	setcookie(session_name(), '', time() - 42000, $params["path"], 
    	$params["domain"], $params["secure"], $params["httponly"]);
	}
	// Finally, destroy the session.
	session_destroy();
	$message['responce']['message'] = "Logout successful";
	$message['responce']['logout'] = true;
	die(json_encode($message));
}


require_once('ordrin/OrdrinApi.php');

##Date Time (Either set or ASAP)
$dt = (isset($_POST['dT'])) ? $_POST['dT'] : 'ASAP';

if(isset($GLOBALS['dev']) && $GLOBALS['dev']){
	#TODO Use TEST_SERVERS only on dev (after everything is fixed)
}
$ordrin = new OrdrinApi("M4CEY61LCIGUUaOpzF4Jc_TKaHvuOVzb50ZdOYRhMPE", OrdrinApi::TEST_SERVERS);

if (!isset($_GET["api"])) {
	$_GET["api"] = "n";
}

switch ($_GET["api"]) {
  case "r": #Don't do anything
  break;
  case "u": #Authenticate User
  	if(isset($_POST['pass'])){
	  	try{
			$hashPass = hash('sha256',$_POST['pass']);
	    	$ordrin->user->authenticate($_POST['email'], $hashPass);
		}catch(Exception $e){
			die(errorToJSON($e));
		}
		//user is authenticated let's save that hashed pass
		if($_POST['start_session']){
			/*$sql = "INSERT INTO";*/

			bake('pass', $hashPass);
			bake('email',  $_POST['email']);
			$motd['sid'] = session_id();
			die(json_encode($motd));
		}
	}elseif(isset($_POST['get_session'])){
		//user is not authenticated! KILL IT WITH FIRE!
		//disabled for now
		if(false && $_POST['ver'] < $ver){
			$motd['ver'] = "<h1>Please download the newest version of nomON!</h1>";
		}
		if($_POST['get_session']){
			$motd['auth'] = ($_POST['session_id'] == session_id());
			$motd['sid'] = session_id();
		}
		echo json_encode($motd);
	}elseif(isset($_SESSION['pass'])){
		$fuck['nofuck'] = "Session varable is carrying over";
		$fuck['hashpass'] = $_SESSION['pass'];
		$fuck['sid'] = session_id();
		die(json_encode($fuck));
    	$ordrin->user->authenticate($_SESSION['email'], $_SESSION['pass']);
	}else{
		$fuck['fuck'] = "Session varable not carrying over";
		$fuck['sid'] = session_id();
		die(json_encode($fuck));
	}
  break;
  case "o": #Place Order
  	try{
	    if(!empty($_SESSION['pass'])){
	      $ordrin->user->authenticate($_SESSION['email'], $_SESSION['pass']);
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
	    $data['request'] = array('restaurant_id'=>$_POST['rid'],'tray'=>$tray->_convertForAPI(),'tip'=>$_POST['tip'],'date'=>$dt,'em'=>$_SESSION['email'],'password'=>$_SESSION['pass'],"First Name"=>$_POST['fName'],"Last Name"=>$_POST['lName'],"addr"=>$a,"credit_card"=>$credit_card);
	    $addr = $ordrin::address($_POST["addr"], $_POST["city"], $_POST["state"], $_POST["zip"], "");
	    $print = $ordrin->order->submit($_POST["rid"], $tray, $_POST['tip'], $dt, $_SESSION["email"], $_SESSION['pass'], $_POST["fName"], $_POST["lName"], $a, $credit_card);
	    $data['response'] = $print;
	    echo json_respond($data);
	}catch(Exception $e){
		echo json_respond(errorToJSON($e)); //return error
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
	    echo json_respond($print);
	  break;
	  case "dc": #Delivery Check
	    $addr = $ordrin::address($_POST["addr"], $_POST["city"], $_POST["state"], $_POST["zip"], "");
	    $print = $ordrin->restaurant->deliveryCheck($_POST["rid"], $dt, $addr);
	    echo json_respond($print);
	  break;
	  case "df": #Delivery Fee
	    $sT = $_POST["sT"];
	    $tip = $_POST["tip"];
	    $addr = $ordrin::address($_POST["addr"], $_POST["city"], $_POST["state"], $_POST["zip"], "");
	    $print = $ordrin->restaurant->deliveryFee($_POST["rid"], $sT, $tip, $dt, $addr);
	    echo json_respond($print);
	  break;
	  case "rd": #Restaurant Details
	    $print = $ordrin->restaurant->details($_POST["rid"]);
	    echo json_respond($print);
	  break;
	#User API
	  case "gacc": #Account Info
	    $print = $ordrin->user->getAccountInfo();
	    echo json_respond($print);
	  break;
	  case "macc": #Create Account
	    $print = $ordrin->user->create($_POST["email"], hash('sha256',$_POST["pass"]), $_POST["fName"], $_POST["lName"]);
	    echo json_respond($print);
	  break;
	  case "upass": #Update Password
	    $ordrin->user->authenticate($_POST['email'],hash('sha256',$_POST['oldPass']));
	    $print = $ordrin->user->updatePassword(hash('sha256',$_POST['pass']));
	    echo json_respond($print);
	  break;
	  case "gaddr": #Saved Address(es)
	    $print = $ordrin->user->getAddress($_POST["addrNick"]);
	    echo json_respond($print);
	  break;
	  case "uaddr": #Save/Update Address
	    $a = $ordrin::Address($_POST["addr"], $_POST["city"], $_POST["state"], $_POST["zip"], $_POST["phone"], $_POST["addr2"]);
	    $print = $ordrin->user->setAddress($_POST["addrNick"], $a);
	    echo json_respond($print);
	  break;
	  case "daddr": #Delete Address
	    $print = $ordrin->user->deleteAddress($_POST["addrNick"]);
	    echo json_respond($print);
	  break;
	  case "gcar": #Get Card(s)
	    $print = $ordrin->user->getCard($_POST["cardNick"]);
	    echo json_respond($print);
	  break;
	  case "ucar": #Save/update Card
	    $a = $ordrin::Address($_POST["addr"], $_POST["city"], $_POST["state"], $_POST["zip"], $_POST["phone"], $_POST["addr2"]);
	    $print = $ordrin->user->setCard($_POST["cardNick"], $_POST["fName"] . $_POST["lName"], $_POST["cardNum"], $_POST["csc"], $_POST["expMo"], $_POST["expYr"], $a);
	    echo json_respond($print);
	  break;
	  case "dcar": #Delete Card
	    $print = $ordrin->user->deleteCard($_POST["cardNick"]);
	    echo json_respond($print);
	  break;
	  case "gordr": #Get Previous Order(s)
	    $print = $ordrin->user->getOrderHistory();
	    echo json_respond($print);
	  break;
	  case "gordrs": #Info On Specific Order
	    $print = $ordrin->user->getOrderHistory($_POST["ordrID"]);
	    echo json_respond($print);
	  break;
	}
}catch (Exception $e){
	echo json_respond(errorToJSON($e)); //return error
}


function errorToJSON($e){
	$error['error']['message']= $e->getMessage();
	$error['error']['code']= $e->getCode();
	return $error;
}

function calcMeal($targetPrice, $result, $allergies = NULL){
	if($allergies != NULL){
		//If peanut allergy is in $allergies exclude Thai food
		//Dary -> pizza
	}

}

function json_respond($array){
	$data = json_encode($array);
	if(isset($_REQUEST['callback'])){
		return $_REQUEST['callback'] . '(' . $data . ')';
	}
	return $data;
}

//set a secure cookie
function bake($name, $value){
	setcookie($name, $value, 0, '/', 'getnomon.com', true, true);
}

//remove a cookie
function burn($name){
	bake($name, null);
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

function http_die($code, $status, $message) {
  header("HTTP/1.1 $code $status");
  die(json_encode($message));
}

function xql($sql, $params, $print = false, $return = false){
	global $db;

	try{
		header('Content-Type: application/json');
		$q = $db->prepare($sql);
		$q->execute($params);
		if($print || $return){
			$rows = $q->fetchAll(PDO::FETCH_ASSOC);
			if($print){
				echo json_encode($rows);
			}
			return $rows;
		}
	}catch(PDOException $e){
	    // Non-specific error for production
	    http_die(500, "Internal Server Error", "SQL Error: " . $e->getMessage());
	}
}
