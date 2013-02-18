
<html>
  <head>
    <link rel="stylesheet" type="text/css" href="/css/bootstrap.css" />
	<link rel="stylesheet" type="text/css" href="/css/bootstrap-responsive.css" />
	<link rel="stylesheet" type="text/css" href="/css/login.css" />
    <title>Welcome to TamberTEST</title>
	
</head>

<body>   
<div class="navbar">
	<div class="navbar-inner">
		<div class="container" id="center-bar">
			<a class="brand" href="#"><img src="/img/tamber-beta-small.png"></a>
			<ul class="nav" id="search">
				<li>
                       	<img src="/img/search.svg" id="search-icon" />
				<form action="/search" method="post" id="artist-search-form">
					<input type="text" autocomplete="off" id="artist-search-input" name="artistName" placeholder="Search Artist..." />
				</form>
                <ul class="unstyled" id="artist-search-dropdown"></ul>
                </li>
			</ul>
		<ul class="nav pull-right">
			<a id="login" href="{$loginURL}"><h4>Login</h4></a>
		</ul>
		</div>
	</div>
</div>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>	
    <script type="text/javascript" src="/js/search.js"></script>
</body>
</html>

