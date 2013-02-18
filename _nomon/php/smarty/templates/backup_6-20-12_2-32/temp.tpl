{config_load file="tamber.conf" section="setup"}
{include file="header.tpl" title=header}
    <div class="container">
	{include file="tip.tpl" title="tip"}
      <!-- Main hero unit for a primary marketing message or call to action -->
      <headder class="jumbotron subhead">
        <h1>Welcome!</h1>
        <p class="lead">{#title#|capitalize} is a tool to help you manage your online identity. <a href="/regester">Regester</a>
		for an account to see what the hype is about!</p>
		<div class="subnav">
		<ul class="nav nav-pills">
		  <li class="dropdown active">
			<a href="#" data-toggle="dropdown" class="dropdown-toggle">Buttons <b class="caret"></b></a>
			<ul class="dropdown-menu">
			  <li class="active"><a href="#buttonGroups">Button groups</a></li>
			  <li class=""><a href="#buttonDropdowns">Button dropdowns</a></li>
			</ul>
		  </li>
		  <li class="dropdown">
			<a href="#" data-toggle="dropdown" class="dropdown-toggle">Navigation <b class="caret"></b></a>
			<ul class="dropdown-menu">
			  <li class=""><a href="#navs">Nav, tabs, pills</a></li>
			  <li><a href="#navbar">Navbar</a></li>
			  <li><a href="#breadcrumbs">Breadcrumbs</a></li>
			  <li><a href="#pagination">Pagination</a></li>
			</ul>
		  </li>
		  <li><a href="#labels">Labels</a></li>
		  <li class=""><a href="#typography">Typography</a></li>
		  <li><a href="#thumbnails">Thumbnails</a></li>
		  <li class=""><a href="#alerts">Alerts</a></li>
		  <li class=""><a href="#progress">Progress bars</a></li>
		  <li class=""><a href="#misc">Miscellaneous</a></li>
		</ul>
		</div>
	  </headder>
	
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
					<label for="optionsCheckbox" class="control-label">Serveces</label>
					<div class="controls">
					  <label class="checkbox">
						<input type="checkbox" value="option1" name="optionsCheckboxList1">
						Twitter
					  </label>
					  <label class="checkbox">
						<input type="checkbox" value="option2" name="optionsCheckboxList2">
						Facebook
					  </label>
					  <label class="checkbox">
						<input type="checkbox" value="option3" name="optionsCheckboxList3">
						LinkedIn
					  </label>
					  <p class="help-block">Select your desired serveces.</p>
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

      <footer>
        <p>&copy; <?=$title?> 2012</p>
      </footer>

    </div> <!-- /container -->
	
	<div class="modal hide fade in" id="myModal">
		<div class="modal-header">
			<a class="close" data-dismiss="modal">x</a>
			<h3>Select Login Service</h3>
		</div>
		<div class="modal-body">
		<div id="janrainEngageEmbed"></div>
		</div>
    </div>	
	<!--Janrain Script-->
	<script type="text/javascript">
	(function() {
		if (typeof window.janrain !== 'object') window.janrain = {};
		window.janrain.settings = {};
		
		janrain.settings.tokenUrl = 'https://dash.evanbtcohen.com/~evanbtco/dev/dash/rpxtoken.php/';

		function isReady() { janrain.ready = true; };
		if (document.addEventListener) {
		  document.addEventListener("DOMContentLoaded", isReady, false);
		} else {
		  window.attachEvent('onload', isReady);
		}

		var e = document.createElement('script');
		e.type = 'text/javascript';
		e.id = 'janrainAuthWidget';

		if (document.location.protocol === 'https:') {
		  e.src = 'https://rpxnow.com/js/lib/dashseo/engage.js';
		} else {
		  e.src = 'http://widget-cdn.rpxnow.com/js/lib/dashseo/engage.js';
		}

		var s = document.getElementsByTagName('script')[0];
		s.parentNode.insertBefore(e, s);
	})();
	</script>

<PRE>
<div class="hero-unit">Disregard all of this random text</div>
{* bold and title are read from the config file *}
{if #bold#}<b>{/if}
{* capitalize the first letters of each word of the title *}
Title: {#title#|capitalize}
{if #bold#}</b>{/if}

The current date and time is {$smarty.now|date_format:"%Y-%m-%d %H:%M:%S"}

The value of global assigned variable $SCRIPT_NAME is {$SCRIPT_NAME}

Example of accessing server environment variable SERVER_NAME: {$smarty.server.SERVER_NAME}

The value of {ldelim}$Name{rdelim} is <b>{$Name}</b>

variable modifier example of {ldelim}$Name|upper{rdelim}

<b>{$Name|upper}</b>


An example of a section loop:

{section name=outer 
loop=$FirstName}
{if $smarty.section.outer.index is odd by 2}
	{$smarty.section.outer.rownum} . {$FirstName[outer]} {$LastName[outer]}
{else}
	{$smarty.section.outer.rownum} * {$FirstName[outer]} {$LastName[outer]} *
{/if}
{sectionelse}
	none
{/section}

An example of section looped key values:

{section name=sec1 loop=$contacts}
	phone: {$contacts[sec1].phone}<br>
	fax: {$contacts[sec1].fax}<br>
	cell: {$contacts[sec1].cell}<br>
{/section}
<p>

testing strip tags
{strip}
<table border=0>
	<tr>
		<td>
			<A HREF="{$SCRIPT_NAME}">
			<font color="red">This is a  test     </font>
			</A>
		</td>
	</tr>
</table>
{/strip}

</PRE>

This is an example of the html_select_date function:

<form>
{html_select_date start_year=1998 end_year=2010}
</form>

This is an example of the html_select_time function:

<form>
{html_select_time use_24_hours=false}
</form>

This is an example of the html_options function:

<form>
<select name=states>
{html_options values=$option_values selected=$option_selected output=$option_output}
</select>
</form>

{include file="footer.tpl"}
