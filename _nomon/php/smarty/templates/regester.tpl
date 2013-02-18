{include file="header.tpl" title=header}
      <!-- Main hero unit for a primary marketing message or call to action -->
      <div class="jumbotron">
        <h1>Sign Up</h1>
        <p>Enter your personal information and connect your social account that you already have. It's as simple as that!</p>
		<a class="btn btn-primary btn-large" data-toggle="modal" href="#myModal">Social Login</a>
	  </div>
	<hr>
	<div class="row">
		<div class="span8">
			<form class="form-horizontal">
				<fieldset>
				  <!--<legend>Sign Up</legend>-->
				  <div class="control-group">
					<label for="full-name" class="control-label">Full Name</label>
					<div class="controls">
						<div class="input-prepend">
						  <span class="add-on"><i class="icon-user"></i></span>
						  <input type="text" id="name" class="span2" placeholder="First Last">
						</div>
					</div>
				  </div>
				  <div class="control-group">
					<label for="email" class="control-label">Email</label>
					<div class="controls">
					  <div class="input-prepend">
						  <span class="add-on"><i class="icon-envelope"></i></span>
						  <input type="text" id="email" class="span2" placeholder="me@example.com">
					  </div>
					</div>
				  </div>
				  <div class="control-group">
					<label for="password" class="control-label">Password</label>
					<div class="controls">
					  <div class="input-prepend">
						  <span class="add-on"><i class="icon-lock"></i></span>
						  <input type="password" id="pass" class="span2">
					  </div>
					</div>
					<label for="c-password" class="control-label">Confirm Password</label>
					<div class="controls">
					  <div class="input-prepend">
						  <span class="add-on"><i class="icon-lock"></i></span>
						  <input type="password" id="cpass" class="span2">
					  </div>
					</div>
				  </div>
				  <div class="control-group">
					<label for="social-link" class="control-label">Serveces</label>
					<div class="controls">
					  <div class="input-prepend">
						<div id="social_link_container"></div>
					    <p class="help-block">Select your desired serveces.</p>
					  </div>
					</div>
				  </div>
				  <div class="control-group">
					<label for="fileInput" class="control-label">File input</label>
					<div class="controls">
					  <input type="file" id="fileInput" class="input-file">
					</div>
				  </div>
				  <div class="control-group">
					<label for="textarea" class="control-label">Textarea</label>
					<div class="controls">
					  <textarea rows="6" id="textarea" class="input-xlarge"></textarea>
					</div>
				  </div>
				  <div class="form-actions">
					<button class="btn btn-primary" type="submit">Save changes</button>
					<button class="btn">Cancel</button>
				  </div>
				</fieldset>
			</form>
		</div>
		<div class="span4">
			<h2>Some help text</h2>
           <p>This is some additional help text. I may put some other things here, who knows... Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
          <p><a class="btn" href="#">View details &raquo;</a></p>

		</div>
	</div>
	
      <!-- Example row of columns -->
      <div class="row">
        <div class="span4">
          <h2>Heading</h2>
           <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
          <p><a class="btn" href="#">View details &raquo;</a></p>

        </div>
        <div class="span4">
          <h2>Heading</h2>
           <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
          <p><a class="btn" href="#">View details &raquo;</a></p>
       </div>
        <div class="span4">

          <h2>Heading</h2>
          <p>Donec sed odio dui. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula porta felis euismod semper. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.</p>
          <p><a class="btn" href="#">View details &raquo;</a></p>
        </div>
      </div>

      <hr>
{include file="copy.tpl"}
    </div> <!-- /container -->
{include file="footer.tpl"}
