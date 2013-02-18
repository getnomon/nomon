{include file="header.tpl" title=header}
    <div class="container">
      <!-- Main hero unit for a primary marketing message or call to action -->
      <div class="jumbotron">
        <h1>About</h1>
        <p class="lead">Want to learn all about {#title#|capitalize}? You are in the right place.</p>
	  </div>
	<hr>
    <div class="row">
		<div class="span7">
			<h3>Who?</h3>
			<p>Everyone!</p>
			<h3>What?</h3>
			<p>{#title#|capitalize} is a tool to help people manage their online identity</p>
			<h3>Where?</h3>
			<p>At your computer, or on your mobile device!</p>
			<h3>When?</h3>
			<p>Whenever you want! {#title#|capitalize} is designed to be very flexible, you can use
			it as much or as little as you want to.</p>
		</div>
		<div class="span5">
			<h2>Introduction Video</h2>
           <iframe class="span5" height="300" src="http://www.youtube.com/embed/NbaKdNKcp1g" frameborder="0" allowfullscreen></iframe>
		</div>
	</div>

      <hr>
	{include file="copy.tpl"}

    </div> <!-- /container -->
{include file="footer.tpl"}
<script type="text/javascript" src="/assets/js/example.js"></script>

