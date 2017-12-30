<?php
/**
* Protects against CSRF (Cross Site Request Forgery) attacks by a "nonce" check in forms and cookies.
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
* Usage: 
* 

In the Controller:

// Before displaying the form
$this->load->library('utility/csrf');
//$this->load->library('utility/csrf', array('auto_verify' => true));

In the form HTML:
<form action="" method="post">
	<?php echo $this->csrf->get_form_field(); ?>
</form>

Standalone:
include_once('Csrf.php');
$CSRF = new Csrf();

In the form HTML:
<form action="" method="post">
	<?php echo $CSRF->get_form_field(); ?>
</form>

* 
*/
class Csrf
{
	// --------------------------------------------------------------------
	// Private properties
	// --------------------------------------------------------------------
	
	/** CodeIgniter instance **/
	protected $_CI;
	
	/** Shared parameters */
	protected $_params;
	
	/** Default parameters */
	protected $_params_default = array(
		'auto_verify' => true,
		
		// Cookie name for Cross Site Request Forgery Protection Cookie
		'cookie_prefix' => '',
		'cookie_path' => '/',
		'cookie_domain' => '',
		'cookie_secure' => false,
		
		// Use session (Synchronizer Token Pattern) or cookie (Double Submit Cookies)
		'mode' => 'session',
		// Your secret key for handshake
		'secret_key' => 'Zugu$!V&jUKe76Ch',
		// Expiration time for Cross Site Request Forgery Protection Cookie, Defaults to two hours (in seconds)
		'ttl' => 7200,
		// Token name for Cross Site Request Forgery Protection Cookie
		'token_name' => 'csrf_token',
	);
	
	/** Token data */
	protected $_token_data;
	
	/** Random Hash for Cross Site Request Forgery Protection Cookie */
	protected $_token_hash = '';
	
	/** Token name for Cross Site Request Forgery Protection Cookie */
	protected $_token_name;

	// --------------------------------------------------------------------
	
	// --------------------------------------------------------------------
	// Public methods
	// --------------------------------------------------------------------
	
	/**
	* Class constructor
	*/
	public function __construct ( $params = array() )
	{
		// Set default values for missing keys
		if ( is_bool($params) )
		{
			$params = array('auto_verify' => $params); 
		}
		$this->_params = array_merge($this->_params_default, $params);
		
		// Set initial token name
		$this->_token_name = $this->_params['token_name'];
		
		// Check if using CodeIgniter
		if ( function_exists('get_instance') )
		{
			$this->_CI =& get_instance();
		}
		
		// Session
		if ( $this->_params['mode'] == 'session' )
		{
			// If CodeIgniter
			if ( $this->_CI )
			{
				$this->_CI->load->library('session');
			}
			else
			{
				// Start the native PHP session
				if ( ! session_id() )
				{
					session_start();
				}
			}
		}
		// Cookie
		else
		{
			// If CodeIgniter, check for configuration cookie parameters
			if ( $this->_CI )
			{
				$this->_params['cookie_prefix'] = config_item('cookie_prefix');
				$this->_params['cookie_secure'] = config_item('cookie_secure');
				$this->_params['cookie_path'] = config_item('cookie_path');
				$this->_params['cookie_domain'] = config_item('cookie_domain');
			}
			
			// Add cookie prefix
			$this->_token_name = $this->_params['cookie_prefix'] . $this->_token_name;
		}
		
		// Populate token data
		$this->get_token();
		
		// If not a POST request or no data submitted, create/refresh the token
		if ( empty($_POST) || strtoupper($_SERVER['REQUEST_METHOD']) !== 'POST' )
		{
			$this->create_token();
		}
		// Otherwise verify the token
		elseif ( $this->_params['auto_verify'] )
		{
			$this->verify();
		}
		
		if ( function_exists('log_message') )
		{
			log_message('info', __CLASS__ . ' class initialized.');
		}
	}

	// --------------------------------------------------------------------

	/**
	* 
	*/
	public function create_hash ()
	{
		return md5(uniqid(mt_rand(), true));
	}

	// --------------------------------------------------------------------

	/**
	* 
	*/
	public function create_token ( $force_new = false )
	{
		// Reusing the hash avoids conflicts with AJAX and nested pages using the same hash
		// If hash is not already locally set, create a new one
		if ( strlen($this->_token_hash) == 0 || $force_new )
		{
			$this->_token_hash = $this->create_hash();
		}
		
		$this->_token_data = array(
			'date' => time(),
			'hash' => $this->_token_hash,
		);
		
		// Session
		if ( $this->_params['mode'] == 'session' )
		{
			// Set the CSRF hash
			if ( $this->_CI )
			{
				$this->_CI->session->set_userdata($this->_token_name, $this->_token_data);
			}
			else
			{
				$_SESSION[$this->_token_name] = serialize($this->_token_data);
			}
		}
		// Cookie
		else
		{
			$max_expiration_date = time() + $this->_params['ttl'];
			$secure_cookie = $this->_params['cookie_secure'] ? 1 : 0;

			if ( $secure_cookie )
			{
				$https = isset($_SERVER['HTTPS']) ? ( strtolower($_SERVER['HTTPS']) == 'on' ) : false;

				if ( ! $https )
				{
					return false;
				}
			}
			
			require_once('Encryption.php');
			$ENCRYPTION = new Encryption();
			setcookie($this->_token_name, $ENCRYPTION->encode(serialize($this->_token_data)), $max_expiration_date, $this->_params['cookie_path'], $this->_params['cookie_domain'], $secure_cookie);
		}
	}

	// --------------------------------------------------------------------

	/**
	* 
	*/
	public function delete_token ()
	{
		// Session
		if ( $this->_params['mode'] == 'session' )
		{
			if ( $this->_CI )
			{
				$this->_CI->session->unset_userdata($this->_token_name);
			}
			else
			{
				unset($_SESSION[$this->_token_name]);
			}
		}
		// Cookie
		else
		{
			unset($_COOKIE[$this->_token_name]);
		}
		
		unset($_POST[$this->_token_name]);
	}

	// --------------------------------------------------------------------

	/**
	* 
	*/
	public function get_form_field ()
	{
		return '<input type="hidden" name="' . $this->get_token_name() . '" value="' . $this->get_hash() . '" autocomplete="off">' . "\n";//sprintf("<div style=\"display:none\">%s</div>", $form_field);
	}

	// --------------------------------------------------------------------

	/**
	* 
	*/
	public function get_hash ()
	{
		return $this->_token_hash;
	}

	// --------------------------------------------------------------------

	/**
	* 
	*/
	public function get_token ()
	{
		// If data already set, use it
		if ( $this->_token_data )
		{
			return $this->_token_data;
		}
		
		// Session
		if ( $this->_params['mode'] == 'session' )
		{
			// Set the CSRF hash
			if ( $this->_CI )
			{
				$this->_token_data = $this->_CI->session->userdata($this->_token_name);
			}
			else
			{
				if ( ! empty($_SESSION[$this->_token_name]) )
				{
					$this->_token_data = unserialize($_SESSION[$this->_token_name]);
				}
			}
		}
		// Cookie
		else
		{
			if ( ! empty($_COOKIE[$this->_token_name]) )
			{
				require_once('Encryption.php');
				$ENCRYPTION = new Encryption();
				$this->_token_data = unserialize($ENCRYPTION->decode($_COOKIE[$this->_token_name]));
			}
		}
		
		$this->_token_hash = $this->_token_data ? $this->_token_data['hash'] : '';
		
		return $this->_token_data;
	}

	// --------------------------------------------------------------------

	/**
	* 
	*/
	public function get_token_name ()
	{
		return $this->_token_name;
	}

	// --------------------------------------------------------------------

	/**
	* 
	*/
	public function show_error ( $show_error = true )
	{
		if ( $show_error )
		{
			$message = 'The action you have requested is not allowed.';
			
			if ( $this->_CI )
			{
				show_error($message);
			}
			else
			{
				die($message);
			}
		}
	}

	// --------------------------------------------------------------------

	/**
	* 
	*/
	public function verify ( $show_error = true, $delete_token = false )
	{
		// Check if data set
		if ( ! $this->_token_data )
		{
			$this->show_error($show_error);
			return -1;
		}
		
		// If the token was not submitted, stop
		if ( empty($_POST[$this->_token_name]) )
		{
			$this->show_error($show_error);
			return -2;
		}
		
		// Check token Time To Live
		// Cookie date is really trivial because the cookie itself has an expiration date
		$min_expiration_date = time() - $this->_params['ttl'];
		if ( $this->_token_data['date'] < $min_expiration_date )
		{
			$this->show_error($show_error);
			return -3;
		}
		
		// Check hash characters
		if ( preg_match('/^[0-9a-f]{32}$/iS', $this->_token_data['hash']) === false )
		{
			$this->show_error($show_error);
			return -4;
		}
		
		// Check matching hashes
		if ( $_POST[$this->_token_name] != $this->_token_data['hash'] )
		{
			$this->show_error($show_error);
			return -5;
		}
		
		// Delete used token and create a new one
		if ( $delete_token )
		{
			$this->delete_token();
			$this->create_token(true);
		}
		
		return true;
	}

	// --------------------------------------------------------------------
	
}

