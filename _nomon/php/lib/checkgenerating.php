<?php 
$fid = $_POST["fid"];
$userdatastring = file_get_contents("/userdata/" . $fid . ".json");
if ($userdatastring == "Waiting...") {
	echo "0";
}
else{ 
	echo "1";
}
?>