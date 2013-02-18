<?php
#Backend error PAGE
#RULES: This file is included after the old template variable is assigned
header("Server Error");
$template = "error";
$title = "Server Error";

if(isset($_REQUEST['e'])){
	$e = $_REQUEST['e'];
	$file = fopen('error-log.txt', 'a');
	fwrite($file, $e . "\n");
	fclose($file);
}
?>