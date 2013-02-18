<html>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="/css/bootstrap.css" />
	<link rel="stylesheet" type="text/css" href="/css/bootstrap-responsive.css" />
    <link rel="stylesheet" type="text/css" href="/css/style.css" />
	<link rel="stylesheet" type="text/css" href="/css/explanation.css" />
    <title>Welcome to Tamber</title>
</head>
<body> 
    <div id="cover">
    <div class="container">
        <div class="row">
            <div class="span10 offset1">
                <div id="logo">
                    <img src="/img/tamber-beta-small.png" />
                 </div>
                <div id="introduction">
                    <h3>Live music suggestions that work.</h3>
                    <ul id="actions">
                        <li><img src="/img/plus-centered.png" /><span class="intro-caption">Discover live music</span></li>
                        <li><img src="/img/tix-centered.png" /><span class="intro-caption">Find tickets</span></li>
                        <li><img src="/img/review-centered.png" /><span class="intro-caption">Share Reviews</span></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="span6 offset1">
                <img src="/img/search.svg" id="search-icon" />
                    <form action="/search" method="post" id="artist-search-form">
                        <input type="text" id="artist-search-input" name="artistName" placeholder="Search an Artist..." autocomplete="off"></input> 
                    </form>
                    <ul class="unstyled" id="artist-search-dropdown">
                    </ul>
            </div>
                <div class="span2 span2-splash">
                        <a href="{$loginURL}"><div class="splash-button"><h4>Login</h4></div></a>
                </div>
                <div class="span2 span2-splash">
                    <a href="{$loginURL}"><div class="splash-button signup"><h4>Sign Up</h4></div>
                    </a>
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

