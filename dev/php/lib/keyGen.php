<?php
#Random Key Generator
#Evan Cohen
/* Purpose:
Generates the number of given keys with the given length
*/

if(isset($_REQUEST['number'])){
	$number = $_REQUEST['number'];
	if(isset($_REQUEST['length'])){
		$length = $_REQUEST['length'];
	}else{
		$length = 8;
	}
	for($i=0; $i < $number; $i++){
		print(keygen($length) . '<br>');
	}
}else{
	print("you must pass 'number' as a variable");
}


function keygen($length=8){
	$key = '';
	list($usec, $sec) = explode(' ', microtime());
	mt_srand((float) $sec + ((float) $usec * 100000));
   	$inputs = array_merge(range('z','a'),range(0,9),range('A','Z'));
   	for($i=0; $i<$length; $i++){
   	    $key .= $inputs{mt_rand(0,61)};
	}
	return $key;
}