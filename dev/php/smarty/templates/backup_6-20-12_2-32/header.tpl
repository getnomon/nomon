{config_load file="tamber.conf" section="setup"}

<!DOCTYPE html>

<html lang="en">

  <head>

    <meta charset="utf-8">

    <title>	{if isset($page_title)}	{$page_title|capitalize} |{/if} {#title#}

	</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, maximum-scale=1.0">

    <meta name="description" content="">

    <meta name="author" content="">



    <!-- Le styles -->

    <link href="/css/bootstrap.css" rel="stylesheet">

    <link href="/css/bootstrap-responsive.css" rel="stylesheet">

    <link href="/css/searchMeme.css" rel="stylesheet"> <!-- THIS IS OVERRIDDEN BY STYLE.CSS -->

    <link href="/css/style.css" rel="stylesheet">

    <link href="/css/style-responsive.css" rel="stylesheet">
    
    <link href="/css/{$custom_css}.css" rel="stylesheet">

	

	<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>



    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->

    <!--[if lt IE 9]>

      <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>

    <![endif]-->



    <!-- Le fav and touch icons -->

    <link rel="shortcut icon" href="/favicon.ico">

	

    <link rel="apple-touch-icon" href="images/apple-touch-icon.png">

    <link rel="apple-touch-icon" sizes="72x72" href="images/apple-touch-icon-72x72.png">

    <link rel="apple-touch-icon" sizes="114x114" href="images/apple-touch-icon-114x114.png">

	

<!--Analytics-->

	<script type="text/javascript">

	  var _gaq = _gaq || [];

	  _gaq.push(['_setAccount', 'UA-30448665-1']);

	  _gaq.push(['_setDomainName', '.tambermusic.com']);

	  _gaq.push(['_trackPageview']);

	  (function() {

		var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;

		ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';

		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);

	  })();

	</script>

	



 </head>

  

  <body>

  <div id="fb-root"></div>

<script>

{literal}

  window.fbAsyncInit = function() {

    FB.init({

      appId      : '259718464093079', // App ID

      

      status     : true, // check login status

      cookie     : true, // enable cookies to allow the server to access the session

      xfbml      : true  // parse XFBML

    });



    // Additional initialization code here

  };



  // Load the SDK Asynchronously

  (function(d){

     var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];

     if (d.getElementById(id)) {return;}

     js = d.createElement('script'); js.id = id; js.async = true;

     js.src = "//connect.facebook.net/en_US/all.js";

     ref.parentNode.insertBefore(js, ref);

   }(document));

  {/literal}

</script>



<script>

{literal}

		function getXMLHttp()

		{

		  var xmlHttp

		

		  try

		  {

		    //Firefox, Opera 8.0+, Safari

		    xmlHttp = new XMLHttpRequest();

		  }

		  catch(e)

		  {

		    //Internet Explorer

		    try

		    {

		      xmlHttp = new ActiveXObject("Msxml2.XMLHTTP");

		    }

		    catch(e)

		    {

		      try

		      {

		        xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");

		      }

		      catch(e)

		      {

		        alert("Your browser does not support AJAX!")

		        return false;

		      }

		    }

		  }

		  return xmlHttp;

		}



		function FanRequest(fid, artistName)

		{

			 var xmlHttp = getXMLHttp();

			  

			  xmlHttp.onreadystatechange = function()

			  {

			    if(xmlHttp.readyState == 4)

			    {

			      HandleResponse(xmlHttp.responseText);

			    }

			  }

			  var params = "fid=" + fid + 

			  "&artistName=" + artistName;

			  

			 

			  xmlHttp.open("POST", "http://ev.tambermusic.com/ajax-fan.php", true); 

			  

			  xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

			  xmlHttp.setRequestHeader("Content-length", params.length);

			  xmlHttp.setRequestHeader("Connection", "close");

			  

			  xmlHttp.send( params );

		}

		

		function AddRequest(fid, artistName, concertDayOfWeek, venueCity, concertDate, concertMonth, concertVenue, ticketLink, time, rating)

		{

		  

		  var xmlHttp = getXMLHttp();

		  

		  xmlHttp.onreadystatechange = function()

		  {

		    if(xmlHttp.readyState == 4)

		    {

		      HandleResponse(xmlHttp.responseText);

		    }

		  }

		  var params = "fid=" + fid + 

		  "&artistName=" + artistName 

		  + "&concertDayOfWeek=" + concertDayOfWeek

		  + "&venueCity=" + venueCity

		  + "&concertDate=" + concertDate 

		  + "&concertMonth=" + concertMonth

		  + "&concertVenue=" + concertVenue

		  + "&ticketLink=" + ticketLink

		  + "&time=" + time

		  + "&rating=" + rating;

		  

		 

		  xmlHttp.open("POST", "http://ev.tambermusic.com/ajax-add.php", true); 

		  

		  xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

		  xmlHttp.setRequestHeader("Content-length", params.length);

		  xmlHttp.setRequestHeader("Connection", "close");

		  

		  xmlHttp.send( params );

		  

		  

		}

		

		function DelRequest(fid, artistName, concertDayOfWeek, concertDate, concertMonth)

		{

		  

		  var xmlHttp = getXMLHttp();

		  

		  xmlHttp.onreadystatechange = function()

		  {

		    if(xmlHttp.readyState == 4)

		    {

		      HandleResponse(xmlHttp.responseText);

		    }

		  }

		  var params = "fid=" + fid + 

		  "&artistName=" + artistName 

		  + "&concertDayOfWeek=" + concertDayOfWeek

		  + "&concertDate=" + concertDate 

		  + "&concertMonth=" + concertMonth;

		  

		 

		  xmlHttp.open("POST", "http://ev.tambermusic.com/ajax-del.php", true); 

		  

		  xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

		  xmlHttp.setRequestHeader("Content-length", params.length);

		  xmlHttp.setRequestHeader("Connection", "close");

		  

		  xmlHttp.send( params );

		  

		  

		}



		function UnfanRequest(fid, artistName)

		{

			 var xmlHttp = getXMLHttp();

			  

			  xmlHttp.onreadystatechange = function()

			  {

			    if(xmlHttp.readyState == 4)

			    {

			      HandleResponse(xmlHttp.responseText);

			    }

			  }

			  var params = "fid=" + fid + 

			  "&artistName=" + artistName;

			  

			 

			  xmlHttp.open("POST", "http://ev.tambermusic.com/ajax-unfan.php", true); 

			  

			  xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

			  xmlHttp.setRequestHeader("Content-length", params.length);

			  xmlHttp.setRequestHeader("Connection", "close");

			  

			  xmlHttp.send( params );

		}

		function HandleResponse(response)

		{

		   alert(response);

		}

{/literal}

</script>





 

 {include file="menu.tpl" title=menu}

 <div class="container" id="body"> <!--container start -->

 {if isset($error)}

<div class="alert alert-error">

	<a class="close" data-dismiss="alert">x</a>

	<h4 class="alert-heading">Holly Hot Dicks From Heaven!</h4>

	{$error}

</div>

 {/if}