<?php
$html = 
'<html>
  <head>
    <link rel="stylesheet" type="text/css" href="/css/bootstrap.css" />
	<link rel="stylesheet" type="text/css" href="/css/bootstrap-responsive.css" />
	<link rel="stylesheet" type="text/css" href="/css/login.css" />
	<link rel="stylesheet" type="text/css" href="/css/splash.css" />
	
	
    <title>Welcome to Tamber</title>
	
</head>

<body>   
<div class="navbar">
	<div class="navbar-inner">
		<div class="container" id="center-bar">
			<a class="brand" href="#"><img src="/img/tamber-beta-small.png"></a>
			<ul class="nav">
			<li>
				<h4>Please wait while we generate suggested artists for you. <br> This process can take up to 5 minutes. 
				<br> Refresh this page later.</h4>
			</li>
			</ul>
		</div>
	</div>
</div>
	
</body>
</html>';

ini_set('display_errors',1); 
error_reporting(E_ALL);
if (isset($_REQUEST['q'])) {
	$fid = $_REQUEST['q'];
	$userdatastring = file_get_contents("userdata/" . $fid . ".xml");
	if ($userdatastring == "Waiting...") {
		print($html);
	}
	else {
		header("Location: http://tambermusic.com/me");
	}
}
else {
	header("Location: /");
}
?>