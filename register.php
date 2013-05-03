<?php
// twitter.php
// Skeleton PHP script for Lab 3: Twitter Service
// INFO 344, Spring 2013
// Morgan Doocy
	
$username = 'nomon';
$password = 'iloveapples';
$hostname = 'localhost'; // This will always need to be localhost on our server.
$database = 'nomon';

// Create a connection to the database.
$db = new PDO("mysql:dbname=$database;host=$hostname", $username, $password);

// Make any SQL syntax errors result in PHP errors.
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);



if(isset($_REQUEST['action'])){
	$action = $_REQUEST['action'];
	switch ($action) {
		case 'add':
		//$print = $ordrin->user->create($_POST["email"], hash('sha256',$_POST["pass"]), $_POST["fName"], $_POST["lName"]);
			$random = substr(number_format(time() * rand(),0,'',''),0,10);
			ensure_params(array('email', 'pass', 'fName', 'lName', 'addr', 'city', 'state', 'zip', 'phone'));				
			$sql = "INSERT INTO user (userEmail, userPass, userFname, userLname, userAuthCode)
			VALUES (:e, :p, :f, :l, :r)";
			$options = array(':t' => $_POST['email'], ':u' => $_POST['pass'], 
					':u' => $_POST['fName'], ':u' => $_POST['lName'], ':r' => $random);
			executeQuery($sql, $options, false);
			$id = $db->lastInsertId();
			//now return the result

			$sql = "INSERT INTO address (userID, addressStreet, addressCity, addressState, addressZip, userPhone)
			VALUES (:i, :s, :c, :a, :z, :p)";
			$options = array(':i' => $id, ':s' => $_POST['addr'], ':c' => $_POST['city'], 
					':a' => $_POST['state'], ':z' => $_POST['zip'], ':p' => $_POST['phone']);
			executeQuery($sql, $options, false);
			//echo "[]";
			$result['complete'] = true;
			echo json_encode($result);
			break;
		default:
			die("NO NO NO NO NO! Go Away! You didn't pass the correct paramaters");
			break;
	}	
}
	
/* 
 * @param $sql (String)    An SQL string to execure
 * @param $params (Array)  An array (or empty array) of paramaters
 * @param $print (Boolean) Should it print the output
*/
function executeQuery($sql, $params, $print, $return = false){
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
	    http_die(500, "Internal Server Error", "Database Error!");
	}
}

function http_die($code, $status, $message) {
  header("HTTP/1.1 $code $status");
  header("Content-type: text/plain");
  die($message);
}

function ensure_params($params) {
  // Allow calling with a variable number of parameters.
  $params = func_get_args();
  foreach ($params as $param) {
    if (!isset($_REQUEST[$param])) {
      http_die(400, "Invalid Request", "The parameter $param is required and missing.");
    }
  }
}
	
?>