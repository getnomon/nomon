<?php
require('php/smarty/libs/Smarty.class.php');

$s = new Smarty();
$s->setTemplateDir('php/smarty/templates');
$s->setCompileDir('php/smarty/templates_c');
$s->setCacheDir('php/smarty/cache');
$s->setConfigDir('php/smarty/configs');
$s->setPluginsDir('php/smarty/plugins');

// set up APC
$s->setCachingType('apc');

$s->debugging = isset($_COOKIE['dev']);
$s->caching = false;
$s->merge_compiled_includes = true;

//$s->cache_lifetime = 120;

//Check to see if we are on the dev serverl
$servername = explode('.', $_SERVER['SERVER_NAME']);
if($servername[0] == "dev"){
	$GLOBALS['dev'] = true;
	$s->assign("dev", '[DEV SERVER]');
}

$template = "index";

#TODO: Declare META data tags (keywords, discription, etc...)

if(isset($_REQUEST['q'])){
		
	$arg = explode("/", $_REQUEST['q']);
	$q = $arg[0];
	
	
	$s->assign("Query",$arg[0],true);

	switch($arg[0]){			
		case '404': #404
			$s->assign("404", $arg[0], true);
			#load 404
			$title = "404";
			$template = "404";
			break;
			
		default: #PAGE
			$title = $arg[0];
			$template = $arg[0];
			
			
			$s->assign("page", $arg[0], true);
			if(isset($arg[1])){
				$s->assign("attribute", $arg[1], true);
			}
			$inc2 = "php/inc/" . $arg[0] . ".php";
			if(file_exists($inc2)){
					require_once $inc2;
			}
	}
	#process includes
	$inc = "php/inc/" . $arg[0] . ".php";
	if(file_exists($inc)){
			require_once $inc;
	}
	$inc = "js/inc/" . $arg[0] . ".js";
	if(file_exists($inc)){
		addScript('/'.$inc);
	}
}

function _REQUEST($arg, $index){
	if(isset($arg[$index])){
		return $arg[$index];
	}else{
		return null;
	}
}

function error($error){
	if(isset($GLOBALS["error"])){
		$GLOBALS["error"] = $GLOBALS["error"] . '<br>|AND|<br>' . $error;
	}else{
		$GLOBALS["error"] = $error;
	}
}

function addScript($scriptPath){
	$path = "<script type=\"text/javascript\" src=\"$scriptPath?v=$VERSION\"></script>\n";
	if(isset($GLOBALS["scripts"])){
		$GLOBALS["scripts"] = $GLOBALS["scripts"] . $path;
	}else{
		$GLOBALS["scripts"] = $path;
	}
}

#nobody wants to wait 30 pages
#for the artist page to load
?>