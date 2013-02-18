{include file="header.tpl" title="header"}
<div class="row">
  <div class="jumbotron">
    <h1>Search Results</h1>
  </div>
</div>
<div class="search-results">
  {foreach $matches as $match}
  <div class="search-result-toggle" id="{$match['matchID']}">
    <span class="search-result-name"><a href="/artist/{$match['matchName']}">{$match['matchName']}</a></span>
    <span class="search-result-blurb">
      {$match['matchBioSummary']|truncate: 100}
      <i class="icon-chevron-down expand-icon" data-toggle="collapse" data-target="#match{$match['matchID']}"></i>
    </span>
  </div>
  <div id="match{$match['matchID']}" class="collapse in">
    <div class="search-result-content">
	{if $match['matchImageLink'] != "NONE"}
	<img class="search-result-image" src="{$match['matchImageLink']}" title="{$match['matchName']}" />
	{/if}
      {$match['matchBioContent']}
    </div>
  </div>
  <br>
  {/foreach}
</div>
</div>
{include file="footer.tpl" title="footer"}
