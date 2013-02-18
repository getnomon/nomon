<?php /*%%SmartyHeaderCode:15403795205000b7cda32412-14562564%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '92f2cb711316ea1f0285d3728fa43bcb0af8cca2' => 
    array (
      0 => 'php/smarty/templates/404.tpl',
      1 => 1342217918,
      2 => 'file',
    ),
    '312e5c66234c06cf63442579e739f6883b6e87d1' => 
    array (
      0 => 'php/smarty/templates/header.tpl',
      1 => 1342217918,
      2 => 'file',
    ),
    'da39a3ee5e6b4b0d3255bfef95601890afd80709' => 
    array (
      0 => false,
      1 => false,
      2 => 'file',
    ),
    '0bf2a0760f3c093088a9a238bca014f8b3e4faee' => 
    array (
      0 => 'php/smarty/templates/menu.tpl',
      1 => 1342217918,
      2 => 'file',
    ),
    '5026a382d5044fe4dd0ba2c4b28185e020226a69' => 
    array (
      0 => 'php/smarty/templates/copy.tpl',
      1 => 1342217918,
      2 => 'file',
    ),
    'a5cbe804356a95fb7a6efbb812a51ea520fbcb14' => 
    array (
      0 => 'php/smarty/templates/footer.tpl',
      1 => 1342217918,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '15403795205000b7cda32412-14562564',
  'variables' => 
  array (
    'artist' => 0,
    'page' => 1,
  ),
  'has_nocache_code' => true,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_5000b7cec792a8_27856306',
  'cache_lifetime' => 3600,
),true); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5000b7cec792a8_27856306')) {function content_5000b7cec792a8_27856306($_smarty_tpl) {?> <!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>		Error 404 | Tamber
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
   
   <link href="/css/404.css" rel="stylesheet">
	
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
  
</script>
 
 <div class="navbar navbar-fixed-top">
	<div class="navbar-inner">
    	<div class="container">
                <a class="brand" href="/me">
                    <img src="/img/tamber+logo.png" />
                </a>
								<ul class="nav location">
					<li class="dropdown">
					  <a data-toggle="dropdown" data-target="#" class="dropdown-toggle location" href="#">Berkeley<b class="caret"></b></a>
					  <ul class="dropdown-menu">
						<li>
						<form id="location-form" action="../php/modifylocation.php" method="post">
							<input data-provide="typeahead" id="location-input" type="text" name="change-location" placeholder="City, State"/>
						</form>
						</li>
					  </ul>
					</li>
				</ul>
				                <!--- right side --->
                    <!--- artist search --->
			<ul class="nav nav-search">
				<li>
                       	<img src="/img/search-35.png" id="search-icon" />
				<form action="/search" method="post" id="artist-search-form">
					<input type="text" id="artist-search-input" name="artist-name" placeholder="Search Artist..." />
				</form>
				</li>
			</ul>
                    <!--- profile/logout --->
                        <div class="nav pull-right">
                            <ul class="nav" id="navlinks">
                                <li><a href="/profile"><h4>Profile</h4></a></li>
                                <li><a id="logout" href="https://www.facebook.com/logout.php?next=http%3A%2F%2Ftambermusic.com%2Fcss%2FNotice%3A%2520Undefined%2520index%3A%2520custom_css%2520in%2520%2Fhome%2Fubuntu%2Fpublic_html%2Fev%2Fphp%2Fsmarty%2Ftemplates_c%2F312e5c66234c06cf63442579e739f6883b6e87d1.file.header.tpl.cache.php%2520on%2520line%252049Notice%3A%2520Trying%2520to%2520get%2520property%2520of%2520non-object%2520in%2520%2Fhome%2Fubuntu%2Fpublic_html%2Fev%2Fphp%2Fsmarty%2Ftemplates_c%2F312e5c66234c06cf63442579e739f6883b6e87d1.file.header.tpl.cache.php%2520on%2520line%252049.css&access_token=AAADsNmrLO5cBAMueDpZCfeD8tldWj975mVM1TG7fWXrXS9YPHRxtu9dDrZA3lA7KtiFQxOyuDw5051ypsjwsZAzSbdbVnTxtiyhmcNC6gZDZD"><h4>Logout</h4></a></li>
                            </ul>
                        </div>
                </div>
		</div>
    </div>
</div>

 <div class="container" id="body"> <!--container start -->
 
    <div class="container">
      <!-- Main hero unit for a primary marketing message or call to action -->
      <div class="jumbotron">
        <h1>Error 404</h1>
        <p class="lead 404">
							Error Dog says: "The page <strong><?php echo $_smarty_tpl->tpl_vars['page']->value;?>
</strong> could not be found!"
					</p>
	  </div>
	<hr>
    <div class="row">
		<div class="span8">
			
			<img src="/img/error-dog.jpg" alt="uh oh, something happened">
		</div>
		<!--<div class="span4">
			<h2>Recommended Content</h2>
            <ul class="recommended">
			<li>Artist One</li>
			<li>Artist Two</li>
			<li>Page Three</li>
			</ul>
		</div>-->
	</div>

      <hr>
	<footer>
	<p>&copy; Tamber 2012</p>
</footer>

    </div> <!-- /container -->
	
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
	
  </body>

</html>

<script type="text/javascript" src="/assets/js/example.js"></script>

<?php }} ?>