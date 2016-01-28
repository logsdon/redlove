<?php
// Require common functionality
if ( ! defined('ENVIRONMENT') )
{
	require_once('includes/common.php');
}
?><!DOCTYPE html>
<!--[if lt IE 7 ]><html class="loading no-js ie lt-ie10 lt-ie9 lt-ie8 lt-ie7 ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="loading no-js ie lt-ie10 lt-ie9 lt-ie8 ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="loading no-js ie lt-ie10 lt-ie9 ie8" lang="en"> <![endif]-->
<!--[if IE 9 ]><html class="loading no-js ie lt-ie10 ie9" lang="en"> <![endif]-->
<!--[if (gte IE 10)|!(IE)]><!--><html class="loading no-js" lang="en"> <!--<![endif]-->
<head>

	<meta charset="utf-8">
	<title><?php echo ! empty($page_data['meta_title']) ? $page_data['meta_title'] : ''; ?></title>
	<meta name="description" content="<?php echo ! empty($page_data['meta_description']) ? $page_data['meta_description'] : ''; ?>">
	<meta name="keywords" content="<?php echo ! empty($page_data['meta_keywords']) ? $page_data['meta_keywords'] : ''; ?>">

	<?php
	// Head common tags and resources
	include(THEMEPATH . 'common/head.php');
	?>

</head>
<body class="home">
<?php
// Body Prepend
include(THEMEPATH . 'common/body.prepend.php');
?>

<div class="body-liner">

<?php
// Header
include(THEMEPATH . 'common/header.php');
?>

<div class="band-wrap">
<div class="band padding-tbxl">
<div class="band-liner">
	
	<section class="content">
		
		<?php
		// Look for view file to display if not placing content directly on the page
		$view_page = ( PAGE == '' ) ? 'index' : PAGE;
		$view_file = THEMEPATH . $view_page . '.php';
		if ( file_exists($view_file) )
		{
			require($view_file);
		}
		else
		{
			require(THEMEPATH . 'error_404.php');
		}
		?>
		
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
include(THEMEPATH . 'common/footer.php');
?>

</div>
<!-- /body-wrap -->

<?php
// Body Append
include(THEMEPATH . 'common/body.append.php');
?>
</body>
</html>