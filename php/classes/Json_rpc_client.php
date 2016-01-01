<?php
/**
* JSON RPC Client
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
* https://en.wikipedia.org/wiki/JSON-RPC#Implementations
* https://bitbucket.org/jbg/php-json-rpc/src/ab865aa9bc28?at=default
* https://github.com/subutux/json-rpc2php/blob/master/jsonRPC2Client.php
* http://www.jsonrpcphp.org/code.php?file=jsonRPCClient
* http://www.jsonrpc.org/specification
* 
* Usage: 
* 

require_once('Json_rpc_client.php');
$rpc_auth = array(
	'type' => 'basic',
	'username' => 'user@mail.com',
	'password' => 'mypassword',
);
$RPC = new Json_rpc_client('https://example.com/server-url', $rpc_auth);
$response = $RPC->getMultiple(0, 10, 'list_name', 'ASC');
var_dump($response);
$response = $RPC->getOne(array('list_id' => 123456));
var_dump($response);

* 
*/
class Json_rpc_client
{
	// --------------------------------------------------------------------
	// Public properties
	// --------------------------------------------------------------------
	
	/**
	* Additional method name prefix when sending request
	* 
	* @var string
	*/
	public $class;
	
	/**
	* Possible error map
	* 
	* @var array
	*/
	public $error_map = array(
		'PARSE_ERROR' => -32700,
		'INVALID_REQUEST' => -32600,
		'METHOD_NOT_FOUND' => -32601,
		'INVALID_PARAMS' => -32602,
		'INTERNAL_ERROR' => -32603,
		'SERVER_ERROR' => -32000,
	);
	
	/**
	* Authentication type
	* 
	* @var string
	*/
	public $rpc_version = '2.0';
	
	/**
	* Request url
	* 
	* @var string
	*/
	public $url;
	
	// --------------------------------------------------------------------
	// Private properties
	// --------------------------------------------------------------------
	
	/**
	* Authentication username and password array
	* 
	* @var array
	*/
	private $auth;
	
	/**
	* Authentication type
	* 
	* @var string
	*/
	private $auth_type = 'rpc';
	
	/**
	* Whether to increment the id to keep track of batch requests
	* 
	* @var string
	*/
	private $increment_id = false;
	
	/**
	* The request id
	* 
	* @var string
	*/
	private $id;
	
	// --------------------------------------------------------------------
	// Public methods
	// --------------------------------------------------------------------
	
	/**
	* Class constructor
	* 
	* @param mixed $params An array of parameters or list of arguments
	*/
	public function __construct ( $params = '' )
	{
		// Get arguments
		$args = func_get_args();
		$num_args = count($args);
		//$args0 = ( isset($args[0]) ? $args[0] : null );
		
		// Check for alternate argument patterns
		if ( is_string($params) && $num_args == 1 )
		{
			$params = array(
				'url' => ( isset($args[0]) ? $args[0] : null ),
			);
		}
		elseif ( $num_args > 1 )
		{
			$params = array(
				'url' => ( isset($args[0]) ? $args[0] : null ),
				'auth' => ( isset($args[1]) ? $args[1] : null ),
			);
		}
		
		// Set default values for missing keys
		$default_params = array(
			'url' => '',
			'class' => '',
			'auth' => array(),
		);
		$params = array_merge($default_params, $params);
		
		// Put constants and codes in map
		$this->error_map = array_merge($this->error_map, array_flip($this->error_map));
		
		$this->url = $params['url'];
		$this->class = $params['class'];
		$this->auth = $params['auth'];
		$this->auth_type = isset($params['auth']['type']) ? $params['auth']['type'] : $this->auth_type;
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
		
		// Generate ID if it does not exist
		if ( ! isset($this->id) )
		{
			$this->id = 0;
			$this->id = $this->generate_id();
		}
		
		// Form JSON request
		$method = isset($this->class[0]) ? $this->class . '.' . $name : $name;
		$request = array(
			'jsonrpc' => $this->rpc_version,
			'method' => $method,
			'params' => $arguments,
			'id' => $this->id,
		);
		$encoded_request = json_encode($request);
		
		// Create request header
		$header = $this->create_header(array('Content-Length' => strlen($encoded_request)));
		
		// Using curl
		$curl = curl_init();
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 30);
		curl_setopt($curl, CURLOPT_HEADER, false);
		// Tell the remote server not to send a chunked response
		curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
		curl_setopt($curl, CURLOPT_HTTPHEADER, explode("\r\n", $header));
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $encoded_request);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 600);
		curl_setopt($curl, CURLOPT_URL, $this->url);
		$response = curl_exec($curl);
		if ( curl_errno($curl) === 0 )
		{
			curl_close($curl);
		}
		else
		{
            throw new Exception('Curl error ' . curl_errno($curl) . ': ' . curl_error($curl));
        }
		
		/*
		// OR
		// Using file reading with context
		$options = array(
			'http' => array(
				'method' => 'POST',
				'header' => $header,
				'content' => $encoded_request,
			),
		);
		$context = stream_context_create($options);
		// Using file_get_contents
		$response = file_get_contents($this->url, false, $context);
		// Using fopen
        if ( $file_handler = fopen($this->url, 'r', false, $context) )
		{
            $headers = $this->parse_eaders($http_response_header);
            if ( isset($headers['x-RPC-Auth-Session']) )
			{
                $this->auth['sessionId'] = $headers['x-RPC-Auth-Session'];
            }
            $response = '';
            while ( $row = fgets($file_handler, 4096) )
			{
                $response .= trim($row) . "\n";
            }
        }
		else
		{
            throw new Exception('Unable to connect to ' . $this->url . '.');
        }
		*/
		
		// Check for a response
		if ( $response === false )
		{
			throw new Json_rpc_fault('Invalid response.', $this->error_map['INTERNAL_ERROR']);
		}
		
		$decoded_response = json_decode($response);
		
		// Check the response format
		if ( $decoded_response === null )
		{
			throw new Json_rpc_fault('JSON cannot be decoded.', $this->error_map['INTERNAL_ERROR']);
		}
		elseif ( $decoded_response->id != $this->id )
		{
			throw new Json_rpc_fault('Mismatched JSON-RPC IDs.', $this->error_map['INTERNAL_ERROR']);
		}
		elseif ( property_exists($decoded_response, 'error') && isset($decoded_response->error) )
		{
			$data = isset($decoded_response->error->data) ? ' ' . $decoded_response->error->data : '';
			throw new Json_rpc_fault($decoded_response->error->message . $data, $decoded_response->error->code);
		}
		elseif ( ! property_exists($decoded_response, 'result') )
		{
			throw new Json_rpc_fault('Invalid JSON-RPC response.', $this->error_map['INTERNAL_ERROR']);
		}
		
		return $decoded_response->result;
	}
	
	// --------------------------------------------------------------------
	// Private methods
	// --------------------------------------------------------------------
	
	/**
	* Create request header
	* 
	* @param array $headers Headers as a key => value array
	* @return string The header string
	*/
	private function create_header ( $headers = array() )
	{
		$headers['Content-type'] = 'application/json';
		
		if ( ! empty($this->auth) )
		{
			if ( $this->auth_type == 'rpc' )
			{
				if ( isset($this->auth['sessionId']) )
				{
					$headers['X-RPC-Auth-Session'] = $this->auth['sessionId'];
				}
				else
				{
					$headers['X-RPC-Auth-Username'] = $this->auth['username'];
					$headers['X-RPC-Auth-Password'] = $this->auth['password'];
				}
			}
			elseif ( $this->auth_type == 'basic' )
			{
				$headers['Authorization'] = 'Basic ' . base64_encode($this->auth['username'] . ':' . $this->auth['password']);
			}
		}
		
		$header = '';
		foreach ( $headers as $header_key => $header_value )
		{
			$header .= $header_key . ': ' . $header_value . "\r\n";
		}
		
		return trim($header);
	}
	
	// --------------------------------------------------------------------
	
	/**
	* Generates a random id from a set of characters
	* 
	* @return string Randomly generated id
	*/
	private function generate_id ()
	{
		if ( $this->increment_id )
		{
			$this->id++;
			return $this->id;
		}
		
		$chars = array_merge(range('A', 'Z'), range('a', 'z'), range(0, 9));
		$max = count($chars) - 1;
		$id = '';
		
		for ( $c = 0; $c < 16; $c++ )
		{
			$id .= $chars[mt_rand(0, $max)];
		}
		
		return $id;
	}
	
	// --------------------------------------------------------------------
	
	/**
	* Parse response headers
	* 
	* @param array $headers Response headers
	* @return array Parsed response headers
	*/
	private function parse_headers ( $headers )
	{
		$parsed_headers = array();
		
		foreach ( $headers as $header )
		{
			$split_header = explode(':', $header, 2);
			$parsed_headers[$split_header[0]] = trim($split_header[1]);
		}
		
		return $parsed_headers;
	}
	
	// --------------------------------------------------------------------
	
}

// --------------------------------------------------------------------

class Json_rpc_fault extends Exception
{
}

// --------------------------------------------------------------------

