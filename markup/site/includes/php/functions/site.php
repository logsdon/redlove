<?php

// --------------------------------------------------------------------

if ( ! function_exists('output_code') )
{
	/**
	* 
	*/
	function output_code ( $code, $full = true )
	{
		if ( $full )
		{
?>
<div class="redlove_code-example">
<span class="redlove_code-example_toggle"></span>
<div class="redlove_code-example_liner">
<?php
	$delimiter_begin = '{{';
	$delimiter_end = '}}';
	$delimiter_begin = '<\?php';
	$delimiter_end = '\?>';
	
	$new_code = $code;
	/*
	// http://www.regexr.com/3a1bt
	// Parse through possible shortcodes indiscriminately, e.g. [shortcode attribute="value"] or [shortcode]Test[/shortcode]
	// |\[([\w\d\-_]+)([^\]]*)\](?:(.*)(\[/\1\]))?|is
	$pattern = $delimiter_begin . '([\w\d\-_]+)([^' . $delimiter_end . ']*)' . $delimiter_end;
	$pattern .= '(?:(.*)(' . $delimiter_begin . '/\1' . $delimiter_end . '))?';
	*/
	$pattern = $delimiter_begin . '([\w\d\-_]+)[^' . $delimiter_end . ']*' . $delimiter_end;
	$pattern = $delimiter_begin . '([^' . $delimiter_end . ']*)' . $delimiter_end;
	$has_matches = preg_match_all('|' . $pattern . '|is', $new_code, $matches,  PREG_SET_ORDER);
	$matched_patterns = array();
	foreach ( $matches as $match )
	{
		$matched_pattern = $match[0];
		$matched_result = $match[1];
		
		if ( in_array($matched_pattern, $matched_patterns) )
		{
			continue;
		}
		$matched_patterns[] = $matched_pattern;
		
		$result = $matched_pattern;
		if ( function_exists($matched_result) )
		{
			$args = array();
			$result = call_user_func_array($matched_result, $args);
		}
		else
		{
			// This is unsafe and is only intended for internal demo/example code use
			ob_start();
			$result = eval($matched_result);
			$output = ob_get_contents();
			ob_end_clean();
			$result = isset($result) ? $result : $output;
		}
		$new_code = str_ireplace($matched_pattern, $result, $new_code);
	}
	echo $new_code;
?>
</div>
</div>
<hr class="default w60 center">
<?php
		}
		else
		{
?>
<?php echo $code; ?>
<div class="redlove_code-example redlove_code-example-shown">
<span class="redlove_code-example_toggle"></span>
<div class="redlove_code-example_liner">
 <pre><?php echo htmlentities(trim($code)); ?></pre>
</div>
</div>
<hr class="default w60 center">
<?php
		}
		
		return;
?>
<div class="columns">
	<div class="column w100">
		<?php echo $code; ?>
	</div>
	<div class="column w100">
		<pre class="code" style="max-height: 20em; overflow-y: auto;"><?php echo htmlentities($code); ?></pre>
	</div>
</div>
<?php
	}
}

// --------------------------------------------------------------------

if ( ! function_exists('check_access') )
{
	/**
	* Check user access to site
	*/
	function check_access ()
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
		
		// Set allowed domains
		$domain = '';
		$allowed_domains = array( parse_url(site_url(), PHP_URL_HOST) );
		/*
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
			/*
			redirect($referrer)
			// Or
			header('Location: http://' . $referrer_domain);
			*/
			
			if ( $is_ajax )
			{
				exit;
			}
			return;
		}
		
		// If there is a querystring, get as variables; later add in variables and update referrer
		if ( ! isset($referrer_parsed['query']) )
		{
			$referrer_parsed['query'] = '';
		}
		parse_str($referrer_parsed['query'], $querystring_vars);
		/*
		$querystring_vars['code'] = $return_data['code'];
		$querystring_vars['action'] = 'thank-you';
		$querystring_vars['form_id'] = 0;
		$referrer_parsed['query'] = http_build_query($querystring_vars, '', '&');
		$referrer = http_build_url($referrer_parsed);
		*/
		// ------------------------------------------------------------
		
		// ------------------------------------------------------------
		// Set process action
		$action = isset($_REQUEST['action']) ? trim(rawurldecode(check_array($_REQUEST, 'action'))) : $args0;

		// Stop if no data submitted
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
		$this->load->library('utility/csrf');
		require_once(INCLUDES_PATH . 'php/classes/Csrf.php');
		$CSRF = new Csrf();
		$CSRF->verify_session();
		*/
		
		// Initialize return data
		$return_data = array(
			'code' => 0,
			'value' => '',
			'message' => array(),
		);
		
		// ------------------------------------------------------------
		// Validate data
		$valid = true;
		$success = false;
		// ------------------------------------------------------------
		
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
			// CSRF check
			$this->load->library('utility/csrf');
			*/
			
			// Gather data
			
			// Validate data
			if ( strlen($something) > 0 )
			{
				$valid = false;
				$return_data['message'][] = 'Please leave fields blank where asked to do so.';
			}
			
			// Process data
			if ( $valid )
			{
				$success = do_something();
				if ( $success )
				{
					$return_data['code'] = 1;
					$return_data['message'][] = 'Success!';
				}
				else
				{
					$return_data['code'] = 0;
					$return_data['message'][] = 'Error, please try again!';
				}
			}
		}
		// Get CSRF
		elseif ( $action == 'get_csrf' )
		{
			require_once(INCLUDES_PATH . 'php/classes/Csrf.php');
			$CSRF = new Csrf();
			
			$return_data['code'] = 1;
			$return_data['value'] = array(
				$CSRF->get_token_name() => $CSRF->get_hash(),
			);
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
		// Enter
		elseif ( $action == 'enter' )
		{
			// Stop if no data submitted
			if ( empty($_POST) )
			{
				exit;
			}
			
			// CSRF check
			require_once(INCLUDES_PATH . 'php/classes/Csrf.php');
			$CSRF = new Csrf();
			
			// Gather data
			$name = (string)check_post('name');
			$created_time = time();
			
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
				
				if ( $success )
				{
					$return_data['code'] = 1;
					$return_data['message'][] = 'Thank you!';
				}
				else
				{
					$return_data['code'] = 0;
					$return_data['message'][] = 'Please try again.';
				}
			}
		}
		// ------------------------------------------------------------
		
		// ------------------------------------------------------------
		// Return JSON data
		if ( $is_ajax )
		{
			/*
			$return_data['message'] = implode(' ', $return_data['message']);
			*/
			
			// ------------------------------------------------------------
			// Iframe form handling
			
			// Event from "AJAX/form target to iframe/callback to top window" file upload
			$event = $this->input->get_post('event', true);
			if ( strlen($event) > 0 )
			{
				echo '<script type="text/javascript">window.top.window.jQuery(window.top.document).trigger("' . 
					rawurldecode(check_array($_REQUEST, 'event')) . 
					'", [' . json_encode($return_data) . ']);</script>';
				exit;
			}
			
			// Callback from "AJAX/form target to iframe/callback to top window" file upload
			$callback = $this->input->get_post('callback', true);
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
			*/
			echo json_encode($return_data);
			exit;
		}
		
		/*
		// Return to referrer
		header('Location: ' . $referrer);
		header('Location: ' . $referrer . '?code=' . rawurlencode($return_data['code']) . '&message=' . rawurlencode(implode(' ', $return_data['message']))) ;
		exit;
		*/
		
		return $return_data;//exit;
	}
}

// --------------------------------------------------------------------

