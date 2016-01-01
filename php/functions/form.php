<?php

// --------------------------------------------------------------------

if ( ! function_exists('obfuscate') )
{
	function obfuscate( $string, $randomly_skip = FALSE )
	{
		$obf_string = '';
		foreach ( str_split($string) as $char )
		{
			if ( $randomly_skip !== FALSE && rand(0, (int)$randomly_skip) == (int)$randomly_skip )
			{
				$obf_string .= $char;
				continue;
			}
			$obf_string .= '&#' . ord($char) . ';';
		}
		return $obf_string;
	}
}

// --------------------------------------------------------------------

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
		$attributes = $attributes == '' ? '' : ' '. $attributes;
		return '<a href="' . $email . '"'. $attributes . '>' . $name .'</a>';
	}
}

// --------------------------------------------------------------------

if ( ! function_exists('has_url') )
{
	/**
	* 
	*/
	function has_url( $str )
	{
		$str = html_entity_decode( $str, ENT_QUOTES, 'utf-8' );
		return ( ! preg_match("#(^|\s|\()((http(s?)://)|(www\.))(\w+[^\s\)\<]+)#i", $str)) ? FALSE : TRUE;
	}
}

// --------------------------------------------------------------------

if ( ! function_exists('valid_email') )
{
	/**
	* 
	*/
	function valid_email($str)
	{
		$str = html_entity_decode( $str, ENT_QUOTES, 'utf-8' );
		return ( ! preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $str)) ? FALSE : TRUE;// /^[^\s@]+@[^\s@]+\.[^\s@]+$/
	}
}

// --------------------------------------------------------------------

if ( ! function_exists('valid_phone') )
{
	/**
	* 
	*/
	function valid_phone( $string, $pattern = '/^[0-9\(\)\/\+ \-\.ext]*\d$/' )
	{
		//$pattern = '/^([0-9\(\)\/\+ \-]*)$/';
		//$pattern = '/^[0-9]{3}-[0-9]{4}-[0-9]{4}$/';
		//$pattern = '/^[+#*\(\)\[\]]*([0-9][ ext+-pw#*\(\)\[\]]*){6,45}$/';
		//$pattern = '/^[\d|\+|\(]+[\)|\d|\s|-]*[\d]$/';//end in a digit
		//$pattern = '/^[\d\+\-\.\(\)x ]+$/';
		return ( preg_match($pattern, $string) === 1 );
	}
}

// --------------------------------------------------------------------

if ( ! function_exists('valid_zip') )
{
	/**
	* 
	*/
	function valid_zip( $string, $pattern = '/^[0-9]{5}(?:-[0-9]{4})?$/' )
	{
		return ( preg_match($pattern, $string) === 1 );
	}
}

// --------------------------------------------------------------------

if ( ! function_exists('check_array') )
{
	/**
	* 
	*/
	function check_array ( $array, $field, $clean = true )
	{
		if ( empty($array) )
		{
			return;
		}
		
		// Get first index, may not be a string array index but will still work
		$x = explode('[', $field);
		$indexes[] = $x[0];
		unset($x);
		
		// Check if string array index and get all pieces
		if ( strpos($field, '[') !== false && preg_match_all('/\[(.*?)\]/', $field, $matches) )
		{
			$num_matches = count($matches['0']);
			for ( $i = 0; $i < $num_matches; $i++ )
			{
				if ( $matches['1'][$i] != '' )
				{
					$indexes[] = $matches['1'][$i];
				}
			}
		}
		
		// Loop over indexes
		$num_indexes = count($indexes);
		for ( $i = 0; $i < $num_indexes; $i++ )
		{
			if ( isset($array[ $indexes[$i] ]) )
			{
				$value = $array[ $indexes[$i] ];
				// If on the last one, this is the value
				if ( $i == $num_indexes - 1 )
				{
					if ( $clean )
					{
						$value = clean_value($value);
					}
					return $value;
				}
				// Try next
				continue;
			}
			// Else stop
			break;
		}
	}
}

// --------------------------------------------------------------------

if ( ! function_exists('check_post') )
{
	/**
	* 
	*/
	function check_post( $field, $clean = true )
	{
		return check_array($_POST, $field, $clean);
	}
}

// --------------------------------------------------------------------

if ( ! function_exists('check_get') )
{
	/**
	* 
	*/
	function check_get( $field, $clean = true )
	{
		return check_array($_GET, $field, $clean);
	}
}

// --------------------------------------------------------------------

if ( ! function_exists('check_get_post') )
{
	/**
	* 
	*/
	function check_get_post( $field, $clean = true )
	{
		return check_array(( isset($_GET[$field]) ? $_GET : $_POST ), $field, $clean);
	}
}

// --------------------------------------------------------------------

if ( ! function_exists('clean_value') )
{
	/**
	* 
	*/
	function clean_value( $value, $strict = true, $decode = false )
	{
		if ( is_array($value) )
		{
			$value = array_map('stripslashes', $value);
			
			if ( $strict )
			{
				$value = array_map('strip_tags', $value);
			}
			
			if ( $decode )
			{
				$value = array_map('rawurldecode', $value);
			}
		}
		else
		{
			$value = stripslashes($value);
			
			if ( $strict )
			{
				$value = strip_tags($value);
			}
			
			if ( $decode )
			{
				$value = rawurldecode($value);
			}
		}
		
		return $value;
	}
}

// --------------------------------------------------------------------

if ( ! function_exists('set_checked') )
{
	/**
	* 
	*/
	function set_checked( $checked )
	{
		if ( $checked )
		{
			return ' checked="checked"';
		}
	}
}

// --------------------------------------------------------------------

if ( ! function_exists('set_checkbox') )
{
	/**
	* 
	*/
	function set_checkbox( $field, $value, $checked )
	{
		$checked_text = ' checked="checked"';
		
		if ( $checked )
		{
			return $checked_text;
		}
		
		$field_value = check_array($_REQUEST, $field);
		
		// If values match
		if ( $field_value == $value )
		{
			return $checked_text;
		}
		// If field value is array and value is one of them
		elseif ( is_array($field_value) && in_array($value, $field_value) )
		{
			return $checked_text;
		}
	}
}

// --------------------------------------------------------------------

if ( ! function_exists('get_field_info') )
{
	/**
	* 
	*/
	function get_field_info( $params = array() )
	{
		// Set default values for missing keys
		$default_params = array(
			'field' => null,
			'db_field' => null,
			'required' => false,
			'required_text' => null,
			'id' => null,
			'name' => null,
			'title' => null,
			'placeholder' => null,
			'type' => 'text',
			'value' => null,
			'default_value' => null,
			'data' => null,
			'encode' => true,
			'checked' => false,
		);
		$params = array_merge($default_params, $params);
		
		if ( ! isset($params['db_field']) )
		{
			$params['db_field'] = $params['field'];
		}
		if ( ! isset($params['title']) )
		{
			$params['title'] = ucwords( str_replace(array('-', '_'), ' ', $params['field']) );
		}
		if ( ! isset($params['placeholder']) )
		{
			$params['placeholder'] = $params['title'];
		}
		if ( ! isset($params['id']) )
		{
			$params['id'] = $params['field'];
		}
		if ( ! isset($params['name']) )
		{
			$params['name'] = $params['field'];
		}
		if ( ! isset($params['default_value']) )
		{
			$params['default_value'] = ( is_array($params['data']) && isset($params['data'][$params['db_field']]) ) ? $params['data'][$params['db_field']] : '';
		}
		if ( ! isset($params['value']) )
		{
			$params['value'] = $params['default_value'];
		}
		
		$params['required_text'] = $params['required'] ? '<em>*</em>' : '';
		$params['title'] = $params['title'] . $params['required_text'];
		
		if ( $params['type'] == 'radio' )
		{
			$params['checked'] = set_radio($params['field'], $params['value'], ($params['value'] == $params['default_value']));
		}
		elseif ( $params['type'] == 'checkbox' )
		{
			$params['checked'] = set_checkbox($params['field'], $params['value'], ($params['value'] == $params['default_value']));
		}
		else
		{
			$value = $params['encode'] ? htmlentities($params['value'], ENT_COMPAT, 'UTF-8') : $params['value'];
			$params['value'] = set_value($params['field'], $value);
		}
		
		return $params;
	}
}

// --------------------------------------------------------------------
