<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* Check if files to upload meet valid criteria.
* 
* @access public
* @param array $config
* @return bool
*/
if ( ! function_exists('valid_upload_files'))
{
	function valid_upload_files( $config = '' )
	{
		// --------------------
		// Config
		$default_config = array(
			'allowed_types' => 'gif|jpg|jpeg|pjpeg|png', // A pipe-separated list of valid file extensions.
			'match_fields' => 'file', // The $_FILES field to be matched.
			'max_file_mb' => 2, // Maximum number of megabytes per file.
			'num_min_files' => 0, // The number of minimum files to be uploaded.
			'relative_path' => '/files', // The relative path for uploaded files.
			'strict_field_match' => TRUE, // Whether or not the field is exact or just part of several fields.
		);
		foreach ( $default_config as $key => $value )
		{
			if ( isset($config[ $key ]) == FALSE )
			{
				$config[ $key ] = $value;
			}
		}
		// --------------------
		
		$data = array(
			'code' => '',
			'value' => '',
			'message' => '',
		);
		
		// Check if files are being uploaded:
		if ( empty($_FILES) )
		{
			$data['message'] .= 'No files have been be uploaded. ';
			$data['code'] = 0;
			return $data;
		}
		
		// Check if the full path exists.
		$CI =& get_instance();
		$CI->load->helper('file');
		$full_path = get_full_path($config['relative_path']);
		if ( $full_path === FALSE )
		{
			$data['message'] .= 'The image upload directory was not set properly. ';
			$data['code'] = 0;
			return $data;
		}
		
		// --------------------
		// Get the field values of valid uploaded files.
		$form_fields = array();
		$match_fields = (is_array($config['match_fields'])) ? $config['match_fields'] : explode(',', $config['match_fields']);
		
		$file_keys = array_keys( $_FILES );
		foreach ( $file_keys as $key )
		{
			if ( strlen($_FILES[$key]['name']) > 0 && (int)$_FILES[$key]['size'] > 0 )
			{
				if ( $config['strict_field_match'] && in_array($key, $match_fields) )
				{
					$form_fields[] = $key;
				}
				elseif ( ! $config['strict_field_match'] )
				{
					foreach ( $match_fields as $match_field )
					{
						if ( strpos($key, $match_field, 0) !== FALSE )
						{
							$form_fields[] = $key;
							continue 2;
						}
					}
				}//end if strict field match
			}//end if valid upload
		}//end for each upload
		// --------------------
		
		// Check if the minimum # of files were uploaded
		if ( count($form_fields) < $config['num_min_files'] )
		{
			$data['message'] .= 'At least ' . $config['num_min_files'] . ' file' . ($config['num_min_files'] !== 1 ? 's' : '') . ' must be uploaded. ';
			$data['code'] = -1;
			return $data;
		}
		
		// If NO files are being uploaded:
		if ( empty($form_fields) )
		{
			$data['message'] .= 'No valid files have been be uploaded. ';
			$data['code'] = 0;
			return $data;
		}
		
		// For each uploaded file:
		$max_kb = (int)$config['max_file_mb'] * 1024 * 1024;// size is in bytes; 1kb = 1024 bytes
		$allowed_types = explode('|', $config['allowed_types']);
		// Possible PHP upload errors
		$php_file_errors = array(
			1 => 'php.ini max file size exceeded.',
			2 => 'HTML form max file size exceeded.',
			3 => 'File upload was only partial.',
			4 => 'No file was attached.',
		);
		
		foreach ( $form_fields as $field )
		{
			$ext = strtolower( substr(strrchr($_FILES[$field]['name'], '.'), 1) );//$ext = strtolower( substr($_FILES[$field]['name'], strrpos($_FILES[$field]['name'], '.')) );
			
			if ( ! in_array($ext, $allowed_types) )
			{
				$data['message'] .= 'The file "' . htmlentities($_FILES[ $field ]['name']) . 
				'" is not an allowed type (' . htmlentities($_FILES[ $field ]['type']) . '). ';
				$data['code'] = -2;
				return $data;
			}
			// Check for PHP's built-in uploading errors
			elseif ( $_FILES[ $field ]['error'] != 0 )
			{
				$data['message'] .= $php_file_errors[ $_FILES[ $field ]['error'] ];
				$data['code'] = -3;
				return $data;
			}
			elseif ( $_FILES[ $field ]['size'] > $max_kb )
			{
				$size = round($_FILES[ $field ]['size'] / (1024 * 1024), 2);
				$data['message'] .= 'The file "'. htmlentities($_FILES[ $field ]['name']) . 
				'" filesize is too large at ' . $size . 'Mb. ';
				$data['code'] = -4;
				return $data;
			}
		}
		
		$data['code'] = 1;
		$data['value'] = array(
			'full_path' => $full_path,
			'form_fields' => $form_fields,
		);
		return $data;
	}
}

// ------------------------------------------------------------------------

