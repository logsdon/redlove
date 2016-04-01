<?php
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2014 - 2015, British Columbia Institute of Technology
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package	CodeIgniter
 * @author	EllisLab Dev Team
 * @copyright	Copyright (c) 2008 - 2014, EllisLab, Inc. (http://ellislab.com/)
 * @copyright	Copyright (c) 2014 - 2015, British Columbia Institute of Technology (http://bcit.ca/)
 * @license	http://opensource.org/licenses/MIT	MIT License
 * @link	http://codeigniter.com
 * @since	Version 1.0.0
 * @filesource
 */

/*
 *---------------------------------------------------------------
 * SYSTEM FOLDER NAME
 *---------------------------------------------------------------
 *
 * This variable must contain the name of your "system" folder.
 * Include the path if the folder is not in the same directory
 * as this file.
 */
	$system_path = 'ci/system';

/*
 *---------------------------------------------------------------
 * APPLICATION FOLDER NAME
 *---------------------------------------------------------------
 *
 * If you want this front controller to use a different "application"
 * folder than the default one you can set its name here. The folder
 * can also be renamed or relocated anywhere on your server. If
 * you do, use a full server path. For more info please see the user guide:
 * http://codeigniter.com/user_guide/general/managing_apps.html
 *
 * NO TRAILING SLASH!
 */
	$application_folder = 'ci/application';
		
/*
 *---------------------------------------------------------------
 * VIEW FOLDER NAME
 *---------------------------------------------------------------
 *
 * If you want to move the view folder out of the application
 * folder set the path to the folder here. The folder can be renamed
 * and relocated anywhere on your server. If blank, it will default
 * to the standard location inside your application folder. If you
 * do move this, use the full server path to this folder.
 *
 * NO TRAILING SLASH!
 */
	$view_folder = '';


/*
 * --------------------------------------------------------------------
 * DEFAULT CONTROLLER
 * --------------------------------------------------------------------
 *
 * Normally you will set your default controller in the routes.php file.
 * You can, however, force a custom routing by hard-coding a
 * specific controller class/function here. For most applications, you
 * WILL NOT set your routing here, but it's an option for those
 * special instances where you might want to override the standard
 * routing in a specific front controller that shares a common CI installation.
 *
 * IMPORTANT: If you set the routing here, NO OTHER controller will be
 * callable. In essence, this preference limits your application to ONE
 * specific controller. Leave the function name blank if you need
 * to call functions dynamically via the URI.
 *
 * Un-comment the $routing array below to use this feature
 */
	// The directory name, relative to the "controllers" folder.  Leave blank
	// if your controller is not in a sub-folder within the "controllers" folder
	// $routing['directory'] = '';

	// The controller class file name.  Example:  mycontroller
	// $routing['controller'] = '';

	// The controller function you wish to be called.
	// $routing['function']	= '';


/*
 * -------------------------------------------------------------------
 *  CUSTOM CONFIG VALUES
 * -------------------------------------------------------------------
 *
 * The $assign_to_config array below will be passed dynamically to the
 * config class when initialized. This allows you to set custom config
 * items or override any default config values found in the config.php file.
 * This can be handy as it permits you to share one application between
 * multiple front controller files, with each file containing different
 * config values.
 *
 * Un-comment the $assign_to_config array below to use this feature
 */
	// $assign_to_config['name_of_config_item'] = 'value of config item';



// --------------------------------------------------------------------
// END OF USER CONFIGURABLE SETTINGS.  DO NOT EDIT BELOW THIS LINE
// --------------------------------------------------------------------

/*
 * ---------------------------------------------------------------
 *  Resolve the system path for increased reliability
 * ---------------------------------------------------------------
 */

	// Set the current directory correctly for CLI requests
	if (defined('STDIN'))
	{
		chdir(dirname(__FILE__));
	}

	if (($_temp = realpath($system_path)) !== FALSE)
	{
		$system_path = $_temp.'/';
	}
	else
	{
		// Ensure there's a trailing slash
		$system_path = rtrim($system_path, '/').'/';
	}

	// Is the system path correct?
	if ( ! is_dir($system_path))
	{
		header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
		echo 'Your system folder path does not appear to be set correctly. Please open the following file and correct this: '.pathinfo(__FILE__, PATHINFO_BASENAME);
		exit(3); // EXIT_CONFIG
	}

/*
 * -------------------------------------------------------------------
 *  Now that we know the path, set the main path constants
 * -------------------------------------------------------------------
 */
	// The name of THIS file
	define('SELF', pathinfo(__FILE__, PATHINFO_BASENAME));

	// Path to the system folder
	define('BASEPATH', str_replace('\\', '/', $system_path));

	// Path to the front controller (this file)
	define('FCPATH', dirname(__FILE__).'/');

	// Name of the "system folder"
	define('SYSDIR', trim(strrchr(trim(BASEPATH, '/'), '/'), '/'));

	// The path to the "application" folder
	if (is_dir($application_folder))
	{
		if (($_temp = realpath($application_folder)) !== FALSE)
		{
			$application_folder = $_temp;
		}

		define('APPPATH', $application_folder.DIRECTORY_SEPARATOR);
	}
	else
	{
		if ( ! is_dir(BASEPATH.$application_folder.DIRECTORY_SEPARATOR))
		{
			header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
			echo 'Your application folder path does not appear to be set correctly. Please open the following file and correct this: '.SELF;
			exit(3); // EXIT_CONFIG
		}

		define('APPPATH', BASEPATH.$application_folder.DIRECTORY_SEPARATOR);
	}

	// The path to the "views" folder
	if ( ! is_dir($view_folder))
	{
		if ( ! empty($view_folder) && is_dir(APPPATH.$view_folder.DIRECTORY_SEPARATOR))
		{
			$view_folder = APPPATH.$view_folder;
		}
		elseif ( ! is_dir(APPPATH.'views'.DIRECTORY_SEPARATOR))
		{
			header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
			echo 'Your view folder path does not appear to be set correctly. Please open the following file and correct this: '.SELF;
			exit(3); // EXIT_CONFIG
		}
		else
		{
			$view_folder = APPPATH.'views';
		}
	}

	if (($_temp = realpath($view_folder)) !== FALSE)
	{
		$view_folder = $_temp.DIRECTORY_SEPARATOR;
	}
	else
	{
		$view_folder = rtrim($view_folder, '/\\').DIRECTORY_SEPARATOR;
	}

	define('VIEWPATH', $view_folder);

// --------------------------------------------------------------------
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

/*
 *---------------------------------------------------------------
 * APPLICATION ENVIRONMENT
 *---------------------------------------------------------------
 *
 * You can load different configurations depending on your
 * current environment. Setting the environment also influences
 * things like logging and error reporting.
 *
 * This can be set to anything, but default usage is:
 *
 *     development
 *     testing
 *     production
 *
 * NOTE: If you change these, also change the error_reporting() code below
 */
	//define('ENVIRONMENT', isset($_SERVER['CI_ENV']) ? $_SERVER['CI_ENV'] : 'development');

// --------------------------------------------------------------------
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
$redlove_root = str_replace('\\', '/', $redlove_root);
$redlove_root = trim($redlove_root, '/') . '/';
define('REDLOVE_ROOT', str_repeat('../', $num_dirs_redlove_from_root_path) . $redlove_root);
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
 *---------------------------------------------------------------
 * ERROR REPORTING
 *---------------------------------------------------------------
 *
 * Different environments will require different levels of error reporting.
 * By default development will show errors but testing and live will hide them.
 */
switch (ENVIRONMENT)
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


/*
 * --------------------------------------------------------------------
 * LOAD THE BOOTSTRAP FILE
 * --------------------------------------------------------------------
 *
 * And away we go...
 */
require_once BASEPATH.'core/CodeIgniter.php';
