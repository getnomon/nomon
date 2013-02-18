<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" 
"http://www.w3.org/TR/html4/strict.dtd">
	 

<html>
  <head>
    <link rel="stylesheet" type="text/css" href="/css/bootstrap.css" />
	<link rel="stylesheet" type="text/css" href="/css/bootstrap-responsive.css" />
	<link rel="stylesheet" type="text/css" href="/css/login.css" />
	
	
    <title>Welcome to Tamber</title>
	
</head>

<body>
 <script src="http://connect.facebook.net/en_US/all.js">
 </script>
<div id="fb-root"></div>
      <script>
        window.fbAsyncInit = function() {
          FB.init({
            appId      : '259718464093079',
            status     : true, 
            cookie     : true,
            xfbml      : true,
            oauth      : true,
          });
        };
        (function(d){
           var js, id = 'facebook-jssdk'; if (d.getElementById(id)) {return;}
           js = d.createElement('script'); js.id = id; js.async = true;
           js.src = "//connect.facebook.net/en_US/all.js";
           d.getElementsByTagName('head')[0].appendChild(js);
         }(document));
      </script>

      
<div class="container">
		<div class="center"><img src="/img/tamber-beta.png" /></div>
		<hr/>
<form class="form-horizontal span6 center-form" action="/php/artistsearch.php" method="post">
				<fieldset>
				  <div class="control-group">
				    
				    
					<label for="artist" class="control-label">Search for an artist</label>
					<div class="controls">
						<div class="input-prepend">
						  <input type="text" id="search" name="artist" placeholder="Artist">
						</div>
					</div>
					</div>
				
					
					<div class="control-group">
					
					<label for="fb-login" class="control-label">Or connect with facebook</label>
				    <div class="controls">
				    {checklogin}
					
				  </div>
				  
				</fieldset>
			</form>
			
			</div>
      
<script>
    FB.Event.subscribe('auth.login', function(response) {
        window.location = "http://tambermusic.com/me";
    });
</script>
</body>
</html>


