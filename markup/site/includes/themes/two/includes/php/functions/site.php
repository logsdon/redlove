<?php

// --------------------------------------------------------------------

if ( ! function_exists('process') )
{
	/**
	* Process data
	*/
	function process ()
	{
		// Get arguments
		$args = func_get_args();
		$args0 = isset($args[0]) ? $args[0] : '';
		$args1 = isset($args[1]) ? $args[1] : '';
		
		// ------------------------------------------------------------
		// Check if referrering domain is allowed
		
		$domain = '';
		// Set allowed domains
		$allowed_domains = array();
		// Allow self
		$allowed_domains[] = parse_url(site_url(), PHP_URL_HOST);
		
		// Check referrer domain against allowed domains
		$referrer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
		$referrer_parsed = parse_url($referrer);
		$referrer_domain = isset($referrer_parsed['host']) ? $referrer_parsed['host'] : '';
		if ( strlen($referrer) > 0 )
		{
			foreach ( $allowed_domains as $allowed_domain )
			{
				if ( stripos($referrer_domain, $allowed_domain) !== false )
				{
					$domain = $allowed_domain;
					break;
				}
			}
		}
		
		// Stop if referrer not allowed
		$is_ajax = is_ajax();
		if ( strlen($domain) == 0 )
		{
			// Stop execution if AJAX request
			if ( $is_ajax )
			{
				exit;
			}
			
			// Return if this process is part of a normal page load
			return;
		}
		
		// If there is a querystring, get as variables; later add in variables and update referrer
		if ( ! isset($referrer_parsed['query']) )
		{
			$referrer_parsed['query'] = '';
		}
		parse_str($referrer_parsed['query'], $querystring_vars);
		/*
		// Example: Update querystring and reset referrer after processing
		$querystring_vars['code'] = $return_data['code'];
		$querystring_vars['action'] = 'thank-you';
		$querystring_vars['form_id'] = 0;
		$referrer_parsed['query'] = http_build_query($querystring_vars, '', '&');
		$referrer = http_build_url($referrer_parsed);
		*/
		// ------------------------------------------------------------
		
		// ------------------------------------------------------------
		// Set process action
		$action = isset($_REQUEST['action']) ? trim(rawurldecode(strip_tags(stripslashes( check_array($_REQUEST, 'action') )))) : $args0;

		// Stop if no data submitted or action to take
		if ( strlen($action) == 0 )//empty($_POST)
		{
			if ( $is_ajax )
			{
				exit;
			}
			
			return;
		}
		
		$params = isset($_REQUEST['params']) ? json_decode(urldecode(check_array($_REQUEST, 'params'))) : array();
		// ------------------------------------------------------------
		
		// ------------------------------------------------------------
		// Initialize return data
		$return_data = array(
			'code' => 0,
			'value' => '',
			'message' => array(),
		);
		// ------------------------------------------------------------
		
		// ------------------------------------------------------------
		// Validate data
		$valid = true;
		$success = false;
		// ------------------------------------------------------------
		
		// ------------------------------------------------------------
		// Process actions
		
		// Contact
		if ( $action == 'contact' )
		{
			// Stop if no data submitted
			if ( empty($_POST) )
			{
				exit;
			}
			
			// ------------------------------------------------------------
			// CSRF check
			require_once(REDLOVE_PATH . 'php/classes/Csrf.php');
			$CSRF = new Csrf();
			$CSRF->verify();
			// ------------------------------------------------------------
			
			// ------------------------------------------------------------
			// Gather data
			// ------------------------------------------------------------
			
			// ------------------------------------------------------------
			// Validate data
			
			require_once(REDLOVE_PATH . 'php/classes/Email.php');
			$EMAIL = new Email(INCLUDES_PATH . 'config/email.php');
			$email_vars = $_POST;
			$process_form_fields_data = $EMAIL->process_form_fields($email_vars);
			$email_vars = $process_form_fields_data['value'];
			if ( $process_form_fields_data['code'] <= 0 )
			{
				$valid = false;
				$return_data['message'] = array_merge($return_data['message'], $process_form_fields_data['message']);
			}
			// ------------------------------------------------------------
			
			// ------------------------------------------------------------
			// Process data
			if ( $valid )
			{
				// ----------------------------------------
				// Send email
				
				// Gather email fields
				$email_fields = array(
					'name' => trim($_POST['name']),
					'phone' => trim($_POST['phone']),
					'email' => trim($_POST['email']),
					'subject' => trim($_POST['subject']),
					'message' => trim(preg_replace('/[\r\n]+/', "\n", $_POST['message'])),
				);
				// Clean email fields
				$email_fields = $EMAIL->clean_fields($email_fields);

				// Build message from html using local variables and buffered output
				// Start buffering
				ob_start();
				include(THEME_PATH . 'includes/email/contact.html');
				// Get buffer
				$email_body = ob_get_contents();
				// Stop buffering
				ob_end_clean();
				
				// Gather email params
				$host = ( ENVIRONMENT != 'development' ) ? parse_url(site_url(), PHP_URL_HOST) : 'example.com';
				$email_params = array(
					'from_email' => 'do-not-reply@' . $host,
					'from_name' => 'Do Not Reply',
					'to_email' => ( ENVIRONMENT != 'development' ) ? $email_fields['email'] : $email_fields['email'],
					'to_name' => $email_fields['name'],
					'subject' => 'Top Home Inspections: Contact Us - ' . $email_fields['subject'],
					'body' => $email_body,
				);
				/*
				if ( ENVIRONMENT != 'development' )
				{
					$email_params['cc_addresses'] = array(
						'example@mail.com' => 'Example Name',
					);
				}
				*/
				
				// Send the email
				$email_data = $EMAIL->send($email_params);
				$success = ( $email_data['code'] > 0 );
				// ----------------------------------------
				
				// If NOT successful
				if (  ! $success )
				{
					$return_data['code'] = 0;
					$return_data['message'][] = 'Your message could not be sent. Please try again.';
				}
				else
				{
					$return_data['code'] = 1;
					$return_data['message'][] = 'Your message has been sent.';
				}
			}
			// ------------------------------------------------------------
		}
		
		// Disclosure
		elseif ( $action == 'disclosure' )
		{
			// Stop if no data submitted
			if ( empty($_POST) )
			{
				exit;
			}
			
			// ------------------------------------------------------------
			// CSRF check
			require_once(REDLOVE_PATH . 'php/classes/Csrf.php');
			$CSRF = new Csrf();
			$CSRF->verify();
			// ------------------------------------------------------------
			
			// ------------------------------------------------------------
			// Gather data
			// ------------------------------------------------------------
			
			// ------------------------------------------------------------
			// Validate data
			
			require_once(REDLOVE_PATH . 'php/classes/Email.php');
			$EMAIL = new Email(INCLUDES_PATH . 'config/email.php');
			$email_vars = $_POST;
			$process_form_fields_data = $EMAIL->process_form_fields($email_vars);
			$email_vars = $process_form_fields_data['value'];
			if ( $process_form_fields_data['code'] <= 0 )
			{
				$valid = false;
				$return_data['message'] = array_merge($return_data['message'], $process_form_fields_data['message']);
			}
			// ------------------------------------------------------------
			
			// ------------------------------------------------------------
			// Process data
			if ( $valid )
			{
				// ----------------------------------------
				// Send email
				
				// Gather email fields
				$email_fields = array(
					'property_address' => trim(preg_replace('/[\r\n]+/', "\n", $_POST['property_address'])),
					'inspection_fee' => trim($_POST['inspection_fee']),
					'inspection_deposit' => trim($_POST['inspection_deposit']),
					'client1_name' => trim($_POST['client1_name']),
					'client1_email' => trim($_POST['client1_email']),
					'client1_date' => trim($_POST['client1_date']),
					'client2_name' => trim($_POST['client2_name']),
					'client2_email' => trim($_POST['client2_email']),
					'client2_date' => trim($_POST['client2_date']),
				);
				// Clean email fields
				$email_fields = $EMAIL->clean_fields($email_fields);
				
				// Build message from html using local variables and buffered output
				// Start buffering
				ob_start();
				include(THEME_PATH . 'includes/email/disclosure-agreement.html');
				// Get buffer
				$email_body = ob_get_contents();
				// Stop buffering
				ob_end_clean();
				
				// Gather email params
				$host = ( ENVIRONMENT != 'development' ) ? parse_url(site_url(), PHP_URL_HOST) : 'example.com';
				$email_params = array(
					'from_email' => 'do-not-reply@' . $host,
					'from_name' => 'Do Not Reply',
					'to_email' => ( ENVIRONMENT != 'development' ) ? $email_fields['client1_email'] : $email_fields['client1_email'],
					'to_name' => $email_fields['client1_name'],
					'subject' => 'Top Home Inspections: Disclosure Agreement',
					'body' => $email_body,
				);
				/*
				if ( ENVIRONMENT != 'development' )
				{
					$email_params['cc_addresses'] = array(
						'example@mail.com' => 'Example Name',
					);
				}
				*/
				
				// Send the email
				$email_data = $EMAIL->send($email_params);
				$success = ( $email_data['code'] > 0 );
				// ----------------------------------------
				
				// If NOT successful
				if (  ! $success )
				{
					$return_data['code'] = 0;
					$return_data['message'][] = 'Your disclosure agreement could not be sent. Please try again.';
					$return_data['message'] = array_merge($return_data['message'], $email_data['message']);
				}
				else
				{
					$return_data['code'] = 1;
					$return_data['message'][] = 'Your disclosure agreement has been sent.';
				}
			}
			// ------------------------------------------------------------
		}
		// ------------------------------------------------------------
		
		// ------------------------------------------------------------
		// Return JSON data
		if ( $is_ajax )
		{
			// ------------------------------------------------------------
			// Iframe form handling
			
			// Event from "AJAX/form target to iframe/callback to top window" file upload
			$event = check_array($_REQUEST, 'event');//$this->input->get_post('event', true);
			if ( strlen($event) > 0 )
			{
				echo '<script type="text/javascript">window.top.window.jQuery(window.top.document).trigger("' . 
					rawurldecode($event) . 
					'", [' . json_encode($return_data) . ']);</script>';
				exit;
			}
			
			// Callback from "AJAX/form target to iframe/callback to top window" file upload
			$callback = check_array($_REQUEST, 'callbacks');//$this->input->get_post('callback', true);
			if ( strlen($callback) > 0 )
			{
				echo '<script type="text/javascript">window.top.window.' . 
					rawurldecode($callback) . 
					'(' . json_encode($return_data) . ');</script>';
				exit;
			}
			// ------------------------------------------------------------
			
			// Explicitly return data type
			echo json_encode($return_data);
			exit;
		}
		
		// Return data
		return $return_data;
	}
}

// --------------------------------------------------------------------

