<?php
/**
* Initialize common resources
*
* @package RedLove
* @subpackage PHP
* @category 
* @author Joshua Logsdon <joshua@joshualogsdon.com>
* @author Various from CodeIgniter to Internet
* @copyright Copyright (c) 2015, Joshua Logsdon (http://joshualogsdon.com/)
* @license http://opensource.org/licenses/MIT MIT License
* @link https://github.com/logsdon/redlove
* @link http://redlove.org
* @version 0.0.0
* 
* Usage:
* 

Include this file at the top of page files like so:

<?php
// Require common functionality
if ( ! defined('ENVIRONMENT') )
{
	require_once('includes/common.php');
}
// Or
// Require common functionality
$file = dirname(__FILE__) . '/' . 'includes/common.php';
if ( file_exists($file) )
{
	require_once($file);
}
?>

* 
*/

// --------------------------------------------------------------------
// Setup global paths
if ( ! defined('ROOTPATH') )
{

	/* REDLOVE
	|--------------------------------------------------------------------------
	| DEFINE DOCUMENT ROOT
	|--------------------------------------------------------------------------
	|
	| http://codeigniter.com/wiki/Dynamic_Base_Url/
	| http://codeigniter.com/wiki/Automatic_configbase_url/
	| ROOTPATH	- The server path to this file.
	| ROOT		- The relative web path to this file.
	| REQUEST_URI - The relative server request URI.
	| PAGE - Cleaned up REQUEST_URI.
	|
	*/
	
	// ROOTPATH - The server path to this file.
	$num_dirs_from_rootpath = 1;
	$dirs_to_rootpath = str_repeat('../', $num_dirs_from_rootpath);
	$dirs_to_rootpath = isset($dirs_to_rootpath[0]) ? '/' . $dirs_to_rootpath : '';
	$realpath = realpath(dirname(__FILE__) . $dirs_to_rootpath);
	$rootpath = str_replace('\\', '/', $realpath);// Swap directory separators to Unix style for consistency
	$rootpath = rtrim($rootpath, '/') . '/';// Make sure the path has a trailing slashx
	define('ROOTPATH', $rootpath);
	
	// ROOT - The relative web path to this file.
	$document_root = ( ! empty($_SERVER['PHP_DOCUMENT_ROOT']) ) ? $_SERVER['PHP_DOCUMENT_ROOT'] : $_SERVER['DOCUMENT_ROOT'];
	$document_root = realpath($document_root);
	$document_root = str_replace('\\', '/', $document_root);
	$document_root = rtrim($document_root, '/') . '/';
	$root = str_replace($document_root, '', ROOTPATH);
	//$root = ( strlen($root) == 0 ) ? '/' : '';
	define('ROOT', $root);
	
	// Get the server request
	$request = ( ! empty($_SERVER['REQUEST_URI']) ) ? $_SERVER['REQUEST_URI'] : '';// Apache
	$request = ( strlen($request) > 0 && ! empty($_SERVER['PATH_INFO']) ) ? $_SERVER['PATH_INFO'] : $request;// IIS
	// REQUEST_URI - The relative server request URI.
	$request_uri = ( strlen(ROOT) > 0 && strpos($request, ROOT) === 1 ) ? substr($request, strlen(ROOT)) : $request;
	define('REQUEST_URI', $request_uri);
	
	// PAGE - Cleaned up REQUEST_URI.
	//define('PAGE', trim(parse_url(REQUEST_URI, PHP_URL_PATH), '/'));
	$page = ltrim(parse_url(REQUEST_URI, PHP_URL_PATH), '/');
	if ( strpos($page, '/') !== false )
	{
		$page = ( substr(REQUEST_URI, -1) != '/' ) ? basename(REQUEST_URI) : '';
	}
	$page_ext = strtolower( substr((string)strrchr($page, '.'), 1) );// Lowercase, get text after dot, get text dot and after
	$page_filename = substr($page, 0, strlen($page) - strlen($page_ext));// Remove file extension
	if ( $page_ext == 'php' )
	{
		$page = substr($page_filename, 0, -1);
	}
	define('PAGE', $page);
	$PAGE_segments = explode('/', PAGE);
	
	// REDLOVE
	// Assuming a web request, let the base url set itself
	$protocol = isset($_SERVER['HTTPS']) ? 'https://' : 'http://';
	if ( ! empty($_SERVER['HTTP_X_FORWARDED_PROTO']) )
	{
		$protocol = $_SERVER['HTTP_X_FORWARDED_PROTO'] . '://';
	}
	// Handle CloudFlare request
	elseif ( ! empty($_SERVER['HTTP_CF_VISITOR']) )
	{
		$visitor = json_decode($_SERVER['HTTP_CF_VISITOR']);
		$protocol = $visitor->scheme . '://';
	}
	$base_url = $protocol . $_SERVER['HTTP_HOST'] . '/' . ROOT;
	define('BASE_URL', $base_url);
	
	define('VIEWPATH', ROOTPATH);
	define('INCLUDESPATH', VIEWPATH . 'includes/');
	
	// Load site config and set template
	$file = INCLUDESPATH . 'config/site_settings.php';
	if ( file_exists($file) )
	{
		include_once($file);
	}
	else
	{
		$config['themes_path'] = '';
		$config['theme'] = '';
	}
	$themes_path = rtrim(INCLUDESPATH . $config['themes_path'], '/');
	$themes_path .= ( strlen($themes_path) > 0 ) ? '/' : '';
	define('THEMES_PATH', $themes_path);
	$themes_root = str_replace(ROOTPATH, '', THEMES_PATH);
	$themes_root = str_replace('\\', '/', $themes_root);
	$themes_root = rtrim($themes_root, '/');
	$themes_root .= ( strlen($themes_root) > 0 ) ? '/' : '';
	define('THEMES_ROOT', $themes_root);
	
	$theme = $config['theme'];
	// If directly browsing a theme via the themes directory, switch resources over to it
	$is_directly_browsing_theme = ( strpos(REQUEST_URI, THEMES_ROOT) === 1 );
	if ( $is_directly_browsing_theme )
	{
		$theme = strtok(str_replace(THEMES_ROOT, '', REQUEST_URI), '/');
	}
	$theme_path = rtrim(THEMES_PATH . $theme, '/');
	$theme_path .= ( strlen($theme_path) > 0 ) ? '/' : '';
	define('THEME_PATH', $theme_path);
	$theme_root = rtrim(THEMES_ROOT . $theme, '/');
	$theme_root .= ( strlen($theme_root) > 0 ) ? '/' : '';
	define('THEME_ROOT', $theme_root);
	$theme_nav_root = '';
	if ( $is_directly_browsing_theme )
	{
		$theme_nav_root = THEME_ROOT;
	}
	define('THEME_NAV_ROOT', $theme_nav_root);
	$theme_url = BASE_URL;
	if ( $is_directly_browsing_theme )
	{
		$theme_url = BASE_URL . $theme_root;
	}
	define('THEME_URL', $theme_url);
	
	$num_dirs_from_rootpath = 2;
	$redlove_path = realpath(ROOTPATH . str_repeat('../', $num_dirs_from_rootpath));
	$redlove_path = str_replace('\\', '/', $redlove_path);
	$redlove_path = rtrim($redlove_path, '/') . '/';
	define('REDLOVE_PATH', $redlove_path);
	$redlove_root = substr(REDLOVE_PATH, strlen($document_root));
	$redlove_root = str_replace('\\', '/', $redlove_root);
	$redlove_root = trim($redlove_root, '/') . '/';
	define('REDLOVE_ROOT', str_repeat('../', 3) . $redlove_root);
	$redlove_url = $protocol . $_SERVER['HTTP_HOST'] . '/' . str_replace($document_root, '', REDLOVE_PATH);
	define('REDLOVE_URL', $redlove_url);
	
	/*
	// Debugging
	echo '<pre>';
	print_r(array(
		'$document_root' => $document_root,
		'ROOTPATH' => ROOTPATH,
		'ROOT' => ROOT,
		'$_SERVER[REQUEST_URI]' => $_SERVER['REQUEST_URI'],
		'REQUEST_URI' => REQUEST_URI,
		'PAGE' => PAGE,
		'BASE_URL' => BASE_URL,
		'VIEWPATH' => VIEWPATH,
		'INCLUDESPATH' => INCLUDESPATH,
		'$theme' => $theme,
		'$is_directly_browsing_theme' => (int)$is_directly_browsing_theme,
		'THEMES_PATH' => THEMES_PATH,
		'THEMES_ROOT' => THEMES_ROOT,
		'THEME_PATH' => THEME_PATH,
		'THEME_ROOT' => THEME_ROOT,
		'THEME_NAV_ROOT' => THEME_NAV_ROOT,
		'THEME_URL' => THEME_URL,
		'REDLOVE_PATH' => REDLOVE_PATH,
		'REDLOVE_ROOT' => REDLOVE_ROOT,
		'REDLOVE_URL' => REDLOVE_URL,
	));
	echo '</pre>';
	*/
}
// --------------------------------------------------------------------

// --------------------------------------------------------------------
// REDLOVE
// Make the timezone consistent on the server and audience location
// http://stackoverflow.com/questions/1646171/mysql-datetime-fields-and-daylight-savings-time-how-do-i-reference-the-extra
if ( 
	function_exists('date_default_timezone_set') && 
	function_exists('date_default_timezone_get') /*&& 
	@date_default_timezone_get() != 'America/New_York' */
)
{
	//@date_default_timezone_set(@date_default_timezone_get());
	@date_default_timezone_set('America/New_York');
}
// --------------------------------------------------------------------

// --------------------------------------------------------------------
// REDLOVE
// Autoload environment include if it exists
$file = INCLUDESPATH . 'config/environment.php';
if ( file_exists($file) )
{
	include_once($file);
}
// ------------------------------------------------------------

// --------------------------------------------------------------------
// REDLOVE
// Set up environment constant for reference
// http://en.wikipedia.org/wiki/Development_environment
if ( ! defined('ENVIRONMENT') )
{
	// Development server
	if ( ! empty($config['environment']['is_development']) )
	{
		define('ENVIRONMENT', 'development');
	}
	// Testing server
	elseif ( ! empty($config['environment']['is_testing']) )
	{
		define('ENVIRONMENT', 'testing');
	}
	// Production server
	else
	{
		define('ENVIRONMENT', 'production');
	}
	
	/*
	 *---------------------------------------------------------------
	 * ERROR REPORTING
	 *---------------------------------------------------------------
	 *
	 * Different environments will require different levels of error reporting.
	 * By default development will show errors but testing and live will hide them.
	 */
	switch ( ENVIRONMENT )
	{
		case 'development':
			error_reporting(-1);
			ini_set('display_errors', 1);
		break;

		case 'testing':
			ini_set('display_errors', 1);
			if (version_compare(PHP_VERSION, '5.3', '>='))
			{
				error_reporting(E_ALL & ~E_CORE_WARNING);
			}
			else
			{
				error_reporting(E_ALL);
			}
		break;

		case 'production':
			ini_set('display_errors', 0);
			if (version_compare(PHP_VERSION, '5.3', '>='))
			{
				error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT & ~E_USER_NOTICE & ~E_USER_DEPRECATED & ~E_CORE_WARNING);
			}
			else
			{
				error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_USER_NOTICE);
			}
		break;

		default:
			header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
			echo 'The application environment is not set correctly.';
			exit(1); // EXIT_ERROR
	}
	
}
// --------------------------------------------------------------------

// --------------------------------------------------------------------
// Autoload includes
$file = INCLUDESPATH . 'config/autoload.php';
if ( file_exists($file) )
{
	include_once($file);
	if ( ! empty($config['autoload']) )
	{
		foreach ( $config['autoload'] as $key => $value )
		{
			$filenames = is_array($value['filenames']) ? $value['filenames'] : array_filter(array_map('trim', explode(',', $value['filenames'])));
			foreach ( $filenames as $filename )
			{
				$file = $value['path'] . $filename . '.php';
				if ( file_exists($file) )
				{
					include_once($file);
				}
			}
		}
	}
}
// ------------------------------------------------------------

// ------------------------------------------------------------
// Check and set the current datetime
// If overriding the session via querystring
$now_time = ! empty($_REQUEST['now']) ? strtotime($_REQUEST['now']) : time();
$now = gmdate('Y-m-d H:i:s', $now_time);
// ------------------------------------------------------------

