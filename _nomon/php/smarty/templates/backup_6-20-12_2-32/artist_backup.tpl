<!--
Available varables:
$name
$shortBio
$concerts

-->

{include file="header.tpl" title=header}
      <!-- Main hero unit for a primary marketing message or call to action -->
	<div class="row">
		<div class="span5">
			<img id="artist-img" src={$imageURL} alt="{$name}'s profile picture"/>
		</div>
		
		{$fanButton}
		
		
		<div class="span7 artist">
			<h1>{$name}</h1>
			{if isset($nextConcertDate) && isset($nextConcertNameLoc)}
			<h3>{$nextConcertDate}</h3>
			<h3>{$nextConcertNameLoc}</h3>
			
			<div class="ticket-small">
				<div class='ticket-small-inner'>
				{if $nextConcertTicketPrice neq -1}
					<a href={$nextConcertTicketLink} rel='no-follow' target='_blank'>
					<div class="tix-large"></div> </a>
					
					<p class=>from <span class="price">${$nextConcertTicketPrice}<span>
				{else}
				<div class="tix-large"></div>
				{/if}
				</div>
			</div>
			<!--  
			{/if}
			{if isset($shortBio)}<p class="bio">{$shortBio}</p>{/if}-->
		</div>
	</div>
	<hr>
	<div class="row">
		<div class="span5">
			<div id="concerts">			  
			   {$concerts}
			</div>
		</div>
		<!--  <div class="span7">
			<div id="reviews">
				<h2>Reviews</h2>
				
				<!--AJAX comment submit-->
				<!-- <form class="form-horizontal review" action="something.php" method="post">
					<fieldset>
					  <div class="control-group">
						<div class="controls">
							<!-- When clicked rows expand to 3 -->
						  <!-- <textarea class="expand input-xxlarge" id="textarea" rows="1"></textarea>
						  <button type="submit" class="btn btn-primary">Submit</button>
						</div>
					  </div>
					</fieldset>
				  </form> -->
				  {$comments}
				  
				  
				<!--  
				<script type="text/javascript">
				var idcomments_acct = 'ca0f1fa1debee0ed60e5ce23e93e9110';
				var idcomments_post_id;
				var idcomments_post_url;
				</script>
				<span id="IDCommentsPostTitle" style="display:none"></span>
				<script type='text/javascript' src='http://www.intensedebate.com/js/genericCommentWrapperV2.js'></script>
				-->
				
			<!--  
			</div>
			<hr>
			<div id="similar">
			<h2>Similar Artists</h2>
			ALLLLLL THEHEE AAKHAKS DAS ARTSITS HERE :)
			</div>
		</div>-->
	</div>
      <hr>
{include file="copy.tpl"}

</div> <!-- /container -->
{include file="footer.tpl"}
