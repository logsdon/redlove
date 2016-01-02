<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* Create a csv from a query and download it.
*
* @access public
* @param object $query Query resource.
* @param string $filename
*/
if ( ! function_exists('stream_csv_from_result'))
{
	function stream_csv_from_result( $query, $filename = '', $closure = false )
	{
		if ( ! is_object($query) || ! method_exists($query, 'list_fields') )
		{
			show_error('You must submit a valid result object');
		}
		
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
		
		$filename = $filename ? $filename : 'records_' . gmdate('YmdHis') . '.csv';
		$delimiter = ',';
		$newline = "\r\n";
		$enclosure = '"';
		$output = '';
		
		// Send the headers to allow the user to download the file
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Content-Description: File Transfer');
		header('Content-Type: application/octet-stream');//header('Content-Type: text/csv');
		header('Content-Disposition: attachment; filename=' . $filename);
		header('Content-Transfer-Encoding: binary');
		header('Expires: 0');
		header('Pragma: public');
		
		echo "\xEF\xBB\xBF"; // UTF-8 BOM
		
		/*
		// Alternate stream way
		//$outstream = fopen( "php://output", 'w' ); fputs( $outstream, "\xEF\xBB\xBF" ); foreach ( $export as $fields ) { fputcsv( $outstream, $fields ); } fclose( $outstream );
		// OR
		// fopen function supports PHP input/output streams as wrappers
		$fh = @fopen( 'php://output', 'w' );
		// First generate the headings from the table column names
		fputcsv($fh, $query->list_fields());
		// Next blast through the result array and build out the rows
		while ( $row = $query->unbuffered_row('array') )
		{
			// Put the data into the stream
			fputcsv($fh, $row);
		}
		// Close the file
		fclose($fh);
		// Make sure nothing else is sent, our file is done
		exit;
		*/
		
		// First generate the headings from the table column names
		foreach ( $query->list_fields() as $name )
		{
			$output .= $enclosure . str_replace($enclosure, $enclosure . $enclosure, $name) . $enclosure . $delimiter;
		}

		$output = rtrim($output);
		$output .= $newline;
		echo $output;
		unset($output);
		
		// Next blast through the result array and build out the rows
		// Old way that used increased memory: foreach ( $query->result_array() as $row )
		while ( $row = $query->unbuffered_row('array') )
		{
			$output = '';
			foreach ( $row as $item )
			{
				$output .= $enclosure . str_replace($enclosure, $enclosure . $enclosure, $item) . $enclosure . $delimiter;
			}
			$output = rtrim($output);
			$output .= $newline;
			echo $output;
			unset($output);
		}
		
		if ( $closure )
		{
			$query->free_result();
			unset($query);
			exit;
		}
	}
}

// ------------------------------------------------------------------------

/**
* Create a csv from a query and download it.
*
* @access public
* @param object $query Query resource.
* @param string $filename
*/
if ( ! function_exists('csv'))
{
	function csv( $query, $filename = 'records', $filename_addon = TRUE )
	{
		$CI =& get_instance();
		
		if ( $query !== FALSE )
		{
			$CI->load->dbutil();
			$CI->load->helper( 'download' );
			
			$delimiter = ',';
			$newline = "\r\n";
			$data = $CI->dbutil->csv_from_result( $query, $delimiter, $newline );
			$query->free_result();
			
			if ( $filename_addon )
			{
				$filename = $filename . '_' . gmdate('YmdHis') . '.csv';
			}
			
			force_download( $filename, $data );
		}
	}
}

// ------------------------------------------------------------------------

/**
 * CSV Helpers
 * Inspiration from PHP Cookbook by David Sklar and Adam Trachtenberg
 * 
 * @author		Jérôme Jaglale
 * @link		http://maestric.com/en/doc/php/codeigniter_csv
 */

// ------------------------------------------------------------------------

/**
 * Array to CSV
 *
 * download == "" -> return CSV string
 * download == "toto.csv" -> download file toto.csv
 */
if ( ! function_exists('array_to_csv'))
{
	function array_to_csv($array, $download = "")
	{
		if ($download != "")
		{
			header('Content-Type: application/csv');
			header('Content-Disposition: attachement; filename="' . $download . '"');
		}

		ob_start();
		$f = fopen('php://output', 'w') or show_error("Can't open php://output");
		$n = 0;
		foreach ($array as $line)
		{
			$n++;
			if ( ! fputcsv($f, $line))
			{
				show_error("Can't write line $n: $line");
			}
		}
		fclose($f) or show_error("Can't close php://output");
		$str = ob_get_contents();
		ob_end_clean();

		if ($download == "")
		{
			return $str;
		}
		else
		{
			echo $str;
		}
	}
}

// ------------------------------------------------------------------------

/**
 * Query to CSV
 *
 * download == "" -> return CSV string
 * download == "toto.csv" -> download file toto.csv
 */
if ( ! function_exists('query_to_csv'))
{
	function query_to_csv($query, $headers = TRUE, $download = "")
	{
		if ( ! is_object($query) OR ! method_exists($query, 'list_fields'))
		{
			show_error('invalid query');
		}
		
		$array = array();
		
		if ($headers)
		{
			$line = array();
			foreach ($query->list_fields() as $name)
			{
				$line[] = $name;
			}
			$array[] = $line;
		}
		
		while ( $row = $query->unbuffered_row('array') )
		{
			$line = array();
			foreach ($row as $item)
			{
				$line[] = $item;
			}
			$array[] = $line;
		}

		echo array_to_csv($array, $download);
	}
}

// --------------------------------------------------------------------

