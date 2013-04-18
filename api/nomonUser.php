<?php

/* User API */
class nomonUser extends nomon {
    function __construct(){
      #can we have an empty constructor
        #we totally have access to this variable
        $ordin;
    }

    function create($email, $password, $fName, $lName) {
        #creates a new user
    }

    function getAccountInfo() {
        #gets user's account info
    }

    function getAddress($addrNick = '') {
        #gets users addresses (by nickname if givin)
    }

    function setAddress($nick, $addr) {
        #save or update an address
        #accepts a nickname and an address (updates if nick is already in use)
    }

    function deleteAddress($addrNick) {
        #deletes an address from ordrin
        #sets it to inactive on nomon
    }

    function getCard($cardNick = '') {
        #retreive a credit card
        #NONOMON
    }

    function setCard($cardNick, $name, $number, $cvc, $expiryMonth, $expiryYear, $addr) {
        #save a credit card
        #NONOMON
    }

    function deleteCard($cardNick) {
        #deletes a cretid card
        #NONOMON
    }

    function getOrderHistory($orderID='') {
        #gets order history baised on the current authenticated user
        #NONOMON
    }

    function updatePassword($password) {
        #Updates a users password
        #should force to enter old password before changing!
    }

    function __destruct() {
       #overide the nomon destructor
   }
}

