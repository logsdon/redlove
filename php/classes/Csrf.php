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
	
	/** Use session (Synchronizer Token Pattern) or cookie (Double Submit Cookies) */
	protected $_mode = 'session';
	/** Random Hash for Cross Site Request Forgery Protection Cookie */
	protected $_data;
	protected $_hash = '';
	protected $_hash_first_set = false;
	/** Token name for Cross Site Request Forgery Protection Cookie */
	protected $_token_name = 'ci_csrf_token';
	/** Cookie name for Cross Site Request Forgery Protection Cookie */
	protected $_cookie_prefix = '';
	protected $_cookie_path = '/';
	protected $_cookie_domain = '';
	protected $_cookie_secure = false;
    protected $_secret_key = 'Zugu$!V&jUKe76Ch';// Your secret key for handshake
	/** Expiration time for Cross Site Request Forgery Protection Cookie, Defaults to two hours (in seconds) */
	protected $_ttl = 7200;

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
		$default_params = array(
			'auto_verify' => true,
		);
		$params = array_merge($default_params, $params);
		//extract($params);
		
		/*
		// Make the timezone consistent on the server and audience location
		if ( 
			function_exists('date_default_timezone_set') && 
			function_exists('date_default_timezone_get') 
			//&& @date_default_timezone_get() != 'America/New_York'
		)
		{
			//@date_default_timezone_set(@date_default_timezone_get());
			@date_default_timezone_set('UTC');
		}
		*/
		
		// Cookie
		if ( $this->_mode != 'session' )
		{
			// Append application specific cookie prefix
			if ( function_exists('get_instance') )
			{
				$this->_cookie_prefix = config_item('cookie_prefix');
				$this->_cookie_secure = config_item('cookie_secure');
				$this->_cookie_path = config_item('cookie_path');
				$this->_cookie_domain = config_item('cookie_domain');
			}
			
			$this->_token_name = $this->_cookie_prefix . $this->_token_name;
		}
		else
		{
			// Start the standalone PHP session
			if ( ! function_exists('get_instance') && ! session_id() )
			{
				session_start();
			}
		}
		
		// Populate token data
		$this->get_token();
		
		// If not a POST request or no data submitted, create/refresh the token
		if ( empty($_POST) || strtoupper($_SERVER['REQUEST_METHOD']) !== 'POST' )
		{
			$this->create_token();
		}
		// Otherwise verify the token
		elseif ( $params['auto_verify'] )
		{
			$this->verify();
		}
		
		if ( function_exists('log_message') )
		{
			log_message('debug', __CLASS__ . ' class initialized.');
		}
	}

	// --------------------------------------------------------------------

	/**
	* 
	*/
	public function create_token ( $refresh = true )
	{
		// Reusing the hash avoids conflicts with AJAX and nested pages using the same hash
		// If hash is not already locally set, create a new one
		if ( ! $this->_hash || ! $refresh )
		{
			$this->_hash = $this->create_hash();
		}
		
		$this->_data = array(
			'date' => time(),
			'hash' => $this->_hash,
		);
		
		// Session
		if ( $this->_mode == 'session' )
		{
			// Set the CSRF hash
			if ( function_exists('get_instance') )
			{
				$CI =& get_instance();
				$CI->load->library('session');
				$CI->session->set_userdata($this->_token_name, $this->_data);
			}
			else
			{
				$_SESSION[$this->_token_name] = serialize($this->_data);
			}
		}
		// Cookie
		else
		{
			$max_expiration_date = time() + $this->_ttl;
			$secure_cookie = $this->_cookie_secure ? 1 : 0;

			if ( $secure_cookie )
			{
				$https = isset($_SERVER['HTTPS']) ? $_SERVER['HTTPS'] : false;

				if ( ! $https || $https == 'off' )
				{
					return false;
				}
			}

			// Set the CSRF hash
			setcookie($this->_token_name, $this->encode(serialize($this->_data)), $max_expiration_date, $this->_cookie_path, $this->_cookie_domain, $secure_cookie);
			//$_COOKIE[$this->_token_name] = serialize($this->_data);
		}
	}

	// --------------------------------------------------------------------

	/**
	* 
	*/
	public function delete_token ( $delete_local = false )
	{
		if ( $delete_local )
		{
			$this->_hash = '';
			$this->_data = null;
		}
		
		// Session
		if ( $this->_mode == 'session' )
		{
			if ( function_exists('get_instance') )
			{
				$CI =& get_instance();
				$CI->load->library('session');
				$CI->session->unset_userdata($this->_token_name);
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
	public function get_token ()
	{
		// If data already set, use it
		if ( $this->_data )
		{
			return $this->_data;
		}
		
		// Session
		if ( $this->_mode == 'session' )
		{
			// Set the CSRF hash
			if ( function_exists('get_instance') )
			{
				$CI =& get_instance();
				$CI->load->library('session');
				$this->_data = $CI->session->userdata($this->_token_name);
				$this->_hash = ! empty($this->_data['hash']) ? $this->_data['hash'] : '';
			}
			else
			{
				if ( ! empty($_SESSION[$this->_token_name]) )
				{
					$this->_data = unserialize($_SESSION[$this->_token_name]);
					$this->_hash = $this->_data['hash'];
				}
			}
		}
		// Cookie
		else
		{
			if ( ! empty($_COOKIE[$this->_token_name]) )
			{
				$this->_data = unserialize($this->decode($_COOKIE[$this->_token_name]));
				$this->_hash = $this->_data ? $this->_data['hash'] : '';
			}
		}
		
		return $this->_data;
	}

	// --------------------------------------------------------------------

	/**
	* 
	*/
	public function verify ( $show_error = true, $delete_token = true, $delete_local = false )
	{
		// Check if data set
		if ( ! $this->_data )
		{
			return $this->show_error($show_error);
		}
		
		// If the token was not submitted, stop
		if ( empty($_POST[$this->_token_name]) )
		{
			return $this->show_error($show_error);
		}
		
		// Check token Time To Live
		// Cookie date is really trivial because the cookie itself has an expiration date
		$min_expiration_date = time() - $this->_ttl;
		if ( $this->_data['date'] < $min_expiration_date )
		{
			return $this->show_error($show_error);
		}
		
		// Check hash characters
		if ( preg_match('/^[0-9a-f]{32}$/iS', $this->_data['hash']) === false )
		{
			return $this->show_error($show_error);
		}
		
		// Check matching hashes
		if ( $_POST[$this->_token_name] != $this->_data['hash'] )
		{
			return $this->show_error($show_error);
		}
		
		// Delete used token and create a new one
		if ( $delete_token )
		{
			$this->delete_token($delete_local);
			$this->create_token();
		}
		
		return $this;
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
	public function get_hash ()
	{
		return $this->_hash;
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
	public function get_form_field ()
	{
		return '<input type="hidden" name="' . $this->get_token_name() . '" value="' . $this->get_hash() . '" autocomplete="off" />' . "\n";//sprintf("<div style=\"display:none\">%s</div>", $form_field);
	}

	// --------------------------------------------------------------------

	/**
	* 
	*/
	public function show_error ( $show_error = true )
	{
		if ( $show_error )
		{
			if ( function_exists('get_instance') )
			{
				show_error('The action you have requested is not allowed.');
			}
			else
			{
				die('The action you have requested is not allowed.');
			}
		}
		
		return false;
	}

	// --------------------------------------------------------------------
	
	// Cookie encryption methods
	
	// --------------------------------------------------------------------
	
    public function safe_b64encode ($string)
	{
        $data = base64_encode($string);
        $data = str_replace(array('+','/','='), array('-','_',''), $data);
        return $data;
    }

	// --------------------------------------------------------------------
	
    public function safe_b64decode ($string)
	{
        $data = str_replace(array('-','_'), array('+','/'), $string);
        $mod4 = strlen($data) % 4;
        if ( $mod4 )
		{
            $data .= substr('====', $mod4);
        }
        return base64_decode($data);
    }

	// --------------------------------------------------------------------
	
    public function encode ( $value, $key = null )
	{
        if ( ! $value )
		{
			return false;
		}
		
		if ( ! isset($key) )
		{
			$key = $this->_secret_key;
		}
		
		// Encrypt
        $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC);
        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        $encrypted_text = mcrypt_encrypt(
			MCRYPT_RIJNDAEL_256,
			md5($key),// MD5 the key to improve variance
			$value,
			MCRYPT_MODE_CBC,
			$iv
		);
		
		// Encode
		// Prefix the encrypted text with the IV for later decryption
		$encoded_text = $this->safe_b64encode($iv . $encrypted_text);
		
        return trim($encoded_text); 
    }

	// --------------------------------------------------------------------
	
    public function decode ( $value, $key = null )
	{
        if ( ! $value )
		{
			return false;
		}
		
		if ( ! isset($key) )
		{
			$key = $this->_secret_key;
		}
		
		// Decode
        $encrypted_text = $this->safe_b64decode($value);
		
		// Decrypt
        $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC);
        $iv = substr($encrypted_text, 0, $iv_size);
		$encrypted_text = substr($encrypted_text, $iv_size);
        $decrypted_text = mcrypt_decrypt(
			MCRYPT_RIJNDAEL_256,
			md5($key),// MD5 the key to improve variance
			$encrypted_text,
			MCRYPT_MODE_CBC,
			$iv
		);
		
        return trim($decrypted_text);
    }
	
	// --------------------------------------------------------------------
	
}

