{include file="header.tpl" title="header"}
<div class="row">
	<div class="span6" id="info">
        <dl class="info">
        	
			<dt id="name">{$name}</dt>
            {$isFan}
			{$aggStars} 
			
			<br>
            
            <div id="main-ticket">
            {if isset($nextConcertPlus)}
                {$nextConcertPlus}
            {/if}
                
                {if $nextConcertTicketLink != "" && $nextConcertTicketLink != "none"}
                <a class="big-tix" id="tix" href={$nextConcertTicketLink}>
                    <img src="/img/tix-large.png" title="Tix" />
                </a>
                {/if}
                {if $nextConcertTicketPrice != -1}
                <strong>from</strong> <span class="price">${$nextConcertTicketPrice}</span>
                {/if}
            </div>
            
			
            {if isset($nextConcertDate) && isset($nextConcertVenue) && isset($nextConcertCity)}
            <dt>{$nextConcertDate}</dt>
            
            {if isset($nextConcertDayOfWeek)}
                <dd>{$nextConcertDayOfWeek}</dd>
            {/if}
            <dt>{$nextConcertVenue}</dt>
            <dd>{$nextConcertCity}</dd>
            {/if}
        </dl>

        <div id="media-content">{$playerOutput}</div>
        <div id="shows">{$concerts}</div>

    </div>
    <div class="span6">
    	<!-- the artist photo should be 480x300 -->
        <span id="thumb-buttons">
            {$downButton}
    		{$fanButton}
        </span>
        <div id="artist-photo" style=" background-image: url('{$imageURL}'); height: 450px; background-repeat: no-repeat; background-size: cover;"></div>
	   <div class="similar-aritst">
        <h2>Similar Artists</h2>
        {foreach $similarArtists as $artist}
            <a href="{$artist['url']}" class="{if !$artist['imageExists']}unloaded{else}loaded{/if}" alt="{$artist['name']}">
                <div class="similar sim-artist" style="background: url('{$artist['img']}'); background-repeat: no-repeat; background-size: cover;">
                    <div class="similar overlay">
                        <h4>{$artist['name']}</h4>
                    </div>
                </div>
            </a>
        {/foreach}
        </div>

        <div id="review">

            <h2>Reviews</h2>
        	{$comments}
        </div>
    </div>
</div>
{include file="copy.tpl"}
{include file="footer.tpl"}