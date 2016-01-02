<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/** 
* Compare values against each other.
* 
* @access public
* @param int $compare_value
* @param string $compare_type
* @param int $against_value
* @return bool
*/
if ( ! function_exists('compare_values'))
{
	function compare_values( $compare_value, $compare_type = '==', $against_value )
	{
		$valid = FALSE;
		
		switch ( $compare_type )
		{
			case 'max' :
			case '>=' :
				$valid = ( $compare_value >= $against_value );
				break;
			case 'min' :
			case '<=' :
				$valid = ( $compare_value <= $against_value );
				break;
			case '>' :
				$valid = ( $compare_value > $against_value );
				break;
			case '<' :
				$valid = ( $compare_value < $against_value );
				break;
			case '===' :
				$valid = ( $compare_value === $against_value );
				break;
			case '==' :
			case '=' :
				$valid = ( $compare_value == $against_value );
				break;
		}
		
		return $valid;
	}
}

// ------------------------------------------------------------------------

