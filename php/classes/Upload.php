<?php
/**
* Upload helper library
*
* @package RedLove
* @subpackage PHP
* @category Classes
* @author Joshua Logsdon <joshua@joshualogsdon.com>
* @author Various from CodeIgniter to Internet
* @copyright Copyright (c) 2016, Joshua Logsdon (http://joshualogsdon.com/)
* @license http://opensource.org/licenses/MIT MIT License
* @link https://github.com/logsdon/redlove
* @link http://redlove.org
* @version 0.0.0
* 
* Resources: 
* 
* Usage: 
* 

// Upload files
require_once('Upload.php');
$UP = new Upload();
$UP->init(array(
	'allowed_types' => 'gif,jpe,jpg,jpeg,pjpeg,png,doc,docx,ppt,pptx,xls,xlsx,pdf',
	'file_name' => 'test-filename',
	'upload_path' => $selected_content_path,
));
$upload = $UP->do_upload($file_field);
var_dump( $upload );

$upload_data = $UP->data();
chmod($upload_data['full_path'], 0755);
$uploads[] = $upload_data;

* 
*/
class Upload
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
	
	public $error_code = 0;
	public $return_message = array();
	
	/**
	* Temporary filename
	*
	* @var	string
	*/
	public $file_temp = '';
	
	/**
	* Filename
	*
	* @var	string
	*/
	public $file_name = '';
	
	/**
	* Original filename
	*
	* @var	string
	*/
	public $orig_name = '';
	/**
	* File type
	*
	* @var	string
	*/
	public $file_type = '';

	/**
	* File size
	*
	* @var	int
	*/
	public $file_size = '';
	
	/**
	* Filename extension
	*
	* @var	string
	*/
	public $file_ext = '';
	
	public $image_width = '';
	public $image_height = '';
	public $image_type = '';
	public $image_size_str = '';
	public $upload_path = '';
	public $config = array(
		'max_size' => 0,
		'max_width' => 0,
		'max_height' => 0,
		'max_filename' => 0,
		'max_filename_increment' => 100,
		'allowed_types' => '*',
		'upload_path' => '',
		'overwrite' => false,
		'encrypt_name' => false,
		'file_name' => '',
		'mimes' => array(),
		'remove_spaces' => true,
		'xss_clean' => false,
	);
	
	// --------------------------------------------------------------------
	// Private properties
	// --------------------------------------------------------------------
	
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
	* @param array $params An array of parameters or list of arguments
	*/
	public function __construct ( $params = array() )
	{
		if ( ! empty($params) )
		{
			$this->init($params);
		}
	}
	
	// --------------------------------------------------------------------
	
	/**
	* Initialize preferences
	* 
	* @param array $params An array of parameters or list of arguments
	*/
	public function init ( $params = array() )
	{
		$this->config = array_merge($this->config, $params);
		
		//set_allowed_types
		if ( ! is_array($this->config['allowed_types']) )
		{
			$this->config['allowed_types'] = array_filter( array_map('trim', explode(',', $this->config['allowed_types'])) );
		}
	}
	
	// --------------------------------------------------------------------
	
	/**
	* Finalized Data Array
	*
	* Returns an associative array containing all of the information
	* related to the upload, allowing the developer easy access in one array.
	*
	* @return	array
	*/
	public function data ()
	{
		return array(
			'file_name' => $this->file_name,
			'file_type' => $this->file_type,
			'file_path' => $this->upload_path,
			'full_path' => $this->upload_path . $this->file_name,
			'raw_name' => str_replace($this->file_ext, '', $this->file_name),
			'orig_name' => $this->orig_name,
			'file_ext' => $this->file_ext,
			'file_size' => $this->file_size,
			'is_image' => $this->is_image(),
			'image_width' => $this->image_width,
			'image_height' => $this->image_height,
			'image_type' => $this->image_type,
			'image_size_str' => $this->image_size_str,
		);
	}
	
	// --------------------------------------------------------------------
	
	/**
	* Perform the file upload
	*
	* @return	bool
	*/
	public function do_upload ( $field = 'userfile' )
	{
		if ( ! $this->valid_upload_path($this->config['upload_path']) )
		{
			return false;
		}
		
		if ( ! $this->valid_upload_file($field) )
		{
			return false;
		}

		if ( $this->config['encrypt_name'] )
		{
			mt_srand();//Seed
			$this->file_name = md5(uniqid(mt_rand())) . $this->file_ext;
		}
		
		// If manually setting the filename, let's now make sure the new name and type is allowed
		if ( $this->config['file_name'] != '' )
		{
			$this->file_name = $this->_protect_extensions($this->config['file_name']);

			// If no extension was provided in the file_name config item, use the uploaded one
			if ( strpos($this->config['file_name'], '.') === false )
			{
				$this->file_name .= $this->file_ext;
			}
			// An extension was provided, lets have it!
			else
			{
				$this->file_ext = (string)strrchr($this->config['file_name'], '.');
			}
		}
		
		// Sanitize the file name for security; Replace non-common chars
		$this->file_name = $this->sanitize_filename($this->file_name);
		/*
		// Sanitize the file name for security; Replace non-common chars
		preg_replace('/[^a-z0-9_\-\.@\s]/gi', '', $this->file_name);
		
		// Remove white spaces in the name
		if ( $this->config['remove_spaces'] )
		{
			$this->file_name = preg_replace('/\s+/', '_', $this->file_name);
		}
		*/

		// Truncate the file name if it's too long
		if ( $this->config['max_filename'] > 0 )
		{
			//$ext = (string)strrchr($this->file_name, '.');
			$filename = substr($this->file_name, 0, strlen($this->file_name) - strlen($this->file_ext));
			$this->file_name = substr($filename, 0, $this->config['max_filename']) . $this->file_ext;
		}

		/*
		* Validate the file name
		* This function appends an number onto the end of
		* the file if one with the same name already exists.
		* If it returns false there was a problem.
		*/
		if ( ! $this->config['overwrite'] )
		{
			$this->file_name = $this->get_nonexistent_filename($this->upload_path, $this->file_name);

			if ( $this->file_name === false )
			{
				return false;
			}
		}

		/*
		* Run the file through the XSS hacking filter
		* This helps prevent malicious code from being
		* embedded within a file.  Scripts can easily
		* be disguised as images or other file types.
		*/
		if ( $this->config['xss_clean'] )
		{
			if ( $this->do_xss_clean() === false )
			{
				$this->error_code = 7;
				$this->return_message[] = 'upload_unable_to_write_file';
				return false;
			}
		}

		/*
		* Move the file to the final destination
		* To deal with different server configurations
		* we'll attempt to use copy() first.  If that fails
		* we'll use move_uploaded_file().  One of the two should
		* reliably work in most environments
		*/
		if ( ! @copy($this->file_temp, $this->upload_path . $this->file_name) )
		{
			if ( ! @move_uploaded_file($this->file_temp, $this->upload_path . $this->file_name) )
			{
				$this->error_code = -1;
				$this->return_message[] = 'upload_destination_error';
				return false;
			}
		}

		/*
		* Set the finalized image dimensions
		* This sets the image width/height (assuming the
		* file was an image).  We use this information
		* in the "data" function.
		*/
		$this->set_image_properties($this->upload_path . $this->file_name);

		return true;
	}

	// --------------------------------------------------------------------

	/**
	* Validate the image
	*
	* @return	bool
	*/
	public function is_image ()
	{
		// IE will sometimes return odd mime-types during upload, so here we just standardize all
		// jpegs or pngs to the same file type.

		$bmp_mimes = array('image/bmp', 'image/x-windows-bmp');
		$gif_mimes = array('image/gif');
		$jpeg_mimes = array('image/jpg', 'image/jpe', 'image/jpeg', 'image/pjpeg');
		$png_mimes = array('image/png', 'image/x-png');

		if ( in_array($this->file_type, $jpeg_mimes) )
		{
			$this->file_type = 'image/jpeg';
		}
		elseif ( in_array($this->file_type, $png_mimes) )
		{
			$this->file_type = 'image/png';
		}
		elseif ( in_array($this->file_type, $bmp_mimes) )
		{
			$this->file_type = 'image/bmp';
		}

		$img_mimes = array(
			'image/bmp',
			'image/gif',
			'image/jpeg',
			'image/png',
		);

		return in_array($this->file_type, $img_mimes, true);
	}

	// --------------------------------------------------------------------

	/**
	* Verify that the filetype is allowed
	*
	* @return	bool
	*/
	public function is_allowed_filetype ( $ignore_mime = false )
	{
		if ( in_array('*', $this->config['allowed_types']) )
		{
			return true;
		}

		if ( ! is_array($this->config['allowed_types']) || count($this->config['allowed_types']) == 0 )
		{
			$this->error_code = -1;
			$this->return_message[] = 'upload_no_file_types';
			return false;
		}

		$ext = strtolower(ltrim($this->file_ext, '.'));

		if ( ! in_array($ext, $this->config['allowed_types']) )
		{
			return false;
		}

		// Images get some additional checks
		$image_types = array('bmp', 'gif', 'jpg', 'jpeg', 'png', 'jpe');

		if ( in_array($ext, $image_types) )
		{
			if ( ! @getimagesize($this->file_temp) )
			{
				return false;
			}
		}

		if ( $ignore_mime )
		{
			return true;
		}

		$mime = $this->mimes_types($ext);

		if ( is_array($mime) )
		{
			if ( in_array($this->file_type, $mime, true) )
			{
				return true;
			}
		}
		elseif ( $mime == $this->file_type )
		{
			return true;
		}

		return false;
	}

	// --------------------------------------------------------------------

	/**
	* List of Mime Types
	*
	* This is a list of mime types.  We use it to validate
	* the "allowed types" set by the developer
	*
	* @param	string
	* @return	string
	*/
	public function mimes_types ( $mime )
	{
		if ( empty($this->config['mimes']) )
		{
			$redlove_path = realpath(dirname(__FILE__) . '/' . str_repeat('../', 1));
			$redlove_path = rtrim( str_replace('\\', '/', $redlove_path) , '/' ) . '/';
			if ( is_file($redlove_path . 'config/mimes.php') )
			{
				$this->config['mimes'] = include($redlove_path . 'config/mimes.php');
			}
			else
			{
				return false;
			}
		}
		return ( ! isset($this->config['mimes'][$mime]) ) ? false : $this->config['mimes'][$mime];
	}

	// --------------------------------------------------------------------

	/**
	* Runs the file through the XSS clean function
	*
	* This prevents people from embedding malicious code in their files.
	* I'm not sure that it won't negatively affect certain files in unexpected ways,
	* but so far I haven't found that it causes trouble.
	*/
	public function do_xss_clean ()
	{
		$file = $this->file_temp;

		if ( filesize($file) == 0 )
		{
			return false;
		}

		if ( function_exists('memory_get_usage') && memory_get_usage() && ini_get('memory_limit') != '' )
		{
			$current = ini_get('memory_limit') * 1024 * 1024;

			// There was a bug/behavioural change in PHP 5.2, where numbers over one million get output
			// into scientific notation.  number_format() ensures this number is an integer
			// http://bugs.php.net/bug.php?id=43053

			$new_memory = number_format(ceil(filesize($file) + $current), 0, '.', '');

			ini_set('memory_limit', $new_memory); // When an integer is used, the value is measured in bytes. - PHP.net
		}

		// If the file being uploaded is an image, then we should have no problem with XSS attacks (in theory), but
		// IE can be fooled into mime-type detecting a malformed image as an html file, thus executing an XSS attack on anyone
		// using IE who looks at the image.  It does this by inspecting the first 255 bytes of an image.  To get around this
		// CI will itself look at the first 255 bytes of an image to determine its relative safety.  This can save a lot of
		// processor power and time if it is actually a clean image, as it will be in nearly all instances _except_ an
		// attempted XSS attack.

		if ( function_exists('getimagesize') && @getimagesize($file) )
		{
			if ( ! ($file = @fopen($file, 'rb')) ) // "b" to force binary
			{
				return false; // Couldn't open the file, return false
			}

			$opening_bytes = fread($file, 256);
			fclose($file);

			// These are known to throw IE into mime-type detection chaos
			// <a, <body, <head, <html, <img, <plaintext, <pre, <script, <table, <title
			// title is basically just in SVG, but we filter it anyhow

			if ( ! preg_match('/<(a|body|head|html|img|plaintext|pre|script|table|title)[\s>]/i', $opening_bytes) )
			{
				return true; // its an image, no "triggers" detected in the first 256 bytes, we're good
			}
		}

		if ( ! ($data = @file_get_contents($file)) )
		{
			return false;
		}

		//$CI =& get_instance();
		//return $CI->security->xss_clean($data, true);
		return true;
	}

	// --------------------------------------------------------------------

	/**
	* Set Image Properties
	*
	* Uses GD to determine the width/height/type of image
	*
	* @param	string
	*/
	public function set_image_properties ( $path = '' )
	{
		if ( ! $this->is_image() )
		{
			return;
		}

		if ( function_exists('getimagesize') )
		{
			if ( ($size = @getimagesize($path)) )
			{
				$types = array(1 => 'gif', 2 => 'jpeg', 3 => 'png');

				$this->image_width = $size['0'];
				$this->image_height = $size['1'];
				$this->image_type = ( ! isset($types[$size['2']]) ) ? 'unknown' : $types[$size['2']];
				$this->image_size_str = $size['3'];  // string containing height and width
			}
		}
	}

	// --------------------------------------------------------------------

	/**
	* Set the file name and path
	*
	* This function takes a filename/path as input and looks for the
	* existence of a file with the same name. If found, it will append a
	* number to the end of the filename to avoid overwriting a pre-existing file.
	*/
	public function get_nonexistent_filename ( $path, $filename )
	{
		if ( ! file_exists($path . $filename) )
		{
			return $filename;
		}

		//$ext = (string)strrchr($this->file_name, '.');
		$filename = substr($this->file_name, 0, strlen($this->file_name) - strlen($this->file_ext));
		for ( $i = 1; $i < $this->config['max_filename_increment']; $i++ )
		{
			$incr_filename = $filename . $i . $this->file_ext;
			if ( ! file_exists($path . $incr_filename) )
			{
				return $incr_filename;
			}
		}

		$this->return_message[] = 'upload_bad_filename';
		$this->error_code = -1;
		return false;
	}

	// --------------------------------------------------------------------
	
	/**
	* Validate Upload Path
	*
	* Verifies that it is a valid upload path with proper permissions.
	*
	*
	* @param string
	* @return	bool
	*/
	public function valid_upload_path ( $path )
	{
		if ( $path == '' )
		{
			$this->return_message[] = 'upload_no_filepath';
			$this->error_code = -1;
			return false;
		}
	
		$this->upload_path = rtrim($path, '/') . '/';// Make sure the upload path has a trailing slash
		
		if ( function_exists('realpath') && @realpath($this->upload_path) )
		{
			$this->upload_path = str_replace('\\', '/', realpath($this->upload_path));// Swap directory separators to Unix style for consistency
		}

		if ( ! @is_dir($this->upload_path) )
		{
			$this->return_message[] = 'upload_no_filepath';
			$this->error_code = -1;
			return false;
		}

		if ( ! is_writable($this->upload_path) )//is_really_writable()
		{
			$this->return_message[] = 'upload_not_writable';
			$this->error_code = -1;
			return false;
		}

		$this->upload_path = preg_replace('/(.+?)\/*$/', '\\1/',  $this->upload_path);
		return true;
	}
	
	// --------------------------------------------------------------------
	
	/**
	* Validate Upload
	*
	* Verifies that it is a valid upload.
	*
	*
	* @param string
	* @return	bool
	*/
	public function valid_upload_file ( $field = 'userfile' )
	{
		// Stop if file field not even set
		if ( empty($_FILES) || ! isset($_FILES[$field]) )
		{
			$this->error_code = 4;
			$this->return_message[] = 'upload_no_file_selected';
			return false;
		}

		// Was the file able to be uploaded? If not, determine the reason why.
		if ( ! is_uploaded_file($_FILES[$field]['tmp_name']) )
		{
			$this->error_code = ( ! isset($_FILES[$field]['error']) ) ? 4 : $_FILES[$field]['error'];

			switch ( $this->error_code )
			{
				case 1: // UPLOAD_ERR_INI_SIZE
					$this->return_message[] = 'upload_file_exceeds_limit';
					break;
				case 2: // UPLOAD_ERR_FORM_SIZE
					$this->return_message[] = 'upload_file_exceeds_form_limit';
					break;
				case 3: // UPLOAD_ERR_PARTIAL
					$this->return_message[] = 'upload_file_partial';
					break;
				case 4: // UPLOAD_ERR_NO_FILE
					$this->return_message[] = 'upload_no_file_selected';
					break;
				case 6: // UPLOAD_ERR_NO_TMP_DIR
					$this->return_message[] = 'upload_no_temp_directory';
					break;
				case 7: // UPLOAD_ERR_CANT_WRITE
					$this->return_message[] = 'upload_unable_to_write_file';
					break;
				case 8: // UPLOAD_ERR_EXTENSION
					$this->return_message[] = 'upload_stopped_by_extension';
					break;
				default :
					$this->return_message[] = 'upload_no_file_selected';
					break;
			}

			return false;
		}
		
		// Set the uploaded data as class variables
		$this->file_temp = $_FILES[$field]['tmp_name'];
		$this->file_size = $_FILES[$field]['size'];
		$this->file_type = preg_replace('/^(.+?);.*$/', '\\1', $_FILES[$field]['type']);
		$this->file_type = strtolower(trim(stripslashes($this->file_type), '"'));
		$this->orig_name = $_FILES[$field]['name'];
		$this->file_name = $this->_protect_extensions($this->orig_name);
		$this->file_ext = (string)strrchr($this->file_name, '.');

		// Is the file type allowed to be uploaded?
		if ( ! $this->is_allowed_filetype() )
		{
			$this->error_code = -1;
			$this->return_message[] = 'upload_invalid_filetype';
			return false;
		}
		
		// If max file size exceeded
		$this->file_size = round($this->file_size / 1024, 2);// Convert the file size to kilobytes
		$this->config['max_size'] = $this->config['max_size'] * 1024;// Convert megabytes to kilobytes; 1kb = 1024 bytes
		if ( $this->config['max_size'] != 0 && $this->file_size > $this->config['max_size'] )
		{
			$this->error_code = -1;
			$this->return_message[] = 'upload_invalid_filesize';
			return false;
		}
		
		// Check image dimensions
		if ( $this->is_image() )
		{
			if ( function_exists('getimagesize') )
			{
				$size = @getimagesize($this->file_temp);

				if ( $this->config['max_width'] > 0 && $size['0'] > $this->config['max_width'] )
				{
					$this->error_code = -1;
					$this->return_message[] = 'upload_invalid_dimensions';
					return false;
				}

				if ( $this->config['max_height'] > 0 && $size['1'] > $this->config['max_height'] )
				{
					$this->error_code = -1;
					$this->return_message[] = 'upload_invalid_dimensions';
					return false;
				}
			}
		}
		
		return true;
	}
	
	// --------------------------------------------------------------------
	
	/**
	* Sanitize the filename and normalize the filename
	* 
	* Reference: http://cubiq.org/the-perfect-php-clean-url-generator
	* 
	* @param string $string The filename
	* @return string Sanitized filename
	*/
	public function sanitize_filename ( $string )
	{
		//setlocale(LC_ALL, 'en_US.UTF8');
		
		// Whitelist
		$cleaned = iconv('UTF-8', 'ASCII//TRANSLIT', $string);
		//$cleaned = preg_replace('/[^a-zA-Z0-9_-.+|\/ ]/g', '', $string);
		$cleaned = trim(preg_replace('/[^a-zA-Z0-9_\-\.\s]/', ' ', $cleaned));
		
		// Trim space individually around the file name and extension
		$file = $cleaned;
		$file_ext = strtolower( substr((string)strrchr($file, '.'), 1) );// Lowercase, get text after dot, get text dot and after
		$file_name = substr($file, 0, strlen($file) - strlen($file_ext));// Remove file extension
		if ( strlen($file_ext) > 0 )
		{
			$file_name = substr($file_name, 0, -1);
			$file = trim($file_name) . '.' . trim($file_ext);
		}
		$cleaned = $file;
		
		// Turn spaces (condense multiples) to dashes
		$cleaned = preg_replace('/\s+/', '-', $cleaned);
		// Maximum of 2 consecutive dashes
		$cleaned = preg_replace('/\-{3,}/', '--', $cleaned);
		// Trim dashes
		$cleaned = trim($cleaned, '-');//strtolower()
		
		//$this->file_name = preg_replace('/[^a-z0-9_\-\.@\s]/gi', '', $this->file_name);
		
		return $cleaned;
	}
	
	// --------------------------------------------------------------------
	
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
	
	// --------------------------------------------------------------------
	// Protected methods
	// --------------------------------------------------------------------
	
	/**
	* Prep Filename
	*
	* Prevents possible script execution from Apache's handling of files multiple extensions
	* http://httpd.apache.org/docs/1.3/mod/mod_mime.html#multipleext
	*
	* @param	string
	* @return	string
	*/
	protected function _protect_extensions ( $file )
	{
		if ( strpos($file, '.') === false || in_array('*', $this->config['allowed_types']) )
		{
			return $file;
		}

		$parts = explode('.', $file);
		$ext = array_pop($parts);
		$filename = array_shift($parts);

		foreach ( $parts as $part )
		{
			$filename .= '.' . $part;
			
			if ( ! in_array(strtolower($part), $this->config['allowed_types']) || $this->mimes_types(strtolower($part)) === false )
			{
				$filename .= '_';
			}
		}

		$filename .= '.' . $ext;

		return $filename;
	}

	// --------------------------------------------------------------------
	
}

// --------------------------------------------------------------------

