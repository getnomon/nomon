
<html>
  <head>
    <link rel="stylesheet" type="text/css" href="/css/bootstrap.css" />
	<link rel="stylesheet" type="text/css" href="/css/bootstrap-responsive.css" />
    <link rel="stylesheet" type="text/css" href="/css/style.css " />
	<link rel="stylesheet" type="text/css" href="/css/explanation.css" />
    <title>Welcome to Tamber</title>
	
</head>
<!-- Variables:
{loginURL}
{signupURL}
-->
<body> 
    <div class="container">
        <div class="row">
            <div class="span8 offset2">
                <div id="logo">
                    <img src="/img/tamber-beta-small.png" />
                 </div>
                <div id="introduction">
                    <h3>Live music suggestions that work.</h3>
                    <ul id="actions">
                        <li><img src="/img/plus-medium.png" />Discover new artists</li>
                        <li><img src="/img/tix-medium.png" />Find tickets</li>
                        <li><img src="/img/review-large.png" />Share Reviews</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="span8 offset2">
                <div id="search">
                    <form action="/search" method="post" id="artist-search-form">
                        <input type="text" id="artist-search-input" name="artistName" placeholder="Search an Artist..." autocomplete="off" /> 
                    </form>
                    <ul class="unstyled" id="artist-search-dropdown">
                    </ul>
                </div>
                <div id="buttons-container">
                    <div id="login">
                        <a href="{$loginURL}"><h4>Login</h4></a>
                    </div>
                    <div id="signup">
                        <a href="{$signupURL}"><h4>Sign Up</h4></a>
                    </div>
                </div>
            </div>
        </div>
                
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>	
<script type="text/javascript" src="/js/search.js"></script>
</body>
</html>

