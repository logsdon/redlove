<?php
/**
* Imaging helper library
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

require_once('Imaging.php');
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





//header('Content-type: image/png');
//imagepng($rotation);
//imagedestroy($source);
//imagedestroy($rotation);


$file = '8f22e30b4eff5cbda9bb8b2e7fa5c205.jpg';

$IM = new Imaging();

if ( ! empty($_GET['rotate']) )
{
	$file = $IM->rotate_from_exif($file);
}

// Output and free from memory
$IM->imagesaveas($file, 'mytest.jpg', 100, null, true);

exit;

// Create image resource
//$image = imagecreatefromstring($file);
//$image = imagecreatefromstring(file_get_contents($_FILES['image_upload']['tmp_name']));

* 
*/
class Imaging
{
	// --------------------------------------------------------------------
	// Public properties
	// --------------------------------------------------------------------
	
	/**
	* File permissions
	* 
	* @var array
	*/
	public $file_permissions = array
	(
		'FILE_READ_MODE' => 0644,
		'FILE_WRITE_MODE' => 0666,
		'DIR_READ_MODE' => 0755,
		'DIR_WRITE_MODE' => 0755,
	);
	
	/**
	* PHP image types
	* 
	* @var array
	*/
	public $image_types = array
	(
		0 => 'UNKNOWN',
		1 => 'GIF',
		2 => 'JPEG',
		3 => 'PNG',
		4 => 'SWF',
		5 => 'PSD',
		6 => 'BMP',
		7 => 'TIFF_II',
		8 => 'TIFF_MM',
		9 => 'JPC',
		10 => 'JP2',
		11 => 'JPX',
		12 => 'JB2',
		13 => 'SWC',
		14 => 'IFF',
		15 => 'WBMP',
		16 => 'XBM',
		17 => 'ICO',
		18 => 'COUNT',
	);
	
	// --------------------------------------------------------------------
	// Private properties
	// --------------------------------------------------------------------
	
	/**
	* Stored parameters
	* 
	* @var array
	*/
	private $_params;
	
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
		// Set default values for missing keys
		$default_params = array(
		);
		$this->_params = array_merge($default_params, $params);
	}
	
	// --------------------------------------------------------------------
	
	/**
	* Create a data uri in the format:  data:{mime};base64,{data}
	* This can then be used for an img src attribute.
	*/
	public function create_data_uri ( $image_file, $mime = '' )
	{
		if ( $this->is_gd($image_file) )
		{
			// Buffer image output
			ob_start();
			imagepng($image_file);
			$contents = ob_get_contents();
			ob_end_clean();
			imagedestroy($image_file);
			
			if ( $mime === '' )
			{
				$mime = 'image/png';
			}
		}
		elseif ( is_file($image_file) )
		{
			$contents = file_get_contents($image_file);
			
			if ( $mime === '' )
			{
				$mime = $this->get_mimetype($image_file);
			}
		}
		else
		{
			return;
		}
		
		return 'data:' . $mime . ';base64,' . base64_encode($contents);
	}
	
	// --------------------------------------------------------------------
	
	/** 
	* http://php.net/manual/en/function.imagecopyresampled.php#112742
	*/
	public function crop ( $params = array() )
	{
		$default_params = array(
			'src' => '',
			'src_info' => '',
			'src_x' => 0,
			'src_y' => 0,
			'src_width' => 0,
			'src_height' => 0,
			'src_scale' => 1.0,
			
			'align' => '',
			'x_align' => 'left',//left, center, right, %
			'y_align' => 'top',//top, center, bottom, %
			'x_axis' => 0,
			'y_axis' => 0,
			
			'width' => '',
			'height' => '',
			
			'scale' => '',//inside, outside, stretch, width, height
			
			'write_file' => '',
		);
		$params = array_merge($default_params, $params);
		extract($params);
		
		$dst_x = 0;
		$dst_y = 0;
		$dst_width = $width;
		$dst_height = $height;
		
		// Create an image resource
		$src_image = $this->imagecreatefrom($src);
		$src_width = imagesx($src_image);
		$src_height = imagesy($src_image);
		
		$scale_x = $src_scale;
		$scale_y = $src_scale;
		$src_x *= $scale_x;
		$src_y *= $scale_y;
		
		// Resize if requested
		if ( $scale != '' )
		{
			$scale_data = $this->get_scale($params);
			$scale_x = $scale_data['scale_x'];
			$scale_y = $scale_data['scale_y'];
			$dst_x = $scale_data['x'];
			$dst_y = $scale_data['y'];
			$dst_width = $scale_data['width'];
			$dst_height = $scale_data['height'];
		}
		else
		{
			// Instead of stretching the source to destination dimensions, keep things at scale or 1:1
			$src_to_dst_scale_x = $dst_width / $src_width;
			$src_to_dst_scale_y = $dst_height / $src_height;
			$src_width = ($src_width * $src_to_dst_scale_x) / $scale_x;
			$src_height = ($src_height * $src_to_dst_scale_y) / $scale_y;
		}
		
		// If aligning oversized source (cropping and/or trimming)
		if ( $align !== '' )
		{
			$alignment_data = $this->get_alignment(array(
				'align' => $align,
				'src_width' => $dst_width,
				'src_height' => $dst_height,
				'width' => $width ,
				'height' => $height,
			));
			$width = $alignment_data['width'];
			$height = $alignment_data['height'];
			$src_x = $alignment_data['x'] * $scale_x;// * $scale_data['scale_x']
			$src_y = $alignment_data['y'] * $scale_y;// * $scale_data['scale_y']
		}
		
		$dst_image = imagecreatetruecolor($width, $height);
		
		// Cropping
		imagecopyresampled(
			$dst_image,
			$src_image,
			$dst_x,
			$dst_y,
			$src_x,
			$src_y,
			$dst_width,
			$dst_height,
			$src_width,
			$src_height
		);
		
		// If saving as a file
		if ( $write_file !== '' )
		{
			return $this->imagesaveas(array(
				'image' => $dst_image,
				'file' => $write_file,
			));
		}
		
		return $dst_image;
	}
	
	// --------------------------------------------------------------------
	
	/**
	* 
	*/
	public function flip ( $image_resource, $mode = '' )
	{
		// Create an image resource
		$image_resource = $this->imagecreatefrom($image_resource);
		
		$width = imagesx( $image_resource );
		$height = imagesy( $image_resource );

		$image_x = 0;
		$image_y = 0;
		$image_width = $width;
		$image_height = $height;

		switch ( $mode )
		{
			case '1':
			case 'vertical':
				$image_y = $height - 1;
				$image_height = - $height;
			break;

			case '2':
			case 'horizontal':
				$image_x = $width - 1;
				$image_width = - $width;
			break;

			case '3':
			case 'both':
				$image_x = $width - 1;
				$image_y = $height - 1;
				$image_width = - $width;
				$image_height = - $height;
			break;

			default:
				return $image_resource;
		}

		$new_image_resource = imagecreatetruecolor( $width, $height );

		if ( imagecopyresampled( $new_image_resource, $image_resource, 0, 0, $image_x, $image_y , $width, $height, $image_width, $image_height ) )
		{
			imagedestroy($image_resource);
			return $new_image_resource;
		}

		return $image_resource;
	}

	// --------------------------------------------------------------------

	/** 
	* 
	*/
	public function get_alignment ( $params = array() )
	{
		$default_params = array(
			'src' => '',
			'src_width' => 0,
			'src_height' => 0,
			'src_coord_scale' => 1.0,
			
			'dst' => '',
			'width' => 0,//* Required
			'height' => 0,//* Required
			
			'align' => '',
			'x_align' => 'left',//left, center, right, %
			'y_align' => 'top',//top, center, bottom, %
			'x_axis' => 0,
			'y_axis' => 0,
			
			// Trim final image canvas dimensions if greater than the source dimensions
			'trim' => true,
		);
		$params = array_merge($default_params, $params);
		extract($params);
		
		$dst_height = $height;
		$x = 0;// left
		$y = 0;// top
		
		// If alignment given in comma-delimted form
		if ( $align != '' )
		{
			$align = array_map('trim', explode(',', $align));
			$x_align = $align[0];
			$y_align = ( count($align) > 1 ) ? $align[1] : $align[0];
		}
		
		// If not aligning to the top left
		if ( $x_align != 'left' || $y_align != 'top' )
		{
			// Get image info
			if ( ! empty($src) && ($src_width <= 0 && $src_height <= 0) )
			{
				$src_info = $this->get_image_info($src);
				$src_width = $src_info['width'];
				$src_height = $src_info['height'];
			}
			
			// Get image info
			if ( ! empty($dst) )
			{
				$dst_info = $this->get_image_info($dst);
				$width = $dst_info['width'];
				$height = $dst_info['height'];
			}
			
			// X Align
			if ( $src_width > $width )
			{
				if ( $x_align == 'center' )
				{
					$x = floor( ($src_width - $width) / 2 );
				}
				elseif ( $x_align == 'right' )
				{
					$x = floor( $src_width - $width );
				}
				elseif ( strpos($x_align, '%') !== false )
				{
					$x = floor( ($src_width - $width) * (float)($x_align / 100) ) ;
				}
			}
			
			// Y Align
			if ( $src_height > $height )
			{
				if ( $y_align == 'center' || $y_align == 'middle' )
				{
					$y = floor( ($src_height - $height) / 2 );
				}
				elseif ( $y_align == 'bottom' )
				{
					$y = floor( $src_height - $height );
				}
				elseif ( strpos($y_align, '%') !== false )
				{
					$y = floor( ($src_height - $height) * (float)($y_align / 100) ) ;
				}
			}
		}
		
		// Trim final image canvas dimensions if greater than the source dimensions
		if ( $trim )
		{
			if ( $width > $src_width )
			{
				$width = $src_width;
			}
			
			if ( $height > $src_height )
			{
				$height = $src_height;
			}
		}
		
		return array(
			'x' => $x,
			'y' => $y,
			'width' => $width,
			'height' => $height,
		);
	}
	
	// --------------------------------------------------------------------
	
	/**
	* Get file or data uri exif
	*/
	public function get_exif ( $image_file, $debug = null )
	{
		$exif = @exif_read_data($image_file, null, true);
		
		if ( $exif && isset($debug) )
		{
			foreach ( $exif as $key => $section )
			{
				foreach ( $section as $name => $val )
				{
					echo "$key.$name: $val<br />\n";
				}
			}
		}
		
		return $exif;
	}

	// --------------------------------------------------------------------

	/** 
	* 
	*/
	public function get_image_info ( $image_file )
	{
		// Check if resource
		if ( $this->is_gd($image_file) )
		{
			return array(
				'type' => 'jpeg',
				'mime_type' => 'image/jpeg',
				'width' => imagesx($image_file),
				'height' => imagesy($image_file),
			);
		}
		
		// Check if data uri
		if ( $this->is_data_uri($image_file) )
		{
			$parsed_data_uri = $this->parse_data_uri($image_file);
			$image_file = imagecreatefromstring( $parsed_data_uri['decoded'] );
			
			return array(
				'type' => strtolower(str_ireplace('image/', '', $parsed_data_uri['mime'])),
				'mime_type' => $parsed_data_uri['mime'],
				'width' => imagesx($image_file),
				'height' => imagesy($image_file),
			);
		}
		
		// Check if file exists
		if ( ! is_file($image_file) )
		{
			return;
		}
		
		// Check if image info gathered
		$vals = @getimagesize($image_file);
		if ( ! $vals )
		{
			return;
		}
		
		// Gather image information
		$type = ( isset($this->image_types[$vals['2']]) ) ? $this->image_types[$vals['2']] : $this->image_types[2];//image_type_to_extension( $type )
		$type = strtolower($type);
		$mime = 'image/' . $type;
		
		$image_info = array(
			'source_image' => $image_file,
			
			'width' => $vals['0'],
			'height' => $vals['1'],
			'size_str' => $vals['3'],
			
			'type' => $type,
			'image_type' => $vals['2'],
			'mime_type' => $mime,
			
			'filesize' => filesize($image_file),
			'last_modified' => filemtime($image_file),
		);
		
		return $image_info;
	}

	// --------------------------------------------------------------------

	/**
	* Get the mime type
	* 
	* @param str $image_file Path to the file including the filename
	* @return bool|string False or the mime type
	*/
	public function get_mimetype ( $image_file )
	{
		if ( $this->is_data_uri($image_file) )
		{
			// Parse data uri
			$parsed_data_uri = $this->parse_data_uri($image_file);
			return $parsed_data_uri['mime'];
		}
		
		if ( ! is_file($image_file) )
		{
			return false;
		}
		
		$mimetype = false;
		
		if ( function_exists('finfo_fopen') )
		{
			// open with FileInfo
			$finfo = finfo_open(FILEINFO_MIME_TYPE);

			if ( is_resource($finfo) )
			{
				$mimetype = finfo_file($finfo, $image_file);
			}

			finfo_close($finfo);
		}
		elseif ( function_exists('getimagesize') )
		{
			// open with GD
			if ( $data = @getimagesize($image_file) )
			{
				$mimetype = $data['mime'];
			}
		}
		elseif ( function_exists('exif_imagetype') )
		{
			// open with EXIF
			$mimetype = image_type_to_mime_type(exif_imagetype($image_file));
		}
		elseif ( function_exists('mime_content_type') )
		{
			$mimetype = preg_replace('~^(.+);.*$~', '$1', mime_content_type($image_file));
		}
		
		return $mimetype;
	}
	
	// --------------------------------------------------------------------
	
	/** 
	* 
	*/
	public function get_scale ( $params = array() )
	{
		$default_params = array(
			'scale' => 'stretch',//inside, outside, stretch, width, height
			
			'src' => '',
			'src_x' => 0,
			'src_y' => 0,
			'src_width' => 0,
			'src_height' => 0,
			'src_scale' => 1.0,
			
			'x' => 0,
			'y' => 0,
			'width' => 0,
			'height' => 0,
			
			'max_width' => '',
			'max_height' => '',
			
			'priority_dimension' => 'auto',//auto, width, height
		);
		$params = array_merge($default_params, $params);
		extract($params);
		
		// Get image info
		if ( ! empty($src) )
		{
			$source_info = $this->get_image_info($src);
			$src_width = $source_info['width'];
			$src_height = $source_info['height'];
		}
		
		$src_width *= $src_scale;
		$src_height *= $src_scale;
		
		// The source aspect ratio
		$src_aspect_ratio = $src_width / $src_height;
		
		$width = ( $width > 0 ) ? $width : $src_width;
		$height = ( $height > 0 ) ? $height : $src_height;
		// The destination aspect ratio
		$dst_aspect_ratio = $width / $height;
		
		// Scale the destination image dimensions accordingly
		$aspect_ratio = $dst_aspect_ratio;
		
		// Proportionate, largest side inside destination
		if ( $scale == 'inside' )
		{
			$aspect_ratio = $src_aspect_ratio;
			
			// If favoring the width or auto source width is larger
			if ( $priority_dimension == 'width' || ( $priority_dimension == 'auto' && $aspect_ratio >= 1 ) )
			{
				$height = $width / $aspect_ratio;
			}
			else
			{
				$width = $height * $aspect_ratio;
			}
		}
		// Proportionate, smallest side inside destination
		elseif ( $scale == 'outside' )
		{
			$aspect_ratio = $src_aspect_ratio;
			
			// If favoring the width or auto source width is larger
			if ( $priority_dimension == 'width' || ( $priority_dimension == 'auto' && $aspect_ratio >= 1 ) )
			{
				$width = $height * $aspect_ratio;
			}
			else
			{
				$height = $width / $aspect_ratio;
			}
		}
		elseif ( $scale == 'width' )
		{
			$height = $src_height;
		}
		elseif ( $scale == 'height' )
		{
			$width = $src_width;
		}
		
		// Constrain dimensions within maxes
		if ( $max_width > 0 && $width > $max_width )
		{
			$width = $max_width;
			$height = $width / $aspect_ratio;
		
		}
		if ( $max_height > 0 && $height > $max_height )
		{
			$height = $max_height;
			$width = $height * $aspect_ratio;
		}
		
		// Normalize values
		$height = round($height);
		$width = round($width);
		
		// Create scaled values separately for safekeeping as the dst values may change with cropping
		$dst_scaled_w = $width;
		$dst_scaled_h = $height;
		
		// The dimensions of the source staged for cropped may be different
		// Adjust the crop coordinates to the scale of the staged src image
		$scale_x = $src_width / $width;
		$scale_y = $src_height / $height;
		$dst_src_scale = $width / $src_width;
		$dst_src_scale_x = $width / $src_width;
		$dst_src_scale_y = $height / $src_height;
		$dst_src_scale_max = max($dst_src_scale_x, $dst_src_scale_y);
		$dst_src_scale_min = min($dst_src_scale_x, $dst_src_scale_y);
		
		return array(
			'scale' => $scale,
			'aspect_ratio' => $aspect_ratio,
			
			'src_x' => $src_x,
			'src_y' => $src_y,
			'src_width' => $src_width,
			'src_height' => $src_height,
			
			'x' => $x,
			'y' => $y,
			'width' => $width,
			'height' => $height,
			
			'scale_x' => $scale_x,
			'scale_y' => $scale_y,
			'dst_src_scale' => $dst_src_scale,
			
			'priority_dimension' => $priority_dimension,
		);
	}
	
	// --------------------------------------------------------------------
	
	/**
	* Create an image resource from an image file.
	* 
	* @access public
	* @param object $file The image file.
	* @param array $image_info The image info.
	* @return object Image resource.
	*/
	public function imagecreatefrom ( $file, $image_info = null )
	{
		if ( $this->is_gd($file) )
		{
			$image = $file;
		}
		elseif ( $this->is_data_uri($file) )
		{
			$parsed_data_uri = $this->parse_data_uri($file);
			$image = imagecreatefromstring( $parsed_data_uri['decoded'] );
		}
		elseif ( is_string($file) && is_file($file) )
		{
			if ( ! isset($image_info) )
			{
				$image_info = $this->get_image_info($file);
			}
			
			$type = $image_info['type'];
			
			// Create image memory from source
			if ( $type == 'png' )
			{
				$image = imagecreatefrompng( $file );
				/*
				imagealphablending($image, false);
				imagesavealpha($image, true);
				
				//$transparent = imagecolorallocatealpha($source, 0, 0, 0, 127);
				//imagefilledrectangle($source, 0, 0, $width, $height, $transparent);
				
				$src_transparent_color = imagecolortransparent( $src_img );
				if ( $src_transparent_color >= 0 && $src_transparent_color < imagecolorstotal( $src_img ) )
				{
					$src_transparent_color = imagecolorsforindex( $src_img, $src_transparent_color );
					$dst_transparent_color = imagecolorallocate( $dst_img, $src_transparent_color['red'], $src_transparent_color['green'], $src_transparent_color['blue'] );
					imagefill( $dst_img, 0, 0, $dst_transparent_color );
					imagecolortransparent( $dst_img, $dst_transparent_color );
				}
				*/
			}
			elseif ( $type == 'jpeg' )
			{
				$image = imagecreatefromjpeg( $file );
			}
			elseif ( $type == 'gif' )
			{
				$image = imagecreatefromgif( $file );
			}
			elseif ( $type == 'bmp' )
			{
				$image = imagecreatefromwbmp( $file );
			}
		}
		
		// Check for failure
		if ( empty($image) )
		{
			// Create a blank image
			$image = imagecreatetruecolor( 150, 30 );
			$background_color = imagecolorallocate( $image, 255, 255, 255 );
			$text_color = imagecolorallocate( $image, 0, 0, 0 );

			imagefilledrectangle( $image, 0, 0, 150, 30, $background_color );

			// Output an error message
			imagestring( $image, 1, 5, 5, 'Error loading ' . $file, $text_color );
		}
		
		return $image;
	}

	// --------------------------------------------------------------------

	/** 
	* 
	* Save an image resource as an image file.
	* 
	* @access public
	* @param array $params Image parameters: 
	* 		image (the image resource)
	* 		file (the write file)
	* 		quality (image quality if applicable, default 100)
	* 		screen (output to screen instead of file, default false)
	* 		from_type (if png, use a white background instead of transparency for saving as other image types, default '')
	* @return null|bool If output to screen, null. Otherwise success of write.
	*
	* http://stackoverflow.com/questions/1201798/use-php-to-convert-png-to-jpg-with-compression
	* http://ellislab.com/codeigniter/user-guide/libraries/image_lib.html
	*/
	public function imagesaveas ( $params = array() )
	{
		// Check if individual arguments were passed instead if an array of parameters
		if ( ! is_array($params) )
		{
			$args = func_get_args();
			$params = array();
			$params['image'] = $args[0];
			
			if ( isset($args[1]) )
			{
				$params['file'] = $args[1];
			}
			
			if ( isset($args[2]) )
			{
				$params['quality'] = $args[2];
			}
			
			if ( isset($args[3]) )
			{
				$params['screen'] = $args[3];
			}
			
			if ( isset($args[4]) )
			{
				$params['from_type'] = $args[4];
			}
		}
		
		// Merge passed parameters with defaults
		$default_params = array(
			'image' => '',
			'file' => '',
			'quality' => 100,
			'screen' => false,
			'from_type' => null,
			'destroy' => true,
		);
		$params = array_merge($default_params, $params);
		extract($params);
		
		// Create an image resource
		$image = $this->imagecreatefrom($image);
		
		// Gather image information
		$type = strtolower(substr( strrchr($file, '.'), 1 ));
		
		if ( $screen )
		{
			$file = null;
		}
		else
		{
			/*
			$dir = dirname($fileName);
			if  ( ! is_dir($dir) )
			{
				if ( ! mkdir($dir, $this->file_permissions['DIR_WRITE_MODE'], true) )
				{
					throw new RuntimeException('Error creating directory ' . $dir);
				}
			}
			*/
		}
		
		// Save destination image memory as new image
		if ( $type == 'gif' )
		{
			if ( $screen )
			{
				header('Content-Type: image/gif');
			}
			$success = imagegif($image, $file);
		}
		elseif ( $type == 'png' )
		{
			if ( $screen )
			{
				header('Content-Type: image/png');
			}
			$success = imagepng($image, $file, $quality);
		}
		elseif ( $type == 'bmp' )
		{
			if ( $screen )
			{
				header('Content-Type: image/bmp');
			}
			$success = imagewbmp($image, $file);
		}
		else
		{
			// Fill transparent png background with white before converting to jpeg
			if ( $from_type == 'png' )
			{
				$width = imagesx( $image );
				$height = imagesy( $image );
				
				// Create destination image memory
				$temp_image = imagecreatetruecolor($width, $height);
				// Set background to white
				imagefill($temp_image, 0, 0, imagecolorallocate($temp_image, 255, 255, 255));
				imagealphablending($temp_image, true);
				// Copy transparent png onto white background
				imagecopy($temp_image, $image, 0, 0, 0, 0, $width, $height);
				// Swap around the temporary image as the new source image
				imagedestroy($image);
				$image = $temp_image;
			}
			
			//$quality = 80; // 0 = worst / smaller file, 100 = better / bigger file
			if ( $screen )
			{
				header('Content-Type: image/jpeg');
			}
			$success = imagejpeg($image, $file, $quality);
		}
		
		// Destroy image memory
		if ( ! empty($temp_image) )
		{
			imagedestroy($temp_image);
		}
		if ( $destroy )
		{
			imagedestroy($image);
		}
		
		if ( $screen )
		{
			exit;
		}
		
		// Update file permissions
		@chmod($file, $this->file_permissions['FILE_WRITE_MODE']);
		
		return $success;
	}

	// --------------------------------------------------------------------
	
	/**
	* http://stackoverflow.com/questions/2556345/detect-base64-encoding-in-php
	* http://php.net/manual/en/function.base64-decode.php
	*/
	public function is_base64_encoded ( $string )
	{
		return preg_match('/^[a-zA-Z0-9\/\r\n+]*={0,2}$/', $string);
	}
	
	// --------------------------------------------------------------------
	
	/**
	* https://gist.github.com/FlyingTopHat/3661056
	*/
	public function is_data_uri ( $string )
	{
		return ( is_string($string) && preg_match('/^data:(.+?){0,1}(?:(?:;(base64)\,){1}|\,)(.+){0,1}$/', $string) );
	}
	
	// --------------------------------------------------------------------
	
	/**
	* 
	*/
	public function is_gd ( $image )
	{
		return ( is_resource($image) && get_resource_type($image) == 'gd' );
	}
	
	// --------------------------------------------------------------------
	
	/**
	* Use the GD library to create an image resource from a file.
	* This function keeps you from having to determine what type 
	* of function needs to be used for the file.
	* 
	* @access public
	* @param string $bg_full_path The full path to the background image file.
	* @param string $fg_full_path The full path to the foreground image file.
	* @param string $file_full_path The full path to the image file to save.
	* @param int $fg_x The x coordinate to overlay the foreground on the background.
	* @param int $fg_y The y coordinate to overlay the foreground on the background.
	*/
	public function merge_images ( $bg_full_path, $fg_full_path, $file_full_path = '', $fg_x = 0, $fg_y = 0, $add_transparency = false )
	{
		// Create new images
		$bg = $this->imagecreatefrom( $bg_full_path );
		$fg = $this->imagecreatefrom( $fg_full_path );
		
		//Grab width and height
		$bg_w = imagesx( $bg );
		$bg_h = imagesy( $bg );
		$fg_w = imagesx( $fg );
		$fg_h = imagesy( $fg );
		
		$image_width = $bg_w;
		$image_height = $bg_h;
		if ( $fg_w > $image_width )
		{
			$image_width = $fg_w;
		}
		if ( $fg_h > $image_height )
		{
			$image_height = $fg_h;
		}
		
		// Merge the two images
		imagecopy( $bg, $fg, $fg_x, $fg_y, 0, 0, $image_width, $image_height );
		
		// If there is not target file to write to, output to the browser:
		if ( $file_full_path === '' )
		{
			// Output header
			header('Content-type: image/png');
			
			// Set up transparency
			if ( $add_transparency === true )
			{
				$rgb_index = imagecolorat( $bg, 1, 1 );// Get first pixel color
				$colors = imagecolorsforindex( $bg, $rgb_index );// Get color associative array
				$transparent_color = imagecolorallocate( $bg, $colors['red'], $colors['green'], $colors['blue'] );// Transparent color
				imagecolortransparent( $bg, $transparent_color );// Make color transparent
			}
			
			// Send new image to browser
			imagepng( $bg );
			imagedestroy( $bg );
		}
		// Else write to the target file:
		else
		{
			imagejpeg( $bg, $file_full_path, 90 );
			imagedestroy( $bg );
		}
		
	}
    
	// --------------------------------------------------------------------
	
	/**
	* From a data: uri string, parse data
	* 
	* @access public
	* @param string $data_uri The data string.
	* @return object Image resource.
	*/
	public function parse_data_uri ( $data_uri )
	{
		// Parse data uri
		//$data_uri = 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7';
		$split_data = explode(',', $data_uri, 2);
		$mime_string = str_replace(array('data:', 'data://', ';base64'), '', $split_data[0]);
		$byte_string = $split_data[1];//substr($data_uri, strpos($data_uri, ',') + 1);
		$encoded_data = str_replace(' ', '+', $byte_string);
		$decoded_data = base64_decode($encoded_data);
		//$generated_data_uri = 'data:' . $mime_string . ';base64,' . base64_encode($decoded_data);
		//echo '<img src="' . $generated_data_uri . '">';
		//$image_resource = imagecreatefromstring($decoded_data);
		
		return array (
			'mime' => $mime_string,
			'encoded' => $encoded_data,
			'decoded' => $decoded_data,
		);
	}
	
	// --------------------------------------------------------------------
	
	/**
	* Resize an image.
	* 
	* @access public
	* @param array $params
	* @return object An image resource
	*/
	public function resize ( $params = array() )
	{
		$default_params = array(
			// Scale parameters
			'scale' => 'stretch',//inside, outside, stretch, width, height
			
			'src' => '',
			'src_x' => 0,
			'src_y' => 0,
			'src_width' => 0,
			'src_height' => 0,
			'src_scale' => 1.0,
			
			'dst_x' => 0,
			'dst_y' => 0,
			'width' => 0,
			'height' => 0,
			
			'max_width' => '',
			'max_height' => '',
			
			'priority_dimension' => 'auto',//auto, width, height
			
			// Cropping parameters
			'align' => '',
			'x_align' => 'left',//left, center, right, %
			'y_align' => 'top',//top, center, bottom, %
			'x_axis' => 0,
			'y_axis' => 0,
			
			'write_file' => '',
		);
		$params = array_merge($default_params, $params);
		extract($params);
		
		$dst_width = $width;
		$dst_height = $height;
		
		$src_image = $this->imagecreatefrom($src);
		$src_width = imagesx($src_image);
		$src_height = imagesy($src_image);
		
		$scale_x = $src_scale;
		$scale_y = $src_scale;
		$src_x *= $scale_x;
		$src_y *= $scale_y;
		
		// Resize if requested
		if ( $scale != '' )
		{
			$scale_data = $this->get_scale($params);
			$scale_x = $scale_data['scale_x'];
			$scale_y = $scale_data['scale_y'];
			$dst_x = $scale_data['x'];
			$dst_y = $scale_data['y'];
			$dst_width = $scale_data['width'];
			$dst_height = $scale_data['height'];
		}
		
		// If aligning oversized source (cropping and/or trimming)
		if ( $align !== '' )
		{
			// Get alignment after scale
			$alignment_data = $this->get_alignment(array(
				'align' => $align,
				'src_width' => $dst_width,
				'src_height' => $dst_height,
				'width' => $width ,
				'height' => $height,
			));
			$width = $alignment_data['width'];
			$height = $alignment_data['height'];
			$src_x = $alignment_data['x'] * $scale_x;
			$src_y = $alignment_data['y'] * $scale_y;
		}
		else
		{
			// Don't crop the image, so make sure it shows the full destination
			$width = $dst_width;
			$height = $dst_height;
		}
		
		// Create the destination image resource
		/*
		if ( $type != 'gif' )
		{
			$dst_img = imagecreatetruecolor( $dst_width, $dst_height );
		}
		else
		{
			$dst_img = imagecreate( $dst_width, $dst_height );
		}
		
		// Additional processing for png / gif transparencies; thanks Dirk Bohl
		if ( $type == 'png' )
		{
			imagealphablending( $dst_img, false );
			imagesavealpha( $dst_img, true );
		}
		elseif ( $type == 'gif' )
		{
			$src_transparent_color = imagecolortransparent( $src_img );
			if ( $src_transparent_color >= 0 && $src_transparent_color < imagecolorstotal( $src_img ) )
			{
				$src_transparent_color = imagecolorsforindex( $src_img, $src_transparent_color );
				$dst_transparent_color = imagecolorallocate( $dst_img, $src_transparent_color['red'], $src_transparent_color['green'], $src_transparent_color['blue'] );
				imagefill( $dst_img, 0, 0, $dst_transparent_color );
				imagecolortransparent( $dst_img, $dst_transparent_color );
			}
		}
		*/
		$dst_image = imagecreatetruecolor($width, $height);
		
		// Transpose source image and coordinates into destination image and coordinates
		imagecopyresampled(
			$dst_image,
			$src_image,
			$dst_x,
			$dst_y,
			$src_x,
			$src_y,
			$dst_width,
			$dst_height,
			$src_width,
			$src_height
		);
		
		// If saving as a file
		if ( $write_file !== '' )
		{
			return $this->imagesaveas(array(
				'image' => $dst_image,
				'file' => $write_file,
			));
		}
		
		return $dst_image;
	}
	
	// --------------------------------------------------------------------
	
	/** 
	* Resize multiple sizes.
	* 
	* @access private
	* @param array $params A parameters array:
	* 		src (the image resource or file)
	* 		sizes (an array of sizes to use with the resize method; additional parameters like suffix are used to create unique files)
	* @return bool
	
	*/
	public function resize_sizes ( $params = array() )
	{
		// Check if individual arguments were passed instead if an array of parameters
		if ( ! is_array($params) )
		{
			$args = func_get_args();
			$params = array();
			$params['src'] = $args[0];
			
			if ( isset($args[1]) )
			{
				$params['sizes'] = $args[1];
			}
		}
		
		// Merge passed parameters with defaults
		$default_params = array(
			'src' => '',
			'write_file' => '',
			'sizes' => array(),
		);
		$params = array_merge($default_params, $params);
		extract($params);
		
		$success = false;
		
		if ( is_string($src) && $write_file === '' )
		{
			$write_file = $src;
		}
		$extension = strtolower(strrchr($write_file, '.'));
		$write_path_and_raw_name = substr($write_file, 0, (strlen($write_file) - strlen($extension)));
		
		$src_image = $this->imagecreatefrom($src);
		$base_resize_params = array(
			'src' => $src_image,
			'destroy' => false,
		);
		
		// For each size
		$sizes_count = count($sizes);
		foreach ( $sizes as $size )
		{
			$suffix = '';
			if ( isset($size['suffix']) )
			{
				$suffix = $size['suffix'];
			}
			$write_file = $write_path_and_raw_name . $suffix . $extension;
			
			// Resize
			$resize_params = array_merge($base_resize_params, $size);
			$image = $this->resize($resize_params);
			
			// Save file
			$success = $this->imagesaveas(array(
				'image' => $image,
				'file' => $write_file,
			));
		}//end for each size
		
		return $success;
	}
	
	// --------------------------------------------------------------------
	
	/**
	* 90, 180, 270//PHP rotates counter-clockwise, so a 90 degree rotation to the right must be specified as 270
	*/
	public function rotate ( $image, $degrees = 0, $color = 0 )
	{
		// Create an image resource
		if ( is_string($image) )
		{
			$image = $this->imagecreatefrom($image);
		}
		
		//PNG
		imagealphablending($image, true);
		imagesavealpha($image, true);
		if ( ! isset($color) )
		{
			$color = imagecolorallocatealpha($image, 0, 0, 0, 127);// Transparent
			//imagefilledrectangle($image, 0, 0, $width, $height, $transparent);
		}
		
		$image = imagerotate($image, $degrees, $color);//, imageColorAllocateAlpha($source, 0, 0, 0, 127)
		
		return $image;
	}

	// --------------------------------------------------------------------
	
	/**
	* 
	*/
	public function rotate_from_exif ( $file, $exif = null, $resave = true, $quality = 100 )
	{
		// Get EXIF if not passed
		if ( ! isset($exif) )
		{
			$exif = $this->get_exif($file);
		}
		
		if ( ! $exif )
		{
			return false;
		}
		
		// Find orientation
		$orientation = 1;
		if ( $exif )
		{
			if ( ! empty($exif['Orientation']) )
			{
				$orientation = $exif['Orientation'];
			}
			elseif ( ! empty($exif['IFD0']['Orientation']) )
			{
				$orientation = $exif['IFD0']['Orientation'];
			}
			elseif ( ! empty($exif['THUMBNAIL']['Orientation']) )
			{
				$orientation = $exif['THUMBNAIL']['Orientation'];
			}
		}
		
		// Create an image resource
		$image = $this->imagecreatefrom($file);
		
		// Modify image resource based on orientation
		switch ( $orientation )
		{
			case 1: // nothing
			break;

			case 2: // horizontal flip
				$image = $this->flip($image, 1);
			break;
			
			case 3: // 180 rotate left
				$image = $this->rotate($image, 180);
			break;
			
			case 4: // vertical flip
				$image = $this->flip($image, 2);
			break;
			
			case 5: // vertical flip + 90 rotate right
				$image = $this->flip($image, 2);
				$image = $this->rotate($image, -90);
			break;
			
			case 6: // 90 rotate right
				$image = $this->rotate($image, -90);
			break;
			
			case 7: // horizontal flip + 90 rotate right
				$image = $this->flip($image, 1);   
				$image = $this->rotate($image, -90);
			break;
			
			case 8: // 90 rotate left
				$image = $this->rotate($image, 90);
			break;
		}
		
		if ( $resave )
		{
			return $this->imagesaveas(array(
				'image' => $image,
				'file' => $file,
				'quality' => $quality,
			));
		}
		
		return $image;
	}

	// --------------------------------------------------------------------

	/**
	* From a data: uri string, save as an image.
	* 
	* @access public
	* @param string $data_uri The data string.
	* @param string $relative_path Relative path where to save file.
	* @param string $file_raw_name The raw name of the file; the extension will be figured out.
	* @return object Image resource.
	*/
	public function save_data_uri ( $data_uri, $write_path, $file_raw_name = null )
	{
		// Parse data uri
		$parsed_data_uri = $this->parse_data_uri($data_uri);
		
		/*
		// Path where the image is going to be saved
		$filePath = $_SERVER['DOCUMENT_ROOT']. '/ima/temp2.png';
		// Write $imgData into the image file
		$file = fopen($filePath, 'w');
		fwrite($file, $imgData);
		fclose($file);
		
		echo file_get_contents('data://text/plain;base64,SSBsb3ZlIFBIUAo=');
		*/
		
		// Set mime and extension info
		$mime_types = array(1 => 'image/gif', 2 => 'image/jpeg', 3 => 'image/png');
		$key = array_search($parsed_data_uri['mime'], $mime_types);
		$key = ( $key !== false ) ? $key : 2;
		$mime_type = $mime_types[$key];
		
		$types = array(1 => 'gif', 2 => 'jpeg', 3 => 'png');
		$type = $types[$key];
		
		$file_extensions = array(1 => 'gif', 2 => 'jpg', 3 => 'png');
		$file_extension = '.' . $file_extensions[$key];
		
		$file_raw_name = isset($file_raw_name) ? $file_raw_name : md5(uniqid(mt_rand(), true));
		$file_name = $file_raw_name . $file_extension;
		
		// Write data to file
		//$write_path = rtrim(ROOT_PATH . $relative_path, '/\\') . '/';
		$full_path = $write_path . $file_name;
		$file_handler = fopen($full_path, 'w');
		$num_bytes_written = fwrite($file_handler, $parsed_data_uri['decoded']);
		fclose($file_handler);
		
		return array(
			'success' => ( $num_bytes_written !== false ),
			'write_path' => $write_path,
			'relative_path' => $relative_path,
			'full_path' => $full_path,
			'raw_name' => $file_raw_name,
			'file_extension' => $file_extension,
			'extension' => $file_extension,
			'file_name' => $file_name,
			'type' => $type,
			'mime_type' => $mime_type,
			'mime_string' => $parsed_data_uri['mime'],
		);
	}

	// --------------------------------------------------------------------

	/*
	$form_field = 'file_match';
	$relative_path = 'images/card';
	if ( ! empty($_FILES[$form_field]['tmp_name']) )
	{
		// Database field
		$field = ! empty($field) ? $field : $form_field;
		
		//$where_data = array('owner_user_id' => $user_id);
		//$this->load->model($this->default_model);
		$where_data = array(
			$this->default_model_id_field => $item_id,
		);
		
		// Use if file is not being overwritten
		// Delete files of fields that are going to be updated
		$params = array(
			'where' => $where_data,
			'fields' => $field,
			'relative_path' => $relative_path,
		);
		$this->{$this->default_model}->delete_image($params);
		
		$this->load->library('utility/imaging');
		$image_params = array(
			// Name of FILE field being uploaded
			'form_field' => $form_field,
			'upload_config' => array(
				// Upload limitations and path
				'allowed_types' => 'gif|jpe|jpg|jpeg|pjpeg|png',
				'upload_path' => $relative_path,//relative_path
				// Upload file name
				//'encrypt_name' => true,
				//'overwrite' => false,
				// or
				'file_name' => ${$this->default_model_parent_id_field} . '__' . $item_id . '__' . $field,
				'overwrite' => true,
			),
			'manipulate_config' => array(
				'resize' => array(
					array(
						'crop' => true,
						'resize' => true,
						'resize_config' => array('constraint' => 'outside'),
						'width' => 154, 
						'height' => 208,
						'suffix' => '_s',
					),
					array(
						'crop' => true,
						'resize' => true,
						'resize_config' => array('constraint' => 'inside'),
						'max_width' => 400, 
						'max_height' => 400,
						'suffix' => '_l',
					),
					// Original image is used throughout, so make it last before it is overwritten
					// Save original, but resize if very large
					array(
						'crop' => false,
						'resize' => true,
						'resize_config' => array('constraint' => 'inside'),
						'max_width' => 2048, 
						'max_height' => 2048,
						'suffix' => '',
					),
				),
			),
		);
		$image_data = $this->imaging->upload_image($image_params);
		if ( $image_data && $image_data['code'] > 0 )
		{
			// Update the image fields
			$params = array(
				'data' => $image_data['value']['field_data'],
				'where' => $where_data,
			);
			$success = $this->{$this->default_model}->update($params);
		}//end if image uploaded
		unset($image_data, $image_params);
	}
	
	
	
	
	
	
	
	
	
	
	
	
	public function delete_image( $params = array() )
	{
		// Set default values for missing keys
		$default_params = array(
			'where' => '',
			'fields' => 'file,file_match',
			'relative_path' => 'images/card',
		);
		$params = array_merge($default_params, $params);
		
		if ( ! is_array($params['where']) || empty($params['where']) )
		{
			return false;
		}
		
		$this->load->helper('file');
		$file_path = get_full_path($params['relative_path']);
		// If the directory DOES NOT exist:
		if ( $file_path == false )
		{
			return false;
		}
		
		if ( ! is_array($params['fields']) )
		{
			$params['fields'] = explode(',', $params['fields']);
		}
		
		// Get file data
		$file_data_params = array(
			'select' => implode(',', $params['fields']),
			'where' => $params['where'],
			'order' => false,
		);
		$query = $this->select($file_data_params);
		// If file data IS NOT found:
		if ( ! $query || $query->num_rows() == 0 )
		{
			return false;
		}
		
		$field_data = array();
		// Delete each file
		foreach ( $query->result_array() as $row )
		{
			foreach ( $params['fields'] as $field )
			{
				$file = $row[$field];
				$file_ext = (string)strrchr($file, '.');
				$filename = substr($file, 0, strlen($file) - strlen($file_ext));
				$relative_path = trim($params['relative_path'], '/');//'images/profile/';
				$relative_path .= ( strlen($relative_path) > 0 ) ? '/' : '';
				$relative_file = $relative_path . $filename . $file_ext;//$file;
				$absolute_path = ROOT_PATH . $relative_path;
				$absolute_file = ROOT_PATH . $relative_file;
				$file_exists = ( strlen($file) > 0 && file_exists($absolute_file) && is_file($absolute_file) );
				$last_edit_time = $file_exists ? filemtime($absolute_file) : '';//isset($item['modified_datetime']) ? strtotime($item['modified_datetime'] . ' UTC') : time();
				//$image = $file_exists ? base_url() . $relative_path . $filename . '_s' . $file_ext . '?' . $last_edit_time : '';
				
				if ( $file_exists )
				{
					$success = @ unlink($absolute_file);
					if ( $success )
					{
						$field_data[$field] = '';
						
						$file_ext = (string)strrchr($file, '.');
						$filename = substr($file, 0, strlen($file) - strlen($file_ext));
						$success = @ unlink($filename . '_s' . $file_ext);
						
						$filename = substr($file, 0, strrpos($file, '.'));
						$file_ext = substr(strrchr($file, '.'), 0);//$file_ext = substr($file, strrpos($file, '.'));
						$success = @ unlink($filename .'_l'. $file_ext);
						
						@ unlink($absolute_path . $filename . '_l' . $file_ext);
						@ unlink($absolute_path . $filename . '_s' . $file_ext);
					}
				}
				
			}
		}
		$query->free_result();
		
		// Update file data
		if ( ! empty($field_data) )
		{
			$params = array(
				'data' => $field_data,
				'where' => $params['where'],
			);
			return $this->update($params);
		}
	}
	
	*/
	/** 
	* 
	
	USAGE:
	
		// Upload images
		$where_data = array(
			'product_id' => $item_id,
		);
		$this->load->library('utility/imaging');
		$form_field = 'image';
		$field = ! empty($field) ? $field : $form_field;
		$image_params = array(
			// Name of FILE field being uploaded
			'form_field' => $form_field,
			'field' => $field,
			'upload_config' => array(
				// Upload limitations and path
				'allowed_types' => 'gif|jpe|jpg|jpeg|pjpeg|png',
				'upload_path' => 'images/featured-products',//relative_path
				// Upload file name
				/*'encrypt_name' => true,
				'overwrite' => false,* /
				// or
				'file_name' => $where_data['product_id'] . '_' . $field . '.jpg',
				'overwrite' => true,
			),
			'manipulate_config' => array(
				'resize' => array(
					array(
						'crop' => true,
						'resize' => true,
						'resize_config' => array('constraint' => 'inside'),
						'width' => 353, 
						'height' => 227,
						'suffix' => '_s',
					),
					// Original image is used throughout, so make it last before it is overwritten
					// Save original, but resize if very large
					array(
						'crop' => false,
						'resize' => true,
						'resize_config' => array('constraint' => 'inside'),
						'max_width' => 2048, 
						'max_height' => 2048,
						'suffix' => '',
					),
				),
			),
		);
		$image_data = $this->_upload_image($image_params);
		if ( $image_data && $image_data['code'] > 0 )
		{
			// Delete images of fields that are going to be updated
			//$where_data = array('owner_user_id' => $user_id);
			$this->load->model($this->default_model);
			// Delete existing image; use if image is not being overwritten or has unique name
			/*
			$params = array(
				'where' => $where_data,
				'fields' => array_keys($field_data),
				'relative_path' => $relative_path,
			);
			$this->{$this->default_model}->delete_image($params);
			* /
			// Update the image fields
			$params = array(
				'data' => $image_data['value']['field_data'],
				'where' => $where_data,
			);
			$success = $this->{$this->default_model}->update($params);
		}//end if image uploaded
		unset($image_data, $image_params);
		
		$form_field = 'large_image';
		$image_params = array(
			// Name of FILE field being uploaded
			'form_field' => $form_field,
			'upload_config' => array(
				// Upload limitations and path
				'allowed_types' => 'gif|jpe|jpg|jpeg|pjpeg|png',
				'upload_path' => 'images/featured-products',//relative_path
				// Upload file name
				'file_name' => $where_data['product_id'] . '_l.jpg',
				'overwrite' => true,
			),
		);
		$image_data = $this->imaging->upload_image($image_params);
		if ( $image_data && $image_data['code'] > 0 )
		{
			$success = true;
		}//end if image uploaded
		unset($image_data, $image_params);
		
	*/
	public function upload_image ( $params = array() )
	{
		/*
		// Stop if no data submitted
		if ( empty($_FILES) )
		{
			return;
		}
		
		if ( ! isset($_FILES[$params['form_field']]) )
		{
			return;
		}
		*/
		
		$field_data = array();
		$uploads = array();
		$success = false;
		$return_message = array();
		
		// Upload files
		$CI =& get_instance();
		$CI->load->library('upload');//$this->load->library('upload', $upload_config);
		$CI->upload->initialize($params['upload_config']);
		$success = $CI->upload->do_upload($params['form_field']);
		if ( ! $success )
		{
			return array(
				'code' => $success,
				'value' => '',
				'message' => implode('<br />', $CI->upload->error_msg),
			);
		}
		
		$upload_data = $CI->upload->data();
		chmod($upload_data['full_path'], FILE_WRITE_MODE);
		$field_data[( ! empty($params['field']) ? $params['field'] : $params['form_field'] )] = $upload_data['file_name'];
		$uploads[] = $upload_data;
		
		// Manipulate image
		if ( ! empty($params['manipulate_config']) )
		{
			// Resize images
			if ( isset($params['manipulate_config']['resize']) )
			{
				// Get source size
				list($source_width, $source_height) = getimagesize($upload_data['full_path']);
				
				$num_resize = count($params['manipulate_config']['resize']);
				for ( $i = 0; $i < $num_resize; $i++ )
				{
					$resize =& $params['manipulate_config']['resize'][$i];
					
					// Set starting width
					$width = isset($resize['width']) ? $resize['width'] : $source_width;
					// Check max width
					if ( isset($resize['max_width']) && $width > $resize['max_width'] )
					{
						$width = $resize['max_width'];
					}
					
					// Set starting height
					$height = isset($resize['height']) ? $resize['height'] : $source_height;
					// Check max height
					if ( isset($resize['max_height']) && $height > $resize['max_height'] )
					{
						$height = $resize['max_height'];
					}
					
					$resize['width'] = $width;
					$resize['height'] = $height;
					
					// Don't resize if skipping and source is smaller than resize
					if ( 
						! empty($resize['skip_if_smaller']) && 
						$resize['skip_if_smaller'] && 
						(
							$source_height <= $resize['height'] &&
							$source_width <= $resize['width']
						)
					)
					{
						unset($params['manipulate_config']['resize'][$i]);
					}
					
					unset($resize);// Delete reference
				}
				
				$this->resize_image($upload_data['file_path'], $upload_data, $params['manipulate_config']['resize']);
			}
		}
		
		return array(
			'code' => $success,
			'value' => array(
				'field_data' => $field_data,
				'uploads' => $uploads,
			),
			'message' => implode('<br />', $return_message),
		);
	}
	
	// --------------------------------------------------------------------
	
	/** 
	* Upload image files.
	* 
	* @access private
	* @param array $image_sizes
	* @param array $file_upload_config
	* @return mixed Array of return code, value, and message.
	*/
	public function upload_images2 ( $image_sizes, $file_upload_config )
	{
		$message = '';
		// Keep track of image fields
		$update_fields = array();
		$delete_fields = array();
		
		$this->CI->load->helper('file');
		$new_image_path = get_full_path( $file_upload_config['relative_path'] );
		// If the relative path is not in the real path, it must not exist:
		if ( $new_image_path === FALSE )
		{
			$message = 'The image upload directory was not set properly. ';
			return array('code' => FALSE, 'value' => NULL, 'message' => $message);
		}
		
		$this->CI->load->library('utility/file_upload');
		$success = $this->CI->file_upload->upload_files( $file_upload_config );
		
		// If at least the first image is being submitted:
		if ( $success )
		{
			$this->CI->load->library('utility/imaging');
			
			// For each uploaded file:
			foreach ( $this->CI->file_upload->uploads as $upload_data )
			{
				if ( $upload_data['is_image'] )
				{
					// IMAGE RESIZE SETUP
					// --------------------
					// Initialize the image class configuration (for first image type)
					$config = array();
					$config['source_image'] = $upload_data['full_path'];
					$config['image_library'] = 'gd2';
					$config['quality'] = 95;
					$config['maintain_ratio'] = TRUE;
					$config['master_dim'] = 'width';
					$config['create_thumb'] = FALSE;
					
					// For each image size
					foreach ( $image_sizes[ $upload_data['field_name'] ] as $image_size )
					{
						$new_image_name = $upload_data['raw_name'] . $image_size['suffix'];
						$new_image = $new_image_path . $new_image_name . strtolower($upload_data['file_ext']);
						
						$width = $image_size['width'];
						$height = $image_size['height'];
						
						// Keep track of image fields
						if ( isset($image_size['fieldname']) && strlen($image_size['fieldname']) > 0 )
						{
							$update_fields[ $image_size['fieldname'] ] = $upload_data['raw_name'] . strtolower($upload_data['file_ext']);
							$delete_fields[] = $image_size['fieldname'];
						}
						
						if ( isset($image_size['fieldname_raw_name']) && strlen($image_size['fieldname_raw_name']) > 0 )
						{
							$update_fields[ $image_size['fieldname_raw_name'] ] = $upload_data['raw_name'];
							$update_fields[ $image_size['fieldname_extension'] ] = strtolower($upload_data['file_ext']);
							$delete_fields[] = $image_size['fieldname_raw_name'];
							$delete_fields[] = $image_size['fieldname_extension'];
						}
						
						// If resizing
						if ( $image_size['resize'] )
						{
							/*
							// OVERLAY ROUNDED CORNERS
							// --------------------
							// Set the image destination and source
							$this->CI->load->helper( 'file' );
							
							$bg_full_path = $new_image;
							$fg_full_path = get_full_path( '../../images_banner/_images_banner_fg_type'. $bannerTypeID .'.png' );
							$target_full_path = $new_image;
							
							$this->CI->imaging->add_png_overlay( $bg_full_path, $fg_full_path, $target_full_path );
							*/
							
							$resize_config = array(
								'constraint' => 'outside',
								'height' => $height,
								'new_image' => $new_image,
								'width' => $width,
								'crop' => (isset($image_size['crop']) ? $image_size['crop'] : TRUE),
							);
							$resized = $this->CI->imaging->resize( $config, $resize_config );
							
							/*if ( $image_size['crop'] )
							{
								$crop_config = array(
									'constraint' => 'fit',//largest //smallest
									'height' => $height, 
									'new_image' => $new_image, 
									'source_image' => $new_image, 
									'width' => $width, 
									'x_align' => 'center', 
									'y_align' => 'center'
								);
								$cropped = $this->CI->imaging->crop( $config, $crop_config );
							}*/
						}
						
						// Delete the uploaded image
						//unlink( $upload_data['full_path'] );
					}
					
				}
				
			}//end foreach upload
			
		}//end if uploaded
		
		return array('code' => $success, 'value' => array('update_fields' => $update_fields, 'delete_fields' => $delete_fields), 'message' => $message);
	}
	
	// --------------------------------------------------------------------
	
	// --------------------------------------------------------------------
	// Private methods
	// --------------------------------------------------------------------
	
	/**
	* Generates a random id from a set of characters
	* 
	* @return string Randomly generated id
	*/
	private function generate_id ( $length = 16 )
	{
		if ( property_exists($this, 'increment_id') )
		{
			$this->id++;
			return $this->id;
		}
		
		$chars = array_merge(range('A', 'Z'), range('a', 'z'), range(0, 9));
		$max = count($chars) - 1;
		$id = '';
		
		for ( $index = 0; $index < $length; $index++ )
		{
			$id .= $chars[mt_rand(0, $max)];
		}
		
		return $id;
	}
	
	// --------------------------------------------------------------------
	
}

// --------------------------------------------------------------------

