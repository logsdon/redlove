<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
* http://codeigniter.com/forums/viewthread/71312/
* http://blogs.warwick.ac.uk/andrewdavey/entry/example_php_to/
* 
* The main difference between this and the dbutil method is the use of CDATA
*/
if (! function_exists('query_to_xml'))
{
	/**
	* Create an XML document from a query.
	*
	* @param object $query Query resource.
	* @param string $root
	* @param string $element
	* @param string $newline
	* @param string $tab
	* @return string
	*/
	function query_to_xml( $query, $root, $element, $newline = "\n", $tab = "\t" )
	{
		$xml = '<?xml version="1.0" encoding="utf-8" ?>' . $newline;
		$xml .= '<' . $root . '>' . $newline;
		while ( $row = $query->unbuffered_row('array') )
		{
			$xml .= '<' . $element . '>' . $newline;
			foreach ( $row as $key => $value )
			{
				$xml .= '<' . $key . '><![CDATA[' . $value . ']]></' . $key . '>' . $newline;//urlencode(utf8_encode(trim(
			}
			$xml .= '</' . $element . '>' . $newline;
		}
		$xml .= '</' . $root . '>';
		
		return $xml;
	}
}

// --------------------------------------------------------------------

