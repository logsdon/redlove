<?php
// Require common functionality
if ( ! defined('ENVIRONMENT') )
{
	require_once(str_repeat('../', 3) . 'includes/common.php');
}
?><!DOCTYPE html>
<!--[if lt IE 7 ]><html class="loading no-js ie lt-ie10 lt-ie9 lt-ie8 lt-ie7 ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="loading no-js ie lt-ie10 lt-ie9 lt-ie8 ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="loading no-js ie lt-ie10 lt-ie9 ie8" lang="en"> <![endif]-->
<!--[if IE 9 ]><html class="loading no-js ie lt-ie10 ie9" lang="en"> <![endif]-->
<!--[if (gte IE 10)|!(IE)]><!--><html class="loading no-js" lang="en"> <!--<![endif]-->
<head>

	<?php
	// Head common tags and resources
	include(THEME_PATH . 'common/head.php');
	?>
	
</head>
<body class="home">
<?php
// Body Prepend
include(THEME_PATH . 'common/body.prepend.php');
?>

<div class="body-liner">

<?php
// Header
include(THEME_PATH . 'common/header.php');
?>

<div class="band-wrap">
<div class="band padding-tbxl">
<div class="band-liner">
	
	<section class="content">
		
		<h3>Home Page</h3>

		<p>This is the homepage view file <code><?php echo str_replace(ROOT_PATH, '/', str_replace('\\', '/', __FILE__)); ?></code>.</p>
		<p>View files can be used if you are not creating individual static pages.</p>

	</section>
	<!-- /section.content -->
	
</div>
<!-- /band-liner -->
</div>
<!-- /band content -->
</div>
<!-- /band-wrap -->

<?php
// Footer
include(THEME_PATH . 'common/footer.php');
?>

</div>
<!-- /body-wrap -->

<?php
// Body Append
include(THEME_PATH . 'common/body.append.php');
?>
</body>
</html>