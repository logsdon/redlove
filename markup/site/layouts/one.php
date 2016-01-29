<?php
// Require common functionality
if ( ! defined('ENVIRONMENT') )
{
	require_once(str_repeat('../', 1) . 'includes/common.php');
}
?>
<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="no-js ie lt-ie10 lt-ie9 lt-ie8 lt-ie7 ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="no-js ie lt-ie10 lt-ie9 lt-ie8 ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="no-js ie lt-ie10 lt-ie9 ie8" lang="en"> <![endif]-->
<!--[if IE 9 ]><html class="no-js ie lt-ie10 ie9" lang="en"> <![endif]-->
<!--[if (gte IE 10)|!(IE)]><!--><html class="no-js" lang="en"> <!--<![endif]-->
<head>

	<meta charset="utf-8">
	<title></title>
	<meta name="description" content="">
	<meta name="keywords" content="">

	<meta name="robots" content="index,follow" />
	<meta name="MSSmartTagsPreventParsing" content="true" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta http-equiv="imagetoolbar" content="false" />

	<!-- Mobile-specific Metas , maximum-scale=1-->
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- StyleSheets -->
	<link rel="stylesheet" type="text/css" href="<?php echo cb_url(str_repeat('../', 2) . 'stylesheets/redlove/base.css'); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo cb_url(str_repeat('../', 2) . 'stylesheets/redlove/common.css'); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo cb_url(str_repeat('../', 2) . 'stylesheets/redlove/examples.css'); ?>">

	<!--<link rel="stylesheet" type="text/css" href="//maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">-->
	<link rel="stylesheet" type="text/css" href="<?php echo cb_url('stylesheets/font-awesome/css/font-awesome.min.css'); ?>">

	<!-- JavaScript -->
	<!--[if lt IE 9]><script type="text/javascript" src="//html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
	<!--[if lt IE 9]><script type="text/javascript" src="<?php echo base_url(); ?>javascript/respond.min.js"></script><![endif]-->
	
	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script type="text/javascript">window.jQuery || document.write('<script type="text/javascript" src="<?php echo base_url(); ?>javascript/jquery-1.11.3.min.js"><\/script>')</script>
	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/jquery-ui.min.js"></script>
	
	<script type="text/javascript" src="<?php echo base_url(); ?>javascript/holder.js"></script>
	
	<script type="text/javascript" src="<?php echo cb_url(str_repeat('../', 2) . 'javascript/redlove/base.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo cb_url(str_repeat('../', 2) . 'javascript/redlove/common.js'); ?>"></script>
	<script type="text/javascript">
	//<![CDATA[
		// Save common data
		window.REDLOVE = window.REDLOVE || {fn : {}};
		$.extend(window.REDLOVE, {
			debug : false,
			form_data : {
				<?php
				if ( isset($this) && property_exists($this, 'csrf') )
				{
				?>
					'<?php echo $this->csrf->get_token_name(); ?>' : '<?php echo $this->csrf->get_hash(); ?>',
				<?php
				}
				?>
				ajax : 1
			},
			base_url : '<?php echo function_exists('base_url') ? base_url() : ''; ?>',
			page_start_time : <?php echo time(); ?>,
			server_timezone_offset : <?php echo date('Z'); ?>,
			client_timezone_offset : - new Date().getTimezoneOffset() * 60,
			common_ajax_options : {
				cache : false,
				dataType : 'json',
				timeout : 300000,
				type : 'POST',
				error : REDLOVE.fn.ajax_error_handler,
				beforeSend : REDLOVE.fn.ajax_beforesend_handler,
				complete : REDLOVE.fn.ajax_complete_handler
			},
			'' : ''// Empty so each real property set above has a comma after it
		});
	//]]>
	</script>

	<!-- Favicons -->
	<link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url(); ?>images/favicon.ico" />
	<link rel="icon" type="image/x-icon" href="<?php echo base_url(); ?>images/favicon.ico" />
	<link rel="image_src" href="<?php echo base_url(); ?>images/favicon.png" />
	<link rel="apple-touch-icon-precomposed" href="<?php echo base_url(); ?>images/favicon_152x152.png">
	<meta name="msapplication-TileImage" content="<?php echo base_url(); ?>images/favicon_144x144.png">
	<meta name="msapplication-TileColor" content="#FFFFFF">

</head>
<body class="mobile-menu-liner">

<div class="body-liner">


<style type="text/css">
/* ------------------------------------------------------------
	Body
------------------------------------------------------------ */

body {
	color: #666666;
}
.body-liner {
	background: #ffffff;
}

/* ------------------------------------------------------------
	Header
------------------------------------------------------------ */

.band-header {
	background: #16A8EA url("<?php echo base_url(); ?>images/layouts/blue-abstract-background.jpg") scroll no-repeat 0 0;
	color: #ffffff;
}

.logo {
	font-size: 2.2em;
}
.logo a {
	text-decoration: none;
}

.nav-primary {
	text-align: right;
	vertical-align: middle;
}
.nav-primary a {
	text-decoration: none;
}
.nav-primary > ul > li {
	margin-right: 2.0em;
}
.nav-primary > ul > li:last-child {
	margin-right: 0;
}

/* ------------------------------------------------------------
	Bands
------------------------------------------------------------ */

.band--zebra {
	background: #f5f5f5;
	border-bottom: 1px solid #e1e8ed;
	border-top: 1px solid #e1e8ed;
}

/* ------------------------------------------------------------
	Lead-in Band
------------------------------------------------------------ */

/* ------------------------------------------------------------
	Content
------------------------------------------------------------ */

section.content h2 {
	color: #afafaf;
	margin-bottom: 0.75em;
}
section.content p {
	line-height: 1.8;
}

/* ------------------------------------------------------------
	Topic Columns
------------------------------------------------------------ */

.band-topics i {
	font-size: 8.0rem;
}

/* ------------------------------------------------------------
	Background Band
------------------------------------------------------------ */

.band-background {
	background: #16A8EA url("<?php echo base_url(); ?>images/layouts/blue-abstract-background.jpg") scroll no-repeat 50% 50%;
	color: #ffffff;
}

/* ------------------------------------------------------------
	Images Band
------------------------------------------------------------ */

.band-images i {
	border: 1px solid #cccccc;
	
	-webkit-border-radius: 50%;
	-khtml-border-radius: 50%;
	-moz-border-radius: 50%;
	border-radius: 50%;
	
	font-size: 3.5em;
	padding: 1.0em;
}

/* ------------------------------------------------------------
	Footer
------------------------------------------------------------ */

body,
.band-footer {
	background: #e6e6e6;
}
</style>
<div class="band-wrap band-header bg-size-cover">
<div class="band padding-t3 grid-gutter">
<div class="band-liner">

	<header class="primary">
		
		<h1 class="logo display-table-cell">
			<a href="<?php echo site_url(''); ?>">Logo<!--<img src="<?php echo base_url(); ?>images/header__logo.jpg" alt="[Logo]" class="scale-with-grid" />--></a>
		</h1>
		
		<nav class="nav-dropdown-setup nav-primary display-table-cell table-cell--middle">
			<ul>
				<li>
					<a href="<?php echo site_url(); ?>">Home</a>
				</li>
				<li class="<?php echo page_is('', true) || strpos(PAGE, '') === 0 ? 'active' : ''; ?>">
					<a href="">Menu Item</a>
					<ul>
						<li>
							<a href="">Submenu Item</a>
						</li>
						<li>
							<a href="">Submenu Item</a>
						</li>
						<li>
							<a href="">Submenu Item</a>
						</li>
					</ul>
				</li>
			</ul>
		</nav>

	</header>
	
	<div class="hero-promo w60 w20-prefix padding-tbxxl">
		<h6 class="text-meta text-dim margin-b0">Promo subheading</h6>
		<h3>Promo heading</h3>
		<p>Splendide philosophia est, cum at probo minimu omesque, fali libris has id. Ad facer pertinax vel, eum nevelni molestie euripidi consectu. Taleni noluise signiferumque te vix, grae titur temporibus his uta, vis ne nulla nemore splendide.</p>
	</div>

</div>
</div>
</div>



<div class="band-wrap">
<div class="band band--zebra padding-tbm band-leadin grid-gutter">
<div class="band-liner">

	<section class="">

		<h4 class="margin-b0 text-bold">Lead in band</h4>
		<p>Splendide philosophia est, cum at probo minimu omesque, fali libris has id.</p>
		<p><a href="" class="button button-inverse">noluise signiferumque</a></p>

	</section>
	
</div>
</div>
</div>



<div class="band-wrap">
<div class="band padding-tbxl band-topics grid-gutter">
<div class="band-liner">

	<section class="text-center">

		<div class="columns grid">
			<div class="column-row">
				<div class="column w1-4 w1-8-prefix">
					<i class="fa fa-folder-o"></i>
					<h5 class="margin-tb2">Topic One</h5>
					<p class="margin-b0 text-m">Splendide philosophia est, cum at probo minimu omesque, fali libris has id.</p>
				</div>
				<div class="column w1-4">
					<i class="fa fa-file-o"></i>
					<h5 class="margin-tb2">Topic Two</h5>
					<p class="margin-b0 text-m">Taleni noluise signiferumque te vix, grae titur temporibus his uta, vis ne nulla nemore splendide.</p>
				</div>
				<div class="column w1-4">
					<i class="fa fa-folder-o"></i>
					<h5 class="margin-tb2">Topic Three</h5>
					<p class="margin-b0 text-m">Splendide philosophia est, cum at probo minimu omesque, fali libris has id.</p>
				</div>
			</div>
		</div>
		
	</section>
	
</div>
</div>
</div>



<div class="band-wrap">
<div class="band padding-tbxl grid-gutter">
<div class="band-liner">

	<div class="w80 w10-prefix">
		
		<div class="columns columns-table grid">
			<div class="column-row">
				<div class="column w1-2 table-cell--middle">
					<h6 class="text-meta text-dim margin-b0">Promo subheading</h6>
					<h3>Promo heading</h3>
					<p>Splendide philosophia est, cum at probo minimu omesque, fali libris has id. Ad facer pertinax vel, eum nevelni molestie euripidi consectu. Taleni noluise signiferumque te vix, grae titur temporibus his uta, vis ne nulla nemore splendide.</p>
				</div>
				<div class="column w1-2 table-cell--middle">
					<img src="<?php echo base_url(); ?>images/layouts/bookkeeping-615384_800.jpg" alt=" " class="img-scale">
				</div>
			</div>
		</div>
		
	</div>
	
</div>
</div>
</div>



<div class="band-wrap">
<div class="band band--zebra padding-tbm grid-gutter">
<div class="band-liner">

	<section class="">

		<h4>Zebra band</h4>
		<p>Splendide philosophia est, cum at probo minimu omesque, fali libris has id.</p>
		<p><a href="" class="button">noluise signiferumque</a></p>

	</section>
	
</div>
</div>
</div>



<div class="band-wrap text-center band-images">
<div class="band padding-tbxl grid-gutter">
<div class="band-liner">

		<div class="columns grid">
			<div class="column-row">
				<div class="column w25">
					<a href=""><i class="fa fa-image"></i></a>
				</div>
				<div class="column w25">
					<a href=""><i class="fa fa-image"></i></a>
				</div>
				<div class="column w25">
					<a href=""><i class="fa fa-image"></i></a>
				</div>
				<div class="column w25">
					<a href=""><i class="fa fa-image"></i></a>
				</div>
			</div>
		</div>
		
</div>
</div>
</div>



<div class="band-wrap band-background bg-size-cover text-center">
<div class="band padding-tbxl grid-gutter">
<div class="band-liner">

	<h4>Prepare for an epic statement that will change your life</h4>
	
</div>
</div>
</div>



<div class="band-wrap">
<div class="band padding-tbxl content grid-gutter">
<div class="band-liner">

	<section class="content">

		<h2>Some actual content</h2>
		<p class="margin-b0 w70">Splendide philosophia est, cum at probo minimu omesque, fali libris has id. Ad facer pertinax vel, eum nevelni molestie euripidi consectu. Taleni <a href="">noluise signiferumque</a> te vix, grae titur temporibus his uta, vis ne nulla nemore splendide. Salutandi scribentur efiantur adta mihis, etoi aliquam vitelre deleniti salutandi ius id.</p>

	</section>
	
</div>
</div>
</div>



<div class="band-wrap">
<div class="band padding-b5 band-footer grid-gutter">
<div class="band-liner">

	<div class="columns grid padding-tbxl">
		<div class="column-row">
			<div class="column w33">
				Column
			</div>
			<div class="column w33">
				Column
			</div>
			<div class="column w33">
				Column
			</div>
		</div>
	</div>
	
	<footer class="primary">
		
		<div class="columns columns-table grid">
			<div class="column-row">
				<div class="column w50">
					<address>
						<b>Company, Inc.</b>
					</address>
					
					<small class="copyright">
						Copyright &copy; <?php echo date('Y'); ?> Company, Inc.  All rights reserved.
					</small>
					
				</div>
				<div class="column w50 text-right text-s table-cell--bottom">
					<nav class="footer">
						<ul class="list-inline">
							<li><a href="">Home</a></li>
							<li><a href="">About</a></li>
							<li><a href="">Sign Up</a></li>
							<li><a href="">Sign In</a></li>
						</ul>
					</nav>
				</div>
			</div>
		</div>
		
	</footer>

</div>
</div>
</div>

</div>
<!-- /body-liner -->



<!-- JavaScript -->

<script type="text/javascript">
//<![CDATA[
jQuery(document).ready(function($)
{
});
//]]>
</script>



</body>
</html>