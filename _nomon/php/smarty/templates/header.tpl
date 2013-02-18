{config_load file="tamber.conf" section="setup"}
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>{if isset($page_title)} {$page_title|capitalize} |{/if} {#title#}</title>
<meta name="title" content="nomON" />
<meta name="description" content="Random food at the press of a button. Get your nom on."  />
<meta name="keywords" content="random, delivery, food, fast, simple" />
<meta name="author" content="nomON Team" />     
     <!-- Le iPhone -->
<meta name="apple-mobile-web-app-title" content="nomON">
<link rel="apple-touch-icon-precomposed" href="/assets/img/mini-logo.png"/>
<meta name="apple-mobile-web-app-capable" content="yes" />  
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, maximum-scale=1.0" />
<link rel="apple-touch-startup-image" href="/assets/img/iphone-splash.png">
<link type="image/x-icon" rel="shortcut icon" href="/assets/img/favicon.ico">
<meta property="og:site_name" content="nomON" />
<meta property="fb:app_id" content="156766664473679" />
<meta property="og:title" content="nomON" />
<meta name="description" content="Random food at the press of a button. Get your nom on.." />
<meta property="og:description" content="Random food at the press of a button. Get your nom on." />
<meta property="og:image" content="/assets/img/facebook.jpg" />
<meta property="og:type" content="website" />
<meta property="og:url" content="https://getnomon.com" />
<meta name="revisit-after" content="1 day" />
<meta property="fb:admins" content="1032810646" />
<link type="text/css" rel="stylesheet" href="/assets/css/bootstrap.css" />
<!-- Scripts -->
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>     
<script type="text/javascript" src="/assets/js/bootstrap.js"></script>
<script type="text/javascript" src="/assets/js/nomon.js"></script>
<!-- Google Analytics -->
<script type="text/javascript">
var _gaq = _gaq || [];
_gaq.push(['_setAccount', 'UA-37995164-1']);
_gaq.push(['_trackPageview']);

(function() {
var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
})();
</script>
	

 </head>
  
  <body>
  
<div class="container-narrow">
      <div class="masthead">
        <ul class="nav nav-pills pull-right">
          <li><a href="/about">About</a></li>
          <li><a href="#">Contact</a></li>
        </ul>
        <div class="mini-logo" style="display:none;">
          <a href="/"><img src="/assets/img/mini-logo.png"/></a></div>
      </div>
     {if isset($error)}
    <div class="alert alert-error">
    	<a class="close" data-dismiss="alert">x</a>
    	<h4 class="alert-heading">Something went wrong:</h4>
    	{$error}
     {/if}
     
