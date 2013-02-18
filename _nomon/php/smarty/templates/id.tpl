
{include file="header.tpl" title=header}
	<div class="row">
		<div class="span12 profile">
		
			<img id="profile-img" src={$profilePicture} alt="Profile picture"/>
				<h1>{$name}</h1> {$addFriend}
				<dt>Lives in {$location}</dt>
				<dt>Reviews: {$commentcount}<dt>
				
				
			</div>
	</div>
	<div class="row fan-list">
		<div class="span7">
		  <h4>Artists</h4>
      	
		  {$fanList}
		  
		</div>
	</div>
	{$comments}
      
{include file="copy.tpl"}

    </div> <!-- /container -->
{include file="footer.tpl"}
