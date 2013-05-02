<?php

$ordrin = new OrdrinApi("M4CEY61LCIGUUaOpzF4Jc_TKaHvuOVzb50ZdOYRhMPE", OrdrinApi::TEST_SERVERS);

class nomon { 

    public $ordrin;

    function __construct() { 
        #Link global ordrin to our local var
        global $ordrin;
        $this->ordrin = $ordrin;
        #connect to the nomon database
        $this->con = mysqli_connect("localhost","nomon","iloveapples","nomon");
        #check session (if it is not yet set, let's create one)
        $a = session_id();
        if(empty($a)){
            session_start();
        }
        #load in helper classes
        $this->user = new nomonUser();
        $this->order = new nomonOrder();
    }

    /**
     * Return a JSON or JSONP object.
     * ALL OUTPUT SHOULD GO THROUGH THIS FUNCTION!
     * Use this instead of json_encode!
     *
     * @param object  $object       Array to return should be a PHP object!
     * @param bool    $p            Whether to wrap in a jsonp callback
     *
     * @return JSON object with an apropriate callback if nessesary
     */
    public function returnJSON($object, $p = false){
        $json = json_encode($object);
        if($p){
            return "jsonpCallback(".$json.");";
        }  
        return $json;
    }
    
    #Clears the user's current session
    public function logout(){
        session_destroy();
        #send session end time to server
    }

    public function login($email, $password){
        #will have to call something like
        try{
            $this->ordrin->authenticate($email, $password);
        } catch (Exception $e){
            #do something with this
        }
        
        $_SESSION['auth'] = true;
    }

    private function query($sql){
        if(!$result = $this->con->query($sql)){
            throw new NomonException(array("There was an error running the query!", $this->$con->error), 1);
        }
        return $result;
    }


    function __destruct() {
       #let go of the database
    	mysqli_close($this->con);
   }
}


// Exceptions
Class NomonException extends Exception {
    public function __construct($aMessages, $code = 0, Exception $previous = null) {
        if(is_array($aMessages)) {
          $message = implode(", ", $aMessages);
        }
        else {
          $message = $aMessages;
        }
        if(isset($previous)) {
          parent::__construct($message, $code, $previous);
        }
        else {
          parent::__construct($message, $code);
        }
    }

    // custom string representation of object
    public function __toString() {
        #TODO: make this return JSON
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}