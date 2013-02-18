<?php

if(!isset($GLOBALS['dev'])){
	
	$servername = explode('.', $_SERVER['SERVER_NAME']);
	
	if($servername[0] == "dev"){
	$GLOBALS['dev'] = true;
	}
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
}

$port = 24576;

if(isset($GLOBALS['dev']) && $GLOBALS['dev']){
	$port++;
}

function call_backend($command, $arg, $wait = True)
{
	global $port;
	$conn = fsockopen("127.0.0.1", $port);
	if ($conn === FALSE) {
		echo "Reloading connection";
		$conn = fsockopen("127.0.0.1", $port);
		if ($conn === FALSE) {
			header('Location: /error?e=Backend+Server+Not+Found');
			//throw new Exception("Backend Server Not Found");
		}
	}

	fwrite($conn, $command . " " . $arg . "\n");
	if ($wait == False) {
		return "";
	}
	$result = fgets($conn);
	while(!feof($conn)) {
		$result = $result . fgets($conn);
	}
	if (substr($result, 0, 4) == "FAIL") {
		//throw new Exception("Failed result on command: " . $command . " " . $arg);
		header('Location: /error?e=' . "Failed result on command: " . $command . " " . $arg );
	}
	$result = substr($result, 5);
	return trim($result);
}

?>
