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
/* REDLOVE
	Setup global paths
	
	http://codeigniter.com/wiki/Dynamic_Base_Url/
	http://codeigniter.com/wiki/Automatic_configbase_url/
*/
if ( ! defined('ROOT_PATH') )
{
	// ROOT_PATH - The server path to this file
	$num_dirs_from_root_path = 1;
	$dirs_to_root_path = '/' . str_repeat('../', $num_dirs_from_root_path);
	$realpath = realpath(dirname(__FILE__) . $dirs_to_root_path);
	$realpath = str_replace('\\', '/', $realpath);// Swap directory separators to Unix style for consistency
	$realpath = rtrim($realpath, '/') . '/';// Make sure the path has a trailing slashx
	define('ROOT_PATH', $realpath);
	
	// DOCUMENT_ROOT - The server path to the site root
	$document_root = ! empty($_SERVER['PHP_DOCUMENT_ROOT']) ? $_SERVER['PHP_DOCUMENT_ROOT'] : $_SERVER['DOCUMENT_ROOT'];
	$realpath = realpath($document_root);
	$realpath = str_replace('\\', '/', $realpath);
	$realpath = rtrim($realpath, '/') . '/';
	define('DOCUMENT_ROOT', $realpath);
	
	// ROOT - The relative web path to this file
	$root = str_replace(DOCUMENT_ROOT, '', ROOT_PATH);
	define('ROOT', $root);
	
	// REQUEST - Get the server request
	$request = ! empty($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';// Apache
	$request = ( strlen($request) > 0 && ! empty($_SERVER['PATH_INFO']) ) ? $_SERVER['PATH_INFO'] : $request;// IIS
	define('REQUEST', $request);
	// REQUEST_URI - The relative server request URI
	$request_uri = ( strlen(ROOT) > 0 && strpos(REQUEST, ROOT) === 1 ) ? substr(REQUEST, strlen(ROOT)) : REQUEST;
	define('REQUEST_URI', $request_uri);
	
	// BASE_URL - The base url to the site
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
	
	// VIEWPATH - The path to view files
	define('VIEWPATH', ROOT_PATH);
	// INCLUDES_PATH - The path to includes
	define('INCLUDES_PATH', VIEWPATH . 'includes/');
}
// --------------------------------------------------------------------

// --------------------------------------------------------------------
// REDLOVE
// Set up environment constant for reference
// http://en.wikipedia.org/wiki/Development_environment
if ( ! defined('ENVIRONMENT') )
{
	// --------------------------------------------------------------------
	// REDLOVE
	// Autoload environment include if it exists
	$file = INCLUDES_PATH . 'config/environment.php';
	if ( file_exists($file) )
	{
		include_once($file);
	}
	// --------------------------------------------------------------------
	
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
			exit(1);// EXIT_ERROR
	}
	
	// --------------------------------------------------------------------
	// REDLOVE_PATH - The path to redlove resources
	$config['environment']['redlove']['num_dirs_from_root_path'] = ! empty($config['environment']['redlove']['num_dirs_from_root_path']) ? $config['environment']['redlove']['num_dirs_from_root_path'] : 0;
	$num_dirs_redlove_from_root_path = ! empty($config['environment']['redlove']['num_dirs_from_root_path']) ? $config['environment']['redlove']['num_dirs_from_root_path'] : 0;
	$realpath = realpath(ROOT_PATH . str_repeat('../', $num_dirs_redlove_from_root_path) . 'redlove/');
	$realpath = str_replace('\\', '/', $realpath);
	$realpath = rtrim($realpath, '/') . '/';
	define('REDLOVE_PATH', $realpath);
	// REDLOVE_ROOT - The web root to redlove resources
	$redlove_root = substr(REDLOVE_PATH, strlen(DOCUMENT_ROOT));
	$redlove_root = str_replace('\\', '/', $redlove_root);
	$redlove_root = trim($redlove_root, '/') . '/';
	define('REDLOVE_ROOT', str_repeat('../', $num_dirs_redlove_from_root_path) . $redlove_root);
	// REDLOVE_URL - The url to redlove resources
	$redlove_url = $protocol . $_SERVER['HTTP_HOST'] . '/' . str_replace(DOCUMENT_ROOT, '', REDLOVE_PATH);
	define('REDLOVE_URL', $redlove_url);
	// --------------------------------------------------------------------
}
// --------------------------------------------------------------------

// --------------------------------------------------------------------
// REDLOVE
// Autoload includes
$file = INCLUDES_PATH . 'config/autoload.php';
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
// --------------------------------------------------------------------

// --------------------------------------------------------------------
// REDLOVE
// Set theme
if ( ! defined('THEMES_PATH') )
{
	// THEMES_PATH - The path to themes
	$config['site']['themes_path'] = ! empty($config['site']['themes_path']) ? $config['site']['themes_path'] : '';
	$themes_path = $config['site']['themes_path'];
	$themes_path = rtrim(INCLUDES_PATH . $themes_path, '/');
	$themes_path .= ( strlen($themes_path) > 0 ) ? '/' : '';
	define('THEMES_PATH', $themes_path);
	// THEMES_ROOT - The web root to themes
	$themes_root = str_replace(ROOT_PATH, '', THEMES_PATH);
	$themes_root = str_replace('\\', '/', $themes_root);
	$themes_root = rtrim($themes_root, '/');
	$themes_root .= ( strlen($themes_root) > 0 ) ? '/' : '';
	define('THEMES_ROOT', $themes_root);

	// THEME_DIRECT - If directly browsing the include theme
	// If directly browsing a theme via the themes directory, switch resources over to it
	$is_directly_browsing_theme = ( strpos(REQUEST_URI, THEMES_ROOT) === 1 );
	define('THEME_DIRECT', (int)$is_directly_browsing_theme);
	// THEME - The theme
	$config['site']['theme'] = ! empty($config['site']['theme']) ? $config['site']['theme'] : '';
	$theme = $config['site']['theme'];
	if ( THEME_DIRECT )
	{
		$theme = strtok(str_replace(THEMES_ROOT, '', REQUEST_URI), '/');
	}
	define('THEME', $theme);
	// THEME_PATH - The path to the theme
	$theme_path = rtrim(THEMES_PATH . THEME, '/');
	$theme_path .= ( strlen($theme_path) > 0 ) ? '/' : '';
	define('THEME_PATH', $theme_path);
	// THEME_ROOT - The web root to the theme
	$theme_root = rtrim(THEMES_ROOT . THEME, '/');
	$theme_root .= ( strlen($theme_root) > 0 ) ? '/' : '';
	define('THEME_ROOT', $theme_root);
	// THEME_NAV_ROOT - Depending on how the theme is being browsed, use this web root for navigation
	$theme_nav_root = '';
	if ( THEME_DIRECT )
	{
		$theme_nav_root = THEME_ROOT;
	}
	define('THEME_NAV_ROOT', $theme_nav_root);
	// THEME_URL - The url to the theme resources
	$theme_url = BASE_URL;
	if ( THEME_DIRECT )
	{
		$theme_url = BASE_URL . $theme_root;
	}
	define('THEME_URL', $theme_url);
	
	// PAGE - The cleaned up REQUEST_URI
	//define('PAGE', trim(parse_url(REQUEST_URI, PHP_URL_PATH), '/'));
	$page = ltrim(parse_url(REQUEST_URI, PHP_URL_PATH), '/');
	if ( THEME_DIRECT )
	{
		$page = str_replace(THEME_ROOT, '', $page);
	}
	$page .= ( substr(REQUEST_URI, -1) == '/' ) ? 'index' : '';
	$page_ext = strtolower( substr((string)strrchr($page, '.'), 1) );// Lowercase, get text after dot, get text dot and after
	$page = substr($page, 0, strlen($page) - strlen($page_ext));// Remove file extension
	if ( strlen($page_ext) > 0 )
	{
		$page = substr($page, 0, -1);
	}
	define('PAGE', $page);
	$page_filename = basename($page);// Remove file extension
	define('PAGE_FILENAME', $page_filename);
	define('PAGE_EXTENSION', $page_ext);
	$PAGE_segments = explode('/', PAGE);
}
// --------------------------------------------------------------------

// --------------------------------------------------------------------
// REDLOVE
// Make the timezone consistent on the server and audience location
// http://stackoverflow.com/questions/1646171/mysql-datetime-fields-and-daylight-savings-time-how-do-i-reference-the-extra
$config['site']['timezone'] = ! empty($config['site']['timezone']) ? $config['site']['timezone'] : 'America/New_York';
$timezone = $config['site']['timezone'];
if ( 
	function_exists('date_default_timezone_set') && 
	function_exists('date_default_timezone_get') && 
	@date_default_timezone_get() != $timezone
)
{
	@date_default_timezone_set( $timezone );
}
// --------------------------------------------------------------------

// --------------------------------------------------------------------
// REDLOVE
// Check and set the current datetime
// If overriding the session via querystring
$now_time = ! empty($_REQUEST['now']) ? strtotime($_REQUEST['now'] . ' ' . $timezone) : time();
$now = gmdate('Y-m-d H:i:s', $now_time);
// --------------------------------------------------------------------

/*
// Debugging
echo '<pre>';
print_r(array(
	'DOCUMENT_ROOT' => DOCUMENT_ROOT,
	'ROOT_PATH' => ROOT_PATH,
	'ROOT' => ROOT,
	'REQUEST' => REQUEST,
	'REQUEST_URI' => REQUEST_URI,
	'PAGE' => PAGE,
	'PAGE_FILENAME' => PAGE_FILENAME,
	'PAGE_EXTENSION' => PAGE_EXTENSION,
	'BASE_URL' => BASE_URL,
	'VIEWPATH' => VIEWPATH,
	'INCLUDES_PATH' => INCLUDES_PATH,
	'THEME' => THEME,
	'THEME_DIRECT' => THEME_DIRECT,
	'THEMES_PATH' => THEMES_PATH,
	'THEMES_ROOT' => THEMES_ROOT,
	'THEME_PATH' => THEME_PATH,
	'THEME_ROOT' => THEME_ROOT,
	'THEME_NAV_ROOT' => THEME_NAV_ROOT,
	'THEME_URL' => THEME_URL,
	'REDLOVE_PATH' => REDLOVE_PATH,
	'REDLOVE_ROOT' => REDLOVE_ROOT,
	'REDLOVE_URL' => REDLOVE_URL,
	'$now' => $now,
));
echo '</pre>';
*/
