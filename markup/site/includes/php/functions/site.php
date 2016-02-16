<?php

// --------------------------------------------------------------------

if ( ! function_exists('check_access__USE_FOR_REFERENCE') )
{
	/**
	* Check user access to site
	*/
	function check_access__USE_FOR_REFERENCE ()
	{
		global $config;
		
		// Check access key
		$valid = false;
		$key = 'key';
		$secret_key = $config['site'][$key];
		
		// Make sure key exists
		$valid = isset($secret_key);
		
		// Check for matching submitted key; example.com?key=abc
		if ( $valid )
		{
			$submitted_key = ( ! empty($_GET) && isset($_GET[$key]) ) ? $_GET[$key] : null;
			if ( isset($submitted_key) )
			{
				$valid = ( $submitted_key === $secret_key );
			}
			// Check for matching cookie key
			else
			{
				$valid = ( get_cookie($key) === $secret_key );
			}
		}
		
		// Deny access
		if ( ! $valid )
		{
			delete_cookie($key);
			
			// Send header
			$server_protocol = isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.1';
			$code = 403;
			$text = 'Forbidden';
			$header = $server_protocol . ' ' . $code . ' ' . $text;
			header($header, true, $code);
			echo '<h1>' . $header . '</h1>';
			exit;
		}
		// Create/refresh valid cookie
		else
		{
			set_cookie($key, $secret_key, 60 * 60 * 24 * 30);
		}
		
		return $valid;
	}
}

// --------------------------------------------------------------------

if ( ! function_exists('process__USE_FOR_REFERENCE') )
{
	/**
	* Process data
	*/
	function process__USE_FOR_REFERENCE ()
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
		/*
		// Set environment-specific allowed domains
		if ( ENVIRONMENT == 'production' )
		{
			$allowed_domains[] = 'example.com';
		}
		*/
		
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
			
			/*
			// Redirect
			redirect($referrer)
			
			// or
			
			header('Location: http://' . $referrer_domain);
			
			// or
			
			// Return if this process is part of a normal page load
			return;
			*/
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
		
		/*
		// CSRF check
		require_once(REDLOVE_PATH . 'php/classes/Csrf.php');//$this->load->library('utility/csrf');
		$CSRF = new Csrf();
		$CSRF->verify();
		*/
		
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
		
		/*
		// ------------------------------------------------------------
		// Get user agent info
		$ip_address = $this->input->ip_address();
		$user_agent_type = '';
		$user_agent_device = '';
		$this->load->library('user_agent');
		if ( $this->agent->is_mobile() )
		{
			$user_agent_type = 'mobile';
			$user_agent_device = $this->agent->mobile();
		}
		elseif ( $this->agent->is_browser() )
		{
			$user_agent_type = 'browser';
			$user_agent_device = $this->agent->browser() . ' ' . $this->agent->version() . ' on ' . $this->agent->platform();
		}
		// ------------------------------------------------------------
		*/
		
		// ------------------------------------------------------------
		// Process actions
		
		// Do something
		if ( $action == 'do-something' )
		{
			// Stop if no data submitted
			if ( empty($_POST) )
			{
				exit;
			}
			
			/*
			// ------------------------------------------------------------
			// CSRF check
			require_once(REDLOVE_PATH . 'php/classes/Csrf.php');//$this->load->library('utility/csrf');
			$CSRF = new Csrf();
			$CSRF->verify();
			// ------------------------------------------------------------
			*/
			
			// ------------------------------------------------------------
			// Gather data
			$created_time = time();
			$something = (string)check_post('something');
			// ------------------------------------------------------------
			
			// ------------------------------------------------------------
			// Validate data
			
			// Example: Check required field
			if ( strlen($something) == 0 )
			{
				$valid = false;
				$return_data['message'][] = 'Please enter something.';
			}
			// ------------------------------------------------------------
			
			// ------------------------------------------------------------
			// Process data
			if ( $valid )
			{
				$success = do_something();
				
				// If NOT successful
				if ( ! $success )
				{
					$return_data['code'] = 0;
					$return_data['message'][] = 'Error, please try again!';
				}
				else
				{
					$return_data['code'] = 1;
					$return_data['message'][] = 'Success!';
				}
			}
			// ------------------------------------------------------------
		}
		
		// Get CSRF
		elseif ( $action == 'get_csrf' )
		{
			require_once(REDLOVE_PATH . 'php/classes/Csrf.php');
			$CSRF = new Csrf();
			
			$return_data['code'] = 1;
			$return_data['value'] = array(
				$CSRF->get_token_name() => $CSRF->get_hash(),
			);
		}
		
		// Set silent visitor data from AJAX requests
		elseif ( $action == 'set_data' )
		{
			// Stop if no data submitted
			if ( empty($_POST) )
			{
				exit;
			}
			
			// CSRF check
			//$this->load->library('utility/csrf');
			
			// Set data
			
			// User timezone offset
			if ( isset($_POST['client_timezone_offset']) )
			{
				// User passed timezone offset or default to server's timezone offset
				$client_timezone_offset = ! empty($_POST['client_timezone_offset']) ? $this->input->post('client_timezone_offset', true) : date('Z');
				/*
				session_start();
				$_SESSION['client_timezone_offset'] = $this->input->post('client_timezone_offset', true);
				
				// or
				
				$this->session->set_userdata('user__client_timezone_offset', $client_timezone_offset);
				*/
			}
			
			exit;
		}
		
		// Ask
		elseif ( $action == 'ask' )
		{
			// Stop if no data submitted
			if ( empty($_POST) )
			{
				if ( $is_ajax )
				{
					exit;
				}
				else
				{
					header('Location: ' . $referrer);//redirect($referrer);
					exit;
				}
			}
			
			// Check for submitted data
			$return_data = call_user_func_array(array(&$this, '_ask_submit'), $args);
			
			// Give end response if request type detected, e.g. AJAX
			$this->load->library('utility/request');
			$this->request->response($return_data, 'json');
			
			// Set notifications
			$this->load->library('utility/notify');
			$this->notify->add($return_data);
			redirect($referrer);
		}
		
		// Contact
		elseif ( $action == 'contact' )
		{
			// Stop if no data submitted
			if ( empty($_POST) )
			{
				exit;
			}
			
			/*
			// ------------------------------------------------------------
			// CSRF check
			require_once(REDLOVE_PATH . 'php/classes/Csrf.php');//$this->load->library('utility/csrf');
			$CSRF = new Csrf();
			$CSRF->verify();
			// ------------------------------------------------------------
			*/
			
			// ------------------------------------------------------------
			// Gather data
			// ------------------------------------------------------------
			
			// ------------------------------------------------------------
			// Validate data
			
			/*
			// Example: Form fields for processing
			<input type="hidden" name="action" value="contact" />
			<input type="hidden" name="origin" value="Contact Form" />
			<input type="hidden" name="form_fields_required" value="first_name,last_name" />
			<input type="hidden" name="form_fields_url_whitelist" value="message" />
			<input type="hidden" name="form_fields_email" value="email" />
			<input type="hidden" name="form_fields_honeypot" value="email" />
			*/
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
					'name' => trim($_POST['first_name']) . ' ' . trim($_POST['last_name']),
					'first_name' => trim($_POST['first_name']),
					'last_name' => trim($_POST['last_name']),
					'phone' => trim($_POST['phone']),
					'email' => trim($_POST['email']),
					'subject' => trim($_POST['subject']),
					'message' => trim(preg_replace('/[\r\n]+/', "\n", $_POST['message'])),
				);
				// Clean email fields
				$email_fields = $EMAIL->clean_fields($email_fields);

				// Build message
				/*
				// Build message from fields
					$email_newline = '<br />';
					$email_body = $EMAIL->build_body($email_fields, $email_newline);
				
				// or
				
				// Build message from variables
					$email_body = nl2br(trim("Submitted form data...{$email_newline}{$email_newline}{$email_body}{$email_newline}{$email_newline}[ END OF MESSAGE ]"));
				
				// or
				
				// Build message from html using passed variables
					$email_body = $this->load->view('learning-center/staff/email__invite.html', $email_fields, true);
				
				// or
				
				// Build message from html using local variables
					$email_body = file_get_contents(APPPATH . 'views/email/spiritual-gifts-results.html');
				
				// or
				
				// Build message from html using local variables and buffered output
					// Start buffering
					ob_start();
					include(THEME_PATH . 'includes/email/contact.html');
					// Get buffer
					$email_body = ob_get_contents();
					// Stop buffering
					ob_end_clean();
				*/
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
					'from_email' => 'admin@' . $host,//'do-not-reply@example.com'
					'from_name' => 'Do Not Reply',
					'to_email' => ( ENVIRONMENT != 'development' ) ? $email_fields['email'] : 'example@example.com',
					'to_name' => 'Example Name',//trim($name)
					'subject' => 'Example Subject',
					'body' => $email_body,
				);
				if ( ENVIRONMENT != 'development' )
				{
					$email_params['bcc_addresses'] = array(
						'example@example.com' => 'Example Name',
					);
				}
				
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
		
		// Enter
		elseif ( $action == 'enter' )
		{
			// Stop if no data submitted
			if ( empty($_POST) )
			{
				exit;
			}
			
			/*
			// ------------------------------------------------------------
			// CSRF check
			require_once(REDLOVE_PATH . 'php/classes/Csrf.php');//$this->load->library('utility/csrf');
			$CSRF = new Csrf();
			$CSRF->verify();
			// ------------------------------------------------------------
			*/
			
			// ------------------------------------------------------------
			// Gather data
			$created_time = time();
			
			$name = (string)check_post('name');
			// Get separate names
			// Explode limit 3 to get first, middle, and last
			$names = explode(' ', preg_replace('/\s+/', ' ', trim($name)), 2);//Remove multiple whitespaces
			$num_names = count($names);
			$first_name = $names[0];
			$last_name = ( $num_names > 1 ) ? $names[$num_names - 1] : '';
			
			$params = array(
				'name' => $name,
				'first_name' => $first_name,
				'last_name' => $last_name,
				'email' => (string)check_post('gobbledy-gook'),
				'email_honeypot' => (string)check_post('email'),
			);
			// ------------------------------------------------------------
			
			// ------------------------------------------------------------
			// Validate data
			
			if ( strlen($params['name']) == 0 )
			{
				$valid = false;
				$return_data['message'][] = 'Please enter your name.';
			}

			if ( strlen($params['email']) == 0 )
			{
				$valid = false;
				$return_data['message'][] = 'Please enter an email address.';
			}

			if ( strlen($params['email']) > 0 && ! valid_email($params['email']) )
			{
				$valid = false;
				$return_data['message'][] = 'Please enter a valid email address.';
			}

			if ( strlen($params['email_honeypot']) > 0 )
			{
				$valid = false;
				$return_data['message'][] = 'Please leave fields blank where asked.';
			}
			// ------------------------------------------------------------
			
			// ------------------------------------------------------------
			// Process data
			if ( $valid )
			{
				// Insert data
				include_once(INCLUDES_PATH . 'php/classes/Database_mysqli.php');
				$sql = "
					INSERT INTO
						entry
					(
						name,
						first_name,
						last_name,
						email,
						created_datetime
					)
					VALUES
					(
						" . $DB->escape($params['name']) . ",
						" . $DB->escape($params['first_name']) . ",
						" . $DB->escape($params['last_name']) . ",
						" . $DB->escape($params['email']) . ",
						NOW()
					)
				";
				$success = $DB->query($sql);
				
				// If NOT successful
				if ( $success )
				{
					$return_data['code'] = 0;
					$return_data['message'][] = 'Please try again.';
				}
				else
				{
					$return_data['code'] = 1;
					$return_data['message'][] = 'Thank you!';
				}
			}
			// ------------------------------------------------------------
		}
		// ------------------------------------------------------------
		
		// ------------------------------------------------------------
		// Return JSON data
		if ( $is_ajax )
		{
			/*
			// Format data as necessary
			$return_data['message'] = implode(' ', $return_data['message']);
			*/
			
			// ------------------------------------------------------------
			// Iframe form handling
			
			// Event from "AJAX/form target to iframe/callback to top window" file upload
			$event = check_array($_REQUEST, 'event');//$this->input->get_post('event', true);
			if ( strlen($event) > 0 )
			{
				echo '<script type="text/javascript">window.top.window.jQuery(window.top.document).trigger("' . 
					rawurldecode(check_array($_REQUEST, 'event')) . 
					'", [' . json_encode($return_data) . ']);</script>';
				exit;
			}
			
			// Callback from "AJAX/form target to iframe/callback to top window" file upload
			$callback = check_array($_REQUEST, 'callbacks');//$this->input->get_post('callback', true);
			if ( strlen($callback) > 0 )
			{
				echo '<script type="text/javascript">window.top.window.' . 
					rawurldecode(check_array($_REQUEST, 'callbacks')) . 
					'(' . json_encode($return_data) . ');</script>';
				exit;
			}
			// ------------------------------------------------------------
			
			/*
			// Give end response if request type detected, e.g. AJAX
			$this->load->library('utility/request');
			$this->request->response($return_data, 'json');
			
			// or
			
			// Explicitly return data type
			echo json_encode($return_data);
			exit;
			*/
			// Explicitly return data type
			echo json_encode($return_data);
			exit;
		}
		
		/*
		// Return to referrer
		// Example: // header('Location: ' . $referrer . '?code=' . rawurlencode($return_data['code']) . '&message=' . rawurlencode(implode(' ', $return_data['message'])));
		header('Location: ' . $referrer);
		exit;
		
		// or
		
		// Return data
		return $return_data;
		*/
		// Return data
		return $return_data;
	}
}

// --------------------------------------------------------------------

