<div class="navbar">
	<div class="navbar-inner">
    	<div class="container">
                <a class="brand" href="/me">
                    <img src="/img/tamber+logo.png" />
                </a>
				{if isset($citystate)}
				<ul class="nav location">
					<li class="dropdown">
					  <a data-toggle="dropdown" data-target="#" class="dropdown-toggle location" href="#">{$citystate}<b class="caret"></b></a>
					  <ul class="dropdown-menu">
						<li>
						<form id="location-form" action="../php/modifylocation.php" method="post">
							<input id="location-input" type="text" name="change-location" placeholder="City, State"/>
						</form>
						</li>
					  </ul>
					</li>
				</ul>
				{else}
				<div class="no-loc"></div>
				{/if}
                <!-- right side -->
                    <!-- artist search -->
			<ul class="nav nav-search">
				<li>
                       	<img src="/img/search-35.png" id="search-icon" />
				<form action="/search" method="post" id="artist-search-form">
					<input type="text" id="artist-search-input" name="artistName" placeholder="Search Artist..." autocomplete="off" />
				</form>
                <!-- populated in /js/search.js -->
                <ul class="unstyled" id="artist-search-dropdown">
                </ul>
				</li>
			</ul>
                    <!-- profile/logout -->
                        <div class="nav pull-right">
                            <ul class="nav" id="navlinks">
                                <li><a href="/profile"><h4>Profile</h4></a></li>
                                <li>
                                	{if isset($logoutURL)}
                                		<a id="logout" href="{$logoutURL}"><h4>Logout</h4></a>
                            		{else}
                            			<a id="login" href="{$loginURL}"><h4>Login</h4></a>
                                	{/if}
                                </li>
                            </ul>
                        </div>
                </div>
		</div>
    </div>
</div>
