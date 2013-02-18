<?php /*%%SmartyHeaderCode:11965553344f78df4caf2af7-30005854%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'dfe5d3d3cf886de9545cadcae439cc8a16dace35' => 
    array (
      0 => 'php/smarty/templates/me.tpl',
      1 => 1333321652,
      2 => 'file',
    ),
    '312e5c66234c06cf63442579e739f6883b6e87d1' => 
    array (
      0 => 'php/smarty/templates/header.tpl',
      1 => 1333063869,
      2 => 'file',
    ),
    'da39a3ee5e6b4b0d3255bfef95601890afd80709' => 
    array (
      0 => false,
      1 => false,
      2 => 'file',
    ),
    '0bf2a0760f3c093088a9a238bca014f8b3e4faee' => 
    array (
      0 => 'php/smarty/templates/menu.tpl',
      1 => 1333061028,
      2 => 'file',
    ),
    '5026a382d5044fe4dd0ba2c4b28185e020226a69' => 
    array (
      0 => 'php/smarty/templates/copy.tpl',
      1 => 1330470653,
      2 => 'file',
    ),
    'a5cbe804356a95fb7a6efbb812a51ea520fbcb14' => 
    array (
      0 => 'php/smarty/templates/footer.tpl',
      1 => 1330469515,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '11965553344f78df4caf2af7-30005854',
  'cache_lifetime' => 120,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_4f78e23ed7e973_69718858',
  'has_nocache_code' => true,
),true); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4f78e23ed7e973_69718858')) {function content_4f78e23ed7e973_69718858($_smarty_tpl) {?><?php $_smarty = $_smarty_tpl->smarty; if (!is_callable('smarty_modifier_capitalize')) include 'home/ubuntu/public_html/ev/php/smarty/libs/plugins/modifier.capitalize.php';
?><!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>	<?php if (isset($_smarty_tpl->tpl_vars['page_title']->value)){?>	<?php echo smarty_modifier_capitalize($_smarty_tpl->tpl_vars['page_title']->value);?>
 |<?php }?> Tamber
	</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, maximum-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="/css/bootstrap.css" rel="stylesheet">
    <link href="/css/bootstrap-responsive.css" rel="stylesheet">
	<link href="/css/style.css" rel="stylesheet">
	
	<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="/favicon.ico">
	
    <link rel="apple-touch-icon" href="images/apple-touch-icon.png">
    <link rel="apple-touch-icon" sizes="72x72" href="images/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="114x114" href="images/apple-touch-icon-114x114.png">
	
<!--Analytics-->
	<script type="text/javascript">
	  var _gaq = _gaq || [];
	  _gaq.push(['_setAccount', 'UA-30448665-1']);
	  _gaq.push(['_setDomainName', '.tambermusic.com']);
	  _gaq.push(['_trackPageview']);
	  (function() {
		var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	  })();
	</script>
  </head>
  <body>
 
 <div class="navbar">
  <div class="navbar-inner">
	<div class="container">

	  <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
	  </a>
	  <a class="brand" href="/">Tamber</a>
	  <div class="nav-collapse">
	  <ul class="nav">
		<li class="dropdown">
              <a data-toggle="dropdown" class="dropdown-toggle" href="#">Boston <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="#">Action</a></li>
                <li><a href="#">Another action</a></li>
                <li><a href="#">Something else here</a></li>
                <li class="divider"></li>
                <li class="nav-header">Nav Head</li>
                <li><a href="#">Separated link</a></li>
                <li><a href="#">One more separated link</a></li>
              </ul>
            </li>
	  </ul>
	  <div class="pull-right">
		<form action="/php/artistsearch.php" method="post" class="navbar-search pull-left">
			<input type="text" name="artist" placeholder="Search Artist" class="span3">
		</form>
		<ul class="nav">      		
      		<li><a href="/review">Write a Review</a></li>
      		<li><a href = "/">My Tamber</a></li>
		</ul>
		</div>
	  </div><!--/.nav-collapse -->
	</div>
  </div>

</div>
 <div class="container"> <!--container start -->
 
      <!-- Main hero unit for a primary marketing message or call to action -->
      <div class="jumbotron">
        <h1>For You</h1>
	  </div>
	<hr>
	<div class="span5">
			<img id="artist-img" src="/img/error-dog.jpg" alt="<br />
<b>Notice</b>:  Undefined index:  name in <b>home/ubuntu/public_html/ev/php/smarty/templates_c/dfe5d3d3cf886de9545cadcae439cc8a16dace35.file.me.tpl.cache.php</b> on line <b>38</b><br />
<br />
<b>Notice</b>:  Trying to get property of non-object in <b>home/ubuntu/public_html/ev/php/smarty/templates_c/dfe5d3d3cf886de9545cadcae439cc8a16dace35.file.me.tpl.cache.php</b> on line <b>38</b><br />
's profile picture"/>
		</div>
		
		<div class="span7 artist">
			<h1><br />
<b>Notice</b>:  Undefined index:  name in <b>home/ubuntu/public_html/ev/php/smarty/templates_c/dfe5d3d3cf886de9545cadcae439cc8a16dace35.file.me.tpl.cache.php</b> on line <b>43</b><br />
<br />
<b>Notice</b>:  Trying to get property of non-object in <b>home/ubuntu/public_html/ev/php/smarty/templates_c/dfe5d3d3cf886de9545cadcae439cc8a16dace35.file.me.tpl.cache.php</b> on line <b>43</b><br />
</h1>
					</div>
	
      <!-- Example row of columns -->
      <div class="row">
        <div class="span2">
          <h2>Heading</h2>
           <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
          <p><a class="btn" href="#">View details &raquo;</a></p>

        </div>
        <div class="span2">
          <h2>Heading</h2>
           <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
          <p><a class="btn" href="#">View details &raquo;</a></p>
       </div>
        <div class="span2">

          <h2>Heading</h2>
          <p>Donec sed odio dui. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula porta felis euismod semper. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.</p>
          <p><a class="btn" href="#">View details &raquo;</a></p>
        </div>
		<div class="span2">

          <h2>Heading</h2>
          <p>Donec sed odio dui. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula porta felis euismod semper. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.</p>
          <p><a class="btn" href="#">View details &raquo;</a></p>
        </div>
      </div>

      <hr>
<footer>
	<p>&copy; Tamber 2012</p>
</footer>

    </div> <!-- /container -->
	<!-- Le javascript -->
	<script type="text/javascript" src="https://www.google.com/jsapi"></script>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
    <script type="text/javascript" src="/js/bootstrap.min.js"></script>
  </body>
</html>
<?php }} ?>