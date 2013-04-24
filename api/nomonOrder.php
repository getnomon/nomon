<?php

/* Order API */
class nomonOrder extends nomon {
    function __construct(){
      #something will need to happen here
    }

    /**
     * Order a tray of items 
     *
     * @param int     $rID          Ordr.in's restaurant identifier 
     * @param object  $tray         An object containing a collection of TrayItems to be ordered
     * @param float   $tip          Tip to be added to order
     * @param array   $dateTime     Either "ASAP" or the dateTime for order to be delivered
     * @param string  $email        Email address of customer
     * @param string  $fName        First name of customer
     * @param string  $lName        Last name of customer
     * @param object  $addr         Address object for delivery
     * @param object  $credit_card  Credit card object for delivery
     * @param bool    $useAuth      Whether to use user authentication or not
     *
     * @return object An object containing information about the order
     */
    function submit() {
        #TONS of shit happens here...
        try{
            if(!empty($_POST['pass'])){
                #should use the nomon wrapper function which gives us the hashed pass
                #from our db and makes auth prompting for auth mo betta (long polling?)
                #$nomon->user->authenticate
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
            echo json_encode(errorToJSON($e)); //return error
        }
    }

    function __destruct() {
       #overide the nomon destructor
   }
}
