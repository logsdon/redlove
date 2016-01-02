<?php if (!defined('BASEPATH')) exit('No direct script access allowed.');
/**
* This class enhances form validation.
* @author	xciden - http://codeigniter.com/forums/viewthread/71312/
* @author	Joshua Logsdon
* @email	joshua@joshualogsdon.com
* @filename	MY_Controller.php
* @title	Controller library
* @url		http://www.joshualogsdon.com
* @version	3.0
*/
class MY_Form_validation extends CI_Form_validation
{
    //------------------
	//  Public methods
    //------------------
	
	function setup_valid_form_security_measure_fields()
	{
		if ( property_exists($this->CI, 'csrf') !== TRUE )
		{
			$this->CI->load->library('utility/csrf');
		}
		
		$this->CI->form_validation->set_rules(
			$this->CI->csrf->get_submitted_form_field_name(),
			'Form Token', 'trim|required|valid_csrf'
		);
		$this->CI->form_validation->set_rules(
			'form_submit_interval',
			'Form Submit Interval', 'trim|required|integer|valid_form_submit_interval'
		);
	}
	
	// --------------------------------------------------------------------
	
	/**
	* Make sure a form has returned a valid session nonce.
	*
	* @access public
	* @param string $value
	* @return bool
	*/
	function valid_csrf( $value = '' )
	{
		// Here we test for the nonce and set an error if need be
		if ( property_exists($this->CI, 'csrf') !== TRUE )
		{
			$this->CI->load->library('utility/csrf');
		}
		
		$valid = $this->CI->csrf->valid($value);
		
		if ( $valid == FALSE )
		{
			$this->set_message('valid_csrf', 'This form is no longer valid. Please refresh the page.');
			//$this->_error_array[] = 'This form is no longer valid. Please refresh it.';
		}
		
		return $valid;
	}
	
	// --------------------------------------------------------------------
	
	/**
	* Make sure the date is valid.
	*
	* @access public
	* @param string $value
	* @return bool
	*/
	function valid_date( $value = '', $format = 'Y-m-d H:i:s' )
	{
		$date = date_parse($value);
		$valid = ( $date['error_count'] == 0 && checkdate($date['month'], $date['day'], $date['year']) );
		
		/*
		// Create a date depending on PHP version
		$version = explode('.', phpversion());
		if (((int) $version[0] >= 5 && (int) $version[1] >= 2 && (int) $version[2] > 17))
		{
			$d = DateTime::createFromFormat($format, $date);
		}
		else
		{
			$d = new DateTime(date($format, strtotime($date)));
		}
		*/
		/*
		// Check valid date
		$format = 'Y-m-d H:i:s';
		$d = new DateTime(date($format, strtotime($date)));
		$valid_date = ( $d && $d->format($format) == $date );
		// or
		$date = date_parse($date);
		$valid_date = ( $date['error_count'] == 0 && checkdate($date['month'], $date['day'], $date['year']) );
		if ( ! $valid_date )
		{
			$valid = false;
			$return_message[] = 'The approved date is invalid.';
		}
		*/
		
		if ( ! $valid )
		{
			$this->set_message('valid_date', 'The %s field has in invalid date.');
			return false;
		}
		
		return true;
	}
	
	// --------------------------------------------------------------------
	
	/**
	* Make sure form has not been submitted too soon by a non-human.
	*
	* @access public
	* @param string $value
	* @return bool
	*/
	function valid_form_submit_interval( $value = '' )
	{
		$interval = 1;// seconds
		$submit_diff = time() - (int)$value;
		
		// If less than interval between form load and submit
		if ( $submit_diff <= $interval )
		{
			$this->set_message(
				'valid_form_submit_interval',
				'This form has been submitted to quickly. Please wait ' . $interval . ' second' . ($interval !== 1 ? 's' : '') . ' and try again.'
			);
			//$this->_error_array[] = 'This form start time is no longer valid. Please refresh it.';
			return FALSE;
		}
		return TRUE;
	}
	
	// --------------------------------------------------------------------
	
	/**
	* Make sure an e-mail decoy input field is empty.
	*
	* @access public
	* @param string $value
	* @return bool
	*/
	function valid_email_decoy( $value = '' )
	{
		$valid = TRUE;
		
		// If fake or bogus fields were filled
		if ( strlen(trim($value)) > 0 )
		{
			$this->_error_array[] = 'Possible spam detected with hidden field filled.';
			$valid = FALSE;
		}
		
		// If fields contains http:// or https://
		if ( strpos($value, 'http://') !== FALSE )
		{
			$this->set_message('valid_email_decoy', 'Possible spam detected with uri in e-mail.');
			//$this->_error_array[] = 'Possible spam detected with uri in e-mail.';
			$valid = FALSE;
		}
		
		return $valid;
	}
	
	// --------------------------------------------------------------------
	
	/**
	* 
	*/
	function valid_phone( $string, $pattern = '/^[0-9\(\)\/\+ \-\.ext]*\d$/' )
	{
		//$pattern = '/^([0-9\(\)\/\+ \-]*)$/';
		//$pattern = '/^[0-9]{3}-[0-9]{4}-[0-9]{4}$/';
		//$pattern = '/^[+#*\(\)\[\]]*([0-9][ ext+-pw#*\(\)\[\]]*){6,45}$/';
		//$pattern = '/^[\d|\+|\(]+[\)|\d|\s|-]*[\d]$/';//end in a digit
		return ( preg_match($pattern, $string) === 1 );
	}
	
	// --------------------------------------------------------------------
	
	/**
	* 
	*/
	function valid_zip( $string, $pattern = '/^[0-9]{5}(?:-[0-9]{4})?$/' )
	{
		return ( preg_match($pattern, $string) === 1 );
	}
	
	// --------------------------------------------------------------------
	
}

