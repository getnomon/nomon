

{include file="header.tpl" title=header}

      <!-- Main hero unit for a primary marketing message or call to action -->

      <div class="jumbotron">

        <h1>For You</h1>

	  </div>

<div class="container">
	<div class="row">

		<div class="span5 artist">
		

			<a href="/artist/{urlencode($name)}"><img id="artist-img" src={$nextConcertImage} alt="{$name}'s profile picture"/></a>
			{if isset($play)}
				{$play}
			{/if}
		
		</div>

			<div class="span7 artist">
				
				{if isset($nextLink)}
					<h1><a href="{$nextLink}">{$name}</a></h1>
				{else}
				<h1>{$name}</h1>
				{/if}
				
				{if isset($nextConcertDate) && isset($nextConcertNameLoc)}

				<h3>{$nextConcertDate}</h3>

				<h3>{$nextConcertNameLoc}</h3>
				
			{if $nextConcertTicketLink != "none"}
               		 <a id="tix" class="big-tix" href="{$nextConcertTicketLink}"><img src="/img/tix-large.png" title="Tix"/></a>
            {/if}
			{if $nextConcertTicketPrice != -1}
                		<strong>from</strong> <span class="price">{$nextConcertTicketPrice}</span>

			{/if}
			{/if}
			{if isset($lfid)}
					<a class="plus-concert big-plus" fid="{$fid}" lfid="{$lfid}" artist="{$name}"><img src="/img/plus-large.png"/></a>
			{/if}
			</div>

		</div>

	</div>

      <!-- Example row of columns -->

	 	  {$suggestionList}
	 	  <hr />
	 	  <h2>More Nearby</h2>
	 	  {$genericSuggestionList}
	 	  
</div>

{include file="copy.tpl"}



    </div> <!-- /container -->

{include file="footer.tpl"}

