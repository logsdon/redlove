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
	include(THEME_PATH . 'includes/common/head.php');
	?>
	
</head>
<body>
<?php
// Body Prepend
include(THEME_PATH . 'includes/common/body.prepend.php');
?>

<div class="body-liner">

<?php
// Header
include(THEME_PATH . 'includes/common/header.php');
?>

<div class="band-wrap">
<div class="band padding-tbm content">
<div class="band-liner">

	<section class="content">
		
		<h1 class="text-align-center">jQuery</h1>
		<p>These are just somee elements to enact plugins on.</p>
		
		<ul id="basic-plugin_test-list-1">
			<li>Item one</li>
			<li>Item two</li>
			<li>Item three</li>
		</ul>
		<ul id="basic-plugin_test-list-2">
			<li>Item one</li>
			<li>Item two</li>
			<li>Item three</li>
		</ul>
		<ul id="basic-plugin_test-list-3">
			<li>Item one</li>
			<li>Item two</li>
			<li>Item three</li>
		</ul>
		
		<ul id="test-list-1">
			<li>Item one</li>
			<li>Item two</li>
			<li>Item three</li>
		</ul>
		<ul id="test-list-2">
			<li>Item four</li>
			<li>Item five</li>
			<li>Item six</li>
		</ul>
		<ul id="test-list-3">
			<li>Item seven</li>
			<li>Item eight</li>
			<li>Item nine</li>
		</ul>
		
	</section>
	<!-- /content -->
	
</div>
<!-- /band-liner -->
</div>
<!-- /band content -->
</div>
<!-- /band-wrap -->

<script type="text/javascript" src="<?php echo redlove_cb_url('javascript/redlove/_patterns.js'); ?>"></script>


<?php
// Footer
include(THEME_PATH . 'includes/common/footer.php');
?>

</div>
<!-- /body-liner -->

<?php
// Body Append
include(THEME_PATH . 'includes/common/body.append.php');
?>
</body>
</html>