<?php
/**
* Work with MySQLi databases
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

// Create an instance of the Database class
include_once('php/classes/Database_mysqli.php');
$DB = new Database_mysqli('default');

Or

include_once('config/database.php');
include_once('php/classes/Database_mysqli.php');
$DB = new Database_mysqli($config['database']);

// --------------------------------------------------------------------
// Include the database class via a single config file like database.php
include_once('php/classes/Database_mysqli.php');

if ( ENVIRONMENT == 'development' )
{
	$db_config = array(
		'host' => 'localhost',
		'username' => 'root',
		'password' => '',
		'database' => 'ftc_demo',
	);
}
elseif ( ENVIRONMENT == 'testing' )
{
	$db_config = array(
		'host' => '',
		'username' => '',
		'password' => '',
		'database' => '',
	);
}
elseif ( ENVIRONMENT == 'production' )
{
	$db_config = array(
		'host' => '',
		'username' => '',
		'password' => '',
		'database' => '',
	);
}

// Create an instance of the Database class
$DB = new Database($db_config);
// --------------------------------------------------------------------

// Or

// --------------------------------------------------------------------
// Include the database class
include_once('php/classes/Database_mysqli.php');

// Create an instance of the Database class
$db_config = array(
	'host' => 'localhost',
	'username' => 'root',
	'password' => '',
	'database' => '',
);
$DB = new Database($db_config);
// --------------------------------------------------------------------

// Loop over results
$result = $DB->query('SELECT * FROM table');
if ( $result )
{
	while ( $row = $DB->fetch() )
	{
		$row = (object)$row;
		echo $row->id;
	}
}

* 
*/
class Database_mysqli// extends OtherClass
{
	// --------------------------------------------------------------------
	// Public properties
	// --------------------------------------------------------------------
	
	// MySQL server
	public $host = 'localhost';
	public $user = '';
	public $password = '';
	public $database = '';
	public $port = 3306;
	public $charset = 'utf8';
	public $collation = 'utf8_general_ci';
	public $persistent = false;

	// Query metadata
	public $link = 0;// Result of mysql_connect()
	public $last_query;
	public $num_queries = 0;

	// Error state of query
	public $errno = 0;
	public $error = '';

	// --------------------------------------------------------------------
	// Public methods
	// --------------------------------------------------------------------
	
	/**
	* Class constructor
	*/
	public function __construct( $params = array() )
	{
		if ( $params === 'default' )
		{
			$config_file = dirname(__FILE__) . '/../../config/database.php';
			if ( file_exists($config_file) )
			{
				require($config_file);
				$params = $config['database'];
			}
		}
		
		if ( ! empty($params) )
		{
			return $this->configure($params);
		}
	}

	// --------------------------------------------------------------------

	/** 
	* Class desctructor
	*/
	public function __destruct()
	{
		// Close database connection
		$this->close();
	}

	// --------------------------------------------------------------------

	// http://www.micahcarrick.com/php5-mysql-database-class.html
	// http://scriptperfect.com/2009/09/php-database-class-the-right-way/
	// https://github.com/Quixotix/PHP-MySQL-Database-Class/blob/master/mysqldatabase.php
	/** 
	* 
	*/
	public function configure( $params = array() )
	{
		// Set default values for missing keys
		$default_params = array(
			'host' => 'localhost',
			'username' => 'root',
			'password' => '',
			'new_link' => false,
			'client_flags' => 0,
			
			'charset' => 'utf8',
			'collation' => 'utf8_general_ci',
			'persistent' => false,
			
			'database' => '',
			
			'connect' => true,
		);
		$params = array_merge($default_params, $params);
		
		// Enforce only default params and object properties being set
		foreach ( $params as $key => $value )
		{
			if ( ! array_key_exists($key, $default_params) && ! property_exists(__CLASS__, $key) )
			{
				unset($params[$key]);
			}
		}
		
		// Bring param variables into local
		//extract($params);
		
		// Put params in class variables
		foreach ( $params as $key => $value )
		{
			$this->{$key} = $value;
		}
		
		// Init
		if ( $this->connect )
		{
			$this->link = $this->connect($params);
		}
		
		return true;
	}

	// --------------------------------------------------------------------

	/** 
	* 
	*/
	public function connect( $params = array() )
	{
		// Set default values for missing keys
		$default_params = array(
			'host' => 'localhost',
			'username' => 'root',
			'password' => '',
			'database' => '',
			'port' => 3306,
			'socket' => '',
			
			'charset' => 'utf8',
			'collation' => 'utf8_general_ci',
			'persistent' => false,
		);
		$params = array_merge($default_params, $params);
		
		extract($params);
		
		// To open a persistent connection you must prepend p: to the hostname when connecting. 
		if ( $persistent && strpos($host, 'p:') !== 0 )
		{
			$host = 'p:' . $host;
		}
		
		$link = @mysqli_connect($host, $username, $password, $database, $port, $socket);

		if ( ! $link )
		{
			$this->error('Unable to connect to database');
		}
		
		// Change the character set
		if ( $link->set_charset($charset) )
		{
			$link->query("SET collation_connection = '" . $collation . "';");
		}

		return $link;
	}

	// --------------------------------------------------------------------

	/** 
	* 
	*/
	public function get_link( $link = null )
	{
		if ( ! $link )
		{
			$link = $this->link;
		}
		
		if ( ! $link )
		{
			return false;
		}
		
		return $link;
	}

	// --------------------------------------------------------------------

	/** 
	* 
	*/
	public function is_connected( $link = null )
	{
		$link = $this->get_link($link);
		if ( $link )
		{
			return mysqli_ping($link);
		}
		
		return false;
	}

	// --------------------------------------------------------------------

	/** 
	* 
	*/
	public function close( $link = null )
	{
		$link = $this->get_link($link);
		if ( ! $link )
		{
			return;
		}
		
		$success = mysqli_close($link);
		$link = 0;
		return $success;
	}

	// --------------------------------------------------------------------

	/** 
	* 
	*/
	public function select_db( $database, $link = null )
	{
		$link = $this->get_link($link);
		if ( ! $link )
		{
			return false;
		}
		
		$success = mysqli_select_db($link, $database);
		
		if ( $success )
		{
			$this->database = $database;
		}
		else
		{
			$this->error('Unable to select database');
		}
		
		return $success;
	}

	// --------------------------------------------------------------------

	/** 
	* 
	*/
	public function error( $message = 'Database Error', $link = null )
	{
		$this->errno = 0;
		$this->error = '';
		
		$link = $this->get_link($link);
		if ( $link )
		{
			//$mysql_version = mysql_get_server_info($link);
			$this->errno = mysqli_errno($link);
			$this->error = mysqli_error($link);
		}
		else
		{
			$this->errno = mysqli_connect_errno();
			$this->error = mysqli_connect_error();
		}
		
		$error = '<b>' . $message . ':</b> ' . $this->error . '<br />Last query was <br />' . $this->last_query . ' <br />';
		
		//die($error);
		throw new Exception($error);
	}

	// --------------------------------------------------------------------

	// --------------------------------------------------------------------
	// 
	// Query functions
	// 
	// --------------------------------------------------------------------

	/** 
	* 
	public function query( $query, $link = null )
	{
		$link = $this->get_link($link);
		if ( ! $link )
		{
			return false;
		}
		
		$this->last_query = $query;
		$this->num_queries += 1;
		$this->result = mysqli_query($link, $query);
		
		if ( ! $this->result )
		{
			return false;
		}
		
		return $this->result;
	}
	*/

	// --------------------------------------------------------------------

	/** 
	* 
	*/
	public function query( $query, $link = null )
	{
		$link = $this->get_link($link);
		if ( ! $link )
		{
			return false;
		}
		
		$this->last_query = $query;
		$this->num_queries += 1;
		
		$result = mysqli_query($link, $query);
		
		if ( $result )
		{
			return new Database_mysqli_result( $result );
		}
		
		$this->error('Query error');
		return false;
	}

	// --------------------------------------------------------------------

	/** 
	* 
	*/
	public function insert_id( $link = null )
	{
		$link = $this->get_link($link);
		if ( ! $link )
		{
			return false;
		}
		
		return mysqli_insert_id($link);
	}

	// --------------------------------------------------------------------

	/** 
	* 
	*/
	public function affected_rows( $link = null )
	{
		$link = $this->get_link($link);
		if ( ! $link )
		{
			return false;
		}
		
		return mysqli_affected_rows($link);
	}

	// --------------------------------------------------------------------

	// --------------------------------------------------------------------
	// 
	// Sanitization functions
	// 
	// --------------------------------------------------------------------

	/** 
	* 
	*/
	public function escape( $string = '', $link = null )
	{
		if ( is_string($string) )
		{
			$string = "'" . $this->escape_string($string) . "'";
		}
		elseif ( is_bool($string) )
		{
			$string = ( $string === false ) ? 0 : 1;
		}
		elseif ( is_null($string) )
		{
			$string = 'NULL';
		}

		return $string;
	}

	// --------------------------------------------------------------------
	
	/** 
	* 
	*/
	public function escape_string( $string = '', $link = null )
	{
		$link = $this->get_link($link);
		
		if ( $link && function_exists('mysqli_real_escape_string') )
		{
			$string = mysqli_real_escape_string($link, $string);
		}
		else
		{
			$string = addslashes($string);
		}
		
		return $string;
	}

	// --------------------------------------------------------------------

	/** 
	* 
	*/
	public function escape_like( $string = '', $link = null )
	{
		$string = $this->escape_string($string, $link);
		// Add slashes to escape the qualifiers % and _
		$string = addcslashes($string, '%_');
		return $string;
	}

	// --------------------------------------------------------------------

	/** 
	* 
	*/
	public function clean_input( $string = '' )
	{
		$string = stripslashes($string);
		$string = str_replace(
			array('<','>','"',"'","\n"),
			array('&lt;','&gt;','&quot;','&#39;','<br />'),
			$string
		);
		return $string;
	}

	// --------------------------------------------------------------------

	/** 
	* 
	*/
	public function protect_identifiers ( $string = '', $separator = '`' )
	{
		if ( strpos($separator, $string) === false )
		{
			$string = $separator . $string . $separator;
		}
		
		return $string;
	}

	// --------------------------------------------------------------------
	
	// --------------------------------------------------------------------
	// 
	// Query building functions
	// 
	// --------------------------------------------------------------------

	/** 
	* 
	
		enabled = 1
		AND
		(
			published > 0 AND published > NOW()
		)
		
		$sql_data = array(
			'enabled' => 1,
			array(
				'AND' => array(
					'AND' => array(
						'published_start >' => 0,
						'published_start <= NOW()' => false,
					),
					'OR' => array(
						'published_stop' => 0,
						'published_stop > NOW()' => false,
					),
				),
			),
		);
		echo $DB->sql_from_field_value_data($sql_data, 'AND');
		
	* 
	*/
	public function sql_from_field_value_data ( $data = array(), $type = 'AND' )
	{
		$sql_array = array();
		
		foreach ( $data as $field => $value )
		{
			if ( is_array($value) )
			{
				if ( isset($value['AND']) || isset($value['OR']) )
				{
					$and_or = isset($value['OR']) ? 'OR' : 'AND';
					$sql = '(';
					$sql .= $this->sql_from_field_value_data($value[$and_or], $and_or);
					$sql .= ')';
					$sql_array[] = $sql;
					continue;
				}
				elseif ( in_array($field, array('AND', 'OR')) )
				{
					$type = $field;
				}
				
				$sql = '(';
				$sql_nested_array = array();
				foreach ( $value as $nested_field => $nested_value )
				{
					$sql_nested_array[] = $this->sql_from_field_value($nested_field, $nested_value);
				}
				$sql .= implode(' ' . $type . ' ', $sql_nested_array);
				$sql .= ')';
				$sql_array[] = $sql;
			}
			else
			{
				$sql_array[] = $this->sql_from_field_value($field, $value);
			}
			/*
			if ( $field === 'AND' )
			{
				$sql .= '(';
				// Process field and value
				$sql .=  $this->sql_from_field_value($field, $value);
				$sql .= ')';
			}
			else
			{
				$sql .= ' AND ' . $this->sql_from_field_value($field, $value);
			}
			*/
		}
		
		$sql = implode(' ' . $type . ' ', $sql_array);
		return $sql;
	}
	
	// --------------------------------------------------------------------

	/** 
	* 
	
		$sql_data = array(
			'test1' => 1,
			'test2 >' => 0,
			't_3.test3' => 1,
			't_4.test4 >=' => 1,
			'AVERAGE(`monkeys`) >=' => 1,
			'CONCAT("David", "Goliath")' => false,
			'CONCAT("Jonah", " and the ", "Whale")' => true,
			'CONCAT(t_1.field_1, t_2.field_2) =' => 'Monkeys',
			't_1.field IS NOT NULL' => false,
		);
		// Create SQL from field and value
		foreach ( $sql_data as $field => $value )
		{
			$sql = $DB->sql_from_field_value($field, $value);
			
			echo "'{$sql}'<br>";
		}
		
	* 
	*/
	public function sql_from_field_value ( $field, $value = false )
	{
		$escape_field = true;
		
		// Check for comparison at the end of the field name: 'table_alias.field_name >=' => 3
		$compare_type_whitelist = array('=', '>', '>=', '<', '<=', '!=');
		$compare_type = is_bool($value) ? false : '=';//trim(strrchr($field, ' '));
		$compare_type_end = strrpos($field, ' ');
		if ( $compare_type_end !== false )
		{
			$tmp_field = substr($field, 0, $compare_type_end);
			$tmp_compare_type = substr($field, $compare_type_end + 1);
			// Validate compare type
			if ( in_array($tmp_compare_type, $compare_type_whitelist) )
			{
				$field = $tmp_field;//substr($field, 0, strrpos($field, ' '));
				$compare_type = $tmp_compare_type;
			}
			// Must not be a field name or known comparison so do not escape
			else
			{
				$escape_field = false;
			}
		}
		
		// Do not escape a field name with special characters
		if ( strpos($field, '(') !== false )
		{
			$escape_field = false;
		}
		
		// Override escape based on value
		if ( is_bool($value) )
		{
			$escape_field = (bool)$value;
		}
		
		// If escaping the field
		if ( $escape_field )
		{
			// Check for a single aliased field: 'table_alias.field_name' => 1
			$table_alias = '';
			$table_alias_begin = strpos($field, '.');
			$table_alias_end = strrpos($field, '.');
			if ( $table_alias_begin !== false && $table_alias_begin === $table_alias_end )
			{
				$table_alias = substr($field, 0, $table_alias_begin);
				$field = substr($field, $table_alias_begin + 1);
			}
			
			// Escape the field and alias
			$field = ( $table_alias !== '' ? $this->protect_identifiers($table_alias) . '.' : '' ) . $this->protect_identifiers($field);
		}
		
		$sql = $field . ( $compare_type === false ? '' : ' ' . $compare_type . ' ' ) . ( is_bool($value) ? '' : $this->escape($value) );
		return $sql;
	}
	
	// --------------------------------------------------------------------

	// --------------------------------------------------------------------
	// 
	// Utility functions
	// 
	// --------------------------------------------------------------------

	/** 
	* 
	*/
	public function result_to_array( $result = null )
	{
		// If string, use as sql
		if ( is_string($result) )
		{
			$result = $this->query($result);
		}
		
		// Loop over results
		$data = array();
		if ( $result && $result->num_rows() > 0 )
		{
			while ( $row = $result->fetch() )
			{
				$data[] = $row;
			}
			$result->free_result();
			unset($row, $result);
		}
		
		return $data;
	}

	// --------------------------------------------------------------------

	/** 
	* 
	*/
	public function result_to_csv( $result = null, $delim = ',', $newline = "\r\n", $enclosure = '"' )
	{
		$data = '';
		
		// First generate the headings from the table column names
		$fields = mysqli_fetch_fields($result);
		foreach ( $fields as $field )
		{
			$data .= $enclosure . str_replace($enclosure, $enclosure . $enclosure, $field->name) . $enclosure . $delim;
		}
		$data = rtrim($data, $delim) . $newline;
		
		mysqli_data_seek($result, 0);
		
		// Next blast through the result array and build out the rows
		while ( $row = mysqli_fetch_assoc($result) )
		{
			foreach ( $row as $item )
			{
				$data .= $enclosure . str_replace($enclosure, $enclosure . $enclosure, $item) . $enclosure . $delim;
			}
			$data = rtrim($data, $delim) . $newline;
		}
		
		return $data;
	}

	// --------------------------------------------------------------------

	/** 
	* http://stackoverflow.com/questions/4249432/export-to-csv-via-php
	*/
	function array2csv(array & $array)
	{
		if ( empty($array) )
		{
			return null;
		}
		
		ob_start();
		$df = fopen('php://output', 'w');
		fputcsv($df, array_keys(reset($array)));
		
		foreach ( $array as $row )
		{
			fputcsv($df, $row);
		}
		
		fclose($df);
		
		return ob_get_clean();
	}

	// --------------------------------------------------------------------

	/** 
	* 
	*/
	public function download_csv( $data, $filename = '' )
	{
		if ( $filename == '' )
		{
			$filename = 'my-file_' . date('Ymd-His') . '.csv';
		}
		
		$mime = 'application/octet-stream';

		// Generate the server headers
		if ( strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== FALSE )
		{
			header('Content-Type: "' . $mime . '"');
			header('Content-Disposition: attachment; filename="' . $filename . '"');
			header('Expires: 0');
			header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
			header("Content-Transfer-Encoding: binary");
			header('Pragma: public');
			header("Content-Length: " . strlen($data));
		}
		else
		{
			header('Content-Type: "' . $mime . '"');
			header('Content-Disposition: attachment; filename="' . $filename . '"');
			header("Content-Transfer-Encoding: binary");
			header('Expires: 0');
			header('Pragma: no-cache');
			header("Content-Length: " . strlen($data));
		}

		exit($data);
	}

	// --------------------------------------------------------------------

}//end class

class Database_mysqli_result
{
	/** Class properties */
	public $result = 0;// Result of most recent mysql_query()
	public $results;
	public $record = array();// Current mysql_fetch_assoc() result
	public $row = 0;// Current row number
	
	// --------------------------------------------------------------------

	/** 
	* 
	*/
	public function __construct( $result )
	{
		if ( ! $result )
		{
			return false;
		}
		
		$this->result = $result;
		return $this;
	}

	// --------------------------------------------------------------------

	/** 
	* 
	public function __call( $method, $args )
	{
		if ( method_exists($this, $method) )
		{
			array_unshift($args, $this->result);
			return call_user_func_array(array($this, $method), $args);
		}
		
		throw new Exception("The method {$method} does not exist.");
	}
	*/

	// --------------------------------------------------------------------

	/** 
	* 
	*/
	public function num_rows()
	{
		return mysqli_num_rows($this->result);
	}

	// --------------------------------------------------------------------

	/** 
	* 
	*/
	public function fetch_fields()
	{
		return mysqli_fetch_fields($this->result);
	}

	// --------------------------------------------------------------------

	/** 
	* 
	*/
	public function free_result()
	{
		return mysqli_free_result($this->result);
	}

	// --------------------------------------------------------------------

	/** 
	* 
	*/
	public function fetch( $increment = 1 )
	{
		$this->row += $increment;
		$this->record = mysqli_fetch_object($this->result);
		return $this->record;
	}

	// --------------------------------------------------------------------

	/** 
	* 
	*/
	public function fetch_array()
	{
		$args = func_get_args();
		$record = call_user_func_array(array($this, 'fetch'), $args);
		
		if ( $record )
		{
			return (array)$record;
		}
		
		return $record;
	}

	// --------------------------------------------------------------------

	/** 
	* 
	*/
	public function result()
	{
		if ( $this->results )
		{
			return $this->results;
		}
		
		$this->reset();
		$this->results = array();
		while ( $row = $this->fetch() )
		{
			$this->results[] = $row;
		}
		return $this->results;
	}

	// --------------------------------------------------------------------

	/** 
	* 
	*/
	public function result_array()
	{
		if ( $this->results )
		{
			// http://stackoverflow.com/questions/2476876/how-do-i-convert-an-object-to-an-array
			return json_decode(json_encode($this->results), true);;
		}
	}

	// --------------------------------------------------------------------

	/** 
	* 
	*/
	public function row( $row = 0 )
	{
		mysqli_data_seek($this->result, $row);
		$this->record = $this->fetch(0);
		mysqli_data_seek($this->result, $this->row);
		return $this->record;
	}

	// --------------------------------------------------------------------

	/** 
	* 
	*/
	public function row_array()
	{
		$args = func_get_args();
		$record = call_user_func_array(array($this, 'row'), $args);
		
		if ( $record )
		{
			return (array)$record;
		}
		
		return $record;
	}

	// --------------------------------------------------------------------

	/** 
	* 
	*/
	public function reset()
	{
		$this->row = 0;
		return mysqli_data_seek($this->result, 0);
	}

	// --------------------------------------------------------------------

}

// --------------------------------------------------------------------

