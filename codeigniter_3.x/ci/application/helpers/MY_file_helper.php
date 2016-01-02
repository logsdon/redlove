<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* 
http://stackoverflow.com/questions/3074527/how-to-check-whether-file-is-image-or-video-type-in-php-version-5-2-9
http://stackoverflow.com/questions/2006632/php-how-can-i-check-if-a-file-is-mp3-or-image-file
http://www.php.net/manual/en/function.mime-content-type.php#87856
*/
if ( ! function_exists('get_mimetype') )
{
	function get_mimetype( $file, $check_file = false )
	{
		$mimetype = false;
		
		if ( $check_file && ! is_file($file) )
		{
			return false;
		}
		
		$mime_types = array(
			// application
			'bin' => 'application/mac-binary',
			'class' => 'application/octet-stream',
			'cpt' => 'application/mac-compactpro',
			'dll' => 'application/octet-stream',
			'dms' => 'application/octet-stream',
			'hqx' => 'application/mac-binhex',
			'lha' => 'application/octet-stream',
			'lzh' => 'application/octet-stream',
			'oda' => 'application/oda',
			'mif' => 'application/vnd.mif',
			'cer' => 'application/pkix-cert',
			'crl' => 'application/pkix-crl',
			'crt' => 'application/pkix-cert',
			'csr' => 'application/octet-stream',
			'der' => 'application/x-x509-ca-cert',
			'dvi' => 'application/x-dvi',
			'eml' => 'message/rfc822',
			'kdb' => 'application/octet-stream',
			'gpg' => 'application/gpg-keys',
			'p10' => 'application/pkcs10',
			'p12' => 'application/x-pkcs12',
			'p7a' => 'application/x-pkcs7-signature',
			'p7c' => 'application/pkcs7-mime',
			'p7m' => 'application/pkcs7-mime',
			'p7r' => 'application/x-pkcs7-certreqresp',
			'p7s' => 'application/pkcs7-signature',
			'pem' => 'application/x-pem-file',
			'pgp' => 'application/pgp',
			'rsa' => 'application/x-pkcs7',
			'sea' => 'application/octet-stream',
			'so' => 'application/octet-stream',
			'sst' => 'application/octet-stream',
			'wbxml' => 'application/wbxml',
			'wmlc' => 'application/wmlc',
			'xspf' => 'application/xspf+xml',
			
			// text
			'css' => 'text/css',
			'csv' => 'text/csv',
			'htm' => 'text/html',
			'html' => 'text/html',
			'js' => 'application/javascript',
			'json' => 'application/json',
			'log' => 'text/plain',
			'php' => 'application/x-httpd-php',
			'php3' => 'application/x-httpd-php',
			'php4' => 'application/x-httpd-php',
			'phps' => 'application/x-httpd-php-source',
			'phtml' => 'application/x-httpd-php',
			'shtml' => 'text/html',
			'text' => 'text/plain',
			'txt' => 'text/plain',
			'xht' => 'application/xhtml+xml',
			'xhtml' => 'application/xhtml+xml',
			'xml' => 'application/xml',
			'xsl' => 'text/xml',
			
			// adobe
			'ai' => 'application/postscript',
			'dcr' => 'application/x-director',
			'dir' => 'application/x-director',
			'dxr' => 'application/x-director',
			'eps' => 'application/postscript',
			'ps' => 'application/postscript',
			'pdf' => 'application/pdf',
			'psd' => 'application/x-photoshop',
			'swf' => 'application/x-shockwave-flash',

			// ms office
			'doc' => 'application/msword',
			'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
			'ppt' => 'application/vnd.ms-powerpoint',
			'rtf' => 'application/rtf',
			'rtx' => 'text/richtext',
			'word' => 'application/msword',
			'xl' => 'application/excel',
			'xls' => 'application/vnd.ms-excel',
			'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',

			// open office
			'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
			'odt' => 'application/vnd.oasis.opendocument.text',
			
			// archives
			'cab' => 'application/vnd.ms-cab-compressed',
			'exe' => 'application/x-msdownload',
			'gz' => 'application/x-gzip',
			'gzip' => 'application/x-gzip',
			'gtar' => 'application/x-gtar',
			'msi' => 'application/x-msdownload',
			'rar' => 'application/x-rar-compressed',
			'sit' => 'application/x-stuffit',
			'tar' => 'application/x-tar',
			'tgz' => 'application/x-tar',
			'zip' => 'application/zip',

			// images
			'bmp' => 'image/bmp',
			'gif' => 'image/gif',
			'ico' => 'image/vnd.microsoft.icon',
			'jpe' => 'image/jpeg',
			'jpeg' => 'image/jpeg',
			'jpg' => 'image/jpeg',
			'png' => 'image/png',
			'svg' => 'image/svg+xml',
			'svgz' => 'image/svg+xml',
			'tiff' => 'image/tiff',
			'tif' => 'image/tiff',

			// audio/video
			'aac' => 'audio/x-acc',
			'ac3' => 'audio/ac3',
			'aif' => 'audio/aiff',
			'aifc' => 'audio/x-aiff',
			'aiff' => 'audio/aiff',
			'au' => 'audio/x-au',
			'flac' => 'audio/x-flac',
			'm4a' => 'audio/x-m4a',
			'mid' => 'audio/midi',
			'midi' => 'audio/midi',
			'mp2' => 'audio/mpeg',
			'mp3' => 'audio/mp3',
			'mpga' => 'audio/mpeg',
			'oga' => 'audio/ogg',
			'ogg' => 'audio/ogg',
			'ra' => 'audio/x-realaudio',
			'ram' => 'audio/x-pn-realaudio',
			'rm' => 'audio/x-pn-realaudio',
			'rpm' => 'audio/x-pn-realaudio-plugin',
			'wav' => 'audio/wav',
			
			'3g2' => 'video/3gpp2',
			'3gp' => 'video/3gp',
			'avi' => 'video/avi', 
			'f4v' => 'video/mp4',
			'flv' => 'video/x-flv',
			'm4v' => 'video/mp4',
			'movie' => 'video/x-sgi-movie',
			'mp4' => 'video/mp4',
			'mpe' => 'video/mpeg',
			'mpeg' => 'video/mpeg',
			'mpg' => 'video/mpeg',
			'mov' => 'video/quicktime',
			'ogv' => 'video/ogg',
			'qt' => 'video/quicktime',
			'rv' => 'video/vnd.rn-realvideo',
			'wmv' => 'video/x-ms-wmv',
			
			'm3u' => 'text/plain',
			'm4u' => 'application/vnd.mpegurl',
			'smi' => 'application/smil',
			'smil' => 'application/smil',
			'vlc' => 'application/videolan',
		);
		
		//$ext = strtolower(array_pop(explode('.', $file)));
		$ext = strtolower( pathinfo($file, PATHINFO_EXTENSION) );
		if ( array_key_exists($ext, $mime_types) )
		{
			$mimetype = $mime_types[$ext];
		}
		// open with FileInfo
		elseif ( function_exists('finfo_open') )
		{
			$finfo = finfo_open(FILEINFO_MIME_TYPE);
			if ( is_resource($finfo) )
			{
				$mimetype = finfo_file($finfo, $file);
			}
			finfo_close($finfo);
		}
		// open with deprecated mime_content_type
		elseif ( function_exists('mime_content_type') )
		{
			//$mimetype = mime_content_type($file);
			$mimetype = preg_replace('~^(.+);.*$~', '$1', mime_content_type($file));
		}
		elseif ( $check_file && function_exists('getimagesize') )
		{
			// open with GD
			$info = getimagesize($file);
			$mimetype = $info['mime'];
		}
		elseif ( function_exists('exif_imagetype') )
		{
			// open with EXIF
			$mimetype = image_type_to_mime_type(exif_imagetype($file));
		}
		else
		{
			$mimetype = 'application/octet-stream';
		}
		
		return $mimetype;
	}
}

// ------------------------------------------------------------------------

/** 
* Create a normalized path.
* 
* @access public
* @param string $path
* @return string The normalized path.
*/
if ( ! function_exists('normalize_path') )
{
	function normalize_path( $path = '', $is_absolute = true )
	{
		// Normalize relative path
		// Swap directory separators to Unix style for consistency
		$path = str_replace('\\', '/', $path);
		$path = $is_absolute ? rtrim($path, '/') : trim($path, '/');
		$path .= $path ? '/' : '';
		return $path;
	}
}

// ------------------------------------------------------------------------

/** 
* Get the full file path from a relative path.
* 
* @access public
* @param string $relative_path
* @return string The full path.
*/
if ( ! function_exists('get_full_path') )
{
	function get_full_path( $relative_path = '' )
	{
		$relative_path = normalize_path($relative_path);
		$absolute_path = ROOTPATH . $relative_path;
		$absolute_path = realpath($absolute_path);
		
		// In case a relative directory was passed
		if ( is_dir($absolute_path) )
		{
			return normalize_path($absolute_path);
		}
		// In case a relative file was passed
		elseif ( is_file($absolute_path) )
		{
			return normalize_path(dirname($absolute_path));
		}
		
		return false;
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('get_site_file_info') )
{
	function get_site_file_info( $relative_path = '', $file = '' )
	{
		$extension = (string)strrchr($file, '.');
		$filename = substr($file, 0, strlen($file) - strlen($extension));
		$relative_path = normalize_path($relative_path);
		$relative_file = $relative_path . $file;//$filename . '_s' . $extension
		$absolute_path = get_full_path($relative_path);
		$absolute_file = $absolute_path . $file;
		$file_exists = ( $file && file_exists($absolute_file) && is_file($absolute_file) );
		$filesize = $file_exists ? filesize($absolute_file) : '';
		$last_edit_time = $file_exists ? filemtime($absolute_file) : '';//isset($item['modified_datetime']) ? strtotime($item['modified_datetime'] . ' UTC') : time();
		
		//$img_src = base_url() . $relative_path . $filename . '_s' . $extension . '?' . $last_edit_time;
		
		return array(
			'file' => $file,
			'extension' => $extension,
			'filename' => $filename,
			'relative_path' => $relative_path,
			'relative_file' => $relative_file,
			'relative_file_prefix' => $relative_path . $filename,
			'absolute_path' => $absolute_path,
			'absolute_file' => $absolute_file,
			'absolute_file_prefix' => $absolute_path . $filename,
			'exists' => $file_exists,
			'filesize' => $filesize,
			'last_edit_time' => $last_edit_time,
			'image_info' => $file_exists ? get_image_info($absolute_file) : null,
		);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('get_image_info') )
{
	function get_image_info( $absolute_file )
	{
		// Check if file exists
		if ( ! file_exists($absolute_file) || ! is_file($absolute_file) )
		{
			return;
		}
		
		// Check if image info gathered
		$vals = @getimagesize($absolute_file);
		if ( ! $vals )
		{
			return;
		}
		
		// Gather image information
		$types = array(1 => 'gif', 2 => 'jpeg', 3 => 'png');
		$type = isset($types[$vals['2']]) ? $types[$vals['2']] : $types[2];
		$mime = 'image/' . $type;
		
		$filesize = filesize($absolute_file);
		$mtime = filemtime($absolute_file);
		
		$image_info = array(
			'source_image' => $absolute_file,
			
			'width' => $vals['0'],
			'height' => $vals['1'],
			'size_str' => $vals['3'],
			
			'type' => $type,
			'image_type' => $vals['2'],
			'mime_type' => $mime,
			
			'filesize' => $filesize,
			'mtime' => $mtime,
		);
		
		return $image_info;
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('scale_value') )
{
	/*
	// http://stackoverflow.com/questions/929103/convert-a-number-range-to-another-range-maintaining-ratio
	// http://habitualcode.com/post/2010/10/10/Scaling-Numbers-From-One-Number-Range-To-Another.aspx
	Scaled Value  = (A-B) * (E-D) / (C-B) + D

	Where:
	A = Value to Scale
	B = From Minimum
	C = From Maximum
	D = To Minimum
	E = To Maximum
	*/
	function scale_value( $from_val, $from_min, $from_max, $to_min, $to_max )
	{
		$from_val_normalized = $from_val - $from_min;
		$from_diff = $from_max - $from_min;
		$to_diff = $to_max - $to_min;
		$to_val = (($from_val_normalized * $to_diff) / $from_diff) + $to_min;
		return $to_val;
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('check_file_cache') )
{
	/**
	* $ttl Cache time to live in seconds
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

if ( ! function_exists('curl') )
{
	/**
	* Get a web file (HTML, XHTML, XML, image, etc.) from a URL.  Return an
	* array containing the HTTP server response header fields and content.
	*/
	function curl( $url )
	{
		if ( ! function_exists('curl_init') ) die('CURL is not installed!');
		//Fetch the url using the CURL Library
		$options = array(
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => true,// return the content
			CURLOPT_HEADER => false,// don't return headers
			CURLOPT_FOLLOWLOCATION => true,// follow redirects
			CURLOPT_ENCODING => '',// handle all encodings
			CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2228.0 Safari/537.36',// who am i
			CURLOPT_AUTOREFERER => true,// set referer on redirect
			CURLOPT_CONNECTTIMEOUT => 120,// timeout on connect
			CURLOPT_TIMEOUT => 120,// timeout on response
			CURLOPT_MAXREDIRS => 10,// stop after 10 redirects
		);
		$ch = curl_init();
		curl_setopt_array($ch, $options);
		$content = curl_exec($ch);
		$err = curl_errno($ch);
		$errmsg = curl_error($ch);
		$header = curl_getinfo($ch);
		curl_close($ch);
		return $content;
	}
}

// --------------------------------------------------------------------
