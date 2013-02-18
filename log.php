<?php
# Log
# Evan Cohen
# Get and return the contents of the git log
ini_set('display_errors',1); 
error_reporting(E_ALL);

//What is the path to the repo? I wonder...
//$dir = "/public_html/ev";
$output = array();
//chdir($dir);

$numberToDisplay = -50;

if(isset($_GET['num'])){
	if(is_int($_GET['num'])){
		$numberToDisplay = 0 - $_GET['num'];
	}elseif($_GET['num'] == "all"){
		$numberToDisplay = "";
	}
}

exec("git log $numberToDisplay",$output);

#This stuff is questionable
$log = "<div id='log'>";

$count = 0;
foreach($output as $line){
	if(startsWith($line,'commit') || startsWith($line,'Merge') || $line == ""){
		//dont do anything because that shit is dumb
	}else{
		if(startsWith($line, '    ')){
			$log .= "<blockquote>" . htmlspecialchars($line) . "</blockquote>\n";
		}elseif(startsWith($line, 'Author')){
			$newName = explode(": ", $line);
			$name = $newName[1];
			$log .= "<span class='count'>$count</span> <span class='name'>" . $name . "</span>\n";
			$count++; //Count every time name shows
		}elseif(startsWith($line, 'Date')) {
			$newDate = explode(":   ", $line);
			$date = $newDate[1];
			$log .= "<span class='date'>" . $date . "</span>\n";
		}else{
			$log .= htmlspecialchars($line) . "\n";
		}
	}
}

$log .= "</div>";

echo $log;

function startsWith($haystack, $needle)
{
    $length = strlen($needle);
    return (substr($haystack, 0, $length) === $needle);
}

?>