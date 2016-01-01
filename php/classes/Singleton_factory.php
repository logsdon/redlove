<?php
/**
* Singleton Factory
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
* http://stackoverflow.com/questions/130878/global-or-singleton-for-database-connection
* 
* Usage: 
* 

require_once('Singleton_factory.php');
$obj = Singleton_factory::get_instance()->get_obj();
var_dump($obj);
var_dump(Singleton_factory::get_instance()->public_property);

* 
*/
class Singleton_factory
{
	// --------------------------------------------------------------------
	// Public properties
	// --------------------------------------------------------------------
	
	/**
	* Test public property
	* 
	* @var string
	*/
	public $public_property = 'my-public-property';
	
	// --------------------------------------------------------------------
	// Private properties
	// --------------------------------------------------------------------
	
	/**
	* Static class instance
	* 
	* @var object
	*/
	private static $instance;
	
	/**
	* Secondary object
	* 
	* @var object
	*/
	private $obj;
	
	// --------------------------------------------------------------------
	// Public methods
	// --------------------------------------------------------------------
	
	/**
	* Class constructor
	* 
	* @param mixed $params An array of parameters or list of arguments
	*/
	public function __construct ( $params = array() )
	{
	}
	
	/**
	* Get single instance
	* 
	* @return object Singleton
	*/
	public static function get_instance ()
	{
		// Create single instance if it doesn't exist
		if ( ! self::$instance )
		{
			self::$instance = new Singleton_factory();
		}
		
		return self::$instance;
	}
	
	/**
	* Get single instance
	* 
	* @return object Singleton
	*/
	public function get_obj ()
	{
		// Create single instance if it doesn't exist
		if ( ! $this->obj )
		{
			$this->obj = new Singleton_factory_obj();
		}
		
		return $this->obj;
	}
	
}

class Singleton_factory_obj
{
}

