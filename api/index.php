<?php
/*
API PROXY
*/
$api = $_REQUEST['api'];

switch ($api) {
	case 'geo':
		#this is slow, yo
		if(isset($_REQUEST['lat']) && isset($_REQUEST['lng']) && isset($_REQUEST['sensor'])){
			$url = 'http://maps.googleapis.com/maps/api/geocode/json?latlng='.
				$_REQUEST['lat'].','.$_REQUEST['lng'].
				'&sensor='.$_REQUEST['sensor'];
			$responce = json_decode(file_get_contents($url));
			//echo '<pre>';
			//print_r($responce);
			print_r($responce->results[0]->formatted_address);
			//echo '</pre>';
		}
		break;
	
	default:
		# code...
		break;
}

?>