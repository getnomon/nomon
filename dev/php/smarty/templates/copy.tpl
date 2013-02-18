{config_load file="tamber.conf" section="setup"}
<div class="modal hide" id="askModal">
    <div class="modal-header">
        <h3>Ask Us Anything</h3>
    </div>
    <div class="modal-body">
        <div id="webengage">
        <iframe id="webengage" frameborder="0" scrolling="no" allowtransparency="true" src="//webengage.com/f/~13410613b" style="background-color:transparent;"></iframe>
        <!-- <span id="complete-message"><a href="/questions">See others' questions!</a></span> -->
        </div>
    </div>
</div>
<footer class="copy">
    <div class="container">
        <ul class="unstyled footer-links">
            <li><a href="/about">About Us</a></li>
            <li><a href="http://blog.tambermusic.com">Blog</a></li>
            <li><a href="/privacy">Privacy Policy</a></li>
            <li><a href="mailto:jobs@tambermusic.com">Jobs</a></li>
        </ul>
        <ul class="unstyled footer-links">
            <li><a id="ask" href="#" data-toggle="modal">Ask A Question</a></li>
            <li><a href="/ideas">Ideas</a></li>
            <li><a href="/feedback">Feedback</a><li>
            <li><br></li><!-- kludge, sorry -->
        </ul>
        <!--
        <ul class="unstyled footer-links">
            <li>
            <a href="https://twitter.com/share" class="twitter-share-button" data-size="small" data-lang="en" data-count="none">Tweet</a>
            {literal}
            <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js?size=small";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
            {/literal}
            </li>
            <li><br></li>
            <li><br><li>
            <li><br></li>
        -->
        </ul>
    <div class="powered-by">	
        
        <p class="powered-by">Tamber is powered by</p>
        <a href="http://last.fm">
            <img src="/img/lastfm_red_small.gif" alt="Last.fm"/>
        </a>
        <a href="http://the.echonest.com">
            <img src="/img/echonest-140x30.gif" alt="The Echonest" />
        </a>
        <p class="version">Version: {$version}{if isset($dev)} {$dev}{/if}</p>
    </div>
    <p id="copyright">Copyright 2012 Tamber, Inc. All rights reserved.</p> 

    </div>
</footer>
