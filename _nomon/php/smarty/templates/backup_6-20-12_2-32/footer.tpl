	<!-- Le javascript -->

	<script type="text/javascript" src="https://www.google.com/jsapi"></script>

	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>

    <script type="text/javascript" src="/js/bootstrap.min.js"></script>

	<script type="text/javascript" src="/js/jquery/jquery.searchMeme.js"></script>

	<script type="text/javascript">

        $(document).ready(function () {

            var search = $('input[id="searchMeme"]').searchMeme({ onSearch: function (searchText) {

                $('#searchMeme').submit();

            }

            , buttonPlacement: 'left', button: 'orange'

            });

        });

    </script>

	{if isset($scripts)}

	{$scripts}

	{/if}

  </body>

</html>