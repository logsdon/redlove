<?php
/**
* Work with Net-Results API
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
* http://support.net-results.com/index.php/Marketing_Automation_API
* 
* Usage: 
* 

require_once('Net_results_api.php');
$API = Net_results_api::get_instance('EmailList');
$response = $API->getMultiple(0, 10, 'email_list_name', 'ASC');
var_dump($response);
$response = $API->getOne(array('list_id' => 220996));
var_dump($response);

$API = Net_results_api::get_instance();
$response = $API->call('EmailList', 'getMultiple', array(0, 10, 'email_list_name', 'ASC'));
var_dump($response);

* 
*/
class Net_results_api
{
	// --------------------------------------------------------------------
	// Private properties
	// --------------------------------------------------------------------
	
	/**
	* RPC client
	* 
	* @var object
	*/
	private $RPC_CLIENT;
	
	/**
	* The Net-Results Controller method
	* 
	* @var string
	*/
	private $controller = '';
	
	/**
	* Static class instance
	* 
	* @var object
	*/
	private static $instance;
	
	/**
	* API authentication credentials
	* 
	* @var array
	*/
	private $rpc_auth = array(
		'type' => 'basic',
		'username' => '',
		'password' => '',
	);
	
	/**
	* API endpoint
	* 
	* @var string
	*/
	private $url_prefix = 'https://apps.net-results.com/api/v2/rpc/server.php?Controller=';
	
	// --------------------------------------------------------------------
	// Public methods
	// --------------------------------------------------------------------
	
	/**
	* Class constructor
	*/
	public function __construct ()
	{
		$config_file = dirname(__FILE__) . '/../../config/net-results.php';
		if ( file_exists($config_file) )
		{
			require($config_file);
			$this->rpc_auth['username'] = $config['net-results']['username'];
			$this->rpc_auth['password'] = $config['net-results']['password'];
		}
		
		require_once('Json_rpc_client.php');
		$this->RPC_CLIENT = new Json_rpc_client($this->url_prefix . $this->controller, $this->rpc_auth);
	}
	
	// --------------------------------------------------------------------
	
	/**
	* Get single instance
	* 
	* @return object Singleton
	*/
	public static function get_instance ( $controller = null )
	{
		// Create single instance if it doesn't exist
		if ( ! self::$instance )
		{
			self::$instance = new Net_results_api();
		}
		
		// Reset url with controller
		if ( isset($controller) )
		{
			$this->controller = $controller;
			$this->RPC_CLIENT->url = $this->url_prefix . $controller;
		}
		
		return self::$instance;
	}
	
	// --------------------------------------------------------------------
	
	/**
	* Triggered when invoking inaccessible methods in an object context
	* 
	* @param string $name The object method name attempted
	* @param mixed $arguments The arguments passed
	* @return null|mixed Method response
	*/
	public function __call ( $name, $arguments )
	{
		// Check method name is scalar (not an array, object, or resource)
		if ( ! is_scalar($name) )
		{
			throw new Exception('Method name has no scalar value.');
		}
		
		// Ensure arguments are enumerated
		if ( ! is_array($arguments) )
		{
			throw new Exception('Arguments must be given as an enumerated array.');
		}
		$arguments = array_values($arguments);
		
		return call_user_func_array(array($this->RPC_CLIENT, $name), $arguments);
	}
	
	// --------------------------------------------------------------------
	
	/**
	* Helper to call Net-Results controller methods
	* 
	* @param string $controller Net-Results controller
	* @param string $method Net-Results controller method
	* @param mixed $arguments The arguments passed
	* @return null|mixed Method response
	*/
	public function call ( $controller, $method, $arguments )
	{
		// Check controller name is scalar (not an array, object, or resource)
		if ( ! is_scalar($controller) )
		{
			throw new Exception('Controller name has no scalar value.');
		}
		
		// Check method name is scalar (not an array, object, or resource)
		if ( ! is_scalar($method) )
		{
			throw new Exception('Method name has no scalar value.');
		}
		
		// Ensure arguments are enumerated
		if ( ! is_array($arguments) )
		{
			throw new Exception('Arguments must be given as an enumerated array.');
		}
		$arguments = array_values($arguments);
		
		// Reset url with controller
		$this->RPC_CLIENT->url = $this->url_prefix . $controller;
		
		return call_user_func_array(array($this->RPC_CLIENT, $method), $arguments);
	}
	
	// --------------------------------------------------------------------
	
}

// --------------------------------------------------------------------

