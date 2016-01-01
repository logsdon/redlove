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
		$absolute_file = ROOTPATH . $file;
		
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
		return base_url() . get_cache_busting_filename($file, $bypass);
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
