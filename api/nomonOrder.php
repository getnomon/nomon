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
    function submit($rID, $tray, $tip, $date_time, $email, $password='', $fName, $lName, $addr, $credit_card, $useAuth = false) {
        #TONS of shit happens here...
    }

    function __destruct() {
       #overide the nomon destructor
   }
}
