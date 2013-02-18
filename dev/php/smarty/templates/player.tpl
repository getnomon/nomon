<!-- jPlayer -->

<link href="skin/blue.monday/jplayer.blue.monday.css" rel="stylesheet" type="text/css" />

<div id="jp_container_N" class="jp-video jp-video-270p">
			<div class="jp-type-playlist">
				<div id="jquery_jplayer_N" class="jp-jplayer"></div>
				<div class="jp-gui">
					<div class="jp-video-play">
						<a href="javascript:;" class="jp-video-play-icon" tabindex="1">play</a>
					</div>
					<div class="jp-interface">
						<div class="jp-progress">
							<div class="jp-seek-bar">
								<div class="jp-play-bar"></div>
							</div>
						</div>
						<div class="jp-current-time"></div>
						<div class="jp-duration"></div>
						<div class="jp-controls-holder">
							<ul class="jp-controls">
								<li><a href="javascript:;" class="jp-previous" tabindex="1">previous</a></li>
								<li><a href="javascript:;" class="jp-play" tabindex="1">play</a></li>
								<li><a href="javascript:;" class="jp-pause" tabindex="1">pause</a></li>
								<li><a href="javascript:;" class="jp-next" tabindex="1">next</a></li>
								<li><a href="javascript:;" class="jp-stop" tabindex="1">stop</a></li>
								<li><a href="javascript:;" class="jp-mute" tabindex="1" title="mute">mute</a></li>
								<li><a href="javascript:;" class="jp-unmute" tabindex="1" title="unmute">unmute</a></li>
								<li><a href="javascript:;" class="jp-volume-max" tabindex="1" title="max volume">max volume</a></li>
							</ul>
							<div class="jp-volume-bar">
								<div class="jp-volume-bar-value"></div>
							</div>
							<ul class="jp-toggles">
								<li><a href="javascript:;" class="jp-full-screen" tabindex="1" title="full screen">full screen</a></li>
								<li><a href="javascript:;" class="jp-restore-screen" tabindex="1" title="restore screen">restore screen</a></li>
								<li><a href="javascript:;" class="jp-shuffle" tabindex="1" title="shuffle">shuffle</a></li>
								<li><a href="javascript:;" class="jp-shuffle-off" tabindex="1" title="shuffle off">shuffle off</a></li>
								<li><a href="javascript:;" class="jp-repeat" tabindex="1" title="repeat">repeat</a></li>
								<li><a href="javascript:;" class="jp-repeat-off" tabindex="1" title="repeat off">repeat off</a></li>
							</ul>
						</div>
						<div class="jp-title">
							<ul>
								<li></li>
							</ul>
						</div>
					</div>
				</div>
				<div class="jp-playlist">
					<ul>
						<!-- The method Playlist.displayPlaylist() uses this unordered list -->
						<li></li>
					</ul>
				</div>
				<div class="jp-no-solution">
					<span>Update Required</span>
					To play the media you will need to either update your browser to a recent version or update your <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.
				</div>
			</div>
		</div>
		{literal}
			<p style="margin-top:1em;">
				<code>setPlaylist( <a href="javascript:;" id="playlist-setPlaylist-audio-mix">[Audio Mix]</a> | <a href="javascript:;" id="playlist-setPlaylist-video-mix">[Video Mix]</a> | <a href="javascript:;" id="playlist-setPlaylist-media-mix">[Media Mix]</a> )</code><br />

				Miaow audio: <code>add( <a href="javascript:;" id="playlist-add-bubble">{Bubble}</a> | <a href="javascript:;" id="playlist-add-hidden">{Hidden}</a> | <a href="javascript:;" id="playlist-add-tempered-song">{Tempered Song}</a> | <a href="javascript:;" id="playlist-add-lentement">{Lentement}</a> )</code><br />
				The Stark Palace audio: <code>add( <a href="javascript:;" id="playlist-add-cro-magnon-man">{Cro Magnon Man}</a> | <a href="javascript:;" id="playlist-add-your-face">{Your Face}</a> | <a href="javascript:;" id="playlist-add-cyber-sonnet">{Cyber Sonnet}</a> )</code><br />
				Various video: <code>add( <a href="javascript:;" id="playlist-add-big-buck-bunny">{Big Buck Bunny}</a> | <a href="javascript:;" id="playlist-add-incredibles">{Incredibles}</a> | <a href="javascript:;" id="playlist-add-finding-nemo">{Finding Nemo}</a> )</code><br />

				<code><a href="javascript:;" id="playlist-remove">remove</a>(  <a href="javascript:;" id="playlist-remove--2">-2</a> | <a href="javascript:;" id="playlist-remove--1">-1</a> | <a href="javascript:;" id="playlist-remove-0">0</a> | <a href="javascript:;" id="playlist-remove-1">1</a> | <a href="javascript:;" id="playlist-remove-2">2</a> )</code>
				| <code><a href="javascript:;" id="playlist-shuffle">shuffle</a>( <a href="javascript:;" id="playlist-shuffle-false">false</a> | <a href="javascript:;" id="playlist-shuffle-true">true</a> )</code><br />

				<code>select( <a href="javascript:;" id="playlist-select--2">-2</a> | <a href="javascript:;" id="playlist-select--1">-1</a> | <a href="javascript:;" id="playlist-select-0">0</a> | <a href="javascript:;" id="playlist-select-1">1</a> | <a href="javascript:;" id="playlist-select-2">2</a> )</code>
				| <code><a href="javascript:;" id="playlist-next">next</a>()</code> | <code><a href="javascript:;" id="playlist-previous">previous</a>()</code><br />

				<code><a href="javascript:;" id="playlist-play">play</a>( <a href="javascript:;" id="playlist-play--2">-2</a> | <a href="javascript:;" id="playlist-play--1">-1</a> | <a href="javascript:;" id="playlist-play-0">0</a> | <a href="javascript:;" id="playlist-play-1">1</a> | <a href="javascript:;" id="playlist-play-2">2</a> )</code>
				| <code><a href="javascript:;" id="playlist-pause">pause</a>()</code><br />

				<code>option( "autoPlay", <a href="javascript:;" id="playlist-option-autoPlay-false">false</a> | <a href="javascript:;" id="playlist-option-autoPlay-true">true</a> )</code> Default: false<br />
				<code>option( "enableRemoveControls", <a href="javascript:;" id="playlist-option-enableRemoveControls-false">false</a> | <a href="javascript:;" id="playlist-option-enableRemoveControls-true">true</a> )</code> Default: false<br />
				<code>option( "displayTime", <a href="javascript:;" id="playlist-option-displayTime-0">0</a> | <a href="javascript:;" id="playlist-option-displayTime-fast">'fast'</a> | <a href="javascript:;" id="playlist-option-displayTime-slow">'slow'</a> | <a href="javascript:;" id="playlist-option-displayTime-2000">2000</a> )</code> Default: 'slow'<br />
				<code>option( "addTime", <a href="javascript:;" id="playlist-option-addTime-0">0</a> | <a href="javascript:;" id="playlist-option-addTime-fast">'fast'</a> | <a href="javascript:;" id="playlist-option-addTime-slow">'slow'</a> | <a href="javascript:;" id="playlist-option-addTime-2000">2000</a> )</code> Default: 'fast'<br />
				<code>option( "removeTime", <a href="javascript:;" id="playlist-option-removeTime-0">0</a> | <a href="javascript:;" id="playlist-option-removeTime-fast">'fast'</a> | <a href="javascript:;" id="playlist-option-removeTime-slow">'slow'</a> | <a href="javascript:;" id="playlist-option-removeTime-2000">2000</a> )</code> Default: 'fast'<br />
				<code>option( "shuffleTime", <a href="javascript:;" id="playlist-option-shuffleTime-0">0</a> | <a href="javascript:;" id="playlist-option-shuffleTime-fast">'fast'</a> | <a href="javascript:;" id="playlist-option-shuffleTime-slow">'slow'</a> | <a href="javascript:;" id="playlist-option-shuffleTime-2000">2000</a> )</code> Default: 'slow'

			</p>
			<p>
				Equivalent Effect: <code><a href="javascript:;" id="playlist-equivalent-1-a">add(Your Face, true)</a></code> == <code><a href="javascript:;" id="playlist-equivalent-1-b">add(Your Face) then play(-1)</a></code>
			</p>
			<p>
				Avoid code like: <code><a href="javascript:;" id="playlist-avoid-1">remove(2) then remove(3)</a></code><br />
				Because the second command will only work if the remove animation time, <code class="prettyprint">removeTime</code>, is zero.
				Even then, it will look like it removes the 3rd and 5th items from the original playlist before both commands executed.
				This is because the <code class="prettyprint">remove(2)</code> removes the 3rd item and then <code class="prettyprint">remove(3)</code> removes the 4th item, which was the 5th item before the 3rd item was removed.
				To remove the 3rd and 4th items, you'd use <code class="prettyprint">remove(2)</code> and then <code class="prettyprint">remove(2)</code> again.
				The <code class="prettyprint">remove()</code> method returns a <code class="prettyprint">true</code> when successful, a <code class="prettyprint">false</code> when ignored, which allows you to know whether it worked or not.
			</p>
			{/literal}