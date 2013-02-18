	<script type="text/javascript">

		{literal}

        $(document).ready(function () {

            var search = $('input').searchMeme({ onSearch: function (searchText) {

                $('#searchMeme').submit();

            }

            , buttonPlacement: 'left', button: 'orange'

            });

        });

		{/literal}

    </script>

<div class="navbar navbar-fixed-top">

	<div class="navbar-inner">

    	<div class="container">
		<div class="row">
        	<div class="span4 offset1" id="nav-brand">

                <a class="brand" href="/me">

                    <img src="/img/brand.png" />

                </a>
				<ul class="nav">
					<li class="dropdown">
					  <a data-toggle="dropdown" class="dropdown-toggle location" href="#">{checklocation}<b class="caret"></b></a>
					  <ul class="dropdown-menu">
						<li>
						<form action="php/modifylocation.php" method="post">
							<input type="text" name="change-location" placeholder="City, State"/>
						</form>
						</li>
						
					  </ul>
					</li>
				</ul>
            </div>
            
             

                <!--- right side --->

                    <!--- artist search --->

                    <div class="span4">
				<form method="post" action="/php/artistsearch.php">
                       		<input type="text" id="searchMeme"/>
				</form>

                    </div>

                    <!--- profile/logout --->

                    <div class="span3" id="nav-links">

                        <div class="nav pull-right">

                            <ul class="nav" id="navlinks">
                            
								                          

                                <li><a href="/profile"><h4>Profile</h4></a></li>

                                <li>{checklogin}</li>

								<script type="text/javascript">

                                    {literal}

                                    window.onload = function() {

                                            var a = document.getElementById("logout");

                                            a.onclick = function() {

                                                location.reload(true);

                                            }			

                                        }

                                    {/literal}

                                </script>	

                            </ul>

                        </div>

                    </div>

                </div>

            </div>  	
		</div>
    </div>

</div>