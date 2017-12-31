<?php
/**
* This file is a hook class
*
* @package CodeIgniter
* @subpackage RedLove
* @category Hooks
* @author Joshua Logsdon <joshua@joshualogsdon.com>
* @copyright Copyright (c) 2015, Joshua Logsdon (http://joshualogsdon.com/)
* @license http://opensource.org/licenses/MIT MIT License
* @link http://joshualogsdon.com
* @filesource
* @since Version 0.0.0
* @version 0.0.0
*/

/**
* Initialize constants and variables for app use
*
* @package CodeIgniter
* @subpackage RedLove
* @author Joshua Logsdon <joshua@joshualogsdon.com>
* @link
*/
class Redlove
{
	/**
	* CodeIgniter instance
	*
	* @var object
	*/
	public $CI;
	
	/**
	* The data array
	*
	* @var array
	*/
	public $data = array();
	
	// --------------------------------------------------------------------
	
	/**
	* Class constructor
	*/
	public function __construct ()
	{
		$this->CI =& get_instance();
		
		log_message('info', __CLASS__ . ' class initialized.');
	}
	
	// --------------------------------------------------------------------
	
	/** 
	* Display a certain notice type or name, optionally deleting after display.
	* 
	* @param array $params
	* @return string
	*/
	public function init ( $params = array() )
	{
		// If array not passed, set params with arguments
		if ( ! is_array($params) )
		{
			// Get arguments
			$args = func_get_args();
			$num_args = count($args);
			
			if ( $num_args > 0 )
			{
				$params['code'] = $args[0];
			}
			if ( $num_args > 1 )
			{
				$params['type'] = $args[1];
			}
		}
		
		// Set default values for missing keys
		$default_params = array(
			'code' => '',
			'type' => '',
			'format' => '',
			'cleanup' => false,
		);
		$params = array_merge($default_params, $params);
		
/* REDLOVE
	Setup global paths
	
	http://codeigniter.com/wiki/Dynamic_Base_Url/
	http://codeigniter.com/wiki/Automatic_configbase_url/
*/
if ( ! defined('ROOT_PATH') )
{
	// ROOT_PATH - The server path to this file
	$num_dirs_from_root_path = 0;
	$dirs_to_root_path = '/' . str_repeat('../', $num_dirs_from_root_path);
	$realpath = realpath(dirname(__FILE__) . $dirs_to_root_path);
	
	$realpath = FCPATH;
	
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
	$root = str_replace(DOCUMENT_ROOT, '/', ROOT_PATH);
	$root = rtrim($root, '/') . '/';
	define('ROOT', $root);
	
	// REQUEST - Get the server request
	$request = ! empty($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';// Apache
	$request = ( strlen($request) > 0 && ! empty($_SERVER['PATH_INFO']) ) ? $_SERVER['PATH_INFO'] : $request;// IIS
	define('REQUEST', $request);
	// REQUEST_URI - The relative server request URI
	$request_uri = ( strlen(ROOT) > 0 && strpos(REQUEST, ROOT) === 0 ) ? substr(REQUEST, strlen(ROOT)) : REQUEST;
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
	$base_url = $protocol . $_SERVER['HTTP_HOST'] . ROOT;
	define('BASE_URL', $base_url);
	
	// VIEWPATH - The path to view files
	//define('VIEWPATH', ROOT_PATH);
	// INCLUDES_PATH - The path to includes
	define('INCLUDES_PATH', VIEWPATH . '_includes/');;
}
// REDLOVE
// Preload includes
$filename = 'preload';
$file = APPPATH . 'config/application/' . $filename . '.php';
if ( file_exists($file) )
{
	include_once($file);
	if ( ! empty($config[$filename]) )
	{
		foreach ( $config[$filename] as $key => $value )
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

/* CodeIgniter now handles this
// REDLOVE
// Set up environment constant for reference
// http://en.wikipedia.org/wiki/Development_environment
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
*/

// --------------------------------------------------------------------
// REDLOVE_PATH - The path to redlove resources
$config['environment']['redlove']['num_dirs_from_root_path'] = ! empty($config['environment']['redlove']['num_dirs_from_root_path']) ? $config['environment']['redlove']['num_dirs_from_root_path'] : 0;
$num_dirs_redlove_from_root_path = ! empty($config['environment']['redlove']['num_dirs_from_root_path']) ? $config['environment']['redlove']['num_dirs_from_root_path'] : 0;
$realpath = realpath(ROOT_PATH . str_repeat('../', $num_dirs_redlove_from_root_path) . 'redlove/');
$realpath = str_replace('\\', '/', $realpath);
$realpath = rtrim($realpath, '/') . '/';
define('REDLOVE_PATH', $realpath);
if ( defined('REDLOVE_PATH') && ! is_dir(REDLOVE_PATH) )
{
	die('RedLove path does not exist.');
}
// REDLOVE_ROOT - The web root to redlove resources
$redlove_root = substr(REDLOVE_PATH, strlen(DOCUMENT_ROOT));
$redlove_root = '/' . str_repeat('../', $num_dirs_redlove_from_root_path) . $redlove_root;
$redlove_root = str_replace('\\', '/', $redlove_root);
$redlove_root = rtrim($redlove_root, '/') . '/';
if ( $num_dirs_redlove_from_root_path == 0 )
{
	$redlove_root = str_replace(ROOT, '/', $redlove_root);
}
define('REDLOVE_ROOT', $redlove_root);
// REDLOVE_URL - The url to redlove resources
$redlove_url = $protocol . $_SERVER['HTTP_HOST'] . '/' . str_replace(DOCUMENT_ROOT, '', REDLOVE_PATH);
define('REDLOVE_URL', $redlove_url);
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
	$is_directly_browsing_theme = ( strpos(REQUEST_URI, THEMES_ROOT) === 0 );
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
	$page .= ( REQUEST_URI == '' || substr(REQUEST_URI, -1) == '/' ) ? 'index' : '';
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
/*
REDLOVE
http://ellislab.com/codeigniter/user-guide/general/errors.html

Make your logs folder writable and use log_message()


http://stackoverflow.com/questions/3209807/how-to-do-error-logging-in-php-codeigniter
http://us.php.net/manual/en/ref.errorfunc.php

First, to trigger an error:
trigger_error("Error message here", E_USER_ERROR);

By default, this will go in the server's error log file. See the ErrorLog directive for Apache. To set your own log file:
ini_set('error_log', 'path/to/log/file');

Note that the log file you choose must already exist and be writable by the server process. The simplest way to make the file writable is to make the server user the owner of the file. (The server user may be nobody, _www, apache, or something else, depending on your OS distribution.)

To e-mail the error, you need to set up a custom error handler:

function mail_error($errno, $errstr, $errfile, $errline) {
	$message = "[Error $errno] $errstr - Error on line $errline in file $errfile";
	error_log($message); // writes the error to the log file
	mail('you@yourdomain.com', 'I have an error', $message);
}
set_error_handler('mail_error', E_ALL^E_NOTICE);
*/
	}
	
	// --------------------------------------------------------------------
	
}