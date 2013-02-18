
{include file="header.tpl" title=header}
      <!-- Main hero unit for a primary marketing message or call to action -->
      <div class="jumbotron">
        <h1>For You</h1>
	  </div>
	<hr>
	<div class="row">
		<div class="span5">
			<img id="artist-img" src={$nextConcertImage} alt="{$name}'s profile picture"/>
		</div>
			<div class="span7 artist">
				<h1>{$name}</h1>
				{if isset($nextConcertDate) && isset($nextConcertNameLoc)}
				<h3>{$nextConcertDate}</h3>
				<h3>{$nextConcertNameLoc}</h3>
				
				<div class="ticket-small">
					<div class='ticket-small-inner'>						{if $nextConcertTicketPrice neq -1}						<a href={$nextConcertTicketLink} rel='no-follow' target='_blank'>
						<div class="tix-large"></div> </a>												<p class=>from <span class="price">${$nextConcertTicketPrice}<span>						{else}						<div class="tix-large"></div>						{/if}									
				</div>
				{/if}
			</div>
		</div>
	</div>
      <!-- Example row of columns -->
	 	  {$suggestionList}
	

      <hr>
{include file="copy.tpl"}

    </div> <!-- /container -->
{include file="footer.tpl"}
