<?php
/**
* URL helper functions
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

if ( ! function_exists('anchor'))
{
	function anchor($uri = '', $title = '', $attributes = '')
	{
		$title = (string) $title;

		if ( ! is_array($uri))
		{
			$site_url = ( ! preg_match('!^\w+://! i', $uri)) ? site_url($uri) : $uri;
		}
		else
		{
			$site_url = site_url($uri);
		}

		if ($title == '')
		{
			$title = $site_url;
		}

		return '<a href="'.$site_url.'"'.$attributes.'>'.$title.'</a>';
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('page_seg_is') )
{
	function page_seg_is( $page, $seg = 0, $strict = FALSE )
	{
		global $PAGE_segments;
		if ( $seg < 0 ) $seg += count($PAGE_segments);
		if ( $strict || $page == '' ) return ($PAGE_segments[$seg] === $page);
		return (strpos(strtolower($PAGE_segments[$seg]), strtolower($page)) === 0);
	}
}

// --------------------------------------------------------------------

if ( ! function_exists('page_is') )
{
	function page_is( $page, $strict = FALSE )
	{
		if ( is_array($page) ) return page_in($page, $strict);
		elseif ( $strict || $page == '' ) return (PAGE === $page);
		return (strpos(strtolower(PAGE), strtolower($page)) === 0);
	}
}

// --------------------------------------------------------------------

if ( ! function_exists('page_in') )
{
	function page_in( $array, $strict = FALSE )
	{
		return (deep_in_array(PAGE, $array, $strict));
	}
}

// --------------------------------------------------------------------

if ( ! function_exists('deep_in_array') )
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
					$ret = (! $strict) ? strpos(strtolower($value), strtolower($item)) === 0 : $item == $value;
				}
			}
			if ( $ret ) return $ret;
		}
		return FALSE;
	}
}

// --------------------------------------------------------------------

/**
 * Create URL Title
 *
 * Takes a "title" string as input and creates a
 * human-friendly URL string with either a dash
 * or an underscore as the word separator.
 *
 * @access	public
 * @param	string	the string
 * @param	string	the separator: dash, or underscore
 * @return	string
 */
if ( ! function_exists('url_title'))
{
	function url_title( $str, $separator = 'dash', $lowercase = FALSE )
	{
		if ( $separator == 'dash' )
		{
			$search = '_';
			$replace = '-';
		}
		else
		{
			$search = '-';
			$replace = '_';
		}
		
		$trans = array(
			'&\#\d+?;' => '',
			'&\S+?;' => '',
			'\s+' => $replace,
			'[^a-z0-9\-_]' => '',// JOSHUA LOGSDON - Removed period // \.
			$replace . '+' => $replace,
			$replace . '$' => $replace,
			'^' . $replace => $replace,
			'\.+$' => '',
		);
		
		$str = strip_tags($str);
		
		foreach ( $trans as $key => $val )
		{
			$str = preg_replace("#" . $key . "#i", $val, $str);
		}
		
		if ( $lowercase )
		{
			$str = strtolower($str);
		}
		
		return trim(stripslashes($str));
	}
}

// --------------------------------------------------------------------

