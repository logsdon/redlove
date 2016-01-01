<?php
/**
* Work with FTP connection and files
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

// Include the class
include('FTPClient.php');

$ftp_params = array(
	'host' => 'example.com',
	'username' => '',
	'password' => '',
	'time_limit' => 600,
);

// Create the FTP object
$FTPClient = new FTPClient();

// Connect
if ( $FTPClient->connect($ftp_params) )
{

	// --------------------------------------------------------------------

	$dir = 'httpdocs/photos';		

	// Make directory
	$FTPClient->make_dir($dir);

	print_r($FTPClient -> get_messages());

	// --------------------------------------------------------------------

	$file_from = 'zoe.jpg';				
	$file_to = $dir . '/' . $file_from;

	// Upload local file to new directory on server
	$FTPClient -> upload_file($file_from, $file_to);

	print_r($FTPClient -> get_messages());

	// --------------------------------------------------------------------

	// Change to folder
	$FTPClient->change_dir($dir);

	// Get folder contents
	$contents_array = $FTPClient->get_dir_listing();

	// Output our array of folder contents
	echo '<pre>';
	print_r($contents_array);
	echo '</pre>';

	// --------------------------------------------------------------------

	$file_from = 'zoe.jpg';		# The location on the server
	$file_to = 'zoe-new.jpg';			# Local dir to save to

	// Download file
	$FTPClient->download_file($file_from, $file_to);

	// --------------------------------------------------------------------

}

* 
*/
class FTPClient// extends OtherClass
{
	// --------------------------------------------------------------------
	// Private properties
	// --------------------------------------------------------------------
	
	/**
	* Connection id
	* 
	* @var int
	*/
	private $connection_id;
	
	/**
	* Whether logged in
	* 
	* @var bool
	*/
	private $logged_in = false;
	
	/**
	* Messages
	* 
	* @var array
	*/
	private $messages = array();

	// --------------------------------------------------------------------
	// Public methods
	// --------------------------------------------------------------------
	
	/**
	* Class constructor
	*/
	public function __construct ()
	{
		//parent::__construct();//__CLASS__
	}

	// --------------------------------------------------------------------

	/** 
	* 
	*/
	public function connect ( $params = array() )
	{
		// Set default values for missing keys
		$default_params = array(
			'host' => '',
			'port' => 21,
			'timeout' => 90,
			
			'username' => '',
			'password' => '',
			
			'is_passive' => true,
			
			'time_limit' => '',
		);
		$params = array_merge($default_params, $params);
		
		extract($params);
		
		if ( $time_limit )
		{
			set_time_limit($time_limit);
		}

		// Set up basic connection
		$this->connection_id = ftp_connect($host, $port, $timeout);

		// Check connection
		if ( ! $this->connection_id )
		{
			$this->log('FTP connection failed to ' . $host . ' for user ' . $username);
			return false;
		}

		// Login with username and password
		$login = @ ftp_login($this->connection_id, $username, $password);

		// Check logged in
		if ( ! $login )
		{
			$this->log('FTP login failed to ' . $host . ' for user ' . $username);
			return false;
		}
		else
		{
			// Sets passive mode on/off (default off)
			ftp_pasv($this->connection_id, $is_passive);
			
			$this->log('Connected to ' . $host . ' for user ' . $username);
			$this->logged_in = true;
			return true;
		}
	}

	// --------------------------------------------------------------------

	/** 
	* 
	*/
	public function upload_file ( $file_from, $file_to )
	{
		// Set the transfer mode
		$ascii_array = array('txt', 'csv');
		$extension = end(explode('.', $file_from));
		if ( in_array($extension, $ascii_array) )
		{
			$mode = FTP_ASCII;		
		}
		else
		{
			$mode = FTP_BINARY;
		}

		// Upload the file
		$upload = ftp_put($this->connection_id, $file_to, $file_from, $mode);

		// Check upload status
		if ( ! $upload )
		{
			$this->log('FTP upload has failed!');
			return false;
		}
		else
		{
			$this->log('Uploaded "' . $file_from . '" as "' . $file_to);
			return true;
		}
	}

	// --------------------------------------------------------------------

	/** 
	* 
	*/
	public function download_file ( $file_from, $file_to )
	{
		// Set the transfer mode
		$ascii_array = array('txt', 'csv');
		$extension = end(explode('.', $file_from));
		if ( in_array($extension, $ascii_array) )
		{
			$mode = FTP_ASCII;		
		}
		else
		{
			$mode = FTP_BINARY;
		}

		// Open some file to write to
		//$handle = fopen($file_to, 'w');

		// Try to download $remote_file and save it to $handle
		if ( ftp_get($this->connection_id, $file_to, $file_from, $mode, 0) )
		{
			$this->log('File "' . $file_to . '" successfully downloaded');
			return true;
		}
		else
		{
			$this->log('There was an error downloading file "' . $file_from . '" to "' . $file_to . '"');
			return false;
		}
	}

	// --------------------------------------------------------------------

	/** 
	* 
	*/
	public function delete_file ( $file_to )
	{
		// Delete the file
		$delete = ftp_delete($this->connection_id, $file_to);
		
		// Check upload status
		if ( ! $delete )
		{
			$this->log('FTP delete has failed!');
			return false;
		}
		else
		{
			$this->log('Deleted "' . $file_to . '"');
			return true;
		}
	}

	// --------------------------------------------------------------------

	/** 
	* 
	*/
	public function make_dir ( $directory )
	{
		// If creating a directory is successful...
		if ( ftp_mkdir($this->connection_id, $directory) )
		{
			$this->log('Directory "' . $directory . '" created successfully');
			return true;
		}
		else
		{
			// ...Else, FAIL.
			$this->log('Failed creating directory "' . $directory . '"');
			return false;
		}
	}

	// --------------------------------------------------------------------

	/** 
	* 
	*/
	public function change_dir ( $directory )
	{
		if ( @ ftp_chdir($this->connection_id, $directory) )
		{
			$this->log('Current directory is now: ' . ftp_pwd($this->connection_id));
			return true;
		}
		else
		{ 
			$this->log('Could not change directory');
			return false;
		}
	}

	// --------------------------------------------------------------------

	/** 
	* 
	*/
	public function get_dir_listing( $directory = '.', $parameters = '-la' )
	{
		// Get contents of the current directory
		$contents_array = ftp_nlist($this->connection_id, $parameters . ' ' . $directory);
		return $contents_array;
	}

	// --------------------------------------------------------------------

	/** 
	* 
	*/
	public function close () 
	{
		if ( $this->connection_id )
		{
			ftp_close($this->connection_id);
		}
	}

	// --------------------------------------------------------------------

	/** 
	* 
	*/
	private function log ( $message, $clear = false ) 
	{
		if ( $clear )
		{
			$this->messages = array();
		}

		$this->messages[] = $message;
	}

	// --------------------------------------------------------------------

	/** 
	* 
	*/
	public function get_messages ()
	{
		return $this->messages;
	}

	// --------------------------------------------------------------------

	/** 
	* 
	*/
	public function __destruct ()
	{
		//parent::__destruct();
		$this->close();
	}

	// --------------------------------------------------------------------

}

// --------------------------------------------------------------------

class FTPClientException extends Exception
{
}

