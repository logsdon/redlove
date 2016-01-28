<?php
// Require common functionality
if ( ! defined('ENVIRONMENT') )
{
	require_once('../includes/common.php');
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

	<?php
	// Head common tags and resources
	include(THEMEPATH . 'common/head.php');
	?>

</head>
<body>

<div class="body-liner">

<?php
// Header
include(THEMEPATH . 'common/header.php');
?>

<div class="band-wrap">
<div class="band padding-t4">
<div class="band-liner">

	<div class="columns display-table">
		
		<h1 class="display-table-cell middle">Theme Elements</h1>

		<nav class="display-table-cell middle nav-breadcrumbs">
			<ul>
				<li><a href="<?php echo site_url(''); ?>">Home</a></li>
				<li><a href="<?php echo site_url(''); ?>">Theme</a></li>
				<li><a href="" class="active">Inside Page</a></li>
			</ul>
		</nav>

	</div>
	<!-- /columns -->
	
</div>
<!-- /band-liner -->
</div>
<!-- /band -->
</div>
<!-- /band-wrap -->

<div class="band-wrap">
<div class="band content padding-tbm">
<div class="band-liner">


	<section class="content">
		
		<div class="columns">
			
			<h2>Inside page heading</h2>
			
			<p class="lead">Splendide philosophia est, cum at probo minimu omesque, fali libris has id. Ad facer pertinax vel, eum nevelni molestie euripidi consectu. Taleni noluise signiferumque te vix, grae titur temporibus his uta, vis ne nulla nemore splendide.</p>
			
			<p>Splendide philosophia est, cum at probo minimu omesque, fali libris has id. Ad facer pertinax vel, eum nevelni molestie euripidi consectu. Taleni <a href="">noluise signiferumque</a> te vix, grae titur temporibus his uta, vis ne nulla nemore splendide. Salutandi scribentur efiantur adta mihis, etoi aliquam vitelre deleniti salutandi ius id.</p>
			
			<h3>Sub Heading</h3>
			<p>Splendide philosophia est, cum at probo minimu omesque, fali libris has id. Ad facer pertinax vel, eum nevelni molestie euripidi consectu. Taleni noluise signiferumque te vix, grae titur temporibus his uta, vis ne nulla nemore splendide. Salutandi scribentur efiantur adta mihis, etoi aliquam vitelre deleniti salutandi ius id.</p>
			
			<h4>Sub Sub Heading</h4>
			<p>Splendide philosophia est, cum at probo minimu omesque, fali libris has id. Ad facer pertinax vel, eum nevelni molestie euripidi consectu. Taleni noluise signiferumque te vix, grae titur temporibus his uta, vis ne nulla nemore splendide. Salutandi scribentur efiantur adta mihis, etoi aliquam vitelre deleniti salutandi ius id.</p>
			
		</div>
		<!-- /columns -->
		
		<hr>
		
		<div class="columns">
			
			<div class="columns-row">
				
				<div class="column w2-3">
					
					<div class="columns">
						
						<h2>Impact</h2>
						
						<p class="lead">Splendide philosophia est, cum at probo minimu omesque, fali libris has id. Ad facer pertinax vel, eum nevelni molestie euripidi consectu. Taleni noluise signiferumque te vix, grae titur temporibus his uta, vis ne nulla nemore splendide.</p>
						
						<p>Splendide philosophia est, cum at probo minimu omesque, fali libris has id. Ad facer pertinax vel, eum nevelni molestie euripidi consectu. Taleni <a href="">noluise signiferumque</a> te vix, grae titur temporibus his uta, vis ne nulla nemore splendide. Salutandi scribentur efiantur adta mihis, etoi aliquam vitelre deleniti salutandi ius id.</p>
						
						<h3>Subheading</h3>
						<p>Splendide philosophia est, cum at probo minimu omesque, fali libris has id. Ad facer pertinax vel, eum nevelni molestie euripidi consectu. Taleni noluise signiferumque te vix, grae titur temporibus his uta, vis ne nulla nemore splendide. Salutandi scribentur efiantur adta mihis, etoi aliquam vitelre deleniti salutandi ius id.</p>
						
						<h4>Literature (or Publications)</h4>
						<p class="datetime"><span class="date">November 22nd, 2014</span> &mdash; <span class="credit">Credit</span></p>
						<p>Splendide philosophia est, cum at probo minimu omesque, fali libris has id. Ad facer pertinax vel, eum nevelni molestie euripidi consectu. Taleni noluise signiferumque te vix, grae titur temporibus his uta, vis ne nulla nemore splendide. Salutandi scribentur efiantur adta mihis, etoi aliquam vitelre deleniti salutandi ius id.</p>
						<p><a href="" class="">Read More</a></p>
						
					</div>
					
				</div>
				<!-- /column -->
			
				<div class="column w1-3 sidebar">
					<h4>Sidebar</h4>
					<p>Splendide philosophia est, cum at probo minimu omesque, fali libris has id. Ad facer pertinax vel, eum nevelni molestie euripidi consectu. Taleni noluise signiferumque te vix, grae titur temporibus his uta, vis ne nulla nemore splendide.</p>
					<p>Splendide philosophia est, cum at probo minimu omesque, fali libris has id. Ad facer pertinax vel, eum nevelni molestie euripidi consectu. Taleni noluise signiferumque te vix, grae titur temporibus his uta, vis ne nulla nemore splendide.</p>
					<ul>
						<li>List item</li>
						<li>List item</li>
						<li>List item</li>
					</ul>
				</div>
				<!-- /column -->
			
			</div>
			<!-- /columns-row -->
			
		</div>
		<!-- /columns -->
		
	</section>
	<!-- /content -->
	
</div>
<!-- /band-liner -->
</div>
<!-- /band content -->
</div>
<!-- /band-wrap -->


<?php
// Footer
include(THEMEPATH . 'common/footer.php');
?>


</div>
<!-- /body-liner -->

<?php
// Body Append
include(THEMEPATH . 'common/body.append.php');
?>
</body>
</html>