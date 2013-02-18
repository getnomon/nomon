

{include file="header.tpl" title=header}
<link rel="stylesheet" href="/css/rotate.css">
      <!-- Main hero unit for a primary marketing message or call to action -->
      <div class="jumbotron">
        <h1>Feedback</h1>
	  </div>

<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=259718464093079";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<script type="text/javascript" src="/js/keymaster.min.js"></script>
<script type="text/javascript">
    key('r', function(){
        if($('body').hasClass("rotatemeR") || $('body').hasClass("rotatemeL")) {
            $('body').removeClass("rotatemeR");
            $('body').removeClass("rotatemeL");
        }
        $('body').addClass("rotatemeR") });
    key('z', function(){ $('body').addClass
    if($('body').hasClass("rotatemeR") || $('body').hasClass("rotatemeL")) {
            $('body').removeClass("rotatemeL");
            $('body').removeClass("rotatemeR");
        }
        $('body').addClass("rotatemeL") });
</script>
<div class="row">
	<div class="span7" id="facebook-feedback">
		<div class="fb-comments" data-href="http://tambermusic.com/feedback" data-num-posts="10" data-width="670"></div>
	</div>

	<div class="span3"><h2>Leave Us Feedback!</h2>
	<p>We apreciate any feedback you'd be willing to leave for us. We love you. Seriously.</p>
	</div>
</div>

	{include file="copy.tpl"}

{include file="footer.tpl"}

