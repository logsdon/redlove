<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* Clean tags text.
*
* @access public
* @param mixed $tags
* @return int Database insert id on success.
* @return bool FALSE on failure.
*/
if ( ! function_exists('clean_tags'))
{
	function clean_tags( $tags, $return_array = FALSE )
	{
		// Make tags a string if necessary
		if ( is_array($tags) )
		{
			$tags = implode(',', $tags);
		}
		
		// Remove non-alphanumeric, non-commas, non-spaces, and non-dashes
		$tags = preg_replace('/[^a-zA-Z0-9,\s-]/', '', $tags);
		// Make all lower case
		$tags = strtolower($tags);
		// Make array to iterate over
		$tags = explode(',', $tags);
		// Trim individual whitespace
		$tags = array_map('trim', $tags);
		// Remove blanks
		$tags = array_diff($tags, array(''));
		// Remove duplicates
		$tags = array_unique($tags);
		
		if ( $return_array === FALSE )
		{
			$tags = implode(', ', $tags);
		}
		
		return $tags;
	}
}

// ------------------------------------------------------------------------

