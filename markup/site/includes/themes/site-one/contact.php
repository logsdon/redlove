<?php
// Require common functionality
if ( ! defined('ENVIRONMENT') )
{
	require_once(str_repeat('../', 3) . 'includes/common.php');
}

$user = true;
?><!DOCTYPE html>
<!--[if lt IE 7 ]><html class="loading no-js ie lt-ie10 lt-ie9 lt-ie8 lt-ie7 ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="loading no-js ie lt-ie10 lt-ie9 lt-ie8 ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="loading no-js ie lt-ie10 lt-ie9 ie8" lang="en"> <![endif]-->
<!--[if IE 9 ]><html class="loading no-js ie lt-ie10 ie9" lang="en"> <![endif]-->
<!--[if (gte IE 10)|!(IE)]><!--><html class="loading no-js" lang="en"> <!--<![endif]-->
<head>

	<?php
	// Head common tags and resources
	include(THEME_PATH . 'includes/common/head.php');
	?>
	
</head>
<body class="mobile-menu-liner">
<?php
// Body Prepend
include(THEME_PATH . 'includes/common/body.prepend.php');
?>


<div class="body-liner">



<?php require_once(THEME_PATH . 'includes/common/header-band_inside.php'); ?>



<div class="band-wrap">
<div class="band padding-tbl content grid-gutter">
<div class="band-liner">

	<section class="content">

		<h2>Some actual content</h2>
		<p>Splendide philosophia est, cum at probo minimu omesque, fali libris has id. Ad facer pertinax vel, eum nevelni molestie euripidi consectu. Taleni <a href="">noluise signiferumque</a> te vix, grae titur temporibus his uta, vis ne nulla nemore splendide. Salutandi scribentur efiantur adta mihis, etoi aliquam vitelre deleniti salutandi ius id.</p>
		
		<form action="" method="post" enctype="multipart/form-data" novalidate="novalidate">
			
			<fieldset>
			
				<div class="columns grid grid-flush">
					<div class="column-row">
						<div class="column w50">
							<label>Your email<em>*</em></label>
							<input type="text" placeholder="test@mail.com" class="width-full">
						</div>
						<div class="column w50">
							<label>Reason for contacting</label>
							<select class="width-full">
								<option value="">&mdash; Please select &mdash;</option>
								<option>Questions</option>
								<option>Quote</option>
								<option>Something Random</option>
							</select>
						</div>
					</div>
					<div class="column-row">
						<div class="column w100">
							<label>Message</label>
							<textarea placeholder="Your message&hellip;" class="width-full"></textarea>
						</div>
					</div>
					<div class="column-row">
						<div class="column w100">
							<label class="label-checkbox field_space-top-half display-inline-block">
								<input type="checkbox"> Checkbox input wrapped in checkbox label
							</label>
							<input type="submit" value="Submit" class="pull-right">
						</div>
					</div>
				</div>
				
			</fieldset>
			
		</form>

	</section>
	
</div>
</div>
</div>



<?php require_once(THEME_PATH . 'includes/common/footer.php'); ?>

</div>
<!-- /body-liner -->


<?php
// Body Append
include(THEME_PATH . 'includes/common/body.append.php');
?>
</body>
</html>