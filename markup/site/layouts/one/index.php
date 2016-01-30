<?php
// Require common functionality
if ( ! defined('ENVIRONMENT') )
{
	require_once(str_repeat('../', 2) . 'includes/common.php');
}
?><!DOCTYPE html>
<!--[if lt IE 7 ]><html class="no-js ie lt-ie10 lt-ie9 lt-ie8 lt-ie7 ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="no-js ie lt-ie10 lt-ie9 lt-ie8 ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="no-js ie lt-ie10 lt-ie9 ie8" lang="en"> <![endif]-->
<!--[if IE 9 ]><html class="no-js ie lt-ie10 ie9" lang="en"> <![endif]-->
<!--[if (gte IE 10)|!(IE)]><!--><html class="no-js" lang="en"> <!--<![endif]-->
<head>

	<?php
	// Head common tags and resources
	include(THEMEPATH . 'common/head.php');
	?>
	
	<link rel="stylesheet" type="text/css" href="site.css">

</head>
<body class="mobile-menu-liner">

<div class="body-liner">



<div class="band-wrap band-header bg-size-cover">
<div class="band padding-t3 grid-gutter">
<div class="band-liner">

	<header class="primary">
		
		<h1 class="logo display-table-cell">
			<a href="<?php echo site_url(''); ?>">Logo<!--<img src="<?php echo base_url(); ?>images/header__logo.jpg" alt="[Logo]" class="scale-with-grid" />--></a>
		</h1>
		
		<nav class="nav-dropdown-setup nav-primary display-table-cell table-cell--middle">
			<ul>
				<?php require_once('common/header_nav-items_common.php'); ?>
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



<?php require_once('common/footer.php'); ?>

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