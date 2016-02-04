<?php
/**
* Request helper functions
*
* @package RedLove
* @subpackage PHP
* @category Functions
* @author Joshua Logsdon <joshua@joshualogsdon.com>
* @author Various from CodeIgniter to Internet
* @copyright Copyright (c) 2015, Joshua Logsdon (http://joshualogsdon.com/)
* @license http://opensource.org/licenses/MIT MIT License
* @link https://github.com/logsdon/redlove
* @link http://redlove.org
* @version 0.0.0
* 
*/

// --------------------------------------------------------------------

if ( ! function_exists('is_ajax') )
{
	/**
	* Return whether is request is type associated with AJAX.
	* 
	* @access public
	* @param void
	* @return bool
	*/    
    function is_ajax()
    {
		return (
			(
				isset($_SERVER) && 
				isset($_SERVER['HTTP_X_REQUESTED_WITH']) && 
				$_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest' 
			) || 
			(
				isset($_REQUEST) && 
				isset($_REQUEST['ajax']) && 
				$_REQUEST['ajax'] === '1' 
			)
		);
	}
}

// --------------------------------------------------------------------

if ( ! function_exists('header_cache') )
{
	/**
	* Handle the cache of the request.
	* 
	* @access public
	* @param bool $clear
	* @return void
	*/
    function header_cache( $clear = TRUE )
    {
    	if ( $clear )
    	{
			header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');// Date in the past
			header('Expires: -1', FALSE);// IE6
			header('Last-Modified: '. gmdate('D, d M Y H:i:s') .' GMT');
			header('If-Modified-Since: Sat, 1 Jan 2000 00:00:00 GMT');
			header('Cache-Control: no-store, no-cache, must-revalidate');// HTTP/1.1
			header('Cache-Control: post-check=0, pre-check=0, max-age=0', FALSE);// HTTP/1.1
			header('Pragma: no-cache');// HTTP/1.0 && IE6
    	}
    }
}

// --------------------------------------------------------------------

if ( ! function_exists('curl') )
{
	/**
	* Get a web file (HTML, XHTML, XML, image, etc.) from a URL.  Return an
	* array containing the HTTP server response header fields and content.
	*/
	function curl( $url )
	{
		if ( ! function_exists('curl_init') ) die('CURL is not installed!');
		//Fetch the url using the CURL Library
		$options = array(
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => true,// return the content
			CURLOPT_HEADER => false,// don't return headers
			CURLOPT_FOLLOWLOCATION => true,// follow redirects
			CURLOPT_ENCODING => '',// handle all encodings
			CURLOPT_USERAGENT => '',// who am i
			CURLOPT_AUTOREFERER => true,// set referer on redirect
			CURLOPT_CONNECTTIMEOUT => 120,// timeout on connect
			CURLOPT_TIMEOUT => 120,// timeout on response
			CURLOPT_MAXREDIRS => 10,// stop after 10 redirects
		);
		$ch = curl_init();
		curl_setopt_array($ch, $options);
		$content = curl_exec($ch);
		$err = curl_errno($ch);
		$errmsg = curl_error($ch);
		$header = curl_getinfo($ch);
		curl_close($ch);
		return $content;
	}
}

// --------------------------------------------------------------------

if ( ! function_exists('set_cookie') )
{
	/**
	* Set cookie
	* 
	* @param mixed $params An array of parameters or list of arguments
	* @return bool Whether cookie was set or not
	*/
	function set_cookie ( $params = array() )
	{
		// Get arguments
		$args = func_get_args();
		$num_args = count($args);
		
		// Check for alternate argument patterns
		if ( $num_args > 1 )
		{
			$params = array(
				'name' => ( isset($args[0]) ? $args[0] : null ),
				'value' => ( isset($args[1]) ? $args[1] : null ),
				'ttl' => ( isset($args[2]) ? $args[2] : null ),
			);
		}
		
		// Set default values for missing keys
		$default_params = array(
			'delete' => false,
			'domain' => '',// .some-domain.com
			'expire' => 0,// Default to last browsing session
			'httponly' => false,
			'name' => 'mycookie',
			'path' => '/',
			'secure' => false,
			'ttl' => null,//60 * 60 (1 hour) * 24 (1 day) * 30 (30 days)
			'value' => '',
		);
		$params = array_merge($default_params, $params);
		
		// Enforce setting secure cookie over HTTPS
		if ( $params['secure'] )
		{
			$https = isset($_SERVER['HTTPS']) ? $_SERVER['HTTPS'] : false;
			if ( ! $https || $https == 'off' )
			{
				return false;
			}
		}
		
		// Set expires if time-to-live passed
		if ( isset($params['ttl']) )
		{
			$params['expire'] = time() + $params['ttl'];
		}
		
		// Encode cookie value
		return setcookie($params['name'], base64_encode(serialize($params['value'])), $params['expire'], $params['path'], $params['domain'], $params['secure'], $params['httponly']);
	}
}

// --------------------------------------------------------------------

if ( ! function_exists('get_cookie') )
{
	/**
	* Get cookie
	* 
	* @param mixed $name The cookie name
	* @return null|mixed The cookie value if it exists
	*/
	function get_cookie ( $name )
	{
		if ( ! empty($_COOKIE) && isset($_COOKIE[$name]) )
		{
			// Decode cookie value
			return unserialize(base64_decode($_COOKIE[$name]));
		}
	}
}

// --------------------------------------------------------------------

if ( ! function_exists('delete_cookie') )
{
	/**
	* Get cookie
	* 
	* @param mixed $name The cookie name
	*/
	function delete_cookie ( $params = array() )
	{
		// Check for alternate argument patterns
		if ( is_string($params) )
		{
			$params = array(
				'name' => $params,
			);
		}
		
		// Set default values for missing keys
		$default_params = array(
			'delete' => false,
			'domain' => '',// .some-domain.com
			'httponly' => false,
			'name' => 'mycookie',
			'path' => '/',
			'secure' => false,
		);
		$params = array_merge($default_params, $params);
		
		if ( ! empty($_COOKIE) && isset($_COOKIE[$params['name']]) )
		{
			unset($_COOKIE[$params['name']]);
			// Empty value and old timestamp
			return setcookie($params['name'], '', time() - 3600, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
		}
	}
}

// --------------------------------------------------------------------
