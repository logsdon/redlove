<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* This file has helper functions
*
* @package CodeIgniter
* @subpackage Logsdon
* @category Helpers
* @author Joshua Logsdon <joshua@joshualogsdon.com>
* @copyright Copyright (c) 2015, Joshua Logsdon (http://joshualogsdon.com/)
* @license http://opensource.org/licenses/MIT MIT License
* @link http://joshualogsdon.com
* @filesource
* @since Version 0.0.0
* @version 0.0.0
*/

// ------------------------------------------------------------------------

if ( ! function_exists('has_url'))
{
	function has_url( $str )
	{
		$str = html_entity_decode($str, ENT_QUOTES, 'utf-8');
		return ( ! preg_match("#(^|\s|\()((http(s?)://)|(www\.))(\w+[^\s\)\<]+)#i", $str) ? FALSE : TRUE );
	}
}
/*
$SCHEMES = array('http', 'https', 'ftp', 'mailto', 'news', 'gopher', 'nntp', 'telnet', 'wais', 'prospero', 'aim', 'webcal');
// Note: fragment id is uchar | reserved, see rfc 1738 page 19
// %% for % because of string formating
// puncuation = ? , ; . : !
// if punctuation is at the end, then don't include it
$URL_FORMAT = '~(?<!\w)((?:'.implode('|',
    $SCHEMES).'):' # protocol + :
.   '/*(?!/)(?:' # get any starting /'s
.   '[\w$\+\*@&=\-/]' # reserved | unreserved
.   '|%%[a-fA-F0-9]{2}' # escape
.   '|[\?\.:\(\),;!\'](?!(?:\s|$))' # punctuation
.   '|(?:(?<=[^/:]{2})#)' # fragment id
.   '){2,}' # at least two characters in the main url part
.   ')~';

then use it later as:

preg_match($URL_FORMAT, $text, $matches, PREG_SPLIT_DELIM_CAPTURE);
*/

// ------------------------------------------------------------------------

if ( ! function_exists('has_html'))
{
	function has_html( $str )
	{
		//return (strlen($str) == strlen(strip_tags($str)));
		//return (strlen($str) == strlen(preg_replace('/<[^>]*>/', '', $str)));
		return ( ! preg_match('/<[^>]*>/', $str) ? FALSE : TRUE );
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('valid_email'))
{
	function valid_email($str)
	{
		$str = html_entity_decode($str, ENT_QUOTES, 'utf-8');
		return ( ! preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $str) ? FALSE : TRUE );
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('real_domain'))
{
	function real_domain( $url, $prefix = '' )
	{
		$host = parse_url($url, PHP_URL_HOST);
		// If not an IP
		if ( ! preg_match('/^(\d{1,3})\.(\d{1,3})\.(\d{1,3})\.(\d{1,3})$/', $host) )
		{
			// If subdomains, get the last x.x
			if ( preg_match('/\.([^\.]+\.[^\.]+)$/', $host, $matches) > 0 )
			{
				$host = $matches[1];
			}
			$host = $prefix . $host;
		}
		return $host;
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('obfuscate') )
{
	function obfuscate( $string, $randomly_skip = FALSE )
	{
		$obf_string = '';
		foreach ( str_split($string) as $char )
		{
			if ( $randomly_skip !== FALSE && mt_rand(0, (int)$randomly_skip) == (int)$randomly_skip )
			{
				$obf_string .= $char;
				continue;
			}
			$obf_string .= '&#' . ord($char) . ';';
		}
		return $obf_string;
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('obfuscate_email') )
{
	function obfuscate_email( $email )
	{
		$email = obfuscate($email, 2);
		$email = str_replace(array(':', '@', '.'), array('&#58;', '&#64;', '&#46;'), $email);
		return $email;
	}
}

// --------------------------------------------------------------------

if ( ! function_exists('obfuscate_mailto') )
{
	function obfuscate_mailto( $email, $name = '', $attributes = '' )
	{
		$name = obfuscate( ($name == '' ? $email : $name), 2 );
		$name = str_replace(array(':', '@', '.'), array('&#58;', '&#64;', '&#46;'), $name);
		$email = obfuscate('mailto:' . $email, 2);
		$email = str_replace(array(':', '@', '.'), array('&#58;', '&#64;', '&#46;'), $email);
		$attributes = $attributes == '' ? '' : ' ' . $attributes;
		return '<a href="' . $email . '"' . $attributes . '>' . $name . '</a>';
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('page_seg_is'))
{
	function page_seg_is( $page, $seg = 0, $strict = FALSE )
	{
		global $PAGE_segments;
		if ( $seg < 0 )
		{
			$seg += count($PAGE_segments);
		}
		if ( $strict || $page == '' )
		{
			return ($PAGE_segments[$seg] === $page);
		}
		return ( strpos(strtolower($PAGE_segments[$seg]), strtolower($page)) === 0 );
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('page_is'))
{
	function page_is( $page, $strict = FALSE )
	{
		if ( is_array($page) )
		{
			return page_in($page, $strict);
		}
		elseif ( $strict || $page == '' )
		{
			return (PAGE === $page);
		}
		return ( strpos(strtolower(PAGE), strtolower($page)) === 0 );
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('page_in'))
{
	function page_in( $array, $strict = FALSE )
	{
		return ( deep_in_array(PAGE, $array, $strict) );
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('deep_in_array'))
{
	//http://www.php.net/manual/en/function.in-array.php#64161
	function deep_in_array( $value, $array, $strict = FALSE )
	{
		foreach ( $array as $item )
		{
			if ( is_array($item) )
			{
				$ret = deep_in_array($value, $item, $strict);
			}
			//else $ret = (! $strict) ? strtolower($item)==strtolower($value) : $item==$value;
			else
			{
				if ( $item == '' )
				{
					$ret = ($item === $value);
				}
				else
				{
					$ret = (! $strict ? strpos(strtolower($value), strtolower($item)) === 0 : $item == $value);
				}
			}
			
			if ( $ret )
			{
				return $ret;
			}
		}
		return FALSE;
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('is_https'))
{
	function is_https()
	{
		// Check if using SSL (HTTPS)
		//$_SERVER['SERVER_PORT'] != 443// SSL port check, but unreliable if different port used
		return ( isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) == 'on' );
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('enforce_https'))
{
	function enforce_https()
	{
		if ( ! is_https() )
		{
			$CI =& get_instance();
			$url = $CI->security->xss_clean('https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
			header('Location: ' . $url);
			exit;
		}
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('get_full_url') )
{
	function get_full_url( $url )
	{
		$full_url = ( ! preg_match('!^\w+://! i', $url) ) ? site_url($url) : $url;

		return $full_url;
	}
}

// ------------------------------------------------------------------------

// http://stackoverflow.com/questions/1459739/php-serverhttp-host-vs-serverserver-name-am-i-understanding-the-ma
if ( ! function_exists('get_host') )
{
	function get_host()
	{
		$host = NULL;
		
		if ( isset($_SERVER['HTTP_X_FORWARDED_HOST']) )
		{
			$host = $_SERVER['HTTP_X_FORWARDED_HOST'];
			$elements = explode(',', $host);

			$host = trim(end($elements));
		}
		else
		{
			if ( ! $host = $_SERVER['HTTP_HOST'] )
			{
				if ( ! $host = $_SERVER['SERVER_NAME'] )
				{
					$host = ! empty($_SERVER['SERVER_ADDR']) ? $_SERVER['SERVER_ADDR'] : '';
				}
			}
		}

		// Remove port number from host
		$host = preg_replace('/:\d+$/', '', $host);

		return trim($host);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('get_cache_busting_filename') )
{
	/**
	* Get cache busting filename
	* http://webassets.readthedocs.org/en/latest/expiring.html
	* 
	* @param string $file
	* @param bool $bypass (optional)
	* @return string File with cache busting versioning applied
	*/
	function get_cache_busting_filename( $file, $bypass = false )
	{
		if ( $bypass )
		{
			return $file;
		}
		
		$mtime = 0;
		$file_ext = (string)strrchr($file, '.');
		$filename = substr($file, 0, strlen($file) - strlen($file_ext));
		$absolute_file = ROOT_PATH . $file;
		
		// Get the last modified time and append it to the filename
		$file_exists = ( $file && file_exists($absolute_file) && is_file($absolute_file) );
		if ( $file_exists )
		{
			$mtime = date('YmdHis', filemtime($absolute_file));
		}
		
		return $filename . '.' . (string)$mtime . $file_ext;
	}
}

// --------------------------------------------------------------------

if ( ! function_exists('base_url') )
{
	function base_url( $uri = '' )
	{
		//return ROOT;
		return BASE_URL . ltrim($uri, '/');
	}
}

// --------------------------------------------------------------------

if ( ! function_exists('site_url') )
{
	function site_url( $uri = '' )
	{
		return BASE_URL . ltrim($uri, '/');
	}
}

// --------------------------------------------------------------------

if ( ! function_exists('theme_base_url') )
{
	function theme_base_url( $uri = '' )
	{
		//return ROOT . THEME_ROOT;
		return BASE_URL . THEME_ROOT . ltrim($uri, '/');
	}
}

// --------------------------------------------------------------------

if ( ! function_exists('theme_url') )
{
	function theme_url( $uri = '' )
	{
		return BASE_URL . THEME_ROOT . ltrim($uri, '/');
	}
}

// --------------------------------------------------------------------

if ( ! function_exists('theme_nav_url') )
{
	function theme_nav_url( $uri = '' )
	{
		return BASE_URL . THEME_NAV_ROOT . ltrim($uri, '/');
	}
}

// --------------------------------------------------------------------

if ( ! function_exists('redlove_url') )
{
	function redlove_url( $uri = '' )
	{
		return BASE_URL . REDLOVE_ROOT . ltrim($uri, '/');
	}
}

// --------------------------------------------------------------------

if ( ! function_exists('cb_url') )
{
	/**
	* Get cache busting url
	* 
	* @param string $file
	* @param bool $bypass (optional)
	* @return string Url with cache busting versioning applied
	*/
	function cb_url( $file, $bypass = false )
	{
		return base_url() . ltrim(get_cache_busting_filename($file, $bypass), '/');
	}
}

// --------------------------------------------------------------------

if ( ! function_exists('theme_cb_url') )
{
	/**
	* Get cache busting url
	* 
	* @param string $file
	* @param bool $bypass (optional)
	* @return string Url with cache busting versioning applied
	*/
	function theme_cb_url( $file, $bypass = false )
	{
		return cb_url(THEME_ROOT . $file, $bypass);
	}
}

// --------------------------------------------------------------------

if ( ! function_exists('redlove_cb_url') )
{
	/**
	* Get cache busting url
	* 
	* @param string $file
	* @param bool $bypass (optional)
	* @return string Url with cache busting versioning applied
	*/
	function redlove_cb_url( $file, $bypass = false )
	{
		return cb_url(REDLOVE_ROOT . $file, $bypass);
	}
}

// --------------------------------------------------------------------

/**
* URL constants as defined in the PHP Manual under "Constants usable with
* http_build_url()".
*
* @see http://us2.php.net/manual/en/http.constants.php#http.constants.url
* @see https://raw.githubusercontent.com/jakeasmith/http_build_url/master/src/http_build_url.php
*/
if (!function_exists('http_build_url'))
{
	if (!defined('HTTP_URL_REPLACE')) {
		define('HTTP_URL_REPLACE', 1);
	}
	if (!defined('HTTP_URL_JOIN_PATH')) {
		define('HTTP_URL_JOIN_PATH', 2);
	}
	if (!defined('HTTP_URL_JOIN_QUERY')) {
		define('HTTP_URL_JOIN_QUERY', 4);
	}
	if (!defined('HTTP_URL_STRIP_USER')) {
		define('HTTP_URL_STRIP_USER', 8);
	}
	if (!defined('HTTP_URL_STRIP_PASS')) {
		define('HTTP_URL_STRIP_PASS', 16);
	}
	if (!defined('HTTP_URL_STRIP_AUTH')) {
		define('HTTP_URL_STRIP_AUTH', 32);
	}
	if (!defined('HTTP_URL_STRIP_PORT')) {
		define('HTTP_URL_STRIP_PORT', 64);
	}
	if (!defined('HTTP_URL_STRIP_PATH')) {
		define('HTTP_URL_STRIP_PATH', 128);
	}
	if (!defined('HTTP_URL_STRIP_QUERY')) {
		define('HTTP_URL_STRIP_QUERY', 256);
	}
	if (!defined('HTTP_URL_STRIP_FRAGMENT')) {
		define('HTTP_URL_STRIP_FRAGMENT', 512);
	}
	if (!defined('HTTP_URL_STRIP_ALL')) {
		define('HTTP_URL_STRIP_ALL', 1024);
	}

	/**
	 * Build a URL.
	 *
	 * The parts of the second URL will be merged into the first according to
	 * the flags argument.
	 *
	 * @param mixed $url     (part(s) of) an URL in form of a string or
	 *                       associative array like parse_url() returns
	 * @param mixed $parts   same as the first argument
	 * @param int   $flags   a bitmask of binary or'ed HTTP_URL constants;
	 *                       HTTP_URL_REPLACE is the default
	 * @param array $new_url if set, it will be filled with the parts of the
	 *                       composed url like parse_url() would return
	 * @return string
	 */
	function http_build_url($url, $parts = array(), $flags = HTTP_URL_REPLACE, &$new_url = array())
	{
		is_array($url) || $url = parse_url($url);
		is_array($parts) || $parts = parse_url($parts);

		isset($url['query']) && is_string($url['query']) || $url['query'] = null;
		isset($parts['query']) && is_string($parts['query']) || $parts['query'] = null;

		$keys = array('user', 'pass', 'port', 'path', 'query', 'fragment');

		// HTTP_URL_STRIP_ALL and HTTP_URL_STRIP_AUTH cover several other flags.
		if ($flags & HTTP_URL_STRIP_ALL) {
			$flags |= HTTP_URL_STRIP_USER | HTTP_URL_STRIP_PASS
				| HTTP_URL_STRIP_PORT | HTTP_URL_STRIP_PATH
				| HTTP_URL_STRIP_QUERY | HTTP_URL_STRIP_FRAGMENT;
		} elseif ($flags & HTTP_URL_STRIP_AUTH) {
			$flags |= HTTP_URL_STRIP_USER | HTTP_URL_STRIP_PASS;
		}

		// Schema and host are alwasy replaced
		foreach (array('scheme', 'host') as $part) {
			if (isset($parts[$part])) {
				$url[$part] = $parts[$part];
			}
		}

		if ($flags & HTTP_URL_REPLACE) {
			foreach ($keys as $key) {
				if (isset($parts[$key])) {
					$url[$key] = $parts[$key];
				}
			}
		} else {
			if (isset($parts['path']) && ($flags & HTTP_URL_JOIN_PATH)) {
				if (isset($url['path']) && substr($parts['path'], 0, 1) !== '/') {
					$url['path'] = rtrim(
							str_replace(basename($url['path']), '', $url['path']),
							'/'
						) . '/' . ltrim($parts['path'], '/');
				} else {
					$url['path'] = $parts['path'];
				}
			}

			if (isset($parts['query']) && ($flags & HTTP_URL_JOIN_QUERY)) {
				if (isset($url['query'])) {
					parse_str($url['query'], $url_query);
					parse_str($parts['query'], $parts_query);

					$url['query'] = http_build_query(
						array_replace_recursive(
							$url_query,
							$parts_query
						)
					);
				} else {
					$url['query'] = $parts['query'];
				}
			}
		}

		if (isset($url['path']) && substr($url['path'], 0, 1) !== '/') {
			$url['path'] = '/' . $url['path'];
		}

		foreach ($keys as $key) {
			$strip = 'HTTP_URL_STRIP_' . strtoupper($key);
			if ($flags & constant($strip)) {
				unset($url[$key]);
			}
		}

		$parsed_string = '';

		if (isset($url['scheme'])) {
			$parsed_string .= $url['scheme'] . '://';
		}

		if (isset($url['user'])) {
			$parsed_string .= $url['user'];

			if (isset($url['pass'])) {
				$parsed_string .= ':' . $url['pass'];
			}

			$parsed_string .= '@';
		}

		if (isset($url['host'])) {
			$parsed_string .= $url['host'];
		}

		if (isset($url['port'])) {
			$parsed_string .= ':' . $url['port'];
		}

		if (!empty($url['path'])) {
			$parsed_string .= $url['path'];
		} else {
			$parsed_string .= '/';
		}

		if (isset($url['query'])) {
			$parsed_string .= '?' . $url['query'];
		}

		if (isset($url['fragment'])) {
			$parsed_string .= '#' . $url['fragment'];
		}

		$new_url = $url;

		return $parsed_string;
	}
}

// --------------------------------------------------------------------

