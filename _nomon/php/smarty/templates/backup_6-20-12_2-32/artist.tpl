{include file="header.tpl" title="header"}



	<div class="row">



    	<div class="span5 offset1" id="info">



        <dl class="info">



			<dt id="name">{$name}</dt>
			{$fanButton}



            {if isset($nextConcertDate) && isset($nextConcertVenue) && isset($nextConcertCity)}



            <dt>{$nextConcertDate}</dt>



            <dd>{$nextConcertDayOfWeek}</dd>



            <dt>{$nextConcertVenue}</dt>



            <dd>{$nextConcertCity}</dd>



            {/if}



        </dl>

		{if $nextConcertTicketPrice != 1}

          	<div id="tix-bar">



                <a id="tix" href="#">



                    <img src="/img/tix-large.png" title="Tix" />



                </a>

		

                from <span class="price">{$nextConcertTicketPrice}</span>

		

            </div>

		{/if}

        </div>



        <div class="span5">



        	<!--- the artist photo should be 480x300 --->



        	<img src="{$imageURL}" alt="{$name}" />


        </div>


    </div>



    



    <div class="row" id="profile-listings">



    	<div class="span5 offset1" id="shows">



        	<table class="table">



            <thead>



            	<tr>



                	<h2 class="table-title">Shows</h2>



                </tr>



            </thead>


<!-- 
            	{foreach $artistConcerts as $show}



                    <tr>



                    	<td>



                        	<strong>{$show->getMonth}{$show->getDateNumber} </strong><br />



                            <em>{$show->getDayOfWeek} </em><br />



                            <em>{$show->getTime}</em><br />



                        </td>



                        <td>



							<strong>{$show->getVenue}</strong><br />



                            <em>{$show->getCity}</em><br />



                            <em alt="Can calculate state from lat/long later.">California</em><br />



                        </td>



                        <td class="buttons">



							<a href="#"><img src="../../../img/plus-small.png" class="fan-button"/></a>



                            <a href="#"><img src="../../../img/tix-small.png" class="tix-button"/></a>



                        </td>



                    </tr>



                    {/foreach}



                    <tr>



                    	<td>



                        	<strong>Nov 15</strong><br />



                            <em>Saturday</em><br />



                            <em>9:00 pm</em><br />



                        </td>



                        <td>



							<strong>Example</strong><br />



                            <em>Of the tables</em><br />



                            <em>When filled in.</em><br />



                        </td>



                        <td>

				

				<div class="buttons">



                        		<a href="#"><img src="../../../img/plus-small.png" class="fan-button"/></a>



                            	<a href="#"><img src="../../../img/tix-small.png" class="tix-button"/></a>



				</div>



                        </td>



                    </tr>


			-->
			
			{$concerts}
            </table>



        </div>



        <div class="span5" id="reviews">

        	<table class="table">

            	<thead>

                    <tr>

                        <h2 class="table-title">Reviews</h2>

                    </tr>

                </thead>

                <tr>

                    <td>

                        {$comments}

                    </td>

            	</tr>

            </table>

        </div>



</div>







{include file="copy.tpl"}



{include file="footer.tpl"}