<?php

ini_set('display_errors',1); 
error_reporting(E_ALL);

require_once('../OrdrinApi.php');

$dt = (isset($_GET['dT'])) ? $_GET['dT'] : '';

$ordrin = new OrdrinApi("M4CEY61LCIGUUaOpzF4Jc_TKaHvuOVzb50ZdOYRhMPE", OrdrinApi::TEST_SERVERS);

switch ($_GET["api"]) {
  case "r":
    // don't need to do anything
  break;
  case "u":
    $ordrin->user->authenticate($_GET['email'],hash('sha256',$_GET['pass']));
  break;
  case "o":
    if(!empty($_GET['pass'])){
      $ordrin->user->authenticate($_GET['email'],hash('sha256',$_GET['pass']));
    }
    $a = OrdrinApi::address($_GET["addr"], $_GET["city"], $_GET["state"], $_GET["zip"], $_GET['phone']);
    $credit_card = OrdrinApi::creditCard($_GET['fName'] .' '. $_GET['lName'], $_GET['expMo'], $_GET['expYr'], $_GET['cardNum'], $_GET['csc'], $a); 

    $details = $ordrin->restaurant->details($_GET["rid"]);
    $items = array();
    foreach($details->menu as $section) {
      foreach($section->children as $item) {
        if($item->price > 5) {
          $items[] = OrdrinApi::trayItem($item->id, 6);
          break;
        }
      }
      if(count($items)) {
        break;
      }
    }

    $tray = OrdrinApi::tray($items);
    
    $data = array();
    $data['request'] = array('restaurant_id'=>$_GET['rid'],'tray'=>$tray->_convertForAPI(),'tip'=>$_GET['tip'],'date'=>$dt,'em'=>$_GET['email'],'password'=>$_GET['pass'],"First Name"=>$_GET['fName'],"Last Name"=>$_GET['lName'],"addr"=>$a,"credit_card"=>$credit_card);
    $addr = OrdrinApi::address($_GET["addr"], $_GET["city"], $_GET["state"], $_GET["zip"], "");
    $print = $ordrin->order->submit($_GET["rid"], $tray, $_GET['tip'], $dt, $_GET["email"], $_GET['pass'], $_GET["fName"], $_GET["lName"], $a, $credit_card);
    $data['response'] = $print;
    echo "THIS IS WORKING! THE PROBLEM IS ORDERIN";
    echo json_encode($data);
  break;
}
if(!isset($_GET['func'])) {
  $_GET['func'] = 'ord';
}
switch ($_GET["func"]) {
  case "dl":
    $addr = OrdrinApi::address($_GET["addr"], $_GET["city"], $_GET["state"], $_GET["zip"], "");
    $print = $ordrin->restaurant->getDeliveryList($dt, $addr);
    echo json_encode($print);
  break;
  case "dc":
    $addr = OrdrinApi::address($_GET["addr"], $_GET["city"], $_GET["state"], $_GET["zip"], "");
    $print = $ordrin->restaurant->deliveryCheck($_GET["rid"], $dt, $addr);
    echo json_encode($print);
  break;
  case "df":
    $sT = $_GET["sT"];
    $tip = $_GET["tip"];
    $addr = OrdrinApi::address($_GET["addr"], $_GET["city"], $_GET["state"], $_GET["zip"], "");
    $print = $ordrin->restaurant->deliveryFee($_GET["rid"], $sT, $tip, $dt, $addr);
    echo json_encode($print);
  break;
  case "rd":
    $print = $ordrin->restaurant->details($_GET["rid"]);
    echo json_encode($print);
  break;

  case "gacc":
    $print = $ordrin->user->getAccountInfo();
    echo json_encode($print);
  break;
  case "macc":
    $print = $ordrin->user->create($_GET["email"], hash('sha256',$_GET["pass"]), $_GET["fName"], $_GET["lName"]);
    echo json_encode($print);
  break;
  case "upass":
    $ordrin->user->authenticate($_GET['email'],hash('sha256',$_GET['oldPass']));
    $print = $ordrin->user->updatePassword(hash('sha256',$_GET['pass']));
    echo json_encode($print);
  break;
  case "gaddr":
    $print = $ordrin->user->getAddress($_GET["addrNick"]);
    echo json_encode($print);
  break;
  case "uaddr":
    $a = OrdrinApi::Address($_GET["addr"], $_GET["city"], $_GET["state"], $_GET["zip"], $_GET["phone"], $_GET["addr2"]);
    $print = $ordrin->user->setAddress($_GET["addrNick"], $a);
    echo json_encode($print);
  break;
  case "daddr":
    $print = $ordrin->user->deleteAddress($_GET["addrNick"]);
    echo json_encode($print);
  break;
  case "gcar":
    $print = $ordrin->user->getCard($_GET["cardNick"]);
    echo json_encode($print);
  break;
  case "ucar":
    $a = OrdrinApi::Address($_GET["addr"], $_GET["city"], $_GET["state"], $_GET["zip"], $_GET["phone"], $_GET["addr2"]);
    $print = $ordrin->user->setCard($_GET["cardNick"], $_GET["fName"] . $_GET["lName"], $_GET["cardNum"], $_GET["csc"], $_GET["expMo"], $_GET["expYr"], $a);
    echo json_encode($print);
  break;
  case "dcar":
    $print = $ordrin->user->deleteCard($_GET["cardNick"]);
    echo json_encode($print);
  break;
  case "gordr":
    $print = $ordrin->user->getOrderHistory();
    echo json_encode($print);
  break;
  case "gordrs":
    $print = $ordrin->user->getOrderHistory($_GET["ordrID"]);
    echo json_encode($print);
  break;
}

?>
