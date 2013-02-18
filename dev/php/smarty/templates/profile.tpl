
{include file="header.tpl" title=header}
	<div class="row">
		<div class="span12 profile">
		
			<img id="profile-img" src={$profilePicture} alt="Your profile picture"/>
				<h1>{$name}</h1>
				
			</div>
	</div>
	<div class="row fan-list">
		<div class="span5">
			<h4>Shows</h4>
			<div id="concerts">
			
				{$formattedConcerts}
			
			</div>
		</div>
		<div class="span7">
		  <h4>Artists</h4>
		  {$fanList}
		  
		  <h4>Dislikes</h4>
			{$dislikeList}
		</div>
		
	</div>
      
{include file="copy.tpl"}

    </div> <!-- /container -->
{include file="footer.tpl"}
