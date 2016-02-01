<?php
// Require common functionality
if ( ! defined('ENVIRONMENT') )
{
	require_once(str_repeat('../', 0) . 'includes/common.php');
}

// This site has been set up to utilize themes and theme browsing. 
// You could take theme files, place them at the site root, and strip out the THEME* constant usage or update the site_settings with blank template info, so it looks at the root, and have a more simple site template structure.

// Look for view file to display if not placing content directly on the page
$view_page = ( PAGE == '' ) ? 'index' : PAGE;
$view_file = THEME_PATH . $view_page . '.php';
if ( file_exists($view_file) )
{
	require_once($view_file);
}
else
{
	header('HTTP/1.0 404 Not Found', true, 404);
	
	$view_file = THEME_PATH . 'error_404.php';
	if ( file_exists($view_file) )
	{
		require_once($view_file);
	}
	else
	{
	?>
	<h1>404 Not Found</h1>
	<p>We can't find what you are looking for.</p>
	<?php
	}
}

