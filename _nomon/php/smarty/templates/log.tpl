{include file="header.tpl" title=header}
    <div class="container">
      <!-- Main hero unit for a primary marketing message or call to action -->
      <div class="jumbotron">
        <h1>About</h1>
        <p class="lead">Git commit log for Tamber!</p>
	  </div>
	<hr>
    <div class="row">
		<div class="span7">
			{$log}
		</div>
		<div class="span5">
			<h2>Our Favorite Commits :)</h2>
           
		</div>
	</div>

      <hr>
	{include file="copy.tpl"}

    </div> <!-- /container -->
{include file="footer.tpl"}
<script type="text/javascript" src="/assets/js/example.js"></script>

