<?php
/**
* Process parameters, content, and send email
*
* @package RedLove
* @subpackage PHP
* @category Classes
* @author Joshua Logsdon <joshua@joshualogsdon.com>
* @author Various from CodeIgniter to Internet
* @copyright Copyright (c) 2015, Joshua Logsdon (http://joshualogsdon.com/)
* @license http://opensource.org/licenses/MIT MIT License
* @link https://github.com/logsdon/redlove
* @link http://redlove.org
* @version 0.0.0
* 
* Resources: 
* PHPMailer - https://github.com/PHPMailer/PHPMailer
* 
* Usage: 
* 

if ( strlen($data['email_honeypot']) > 0 )
{
	$valid = false;
	$ret_data['message'][] = 'Please leave fields blank where asked to do so.';
}

if ( ! valid_email($data['email']) )
{
	$valid = false;
	$ret_data['message'][] = 'Please enter a valid Email address.';
}

// Process data
if ( $valid )
{
	// Send email
	// ----------------------------------------
	// Gather data
	$this->load->library('application/email');
	$email_fields = array(
		'Name' => $data['name'],
		'Phone' => $data['phone'],
		'Email' => $data['email'],
		'Gender' => $data['gender'],
		'Age' => $data['age'],
		'Comments' => $data['comments'],
	);
	// Clean email fields
	$email_fields = $this->email->clean_fields($email_fields);

	// Build message from email parameters
	$email_newline = '<br />';
	$email_body = $this->email->build_body($email_fields, $email_newline);
	$email_body = trim("Submitted form data...{$email_newline}{$email_newline}{$email_body}{$email_newline}{$email_newline}[ END OF MESSAGE ]");
	//$email__body = $this->load->view('email-templates/invite.html', $email_fields, true);
	//$email__body = file_get_contents('contents.html');

	// Gather email data
	$host = parse_url(site_url(), PHP_URL_HOST);
	$email_params = array(
		'from_email' => 'admin@' . $host,//'do-not-reply@example.com'
		'from_name' => 'Do Not Reply',//'Do Not Reply';
		'to_email' => ( ENVIRONMENT == 'production' ) ? 'me@mail.com' : $data['email'],
		'to_name' => 'Example.com',//'Admin'//trim($name)
		'subject' => 'Contact Form Submission',
		'body' => $email_body,
	);

	// Send the email
	$email_data = $this->email->send($email_params);
	$success = ( $email_data['code'] > 0 );

	// If NOT successful
	if (  ! $success )
	{
		$ret_data['code'] = 0;
		$ret_data['message'][] = 'Your message could not be sent. Please try again.';
	}
	else
	{
		$ret_data['code'] = 1;
		$ret_data['message'][] = 'Thank you! Your message has been sent.';
	}
	
}//end if valid


* --------------------------------------------------------------------


$host = parse_url(site_url(), PHP_URL_HOST);//'example.com';//
$host = substr_count($host, '.', 0, 2) >= 2 ? array_pop(explode('.', $host, 2)) : $host;
$host = 'Example.com';//parse_url(site_url(), PHP_URL_HOST);
$email__from = 'admin@' . $host;//$email;//'do-not-reply@example.com';//
$email__to = $email_vars['email'];//(ENVIRONMENT == 'production') ? 'admin@' . $host : $email;//$email;//

// Send any emails or other notifications
$this->_send_email(array(
	'from_email' => 'support@example.com',
	'from_name' => 'Support',
	'to_email' => $user->email,
	'to_name' => 'Example.com User',
	'subject' => 'Example.com - Payment Failed',
	'alt_body' => 'To view the message, please use an HTML compatible email viewer!',
	'char_set' => 'UTF-8',
	'is_html' => true,
	'body' => nl2br(trim("
		Dear {$user->name},

		Oops! Your latest payment failed to go through. Please log on to Example.com and update your credit card info to keep your subscription active. The details are included below.

		======================================
		
		Receipt #: {$invoice->id}
		Date: {$invoice_date}{$for_invoice_period}
		Bill to: {$card_name}{$card_details}

		{$lineitems}
		
		Total: \${$invoice_amount}

		We will try again on {$next_payment_attempt_date}.

		======================================
		NEED TO CANCEL:
		======================================
		
		On your Account > Billing page you can click the Cancel link.

		We do not offer refunds for previous payments, but once you cancel, you will not be charged again.

		If you have any questions, please reply to support@example.com.
		
		Thank you for using Example.com.
	")),
));


* --------------------------------------------------------------------


// Gather data
$email_vars = array(
	'name' => strip_tags(stripslashes($_POST['name'])),
	'email' => $_POST['gobbledy-gook'],
	'email_honeypot' => $_POST['email'],
	'phone' => $_POST['phone'],
	'message' => strip_tags(stripslashes($_POST['message'])),
);

// ------------------------------------------------------------
// Run validation
$valid = true;
$return_data = array(
	'code' => 0,
	'value' => '',
	'message' => array(),
);

if ( strlen($email_vars['email_honeypot']) > 0 )
{
	$valid = false;
	$return_data['message'][] = 'Please leave fields blank where asked to do so.';
}

if ( 
	strlen($email_vars['name']) == 0 || 
	strlen($email_vars['message']) == 0 
)
{
	$valid = false;
	$return_data['message'][] = 'Please enter valid answers for all required fields.';
}

if ( has_url($email_vars['name']) )
{
	$valid = false;
	$return_data['message'][] = 'URLs are only allowed in the Message.';
}

if ( strlen($email_vars['email']) == 0 && strlen($email_vars['phone']) == 0 )
{
	$valid = false;
	$return_data['message'][] = 'Please enter a valid Phone.';
}

if ( strlen($email_vars['email']) > 0 && ! valid_email($email_vars['email']) )
{
	$valid = false;
	$return_data['message'][] = 'Please enter a valid Email.';
}
// ------------------------------------------------------------

if ( $valid )
{
	require_once(ROOT_PATH . 'inc/class.email.php');
	$EMAIL = new Email();
	
	// Clean up data for key > val output
	unset($email_vars['email_honeypot']);
	
	// Clean email_vars
	$email_vars = $EMAIL->clean_fields($email_vars);
	// Build message from POST
	$fields_body = $EMAIL->build_body($email_vars);
	
	// Gather email data
	$host = $allowed_domain;//parse_url(site_url(), PHP_URL_HOST);
	$email_params = array(
		'from_email' => 'admin@' . $host,//$email;//'do-not-reply@example.com';//
		'from_name' => 'Do Not Reply',//$name;//'Do Not Reply';//
		'to_email' => (ENVIRONMENT == 'production') ? 'me@mail.com' : $email_vars['email'],//$email;//
		'to_name' => 'Admin',//'Admin';//trim($name);//
		'subject' => 'Contact Form',
	);
	//$email__body = $this->load->view('email-templates/invite.html', $email_vars, true);//file_get_contents('contents.html')
	//$email__body = "Name: {$name}({$email})\nOpt-in:{$optin}\nMessage:\n{$message}";
	$email_params['body'] = "
Submitted form data...

{$fields_body}

[ END OF MESSAGE ]
";
	
	$email_data = $EMAIL->send($email_params);
	$return_data = $email_data;
}

// Return JSON data
$return_data['message'] = implode(' ', $return_data['message']);
if ( is_ajax() )
{
	exit(json_encode($return_data));
}




	// --------------------------------------------------------------------
	
	/** 
	* 
	* /
	public function process()
	{
		// CSRF check
		$this->load->library('utility/csrf');
		
		$this->load->library('utility/request');
		
		// ------------------------------------------------------------
		// Check if referering domain is allowed

		$referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
		$referer_domain = parse_url($referer, PHP_URL_HOST);

		// Set allowed domains
		$allowed_domain = '';
		$allowed_domains = array();
		if ( ENVIRONMENT == 'development' )
		{
			$allowed_domains[] = '127.0.0.1';
		}
		elseif ( ENVIRONMENT == 'testing' )
		{
			$allowed_domains[] = 'testing.com';
		}
		elseif ( ENVIRONMENT == 'production' )
		{
			$allowed_domains[] = 'example.com';
		}

		// Check referer domain against allowed domains
		if ( $referer )
		{
			foreach ( $allowed_domains as $domain )
			{
				if ( stripos($referer_domain, $domain) !== false )
				{
					$allowed_domain = $domain;
					break;
				}
			}
		}

		// Stop if referer not allowed
		if ( ! $allowed_domain )
		{
			//header('Location: http://' . $referer_domain);
			if ( $this->request->is_ajax() )
			{
				exit;
			}
			return;
		}
		/*
		if ( isset($_SERVER['HTTP_REFERER']) && strpos(parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST), parse_url(site_url(), PHP_URL_HOST)) !== false )

		// Last url
		$last_url = ( isset($_SERVER['HTTP_REFERER']) ) ? $_SERVER['HTTP_REFERER'] : '';
		$view_vars['last_url'] = ( strpos($last_url, site_url('blog/archive')) === 0 ) ? $last_url : site_url('blog/archive');
		* /
		// ------------------------------------------------------------
		
		// ------------------------------------------------------------
		// Stop if no data submitted
		if ( empty($_POST) )
		//if ( empty($_REQUEST) || ! isset($_REQUEST['action']) )
		{
			if ( $this->request->is_ajax() )
			{
				exit;
			}
			return;
		}
		// ------------------------------------------------------------

		// ------------------------------------------------------------
		// Set process action
		//$action = strip_tags(stripslashes($_REQUEST['action']));
		// Initialize return data
		$return_data = array(
			'code' => 0,
			'value' => '',
			'message' => array(),
		);
		// ------------------------------------------------------------

		// ------------------------------------------------------------
		// Process data
		if ( isset($_POST['contact']) && is_array($_POST['contact']) )
		{
			// Gather data
			$email_vars = array(
				'location' => strip_tags(stripslashes($_POST['contact']['location'])),
				'name' => strip_tags(stripslashes($_POST['contact']['name'])),
				'email' => $_POST['contact']['gobbledy-gook'],
				'email_honeypot' => $_POST['contact']['email'],
				'phone' => $_POST['contact']['phone'],
				'message' => strip_tags(stripslashes($_POST['contact']['message'])),
			);
			
			// ------------------------------------------------------------
			// Run validation
			$valid = true;
			
			if ( strlen($email_vars['email_honeypot']) > 0 )
			{
				$valid = false;
				$return_data['message'][] = 'Please leave fields blank where asked to do so.';
			}
			
			if ( 
				strlen($email_vars['location']) == 0 || 
				strlen($email_vars['name']) == 0 || 
				strlen($email_vars['email']) == 0 || 
				strlen($email_vars['message']) == 0 
			)
			{
				$valid = false;
				$return_data['message'][] = 'Please enter valid answers for all required fields.';
			}
			
			if ( has_url($email_vars['name']) || has_url($email_vars['location']) )
			{
				$valid = false;
				$return_data['message'][] = 'URLs are only allowed in the Message.';
			}
			
			if ( strlen($email_vars['email']) > 0 && ! valid_email($email_vars['email']) )
			{
				$valid = false;
				$return_data['message'][] = 'Please enter a valid Email address.';
			}
			// ------------------------------------------------------------
			
			if ( $valid )
			{
				// Send email
				$this->load->library('application/email');
				
				// Clean up data for key > val output
				unset($email_vars['email_honeypot']);
				// Clean email_vars
				$email_vars = $this->email->clean_fields($email_vars);
				// Build message from POST
				$email_body = $this->email->build_body($email_vars, '<br />');
				$email_body = nl2br(trim("
					Submitted form data...

					{$email_body}

					[ END OF MESSAGE ]
				"));
				
				// Gather email data
				$email_params = array(
					'from_email' => 'admin@' . $allowed_domain,
					'from_name' => 'Do Not Reply',
					'to_email' => ( ENVIRONMENT == 'production' ) ? 'info@example.com' : $email_vars['email'],
					'to_name' => 'Example.com',
					'subject' => 'Example.com Contact - ' . $email_vars['location'],
					'body' => $email_body,
				);
				$email_data = $this->email->send($email_params);
				$success = ( $email_data['code'] > 0 );
				$return_data = $email_data;
				if ( $success )
				{
					$return_data['message'] = array('Thank you for getting in touch!');
				}
			}
		}
		// ------------------------------------------------------------
		
		// Return JSON data
		$return_data['message'] = implode(' ', $return_data['message']);
		if ( $this->request->is_ajax() )
		{
			exit(json_encode($return_data));
		}
		
		return $return_data;
	}
	
	// --------------------------------------------------------------------

* 
*/
class Email
{
	// --------------------------------------------------------------------
	// Private properties
	// --------------------------------------------------------------------
	
	/**
	* Config parameters
	* 
	* @var array
	*/
	private $config = array(
		'test' => false,
		'smtp_debug' => 0,
		'smtp_auth' => false,
		'smtp_secure' => null,
		'smtp_host' => null,
		'smtp_port' => null,
		'smtp_username' => null,
		'smtp_password' => null,
		'log' => false,
	);
	
	// --------------------------------------------------------------------
	// Public methods
	// --------------------------------------------------------------------
	
	/**
	* Class constructor
	*/
	public function __construct ( $params = '' )
	{
		// If no parameters passed, try autoloading config
		if ( $params === '' )
		{
			$config_file = dirname(__FILE__) . '/../../config/email.php';
			if ( file_exists($config_file) )
			{
				require($config_file);
				$this->config = array_merge($this->config, $config['email']);
			}
		}
		// If array passed, use for config
		elseif ( is_array($params) )
		{
			$this->config = array_merge($this->config, $params);
		}
		// Else assume config file path passed
		else
		{
			if ( file_exists($params) )
			{
				require($params);
				$this->config = array_merge($this->config, $config['email']);
			}
		}
		
		if ( function_exists('get_instance') )
		{
			log_message('info', __CLASS__ . ' class initialized.');
		}
	}
	
	// --------------------------------------------------------------------
	
	/**
	* 
	* 
	* @param array $params
	* @return bool If failure
	* @return int If success
	*/
	public function send ( $params = array() )
	{
		// Set default values for missing keys
		$default_params = array(
			'test' => null,
			
			'from_email' => '',
			'from_name' => '',
			'reply_to_email' => '',
			'reply_to_name' => '',
			'to_email' => '',
			'to_name' => '',
			'to_addresses' => array(),
			'bcc_addresses' => array(),
			'subject' => '',
			'body' => '',
			'alt_body' => 'To view the message, please use an HTML compatible email viewer.',
			'char_set' => 'UTF-8',
			'is_html' => true,
			'attachments' => array(),
			
			'smtp_debug' => null,
			'smtp_auth' => null,
			'smtp_host' => null,
			'smtp_port' => null,
			'smtp_username' => null,
			'smtp_password' => null,
			
			'log' => null,
			'type' => '',
			'origin' => '',
			'user_agent_type' => '',
			'user_agent_device' => '',
			'ip_address' => '',
			'created_user_id' => '',
		);
		$params = array_merge($default_params, $params);
		
		$is_test = isset($params['test']) ? $params['test'] : $this->config['test'];
		$do_log = isset($params['log']) ? $params['log'] : $this->config['log'];
		
		$return_value = '';
		$return_message = array();
		
		// If IS in development, do not send email
		if ( $is_test )
		{
			$return_message[] = trim('
				<div class="code">
					<pre>TEST MODE (no email sent):
						From: "' . $params['from_name'] . '" &lt;' . $params['from_email'] . '&gt;
						To: "' . $params['to_name'] . '" &lt;' . $params['to_email'] . '&gt;
						Subject: ' . $params['subject'] . '
						Body: ' . $params['body'] . '
					</pre>
				</div>
			');
			return array(
				'code' => true, 
				'value' => $return_value, 
				'message' => $return_message,
			);
		}
		
		// Make the timezone consistent on the server and audience location
		if ( 
			function_exists('date_default_timezone_set') && 
			function_exists('date_default_timezone_get') /*&& 
			@date_default_timezone_get() != 'America/New_York' */
		)
		{
			//@date_default_timezone_set(@date_default_timezone_get());
			@date_default_timezone_set('America/New_York');
		}
		
		// Begin PHPMailer
		
		/*
		include( APPPATH .'libraries/phpmailer/phpmailer/class.pop3.php' );
		$pop = new POP3();
		$pop->Authorise('hostname', 110, 30, 'username', 'password', 1);
		*/
		
		if ( ! class_exists('PHPMailer') && defined('INCLUDES_PATH') )
		{
			if ( defined('APPPATH') )
			{
				$file = APPPATH . 'libraries/third_party/phpmailer/PHPMailerAutoload.php';
			}
			elseif ( defined('REDLOVE_PATH') )
			{
				$file = REDLOVE_PATH . 'php/third_party/phpmailer/PHPMailerAutoload.php';
			}
			elseif ( defined('INCLUDES_PATH') )
			{
				$file = INCLUDES_PATH . 'php/libraries/third_party/phpmailer/PHPMailerAutoload.php';
			}
			
			if ( ! file_exists($file) )
			{
				die('PHPMailer cannot be loaded.');
			}
			
			require_once($file);
		}
		
		$PM = new PHPMailer(true);// true will catch exceptions
		
		try
		{
			// Check for SMTP use
			$smtp_host = isset($params['smtp_host']) ? $params['smtp_host'] : $this->config['smtp_host'];
			if ( isset($smtp_host) && isset($smtp_host[0]) )
			{
				$smtp_debug = isset($params['smtp_debug']) ? $params['smtp_debug'] : $this->config['smtp_debug'];
				$smtp_auth = isset($params['smtp_auth']) ? $params['smtp_auth'] : $this->config['smtp_auth'];
				$smtp_secure = isset($params['smtp_secure']) ? $params['smtp_secure'] : $this->config['smtp_secure'];
				$smtp_port = isset($params['smtp_port']) ? $params['smtp_port'] : $this->config['smtp_port'];
				$smtp_username = isset($params['smtp_username']) ? $params['smtp_username'] : $this->config['smtp_username'];
				$smtp_password = isset($params['smtp_password']) ? $params['smtp_password'] : $this->config['smtp_password'];
				// Use SMTP
				$PM->IsSMTP();// telling the class to use SMTP
				$PM->SMTPDebug = $smtp_debug;// 1 = errors and messages// 2 = messages only
				$PM->SMTPAuth = $smtp_auth;
				$PM->SMTPSecure = $smtp_secure;
				$PM->Host = $smtp_host;
				$PM->Port = $smtp_port;
				$PM->Username = $smtp_username;
				$PM->Password = $smtp_password;
			}
			
			// Reply To
			if ( strlen($params['reply_to_email']) > 0 )
			{
				$PM->AddReplyTo($params['reply_to_email'], $params['reply_to_name']);//do-not-reply//no-reply
			}
			
			// Build and send email
			$PM->SetFrom($params['from_email'], $params['from_name']);
			$PM->Subject = $params['subject'];
			$PM->ClearAddresses();
			
			// Add TO addresses
			if ( is_array($params['to_addresses']) && ! empty($params['to_addresses']) )
			{
				foreach ($params['to_addresses'] as $address => $name )
				{
					$PM->AddAddress($address, $name);//$PM->addBCC($address, $name);
				}
			}
			else
			{
				//$PM->AddAddress($params['to_email'], $params['to_name']);
				
				$to_emails = array_map('trim', explode(',', $params['to_email']));
				$to_names = array_map('trim', explode(',', $params['to_name']));
				$num_to_emails = count($to_emails);
				for ( $i = 0; $i < $num_to_emails; $i++ )
				{
					$to_email = isset($to_emails[$i]) ? $to_emails[$i] : '';
					$to_name = isset($to_names[$i]) ? $to_names[$i] : '';
					$PM->AddAddress($to_email, $to_name);
				}
			}
			
			// Add BCC addresses
			if ( is_string($params['bcc_addresses']) && strlen($params['bcc_addresses']) > 0 )
			{
				$params['bcc_addresses'] = array_filter(array_map('trim', explode(',', $params['bcc_addresses'])));
				$values = array_values($params['bcc_addresses']);
				$params['bcc_addresses'] = array_combine($values, array_fill(0, count($values), ''));
			}
			if ( is_array($params['bcc_addresses']) && ! empty($params['bcc_addresses']) )
			{
				foreach ($params['bcc_addresses'] as $bcc_address => $bcc_name )
				{
					$PM->addBCC($bcc_address, $bcc_name);
				}
			}
			
			$PM->CharSet = $params['char_set'];
			if ( $params['is_html'] )
			{
				$PM->IsHTML(true);
				$PM->MsgHTML(trim($params['body']));
				$PM->AltBody = $params['alt_body'];
			}
			else
			{
				$PM->IsHTML(false);
				$PM->Body = trim($params['body']);
			}
			
			// Add attachments
			if ( is_string($params['attachments']) && strlen($params['attachments']) > 0 )
			{
				$params['attachments'] = array_filter(array_map('trim', explode(',', $params['attachments'])));
				$values = array_values($params['attachments']);
				$params['attachments'] = array_combine($values, array_fill(0, count($values), ''));
			}
			if ( is_array($params['attachments']) && ! empty($params['attachments']) )
			{
				foreach ( $params['attachments'] as $attachment => $attachment_name )
				{
					$PM->AddAttachment($attachment, $attachment_name);
				}
			}
			
			$PM->Send();//$success = @$PM->Send();
		}
		catch ( phpmailerException $e )
		{
			// Error from PHPMailer
			$error = $e->errorMessage();
			$return_message[] = $error;
			
			// Log error
			if ( function_exists('log_message') )
			{
				log_message('error', 'Email: ' . $error);
			}
		}
		catch ( Exception $e )
		{
			// Generic error
			$error = $e->getMessage();
			$return_message[] = $error;
			
			// Log error
			if ( function_exists('log_message') )
			{
				log_message('error', 'Email: ' . $error);
			}
		}
		
		// Handle exceptions/errors
		$success = ( ! isset($error) || ! $error );
		
		if ( $success )
		{
			$return_message[] = 'Email sent successfully.';
			
			if ( $do_log && function_exists('get_instance') )
			{
				$CI =& get_instance();
				// Log the email being sent
				$model = 'Log_email_model';
				$CI->load->model($model);
				$query_params = array(
					'data' => array(
						'type' => $params['type'],
						'origin' => $params['origin'],
						'from_name' => $params['from_name'],
						'from_email' => $params['from_email'],
						'to_name' => $params['to_name'],
						'to_email' => $params['to_email'],
						'subject' => $params['subject'],
						'body' => $params['body'],
						'user_agent_type' => $params['user_agent_type'],
						'user_agent_device' => $params['user_agent_device'],
						'ip_address' => $params['ip_address'],
						'created_user_id' => $params['created_user_id'],
					),
				);
				$email_id = $CI->{$model}->insert($query_params);
			}
		}
		
		$return_data = array(
			'code' => $success, 
			'value' => $return_value, 
			'message' => $return_message,
		);
		
		return $return_data;
	}
	
	// --------------------------------------------------------------------
	
	/**
	* 
	* 
	* @param array $params
	*/
	public function send_native($to, $from, $subject, $message)
	{
		$headers = array();
		$headers[] = 'MIME-Version: 1.0';
		$headers[] = 'Content-type: text/plain; charset=utf-8';
		$headers[] = 'From: ' . $from;
		//$headers[] = 'Bcc: "Test Name" <test@mail.com>';
		$headers[] = 'Reply-To: ' . $from;
		$headers[] = 'Subject: ' . $subject;
		$headers[] = 'X-Mailer: PHP/' . phpversion();
		/*
		//$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
		<html>
		<head>
		   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		   <title>Test Title</title>
		</head>
		<body>
		   <p>Test message.</p>
		</body>
		</html>
		*/
		mail($to, $subject, $message, implode("\r\n", $headers));
	}
	
	// --------------------------------------------------------------------
	
	/**
	* 
	* 
	* @param array $params
	*/
	public function _EXAMPLE_payment_received ( $invoice, $customer )
	{
	$subscription = $invoice->lines->subscriptions[0];
return <<<EOF
Dear {$customer->email}:
 
This is a receipt for your subscription. This is only a receipt,
no payment is due. Thanks for your continued support!
 
-------------------------------------------------
SUBSCRIPTION RECEIPT
 
Email: {$customer->email}
Plan: {$subscription->plan->name}
Amount: {$this->_format_stripe_amount($invoice->total)} (USD)
 
For service between {$this->_format_stripe_timestamp($subscription->period->start)} and {$this->_format_stripe_timestamp($subscription->period->end)}
 
-------------------------------------------------
 
EOF;
	}
	
	// --------------------------------------------------------------------
	
	/**
	* 
	* 
	* @param array $fields
	*/
	public function clean_fields( $fields, $nl2br = true )
	{
		// Clean email fields
		foreach ( $fields as $key => $val )
		{
			unset($fields[$key]);
			$key = strip_tags(stripslashes($key));
			$val = strip_tags(stripslashes($val));
			$fields[$key] = $nl2br ? nl2br($val) : $val;
		}
		
		return $fields;
	}
	
	// --------------------------------------------------------------------
	
	/**
	* 
	* 
	* @access public
	* @param array $email_vars
	*/
	public function process_form_fields( $email_vars )
	{
		// Run validation
		$valid = true;
		// Initialize return data
		$return_data = array(
			'code' => 0,
			'value' => '',
			'message' => array(),
		);
		
		$field_key = 'form_fields_exclude';
		if ( isset($email_vars[$field_key]) && strlen($email_vars[$field_key]) > 0 )
		{
			$fields = explode(',', $email_vars[$field_key]);
			$fields = array_map('trim', $fields);
			
			foreach ( $fields as $field )
			{
				unset($email_vars[$field]);
			}
			
			unset($email_vars[$field_key]);
		}
		
		$field_key = 'form_fields_honeypot';
		if ( isset($email_vars[$field_key]) && strlen($email_vars[$field_key]) > 0 )
		{
			$fields = explode(',', $email_vars[$field_key]);
			$fields = array_map('trim', $fields);
			
			foreach ( $fields as $field )
			{
				if ( isset($email_vars[$field]) && strlen($email_vars[$field]) > 0 )
				{
					$valid = false;
					$proper_field_name = str_replace('_',' ', ucfirst(strip_tags(stripslashes($field))));
					$return_data['message'][] = 'Please leave ' . $proper_field_name . ' blank.';
				}
				
				// Clean up data for key > val output
				unset($email_vars[$field]);
			}
			
			unset($email_vars[$field_key]);
		}
		
		$field_key = 'form_fields_required';
		if ( isset($email_vars[$field_key]) && strlen($email_vars[$field_key]) > 0 )
		{
			$fields = explode(',', $email_vars[$field_key]);
			$fields = array_map('trim', $fields);
			
			foreach ( $fields as $field )
			{
				if ( isset($email_vars[$field]) && strlen(trim($email_vars[$field])) == 0 )
				{
					$valid = false;
					$proper_field_name = str_replace('_',' ', ucfirst(strip_tags(stripslashes($field))));
					$return_data['message'][] = 'Please enter a value for ' . $proper_field_name . '.';
				}
			}
			
			unset($email_vars[$field_key]);
		}
		
		$field_key = 'form_fields_url_blacklist';
		if ( isset($email_vars[$field_key]) && strlen($email_vars[$field_key]) > 0 )
		{
			$fields = explode(',', $email_vars[$field_key]);
			$fields = array_map('trim', $fields);
			
			foreach ( $fields as $field )
			{
				if ( isset($email_vars[$field]) && has_url($email_vars[$field]) )
				{
					$valid = false;
					$proper_field_name = str_replace('_',' ', ucfirst(strip_tags(stripslashes($field))));
					$return_data['message'][] = 'URLs are not allowed in ' . $proper_field_name . '.';
				}
			}
			
			unset($email_vars[$field_key]);
		}
		
		$field_key = 'form_fields_url_whitelist';
		if ( isset($email_vars[$field_key]) && strlen($email_vars[$field_key]) > 0 )
		{
			$fields = explode(',', $email_vars[$field_key]);
			$fields = array_map('trim', $fields);
			
			foreach ( $email_vars as $field => $field_val )
			{
				if ( has_url($field_val) && ! in_array($field, $fields) )
				{
					$valid = false;
					$proper_field_name = str_replace('_',' ', ucfirst(strip_tags(stripslashes($field))));
					$return_data['message'][] = 'URLs are not allowed in ' . $proper_field_name . '.';
				}
			}
			
			unset($email_vars[$field_key]);
		}
		
		$field_key = 'form_fields_email';
		if ( isset($email_vars[$field_key]) )
		{
			$fields = explode(',', $email_vars[$field_key]);
			$fields = array_map('trim', $fields);
			
			foreach ( $fields as $field )
			{
				if ( isset($email_vars[$field]) && strlen($email_vars[$field]) > 0 && ! valid_email($email_vars[$field]) )
				{
					$valid = false;
					$proper_field_name = str_replace('_',' ', ucfirst(strip_tags(stripslashes($field))));
					$return_data['message'][] = 'Please enter valid email addresses.';
				}
			}
			
			unset($email_vars[$field_key]);
		}
		
		$field_key = 'form_fields_remap';
		if ( isset($email_vars[$field_key]) )
		{
			$fields = explode(',', $email_vars[$field_key]);
			$fields = array_map('trim', $fields);
			
			foreach ( $fields as $field )
			{
				$keys = explode(':', $field);
				$keys = array_map('trim', $keys);
				
				if ( count($keys) > 1 && isset($email_vars[$keys[0]]) )
				{
					//$email_vars[$keys[1]] = $email_vars[$keys[0]];
					$email_vars = $this->replace_assoc_key($email_vars, $keys[0], $keys[1]);
					unset($email_vars[$keys[0]]);
				}
			}
			
			unset($email_vars[$field_key]);
		}
		
		$return_data['code'] = $valid;
		$return_data['value'] = $email_vars;
		
		return $return_data;
	}
	
	// --------------------------------------------------------------------
	
	/**
	* 
	* 
	* @access public
	* @param array $fields
	*/
	public function build_body( $fields, $newline = null )
	{
		if ( ! isset($newline) )
		{
			$newline = ( strtoupper(substr(PHP_OS, 0, 3) == 'WIN') ) ? "\r\n" : "\n";
		}
		/*
		// Define end of line character
		if ( ! defined('PHP_EOL') )
		{
			define('PHP_EOL', (strtoupper(substr(PHP_OS, 0, 3) == 'WIN') ? "\r\n" : "\n"));
		}
		*/
		
		// Build message from email parameters
		$body = '';// . $newline . $newline;
		foreach ( $fields as $key => $val )//foreach ( $_POST as $key => $val )
		{
			if ( ! empty($val) )
			{
				$body .= '<b>' . str_replace('_',' ', ucfirst($key)) . ':</b>' . $newline;
				$body .= $val . $newline . $newline;
			}
		}
		$body = rtrim($body);
		
		return $body;
	}
	
	// --------------------------------------------------------------------
	
	/**
	* Replace an associative array key and preserve order.
	* http://stackoverflow.com/questions/10182684/how-to-change-a-key-in-an-array-while-maintaining-the-order
	* 
	* @access public
	* @param array 
	*/
	public function replace_assoc_key( $array, $key1, $key2, $strict = true )
	{
		$keys = array_keys($array);
		$index = array_search($key1, $keys, $strict);

		if ( $index !== false )
		{
			$keys[$index] = $key2;
			$array = array_combine($keys, $array);
		}

		return $array;
	}
	
	// --------------------------------------------------------------------
	
}

