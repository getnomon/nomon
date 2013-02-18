<?php
# Tamber Music
# Copyright 2012

$VERSION = 0.12;
$MAINTANANCE = false;

if(!$MAINTANANCE){
	if(isset($_COOKIE['dev'])){
		error_reporting(E_ALL);
		ini_set('display_errors', '1');
	}

	if(/*isset($_COOKIE['dev']) && $_COOKIE['dev']*/ true){
		require('smart.php');
		//require_once('php/lib/tamberconnect.php');

		#ADD TO DOCS
		if(isset($GLOBALS["error"])){
			$s->assign("error", $GLOBALS["error"], true);
		}
		try{
			$s->fetch($template . '.tpl');
		}catch(SmartyException $e) {
			#echo "Smarty reported: ". $e->getMessage();
			require_once('php/inc/404.php');
			#exit;
		}
		
		#set page title
		$s->assign("page_title", $title, true);
		#set scripts
		if(isset($GLOBALS["scripts"])){$s->assign("scripts", $GLOBALS["scripts"], true);}
		#set custom css
		$s->assign("custom_css", $template, true);
		#set version number
		$s->assign("version", $VERSION, true);
		#render page
		$s->display($template . '.tpl');
	}
}else{
#Seriously Old Random Shit!
?>
<html>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="/css/bootstrap.css" />
	<link rel="stylesheet" type="text/css" href="/css/bootstrap-responsive.css" />
    <link rel="stylesheet" type="text/css" href="/css/style.css" />
	<link rel="stylesheet" type="text/css" href="/css/explanation.css" />
    <title>Under Maintenance | Tamber</title>
</head>
<body> 
    <div id="cover">
    <div class="container">
        <div class="row">
            <div class="span10 offset1">
                <div id="logo">
                    <img src="/img/tamber-beta-small.png" />
                 </div>
                <div id="introduction" class="maintanance">
                    <h3>Tamber is under maintenance.</h3>
                    <span class="intro-caption">Please be patient, we'll be back soon!</span>
                </div>
            </div>
        </div>
    </div>
    </div>                
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>	
<script type="text/javascript" src="/js/jquery.color.js"></script>
<script type="text/javascript" src="/js/search.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    $('body').append("<img src='../img/tune-yards-medium.png' style='display: none' onload='loadBackground()'/>");
});

function loadBackground(){
    $('body').css("background-image", "url('../img/tune-yards-medium.png')");
    $("#cover").animate({
      backgroundColor: "transparent"
  }, 1500 );
}
</script>
</body>
</html>
<?php } ?>
