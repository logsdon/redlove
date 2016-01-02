<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/** 
* http://codeigniter.com/forums/viewthread/71312/
* 
* @access public
* @method string form_csrf($varlen, $str_to_shuffer) returns a constructed hidden input field of the csrf token
* @param int $varlen the length of the input field name that will be generated
* @param string $str_to_shuffer the string that will be used to generate the input field name
* @return string the hidden input field
*/
if (! function_exists('form_csrf'))
{
	function form_csrf()
	{
		$CI =& get_instance();
		if ( property_exists($CI, 'csrf') !== TRUE )
		{
			$CI->load->library('utility/csrf');
		}
		/* alternate csrf implementation
		// $varlen = 3, $str_to_shuffer = 'abcdefghijklmnopqrstuvwxyz0123456789_' 
		csrf_token($varlen, $str_to_shuffer);
		return form_hidden(csrf_varname(), csrf_value());
		*/
		
		$CI->csrf->set_token();
		
		return form_hidden($CI->csrf->get_form_field_name(), $CI->csrf->get_form_field_value());
	}
}

// ------------------------------------------------------------------------

/** 
* Display the hidden form start time input field.
* 
* @access public
* @return string
*/
if (! function_exists('form_submit_interval'))
{
	function form_submit_interval()
	{
		return form_hidden('form_submit_interval', time());
	}
}

// ------------------------------------------------------------------------

/** 
* Display the hidden form csrf nonce token and form start time input fields.
* 
* @access public
* @return string
*/
if (! function_exists('form_security_measure_fields'))
{
	function form_security_measure_fields()
	{
		return form_csrf() . form_submit_interval();
	}
}

// --------------------------------------------------------------------

/** 
* Help populate form field data.
* 
* @access public
* @param array $params
* @return string
*/
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

if ( ! function_exists('check_global') )
{
	/**
	* 
	*/
	function check_global( $global, $field )
	{
		global $$global;
		if ( ! isset($$global) || count($$global) == 0 )
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
		$post_arg =& $$global;
		$num_indexes = count($indexes);
		for ( $i = 0; $i < $num_indexes; $i++ )
		{
			if ( isset($post_arg[ $indexes[$i] ]) )
			{
				$post_arg =& $post_arg[ $indexes[$i] ];
				// If on the last one, this is the value
				if ( $i == $num_indexes - 1 )
				{
					if ( is_array($post_arg) )
					{
						$post_arg = array_map('stripslashes', $post_arg);
						$post_arg = array_map('strip_tags', $post_arg);
						return $post_arg;
					}
					else
					{
						return strip_tags(stripslashes($post_arg));
					}
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
	function check_post( $field )
	{
		return check_global('_POST', $field);
	}
}

// --------------------------------------------------------------------

if ( ! function_exists('check_get') )
{
	/**
	* 
	*/
	function check_get( $field )
	{
		return check_global('_GET', $field);
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

/** 
* Help create and check honeypot fields.
* 
* @access public
* @param array $params
* @return string
*/
if ( ! function_exists('create_honeypot') )
{
	/**
	* 
	*/
	function create_honeypot( $params = array() )
	{
		// Set default values for missing keys
		$default_params = array(
			'fields' => 'subject,name,email,body,message,first_name,last_name,question,comment,address,address1,address_line1,city,state,zip,zipcode,postal,postal_code,post_code,country,province,region,territory',
			'value' => '',
			
			'hide_script' => true,
			'hide_style' => false,
			'clear_value' => false,
			'clear_value_on_submit' => false,
			
			'random_chances' => 0,
			
			'check_values' => null,
		);
		$params = array_merge($default_params, $params);
		
		extract($params);
		
		// Randomly clean up; don't if not 1 in 100
		if ( $random_chances > 0 && rand(0, $random_chances) != $random_chances )
		{
			return;
		}
		
		// Turn string comma-delimited list to array
		$fields = is_string($fields) ? explode(',', $fields) : (array)$fields;
		// Clean array
		$fields = array_map('trim', $fields);
		$fields = array_filter($fields);
		
		// If only checking fields, run through
		if ( is_array($check_values) )
		{
			// For each field in the list
			foreach ( $fields as $field )
			{
				// If it exists and has text entered, stop
				//if ( isset($check_values[$field]) && strlen($check_values[$field]) > 0 )
				// If it exists and does not have the right value, stop
				if ( isset($check_values[$field]) && $check_values[$field] != $value )
				{
					return true;
				}
			}
			
			return false;
		}
		
		// Pick a random key in your array
		$rand_key = array_rand($fields, 1);
		// Extract the corresponding value
		$rand_value = $fields[$rand_key];
		// Remove the key-value pair from the array
		unset($fields[$rand_key]);
		
		// Create random element id for reference
		$rand_id = 'hp-' . mt_rand();
		if ( $clear_value )
		{
			$value = ( strlen($value) > 0 ) ? $value : mt_rand();
		}
		
		$type = 'text';
		if ( strpos($rand_value, 'email') !== false )
		{
			$type = 'email';
		}
		
		$field = '<div id="' . $rand_id . '"><label>Please leave this field blank</label><input type="' . $type . '" name="' . $rand_value . '" value="' . $value . '" placeholder="'. ucfirst($rand_value) . '" autocomplete="off" /></div>';//' . mt_rand() . '
		
		if ( $hide_style )
		{
			$hide_style = '<style type="text/css">#' . $rand_id . '{display: none;}</style>';
			$field .= $hide_style;
		}
		
		if ( $clear_value )
		{
			$clear_value = '<script type="text/javascript">document.getElementById("' . $rand_id . '").getElementsByTagName("input")[0].value = "";</script>';
			$field .= $clear_value;
		}
		
		if ( $clear_value_on_submit )
		{
			$clear_value_on_submit = '<script type="text/javascript">$(document).ready(function($){$("#' . $rand_id . '").closest("form").on("submit", function(event){$("#' . $rand_id . '").find("input").val("");});});</script>';
			$field .= $clear_value_on_submit;
		}
		
		if ( $hide_script )
		{
			$hide_script = '<script type="text/javascript">document.getElementById("' . $rand_id . '").style.display = "none";</script>';
			$field .= $hide_script;
		}

		return $field;
	}
}

// --------------------------------------------------------------------

if ( ! function_exists('map_fields') )
{
	/**
	* 
	* USAGE:
	
	
	In view:
	
	<?php
	if ( $submitted )
	{
		$mapped_field_data = map_fields($this->input->post('fm'), true);
	}
	else
	{
		$mapped_field_data = map_fields('name, gobbledy-gook, photo, title, description, promo_code');
	}
	?>
	
	<input type="hidden" name="fm" value="<?php echo $mapped_field_data['encoded_map']; ?>" autocomplete="" />
	
	<?php
	$field = get_field_info(array(
		'field' => $mapped_field_data['mapped_fields']['name'],
		'title' => 'Full Name',
		'required' => true,
	));
	?>
	<div class="form-row stack full">
		<label for="<?php echo $field['id']; ?>" class="hide"><?php echo $field['title']; ?></label>
		<input type="text" id="<?php echo $field['id']; ?>" name="<?php echo $field['name']; ?>" value="<?php echo $field['value']; ?>" placeholder="<?php echo $field['placeholder']; ?>" class="toggle-val" />
	</div>
	
	
	In controller after submit:
	
	$mapped_field_data = map_fields($this->input->post('fm'), true);
	$mapped_fields = $mapped_field_data['mapped_fields'];
	
	$name = $this->input->post($mapped_fields['name'], true);
	
	$this->form_validation->set_rules($mapped_fields['name'], 'Full Name', 'trim|required');
	
	*/
	function map_fields( $fields_or_map, $decode_map = false )
	{
		// If decoding map data
		if ( $decode_map )
		{
			/*
			$CI =& get_instance();
			$CI->load->library('utility/encryption');
			return unserialize($CI->encryption->decode($fields_or_map));
			*/
			return array(
				'mapped_fields' => unserialize(base64_decode($fields_or_map)),
				'encoded_map' => $fields_or_map,
			);
		}
		
		// If creating encoded map data
		$mapped_fields = array();
		
		if ( ! is_array($fields_or_map) )
		{
			$fields_or_map = explode(',', $fields_or_map);
			$fields_or_map = array_map('trim', $fields_or_map);
			$fields_or_map = array_filter($fields_or_map);
		}
		
		foreach ( $fields_or_map as $field )
		{
			$mapped_fields[$field] = (string)mt_rand();
		}
		
		// Encode map
		$data = '';
		if ( ! empty($mapped_fields) )
		{
			/*
			$CI =& get_instance();
			$CI->load->library('utility/encryption');
			$data = $CI->encryption->encode(serialize($mapped_fields));
			*/
			$data = base64_encode(serialize($mapped_fields));
		}
		
		return array(
			'mapped_fields' => $mapped_fields,
			'encoded_map' => $data,
		);
	}
}

// --------------------------------------------------------------------

