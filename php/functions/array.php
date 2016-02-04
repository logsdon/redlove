<?php
/**
* Array helper functions
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

if ( ! function_exists('shuffle_assoc') )
{
	/**
	* Shuffle associative array
	* 
	* @param array $array Array passed by reference
	* @return mixed Return the variable back if not an array or true on success
	*/
	function shuffle_assoc ( & $array )
	{
		if ( ! is_array($array) )
		{
			return $array;
		}
		
		$keys = array_keys($array);

		shuffle($keys);

		foreach ( $keys as $key )
		{
			$new[$key] = $array[$key];
		}

		$array = $new;

		return true;
	}
}

// --------------------------------------------------------------------
