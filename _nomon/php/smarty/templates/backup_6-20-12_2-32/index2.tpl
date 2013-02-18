
<html>
  <head>
    <link rel="stylesheet" type="text/css" href="/css/bootstrap.css" />
	<link rel="stylesheet" type="text/css" href="/css/bootstrap-responsive.css" />
	<link rel="stylesheet" type="text/css" href="/css/login.css" />
	
	
    <title>Welcome to Tamber</title>
	
</head>

<body>



      
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
				    <div class="fb-login">
				    {checklogin}
				    </div>
					
				  </div>
				  
				</fieldset>
			</form>
			
			</div>
      

</body>
</html>

