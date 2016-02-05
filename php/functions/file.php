<?php
/**
* File helper functions
*
* @package RedLove
* @subpackage PHP
* @category Functions
* @author Joshua Logsdon <joshua@joshualogsdon.com>
* @author Various from CodeIgniter to Internet
* @copyright Copyright (c) 2015, Joshua Logsdon (http://joshualogsdon.com/)
* @license http://opensource.org/licenses/MIT MIT License
* @link https://github.com/logsdon/redlove
* @link http://redlove.org
* @version 0.0.0
* 
*/

// --------------------------------------------------------------------

if ( ! function_exists('get_cache_busting_filename') )
{
	/**
	* Get cache busting filename
	* http://webassets.readthedocs.org/en/latest/expiring.html
	* 
	* @param string $file
	* @param bool $bypass (optional)
	* @return string File with cache busting versioning applied
	*/
	function get_cache_busting_filename( $file, $bypass = false )
	{
		if ( $bypass )
		{
			return $file;
		}
		
		$mtime = 0;
		$file_ext = (string)strrchr($file, '.');
		$filename = substr($file, 0, strlen($file) - strlen($file_ext));
		$absolute_file = ROOT_PATH . $file;
		
		// Get the last modified time and append it to the filename
		$file_exists = ( $file && file_exists($absolute_file) && is_file($absolute_file) );
		if ( $file_exists )
		{
			$mtime = date('YmdHis', filemtime($absolute_file));
		}
		
		return $filename . '.' . (string)$mtime . $file_ext;
	}
}

// --------------------------------------------------------------------

if ( ! function_exists('cb_url') )
{
	/**
	* Get cache busting url
	* 
	* @param string $file
	* @param bool $bypass (optional)
	* @return string Url with cache busting versioning applied
	*/
	function cb_url( $file, $bypass = false )
	{
		return base_url() . ltrim(get_cache_busting_filename($file, $bypass), '/');
	}
}

// --------------------------------------------------------------------

if ( ! function_exists('check_file_cache') )
{
	/**
	* $ttl Cache time to live in seconds
	* 
	* Usage:
	* 
	
	$cache_file = INCLUDESPATH . 'cache/mydata.txt';
	$cache_ttl = 60 * 60;
	$data = check_file_cache($cache_file, $cache_ttl);
	if ( ! isset($data) )
	{
		$data = array();
		// Gather data
		check_file_cache($cache_file, $cache_ttl, $data);
	}
	
	* 
	*/
	function check_file_cache( $file, $ttl = 360, $data = null )
	{
		// Write cache if data is set
		if ( isset($data) )
		{
			// Write cache
			file_put_contents($file, serialize($data));//@chmod($file, 0777);
		}
		// Read cache if valid file
		else
		{
			$filemtime = @filemtime($file);// Returns FALSE if file does not exist
			// If the file exists and chache is not expired
			if ( $filemtime && (time() - $filemtime < $ttl) )
			{
				// Read cache
				$data = unserialize(file_get_contents($file));
			}
		}
		
		return $data;
	}
}

// --------------------------------------------------------------------

if ( ! function_exists('array_to_csv') )
{
	/**
	* $ttl Cache time to live in seconds
	* 
	* Reference:
	* http://stackoverflow.com/questions/4249432/export-to-csv-via-php
	* http://maestric.com/en/doc/php/codeigniter_csv
	* 
	* Usage:
	* 
	
	* 
	*/
	function array_to_csv( $array, $filename = '', $auto_column_headings = true, $use_buffer = false )
	{
		// Error reporting
		//ini_set('display_errors', 0);
		//error_reporting(-1);
		// Extend memory
		$memory_mb = 512 . 'M';//1024 * 128;
		ini_set('memory_limit', $memory_mb);
		// Extend script execution time
		$execution_seconds = 60 * 20;
		set_time_limit($execution_seconds);
		ini_set('max_execution_time', $execution_seconds);
		
		$is_download = isset($filename[0]);
		if ( $is_download )
		{
			// Send the headers to allow the user to download the file
			header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
			header('Content-Description: File Transfer');
			header('Content-Type: application/octet-stream');//header('Content-Type: text/csv');
			header('Content-Disposition: attachment; filename=' . $filename);
			header('Content-Transfer-Encoding: binary');
			header('Expires: 0');
			header('Pragma: public');
			echo "\xEF\xBB\xBF";// UTF-8 BOM
		}
		
		$use_buffer = $is_download ? $use_buffer : true;
		if ( $use_buffer )
		{
			ob_start();
		}
		
		$file_handler = fopen('php://output', 'w') or die('Unable to open php://output');
		//fputs($file_handler, "\xEF\xBB\xBF");// UTF-8 BOM
		
		$line = 0;
		
		// If auto column headings, write first csv line with associative array keys
		if ( $auto_column_headings )
		{
			$keys = array_keys(reset($array));
			if ( isset($keys[0]) && is_string($keys[0]) )
			{
				$line++;
				fputcsv($file_handler, $keys) or die('Unable to write column headings');
			}
		}
		
		// Loop over array for csv
		foreach ( $array as $row )
		{
			$line++;
			fputcsv($file_handler, $row) or die("Unable to write row $n: $row");
		}
		
		fclose($file_handler) or die('Unable to close php://output');
		
		if ( $use_buffer )
		{
			$output = ob_get_contents();
			ob_end_clean();
		}
		
		if ( $is_download )
		{
			if ( $use_buffer )
			{
				echo $output;
			}
			
			exit;
		}
		
		if ( $use_buffer )
		{
			return $output;
		}
	}
}

// --------------------------------------------------------------------

if ( ! function_exists('sanitize_file_path') )
{
	/**
	* Sanitize the file path
	* 
	* http://cubiq.org/the-perfect-php-clean-url-generator
	* 
	* @param string $path Directory path
	* @param string $beginning_base_path (optional) Path base that must be in the path
	* @return bool|string False (if bad path or doesn't begin with base) or sanitized path
	*/
	//setlocale(LC_ALL, 'en_US.UTF8');
	function sanitize_file_path ( $path, $beginning_base_path = null )
	{
		$realpath = realpath($path);
		
		if ( $realpath === false )
		{
			return false;
		}
		
		// Normalize path
		$realpath = rtrim( str_replace('\\', '/', $realpath), '/' ) . '/';
		
		// If passed, ensure base starts the path
		if ( isset($beginning_base_path) && strpos($realpath, $beginning_base_path) === false )
		{
			return false;
		}
		
		return $realpath;
	}
}

// --------------------------------------------------------------------

if ( ! function_exists('sanitize_filename') )
{
	/**
	* Sanitize the filename
	* 
	* http://cubiq.org/the-perfect-php-clean-url-generator
	* 
	* @param string $string The filename
	* @return string Sanitized filename
	*/
	//setlocale(LC_ALL, 'en_US.UTF8');
	function sanitize_filename ( $string )
	{
		// Whitelist
		$cleaned = iconv('UTF-8', 'ASCII//TRANSLIT', $string);
		//$cleaned = preg_replace('/[^a-zA-Z0-9_-.+|\/ ]/g', '', $string);
		$cleaned = preg_replace('/[^a-zA-Z0-9_\-\.\s]/', ' ', $cleaned);
		// Turn spaces (condense multiples) to dashes
		$cleaned = preg_replace('/\s+/', '-', $cleaned);
		// Maximum of 2 consecutive dashes
		$cleaned = preg_replace('/\-{3,}/', '--', $cleaned);
		// Trim dashes
		$cleaned = trim($cleaned, '-');//strtolower()
		
		//$this->file_name = preg_replace('/[^a-z0-9_\-\.@\s]/gi', '', $this->file_name);
		
		return $cleaned;
	}
}

// --------------------------------------------------------------------

if ( ! function_exists('create_directory') )
{
	/**
	* Create a directory
	* Thanks to http://stackoverflow.com/questions/2303372/create-a-folder-if-it-doesnt-already-exist
	* 
	* @param string $path Directory path to create
	* @param int $permissions The permissions for the new directory
	* @param bool $recursive Recursively create missing directories in the new path
	* @return bool
	*/
	function create_directory ( $path, $permissions = null, $recursive = true )
	{
		// Normalize path
		$path = rtrim( str_replace('\\', '/', $path) , '/' ) . '/';
		
		// If directory already exists
		if ( is_dir($path) )
		{
			return true;
		}
		
		// Iterate down the path until the parent or root directory is found
		$parent_depth = 1;
		$parent = dirname( $path );
		$root = realpath('/');
		while ( $parent != $root && ! is_dir( $parent ) )
		{
			$parent = dirname( $parent );
			$parent_depth++;
		}
		
		// If parent directory is not writable
		if ( ! is_writable($parent) )
		{
			return false;
		}
		
		// Get the parent permissions
		$permissions = isset($permissions) ? $permissions : substr(sprintf('%o', fileperms($parent)), -4);
		
		return mkdir($path, $permissions, $recursive);// Use @mkdir to suppress warnings/errors
	}
}

// --------------------------------------------------------------------

if ( ! function_exists('delete_directory_recursive') )
{
	/**
	* Recursively delete a directory and all of it's contents - e.g.the equivalent of `rm -r` on the command-line.
	* Consistent with `rmdir()` and `unlink()`, an E_WARNING level error will be generated on failure.
	* 
	* https://gist.github.com/mindplay-dk/a4aad91f5a4f1283a5e2
	* http://stackoverflow.com/a/3352564/283851
	* 
	* @param string $dir absolute path to directory to delete
	* @return bool true on success; false on failure
	*/
	function delete_directory_recursive ( $dir )
	{
		if ( ! file_exists($dir) )
		{
			return false;
		}

		$it = new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS);
		$files = new RecursiveIteratorIterator($it, RecursiveIteratorIterator::CHILD_FIRST);
		
		foreach ( $files as $fileinfo )
		{
			$run_function = $fileinfo->isDir() ? 'rmdir' : 'unlink';
			$success = $run_function($fileinfo->getRealPath());
			/*
			// or
			if ( $fileinfo->isDir() )
			{
				$success = rmdir($fileinfo->getRealPath());
			}
			else
			{
				$success = unlink($fileinfo->getRealPath());
			}
			*/
			
			if ( ! $success )
			{
				return false;
			}
		}
		
		return rmdir($dir);
	}
}

// --------------------------------------------------------------------

if ( ! function_exists('recurse_dir') )
{
	/**
	* Recurse directory contents
	* 
	* http://www.sitepoint.com/list-files-and-directories-with-php/
	* http://stackoverflow.com/questions/24783862/list-all-the-files-and-folders-in-a-directory-with-php-recursive-function
	* 
	* @version 0.0.0
	* @param mixed $params An array of parameters or list of arguments
	*/
	function recurse_dir ( $params = '' )
	{
		// Set default values for missing keys
		$default_params = array(
			'path' => '',
			'path_root' => '',
			'blacklist_files' => '',
			'blacklist_file_extensions' => '',
			'blacklist_directories' => '',
			'datetime_format' => 'Y-m-d H:i:s',
			'max_depth' => -1,
			'directories_only' => false,
			'files_only' => false,
		);
		
		// Get arguments
		$args = func_get_args();
		$num_args = count($args);
		//$args0 = isset($args[0]) ? $args[0] : null;
		// Check for alternate argument patterns
		if ( is_string($params) )
		{
			// Correspond each passed argument with the order of the default parameters
			$params = array();
			$default_param_keys = array_keys($default_params);
			for ( $arg_i = 0; $arg_i < $num_args; $arg_i++ )
			{
				// Stop if there are no more corresponding default parameters
				if ( ! isset($default_param_keys[ $arg_i ]) )
				{
					break;
				}
				
				$params[ $default_param_keys[$arg_i] ] = $args[ $arg_i ];
			}
		}
		
		// Merge default and passed parameters
		$params = array_merge($default_params, $params);
		extract($params);
		
		// Stop if the path does not exist
		if ( ! is_dir($path) )
		{
			return false;
		}
		
		// Normalize arguments
		if ( ! is_array($blacklist_files) )
		{
			$blacklist_files = explode(',', $blacklist_files);
			$blacklist_files = array_filter($blacklist_files);
		}
		
		if ( ! is_array($blacklist_file_extensions) )
		{
			$blacklist_file_extensions = explode(',', $blacklist_file_extensions);
			$blacklist_file_extensions = array_filter($blacklist_file_extensions);
		}
		
		if ( ! is_array($blacklist_directories) )
		{
			$blacklist_directories = explode(',', $blacklist_directories);
			$blacklist_directories = array_filter($blacklist_directories);
		}
		
		// Initialize directory data
		$data = array(
			'files' => array(),
			'directories' => array(),
		);
		
		// If no path root is set, use the path
		if ( strlen($path_root) == 0 )
		{
			$path_root = $path;
		}
		
		// Setting FilesystemIterator will include depth in file spl info
		$directory = new RecursiveDirectoryIterator($path, RecursiveDirectoryIterator::SKIP_DOTS | FilesystemIterator::KEY_AS_PATHNAME | FilesystemIterator::CURRENT_AS_SELF);
		$iterator = new RecursiveIteratorIterator($directory, RecursiveIteratorIterator::SELF_FIRST);
		$iterator->setMaxDepth($max_depth);
		
		foreach ( $iterator as $file_pathname => $spl_file_info )
		{
			// Skip if file is a link
			if ( $spl_file_info->isLink() )
			{
				continue;
			}
			
			// Normalize directory path
			$file_pathname = str_ireplace('\\', '/', $file_pathname);//$spl_file_info->getPathName()
			// Normalize directory path
			$file_path = rtrim( str_ireplace('\\', '/', $spl_file_info->getPath()), '/' ) . '/';
			$file_path_basename = basename($file_path);//$pathinfo = pathinfo($path);
			$file_path_from_root = str_ireplace($path_root, '', $file_path);
			
			$filename = $spl_file_info->getFileName();
			$depth = $iterator->getDepth();
			$permissions = substr(sprintf('%o', $spl_file_info->getPerms()), -4);
			$created_time = $spl_file_info->getCTime();
			$created_datetime = date($datetime_format, $created_time);
			$modified_time = $spl_file_info->getMTime();
			$modified_datetime = date($datetime_format, $created_time);
			
			$data_piece = array(
				'pathname' => $file_pathname,
				'relative_absolute_pathname' => str_ireplace(ROOT_PATH, ROOT, $file_pathname),
				'path' => $file_path,
				'relative_absolute_path' => str_ireplace(ROOT_PATH, ROOT, $file_path),
				'path_basename' => $file_path_basename,
				'path_from_root' => $file_path_from_root,
				'filename' => $filename,
				'depth' => $depth,
				'depth_filename' => str_repeat(' - ', $depth) . $filename,
				'permissions' => $permissions,
				'created_time' => $created_time,
				'created_datetime' => $created_datetime,
				'modified_time' => $modified_time,
				'modified_datetime' => $modified_datetime,
			);
			
			// If directory
			if ( $spl_file_info->isDir() )
			{
				// Skip if only gathering files
				if ( $files_only )
				{
					continue;
				}
				
				// Skip if blacklisted
				if ( in_array($filename, $blacklist_directories) )
				{
					continue;
				}
				
				$data_piece['path'] .= $filename;
				$data_piece['relative_absolute_path'] .= $filename;
				$data_piece['path_basename'] = $filename;
				$data_piece['path_from_root'] .= $filename;
				$data['directories'][ $file_pathname ] = $data_piece;
			}
			// If file
			else
			{
				// Skip if only gathering directories
				if ( $directories_only )
				{
					continue;
				}
				
				// Skip if blacklisted
				if ( in_array($file_path_basename, $blacklist_directories) )
				{
					continue;
				}
				
				// Skip if blacklisted
				if ( in_array($filename, $blacklist_files) )
				{
					continue;
				}
				
				$file_extension = $spl_file_info->getExtension();
				
				// Skip if blacklisted
				if ( in_array($file_extension, $blacklist_file_extensions) )
				{
					continue;
				}
				
				// Calculate file size from bytes
				$file_size = $spl_file_info->getSize();
				$file_size = bytes_to_string($file_size);
				
				$data_piece['size'] = $file_size;
				$data_piece['extension'] = $file_extension;
				
				$dimensions = @getimagesize($file_pathname);
				if ( $dimensions )
				{
					$data_piece['width'] = $dimensions['0'];
					$data_piece['height'] = $dimensions['1'];
					$data_piece['size_str'] = $dimensions['3'];
					$data_piece['image_type'] = $dimensions['2'];
				}
				
				$data['files'][ $file_pathname ] = $data_piece;
			}
		}
		
		return $data;
	}
}

// --------------------------------------------------------------------

if ( ! function_exists('bytes_to_string') )
{
	/**
	* Present a size (in bytes) as a human-readable value
	* 
	* @param int $size Size (in bytes)
	* @param int $precision The number of digits after the decimal point
	* @return string
	*/
	function bytes_to_string ( $size, $precision = 2 )
	{
		$sizes = array('B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
		$num_sizes = count($sizes);
		
		for ( $size_i = 0; $size > 1000; $size_i++ )
		{
			$size /= 1024;
		}
		
		return number_format($size, $precision, '.', ',') . ( isset($sizes[$size_i]) ? ' ' . $sizes[$size_i] : '' );
	}
}

// --------------------------------------------------------------------
