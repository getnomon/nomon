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
  
<div class="navbar navbar-fixed-top">
	<div class="navbar-inner">
    	<div class="container">
                <a class="brand" href="/me">
                    <img src="/img/tamber+logo.png" />
                    <span id="beta" style="font-size: 9px; vertical-align: super; position: relative; left: -5px; top: -10px;">beta</span>
                </a>
				{if isset($user)}
				<ul class="nav location">
					<li class="dropdown">
					  <a data-toggle="dropdown" data-target="#" class="dropdown-toggle location" href="#">{checklocation}<b class="caret"></b></a>
					  <ul class="dropdown-menu">
						<li>
						<form id="location-form" action="../php/modifylocation.php" method="post">
							<input data-provide="typeahead" id="location-input" type="text" name="change-location" placeholder="City, State"/>
						</form>
						</li>
					  </ul>
					</li>
				</ul>
				{else}
				<div class="no-loc"></div>
				{/if}
                <!-- right side -->
                    <!-- artist search -->
			<ul class="nav nav-search">
				<li>
                       	<img src="/img/search-35.png" id="search-icon" />
				<form action="/search" method="post" id="artist-search-form">
					<input type="text" id="artist-search-input" name="artist-name" placeholder="Search Artist..." autocomplete="off" />
				</form>
                <!-- populated in /js/search.js -->
                <ul class="unstyled" id="artist-search-dropdown">
                </ul>
				</li>
			</ul>
                    <!-- profile/logout -->
                        <div class="nav pull-right">
                            <ul class="nav" id="navlinks">
                                <li><a href="/profile"><h4>Profile</h4></a></li>
                                <li>{nocache}{checklogin}{/nocache}</li>
                            </ul>
                        </div>
                </div>
		</div>
    </div>
</div>


 <div class="container" id="body"> <!--container start -->
 {if isset($error)}
<div class="alert alert-error">
	<a class="close" data-dismiss="alert">x</a>
	<h4 class="alert-heading">Something went wrong:</h4>
	{$error}
</div>
 {/if}

      <!-- Main hero unit for a primary marketing message or call to action -->
      <div class="jumbotron">
        <h1>EMPTY</h1>
	  </div>
	<footer>
	<p>&copy; {#title#|capitalize} 2012</p>
</footer>
	
<!-- Credits for people whose stuff we use. -->
<div class="row">
  <div class="span4 offset4 powered-by">	
<p class="powered-by">Powered by</p>
<a href="http://last.fm"><img src="/img/lastfm_red_small.gif" alt="Last.fm"/></a>
<a href="http://the.echonest.com"><img src="/img/echonest-140x30.gif" alt="The Echonest" /></a>	
  </div>
</div>
</div>
	<!-- Le javascript -->

	<script type="text/javascript" src="https://www.google.com/jsapi"></script>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
    <script type="text/javascript" src="/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="/js/script.js"></script>
	
	<script type="text/javascript">
		//initialize dropdown and fix the input click
		$(function() {
	  		$('.dropdown-toggle').dropdown();
	  		$('.dropdown input, .dropdown label').click(function(e) {
	   			e.stopPropagation();
	  		});
		});
	</script>
<script type="text/javascript" >
	//enable popover on search results
	$(function() {	
		$('.collapse').collapse();
	});
</script>
<script type="text/javascript">
	//hide profile labels onclick (move to profile.tpl?)
    $(document).ready(function() {
	$('.hideable').each(function () {
	    var self = $(this);
	    $("i", this).click( function () {
		self.hide();
	    });
	});
    });
</script>
<script type="text/javascript" src="/js/search.js"></script>
	{if isset($scripts)}

	{$scripts}

	{/if}

  </body>

</html>


