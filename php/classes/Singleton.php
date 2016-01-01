<?php
/**
* Singleton
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

require_once('Singleton.php');
$obj = Singleton::get_obj();
var_dump($obj);

* 
*/
class Singleton
{
	// --------------------------------------------------------------------
	// Private properties
	// --------------------------------------------------------------------
	
	/**
	* Static class instance
	* 
	* @var object
	*/
	private static $obj;
	
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
	public static function get_obj ()
	{
		// Create single instance if it doesn't exist
		if ( ! self::$obj )
		{
			self::$obj = new Singleton_obj();
		}
		
		return self::$obj;
	}
	
}

class Singleton_obj
{
}

