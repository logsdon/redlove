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
	$file = $IM->rotate_exif_orientation($file);
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
	* Additional method name prefix when sending request
	* 
	* @var string
	*/
	public $class;
	
	// --------------------------------------------------------------------
	// Private properties
	// --------------------------------------------------------------------
	
	/**
	* Authentication username and password array
	* 
	* @var array
	*/
	private $auth;
	
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
			'url' => '',
		);
		$params = array_merge($default_params, $params);
	}
	
	// --------------------------------------------------------------------
	
	/**
	* Get the mime type
	* 
	* @param str $file Path to the file including the filename
	* @return bool|string False or the mime type
	*/
	public function get_mimetype ( $file )
	{
		if ( ! file_exists($file) || ! is_file($file) )
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
				$mimetype = finfo_file($finfo, $file);
			}

			finfo_close($finfo);
		}
		elseif ( function_exists('getimagesize') )
		{
			// open with GD
			if ( $data = @getimagesize($file) )
			{
				$mimetype = $data['mime'];
			}
		}
		elseif ( function_exists('exif_imagetype') )
		{
			// open with EXIF
			$mimetype = image_type_to_mime_type(exif_imagetype($file));
		}
		elseif ( function_exists('mime_content_type') )
		{
			$mimetype = preg_replace('~^(.+);.*$~', '$1', mime_content_type($file));
		}
		
		return $mimetype;
	}
	
	// --------------------------------------------------------------------
	
	/**
	* 
	*/
	public function rotate ( $src_img, $degrees = 0, $color = 0 )
	{
		// Create an image resource
		if ( is_string($src_img) )
		{
			$src_img = $this->imagecreatefrom($src_img);
		}
		
		$src_img = imagerotate($src_img, $degrees, $color);//, imageColorAllocateAlpha($source, 0, 0, 0, 127)
		
		//PNG
		imagealphablending($src_img, true);
		imagesavealpha($src_img, true);
		
		return $src_img;
	}

	// --------------------------------------------------------------------
	
	/**
	* 
	*/
	public function flip ( $src_img, $mode = '' )
	{
		// Create an image resource
		if ( is_string($src_img) )
		{
			$src_img = $this->imagecreatefrom($src_img);
		}
		
		$width = imagesx( $src_img );
		$height = imagesy( $src_img );

		$src_x = 0;
		$src_y = 0;
		$src_width = $width;
		$src_height = $height;

		switch ( $mode )
		{
			case '1':
			case 'vertical':
				$src_y = $height - 1;
				$src_height = - $height;
			break;

			case '2':
			case 'horizontal':
				$src_x = $width - 1;
				$src_width = - $width;
			break;

			case '3':
			case 'both':
				$src_x = $width - 1;
				$src_y = $height - 1;
				$src_width = - $width;
				$src_height = - $height;
			break;

			default:
				return $src_img;
		}

		$dst_img = imagecreatetruecolor( $width, $height );

		if ( imagecopyresampled( $dst_img, $src_img, 0, 0, $src_x, $src_y , $width, $height, $src_width, $src_height ) )
		{
			imagedestroy($src_img);
			return $dst_img;
		}

		return $src_img;
	}

	// --------------------------------------------------------------------

	/** 
	* 
	*/
	public function crop( $params = array() )
	{
		$default_params = array(
			'constraint' => '',//fit
			'height' => '',
			'new_image' => '',
			'scale' => 'stretch',//proportional_inside, proportional_outside, stretch, width_only, height_only
			'source_image' => '',
			'source_info' => '',
			'type' => 'jpg',
			'width' => '',
			'x_align' => '',//top, middle, bottom
			'x_axis' => 0,
			'y_align' => '',//left, center, right
			'y_axis' => 0,
		);
		$params = array_merge($default_params, $params);
		extract($params);
		
		// Create an image resource
		if ( is_string($source_image) )
		{
			$src_img = $this->imagecreatefrom($source_image);
		}
		else
		{
			$src_img = $source_image;
		}
		
		// Get image info
		if ( empty($source_info) )
		{
			if ( is_string($source_image) )
			{
				$source_info = $this->get_image_info($source_image);
			}
			else
			{
				$source_info = array(
					'type' => $type,
					'width' => imagesx($src_img),
					'height' => imagesy($src_img),
				);
			}
		}
		$type = $source_info['type'];
		
		$src_x = 0;
		$src_y = 0;
		$src_width = $source_info['width'];
		$src_height = $source_info['height'];
		$src_ratio = $src_width / $src_height;
		
		$dst_x = 0;
		$dst_y = 0;
		$dst_width = ( $width > 0 ) ? $width : $height;
		$dst_height = ( $height > 0 ) ? $height : $width;
		$dst_ratio = $dst_width / $dst_height;
		
		if ( $src_ratio >= $dst_ratio )
		{
			// If image is wider than thumbnail (in aspect ratio sense)
			$new_height = $dst_height;
			$new_width = $src_width / ($src_height / $dst_height);
		}
		else
		{
			// If the thumbnail is wider than the image
			$new_width = $dst_width;
			$new_height = $src_height / ($src_width / $dst_width);
		}

		$dst_img = imagecreatetruecolor( $dst_width, $dst_height );

		// Resize and crop
		imagecopyresampled(
			$dst_img,
			$src_img,
			0 - ($new_width - $dst_width) / 2, // Center the image horizontally
			0 - ($new_height - $dst_height) / 2, // Center the image vertically
			0, 0,
			$new_width, $new_height,
			$src_width, $height
		);
		
		return $dst_img;
		
		
		
		
		$dst_x = 0;   // X-coordinate of destination point
		$dst_y = 0;   // Y-coordinate of destination point
		$src_x = 100; // Crop Start X position in original image
		$src_y = 100; // Crop Srart Y position in original image
		$dst_w = 160; // Thumb width
		$dst_h = 120; // Thumb height
		$src_w = 260; // $src_x + $dst_w Crop end X position in original image
		$src_h = 220; // $src_y + $dst_h Crop end Y position in original image

		// Creating an image with true colors having thumb dimensions (to merge with the original image)
		$dst_image = imagecreatetruecolor($dst_w, $dst_h);
		// Get original image
		$src_image = imagecreatefromjpeg('images/source.jpg');
		// Cropping
		imagecopyresampled($dst_image, $src_image, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h);
		// Saving
		imagejpeg($dst_image, 'images/crop.jpg');
	}
	
	// --------------------------------------------------------------------
	
	/**
	* 
	* 
	* @access public
	* @param array $params
	* @return object An image resource
	*/
	public function resize ( $params = array() )
	{
		$default_params = array(
			'height' => '',
			'master_dim' => 'auto',//auto, width, height
			'max_height' => 0,
			'max_width' => 0,
			'new_image' => '',
			'scale' => 'stretch',//proportional_inside, proportional_outside, stretch, width_only, height_only
			'source_image' => '',
			'source_info' => '',
			'type' => 'jpg',
			'width' => '',
			
			'crop' => false,
			'constraint' => '',//fit
			'x_align' => 'left',//left, center, right
			'x_axis' => 0,
			'y_align' => 'top',//top, middle, bottom
			'y_axis' => 0,
			
			'degrees' => 0,//90, 180, 270//PHP rotates counter-clockwise, so a 90 degree rotation to the right must be specified as 270.
			'color' => 0,
			
			'flip' => 0,
		);
		$params = array_merge($default_params, $params);
		extract($params);
		
		// Create an image resource
		if ( is_string($source_image) )
		{
			$src_img = $this->imagecreatefrom($source_image);
		}
		else
		{
			$src_img = $source_image;
		}
		
		// Get image info
		if ( empty($source_info) )
		{
			if ( is_string($source_image) )
			{
				$source_info = $this->get_image_info($source_image);
			}
			else
			{
				$source_info = array(
					'type' => $type,
					'width' => imagesx($src_img),
					'height' => imagesy($src_img),
				);
			}
		}
		$type = $source_info['type'];
		
		$src_x = 0;
		$src_y = 0;
		$src_width = $source_info['width'];
		$src_height = $source_info['height'];
		$src_ratio = $src_width / $src_height;
		
		$width = ( $width > 0 ) ? $width : $src_width;
		$height = ( $height > 0 ) ? $height : $src_height;
		
		$dst_x = 0;
		$dst_y = 0;
		$dst_width = $width;
		$dst_height = $height;
		$dst_ratio = $dst_width / $dst_height;
		// Create scaled values separately for safekeeping as the dst values may change with cropping
		$dst_scaled_w = $dst_width;
		$dst_scaled_h = $dst_height;
		
		$dst_src_scale = $dst_width / $src_width;
		$dst_src_scale_x = $dst_width / $src_width;
		$dst_src_scale_y = $dst_height / $src_height;
		$dst_src_scale_max = max($dst_src_scale_x, $dst_src_scale_y);
		$dst_src_scale_min = min($dst_src_scale_x, $dst_src_scale_y);
		
		// Resize
		if ( $resize )
		{
			/*
			echo "dst_ratio: $dst_ratio src_ratio: $src_ratio";
			echo '<br>';
			echo "dst_width: $dst_width dst_height: $dst_height";
			echo '<br>';
			*/
			// Scale the destination image dimensions accordingly
			if ( $scale == 'proportional_inside' )
			{
				if ( $master_dim == 'width' || ( $master_dim == 'auto' && $src_ratio >= $dst_ratio ) )
				{
					$dst_height = $dst_width / $src_ratio;
				}
				else
				{
					$dst_width = $dst_height * $src_ratio;
				}
			}
			elseif ( $scale == 'proportional_outside' )
			{
				if ( $master_dim == 'width' || ( $master_dim == 'auto' && $src_ratio >= $dst_ratio ) )
				{
					$dst_width = $dst_height * $src_ratio;
				}
				else
				{
					$dst_height = $dst_width / $src_ratio;
				}
			}
			elseif ( $scale == 'width_only' )
			{
				$dst_height = $src_height;
			}
			elseif ( $scale == 'height_only' )
			{
				$dst_width = $src_width;
			}
			
			// Constrain dimensions within maxes
			if ( $max_width > 0 && $dst_width > $max_width )
			{
				$dst_width = $max_width;
				$dst_height = $dst_width / $dst_ratio;
			}
			if ( $max_height > 0 && $dst_height > $max_height )
			{
				$dst_height = $max_height;
				$dst_width = $dst_height * $dst_ratio;
			}
			
			$dst_height = round($dst_height);
			$dst_width = round($dst_width);
			$dst_scaled_w = $dst_width;
			$dst_scaled_h = $dst_height;
			
			$dst_src_scale = $dst_width / $src_width;
			$dst_src_scale_x = $dst_width / $src_width;
			$dst_src_scale_y = $dst_height / $src_height;
			$dst_src_scale_max = max($dst_src_scale_x, $dst_src_scale_y);
			$dst_src_scale_min = min($dst_src_scale_x, $dst_src_scale_y);
		}
		
		// Crop
		if ( $crop )
		{
			// Set up crop dimensions separately to safeguard originals
			$crop_x = $x_axis;
			$crop_y = $y_axis;
			$crop_w = $width;
			$crop_h = $height;
			$crop_src_w = $src_width;
			$crop_src_h = $src_height;
			
			// X Align
			if ( $x_align == 'center' && $dst_scaled_w > $width )
			{
				$crop_x = ($dst_scaled_w - $width) / 2;
			}
			elseif ( $x_align == 'right' && $dst_scaled_w > $width )
			{
				$crop_x = $dst_scaled_w - $width;
			}
			
			// Y Align
			if ( $y_align == 'middle' && $dst_scaled_h > $height )
			{
				$crop_y = ($dst_scaled_h - $height) / 2;
			}
			elseif ( $y_align == 'bottom' && $dst_scaled_h > $height )
			{
				$crop_y = $dst_scaled_h - $height;
			}
			
			// Change the destination dimensions to the target crop dimensions
			$dst_height = $height;
			$dst_width = $width;
			
			// If the image is smaller than the crop, adjust the crop to fit
			if ( $constraint == 'fit' )
			{
				if ( $dst_width > $dst_scaled_w )
				{
					$crop_w = $dst_scaled_w;
					$dst_width = $dst_scaled_w;
				}
				if ( $dst_height > $dst_scaled_h )
				{
					$crop_h = $dst_scaled_h;
					$dst_height = $dst_scaled_h;
				}
			}
			
			// The dimensions of the source staged for cropped may be different
			$crop_src_staged_w = $dst_width;
			$crop_src_staged_h = $dst_height;
			$crop_src_scale_x = $crop_src_staged_w / $crop_src_w;
			$crop_src_scale_y = $crop_src_staged_h / $crop_src_h;
			$crop_scale_max = max($crop_src_scale_x, $crop_src_scale_y);
			$crop_scale_min = min($crop_src_scale_x, $crop_src_scale_y);
			// Adjust the crop coordinates to the scale of the staged src image
			$crop_x /= $crop_scale_max;
			$crop_y /= $crop_scale_max;
			$crop_w /= $crop_scale_max;
			$crop_h /= $crop_scale_max;
			
			// Update variables with the crop dimensions
			$src_x = $crop_x;
			$src_y = $crop_y;
			$src_width = $crop_w;
			$src_height = $crop_h;
			
			$src_height = round($src_height);
			$src_width = round($src_width);
		}
		
		// Flip
		if ( $flip )
		{
			switch ( $flip )
			{
				case '1':
				case 'vertical':
					$src_y = $src_height - 1;
					$src_height = - $src_height;
				break;

				case '2':
				case 'horizontal':
					$src_x = $src_width - 1;
					$src_width = - $src_width;
				break;

				case '3':
				case 'both':
					$src_x = $src_width - 1;
					$src_y = $src_height - 1;
					$src_width = - $src_width;
					$src_height = - $src_height;
				break;

				default:
				break;
			}
		}
		
		// Create the destination image resource
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
		
		// Copy from the source to the destination resource
		$copied = imagecopyresampled(
			$dst_img, $src_img, 
			$dst_x, $dst_y, $src_x, $src_y, 
			$dst_width, $dst_height, $src_width, $src_height
		);
		
		if ( ! $copied )
		{
			return false;
		}
		
		// Rotate
		if ( $degrees > 0 )
		{
			$dst_img = imagerotate($dst_img, $degrees, $color);//, imageColorAllocateAlpha($source, 0, 0, 0, 127)
		}
		
		imagedestroy($src_img);
		return $dst_img;
	}
	
	// --------------------------------------------------------------------
	
	/** 
	* 
	* 
	* @access private
	* @param array $upload
	* @param array $sizes
	* @return bool
	*/
	public function resize_image( $full_path, $upload, $sizes )
	{
		$success = FALSE;
		
		if ( $upload['is_image'] )
		{
			$this->CI->load->library('utility/imaging');
			
			// IMAGE RESIZE SETUP
			// --------------------
			// Initialize the image class configuration (for first image type)
			$config = array(
				'create_thumb' => FALSE,
				'image_library' => 'gd2',
				'maintain_ratio' => TRUE,
				'master_dim' => 'width',
				'source_image' => $upload['full_path'],
				'quality' => 95,
			);
			
			// For each image size
			foreach ( $sizes as $size )
			{
				$source_image = $upload['full_path'];
				$new_name = $upload['raw_name'] . $size['suffix'];
				$new_image = $full_path . $new_name . $upload['file_ext'];
				
				
				// Get source size
				list($source_width, $source_height) = getimagesize($source_image);
				
				// Set starting width
				$width = isset($size['width']) ? $size['width'] : $source_width;
				// Check max width
				if ( isset($size['max_width']) && $width > $size['max_width'] )
				{
					$width = $size['max_width'];
				}
				
				// Set starting height
				$height = isset($size['height']) ? $size['height'] : $source_height;
				// Check max height
				if ( isset($size['max_height']) && $height > $size['max_height'] )
				{
					$height = $size['max_height'];
				}
				
				
				//$width = $size['width'];
				//$height = $size['height'];
				
				// If resizing
				if ( $size['resize'] )
				{
					$resize_config = array(
						'constraint' => 'outside',
						'crop' => $size['crop'],
						'height' => $height,
						'new_image' => $new_image,
						'width' => $width,
					);
					if ( isset($size['resize_config']) && is_array($size['resize_config']) )
					{
						foreach( $size['resize_config'] as $key => $val )
						{
							$resize_config[$key] = $val;
						}
					}
					$success = $this->resize( $config, $resize_config );
					$source_image = $new_image;
				}
				
				if ( $size['crop'] )
				{
					$crop_config = array(
						'constraint' => 'fit',
						'height' => $height,
						'new_image' => $new_image,
						'source_image' => $source_image,
						'width' => $width,
						'x_align' => 'center',
						'y_align' => 'center',
					);
					if ( isset($size['crop_config']) && is_array($size['crop_config']) )
					{
						foreach( $size['crop_config'] as $key => $val )
						{
							$crop_config[$key] = $val;
						}
					}
					$success = $this->crop( $config, $crop_config );
					$source_image = $new_image;
				}
				
				/*
				// OVERLAY ROUNDED CORNERS
				// --------------------
				// Set the image destination and source
				$this->CI->load->helper( 'file' );
				
				$bg_full_path = $new_image;
				$fg_full_path = get_full_path( '../../images_banner/_images_banner_fg_type'. $bannerTypeID .'.png' );
				$target_full_path = $new_image;
				
				$this->add_png_overlay( $bg_full_path, $fg_full_path, $target_full_path );
				*/
				
				// Delete the uploaded image
				//unlink( $upload['full_path'] );
			}//end for each size
		}//end if image
		
		return $success;
	}
	
	// --------------------------------------------------------------------
	
	/** 
	* 
	*/
	public function _get_alignment( &$image_lib_config, $x_align = 'left', $y_align = 'top' )
	{
		$alignment = $this->get_alignment( $image_lib_config['source_image'], $image_lib_config['width'], $image_lib_config['height'], $x_align, $y_align );
		$image_lib_config['x_axis'] = $alignment['x'];
		$image_lib_config['y_axis'] = $alignment['y'];
	}
	
	// --------------------------------------------------------------------
	
	/** 
	* 
	*/
	public function get_alignment( $image, $area_width, $area_height, $x_align = 'left', $y_align = 'top' )
	{
		$x = 0;// left
		$y = 0;// top
		
		if ( $x_align != 'left' || $y_align != 'top' )
		{
			list( $width, $height, $type, $attr ) = getimagesize( $image );//$imagesize = getimagesize( $image );
			
			// X Align
			if ( $x_align == 'center' && $width > $area_width )
			{
				$x = floor( ($width - $area_width) / 2 );
			}
			elseif ( $x_align == 'right' && $width > $area_width )
			{
				$x = floor( $width - $area_width );
			}
			
			// Y Align
			if ( $y_align == 'center' && $height > $area_height )
			{
				$y = floor( ($height - $area_height) / 2 );
			}
			elseif ( $y_align == 'bottom' && $height > $area_height )
			{
				$y = floor( $height - $area_height );
			}
		}
		
		return array('x' => $x, 'y' => $y);
	}
	
	// --------------------------------------------------------------------
	
	/** 
	* 
	*/
	public function get_image_info ( $source_image )
	{
		// Check if resource or file exists
		if ( ! is_resource($source_image) && ( ! file_exists($source_image) || ! is_file($source_image) ) )
		{
			return;
		}
		
		// Check if image info gathered
		$vals = @getimagesize($source_image);
		if ( ! $vals )
		{
			return;
		}
		
		// Gather image information
		$types = array(1 => 'gif', 2 => 'jpeg', 3 => 'png');
		$type = ( isset($types[$vals['2']]) ) ? $types[$vals['2']] : $types[2];//image_type_to_extension( $type )
		$mime = 'image/' . $type;
		
		$image_info = array(
			'source_image' => $source_image,
			
			'width' => $vals['0'],
			'height' => $vals['1'],
			'size_str' => $vals['3'],
			
			'type' => $type,
			'image_type' => $vals['2'],
			'mime_type' => $mime,
			
			'filesize' => filesize($source_image),
			'last_modified' => filemtime($source_image),
		);
		
		return $image_info;
	}

	// --------------------------------------------------------------------

	/**
	* Use the GD library to create an image resource from a file.
	* This function keeps you from having to determine what type 
	* of function needs to be used for the file.
	* 
	* @access public
	* @param string $full_path The full path to the image file.
	* @return object Image resource.
	*/
	public function imagecreatefrom ( $source_image, $image_info = null )
	{
		if ( ! isset($image_info) )
		{
			$image_info = $this->get_image_info($source_image);
		}
		/*
		list( ,,$type ) = getimagesize( $full_path );
		$type = image_type_to_extension( $type );
		*/
		
		$type = $image_info['type'];
		
		$img = null;
		// Create image memory from source
		if ( $type == 'png' )
		{
			$img = imagecreatefrompng( $source_image );
		}
		elseif ( $type == 'jpeg' )
		{
			$img = imagecreatefromjpeg( $source_image );
		}
		elseif ( $type == 'gif' )
		{
			$img = imagecreatefromgif( $source_image );
		}
		elseif ( $type == 'bmp' )
		{
			$img = imagecreatefromwbmp( $source_image );
		}
		
		// Check for failure
		if ( $img == false )
		{
			// Create a blank image
			$img = imagecreatetruecolor( 150, 30 );
			$bgc = imagecolorallocate( $img, 255, 255, 255 );
			$tc = imagecolorallocate( $img, 0, 0, 0 );

			imagefilledrectangle( $img, 0, 0, 150, 30, $bgc );

			// Output an error message
			imagestring( $img, 1, 5, 5, 'Error loading '. $source_image, $tc );
		}
		
		return $img;
	}

	// --------------------------------------------------------------------

	/** 
	* 
	*/
	public function imagesaveas ( $src_img, $new_image, $quality = 100, $screen = false, $from_type = null )
	{
		// Create an image resource
		if ( is_string($src_img) )
		{
			$src_img = $this->imagecreatefrom($src_img);
		}
		
		// Gather image information
		$type = strtolower(substr( strrchr($new_image, '.'), 1 ));
		$types = array(1 => 'gif', 2 => 'jpeg', 3 => 'png', 4 => 'bmp');
		$type = isset($types[$type]) ? $types[$type] : $types[2];
		
		if ( $screen )
		{
			$new_image = null;
		}
		
		// Save destination image memory as new image
		if ( $type == 'gif' )
		{
			if ( $screen )
			{
				header('Content-Type: image/gif');
			}
			$success = imagegif($src_img, $new_image);
		}
		elseif ( $type == 'png' )
		{
			if ( $screen )
			{
				header('Content-Type: image/png');
			}
			$success = imagepng($src_img, $new_image, $quality);
		}
		elseif ( $type == 'bmp' )
		{
			if ( $screen )
			{
				header('Content-Type: image/bmp');
			}
			$success = imagewbmp($src_img, $new_image);
		}
		else
		{
			// Fill transparent png background with white before converting to jpeg
			if ( $from_type == 'png' )
			{
				$width = imagesx( $src_img );
				$height = imagesy( $src_img );
				
				// Create destination image memory
				$tmp_img = imagecreatetruecolor($width, $height);
				// Set background to white
				imagefill($tmp_img, 0, 0, imagecolorallocate($tmp_img, 255, 255, 255));
				imagealphablending($tmp_img, true);
				// Copy transparent png onto white background
				imagecopy($tmp_img, $src_img, 0, 0, 0, 0, $width, $height);
				// Swap around the temporary image as the new source image
				imagedestroy($src_img);
				$src_img = $tmp_img;
			}
			
			//$quality = 80; // 0 = worst / smaller file, 100 = better / bigger file
			if ( $screen )
			{
				header('Content-Type: image/jpeg');
			}
			$success = imagejpeg($src_img, $new_image, $quality);
		}
		
		// Destroy image memory
		imagedestroy($src_img);
		if ( ! empty($tmp_img) )
		{
			imagedestroy($tmp_img);
		}
		
		if ( $screen )
		{
			exit;
		}
		else
		{
			// Set the file to 777
			@chmod($new_image, FILE_WRITE_MODE);
		}
		
		return $success;
	}

	// --------------------------------------------------------------------
	
	public function save_data_url( $data_url, $relative_path, $raw_name = null )
	{
		// Parse data url
		//$data_url = 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7';
		$split_data = explode(',', $data_url, 2);
		$mime_string = str_replace(array('data:', 'data://', ';base64'), '', $split_data[0]);
		$byte_string = $split_data[1];//substr($data_url, strpos($data_url, ',') + 1);
		$encoded_data = str_replace(' ', '+', $byte_string);
		$decoded_data = base64_decode($encoded_data);
		//$generated_data_url = 'data:' . $mime_string . ';base64,' . base64_encode($decoded_data);
		//echo '<img src="' . $generated_data_url . '">';
		
		// Set mime and extension info
		$mime_types = array(1 => 'image/gif', 2 => 'image/jpeg', 3 => 'image/png');
		$key = array_search($mime_string, $mime_types);
		$key = ( $key !== false ) ? $key : 2;
		$mime_type = $mime_types[$key];
		
		$types = array(1 => 'gif', 2 => 'jpeg', 3 => 'png');
		$type = $types[$key];
		
		$file_extensions = array(1 => 'gif', 2 => 'jpg', 3 => 'png');
		$file_extension = '.' . $file_extensions[$key];;
		
		$raw_name = isset($raw_name) ? $raw_name : md5(uniqid(mt_rand(), true));
		$file_name = $raw_name . $file_extension;
		
		// Write data to file
		$write_path = rtrim(ROOT_PATH . $relative_path, '/\\') . '/';
		$full_path = $write_path . $file_name;
		$file_handler = fopen($full_path, 'w');
		$num_bytes_written = fwrite($file_handler, $decoded_data);
		fclose($file_handler);
		
		return array(
			'success' => ( $num_bytes_written !== false ),
			'write_path' => $write_path,
			'relative_path' => $relative_path,
			'full_path' => $full_path,
			'raw_name' => $raw_name,
			'file_extension' => $file_extension,
			'extension' => $file_extension,
			'file_name' => $file_name,
			'type' => $type,
			'mime_type' => $mime_type,
			'mime_string' => $mime_string,
		);
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
	* @param string $target_full_path The full path to the image file to save.
	* @param int $dst_x The x coordinate to overlay the foreground on the background.
	* @param int $dst_y The y coordinate to overlay the foreground on the background.
	*/
	public function add_png_overlay( $bg_full_path, $fg_full_path, $target_full_path = '', $dst_x = 0, $dst_y = 0, $add_transparency = FALSE )
	{
		// Create new images
		$bg = $this->imagecreatefrom( $bg_full_path );
		$fg = $this->imagecreatefrom( $fg_full_path );
		
		//Grab width and height
		$fg_w = imagesx( $fg );
		$fg_h = imagesy( $fg );
		
		// Merge the two images
		imagecopy( $bg, $fg, $dst_x, $dst_y, 0, 0, $fg_w, $fg_h );
		
		// If there is not target file to write to, output to the browser:
		if ( $target_full_path === '' )
		{
			// Output header
			header('Content-type: image/png');
			
			// Set up transparency
			if ( $add_transparency === TRUE )
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
			imagejpeg( $bg, $target_full_path, 90 );
			imagedestroy( $bg );
		}
		
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
	* @param string $target_full_path The full path to the image file to save.
	* @param int $dst_x The x coordinate to overlay the foreground on the background.
	* @param int $dst_y The y coordinate to overlay the foreground on the background.
	*/
	public function resave_png( $bg_full_path, $target_full_path = '' )
	{
		$bg = $this->imagecreatefrom( $bg_full_path );
		
		$rgb_index = imagecolorat( $bg, 1, 1 );// Get first pixel color
		$colors = imagecolorsforindex( $bg, $rgb_index );// Get color associative array
		$transparent_color = imagecolorallocate( $bg, $colors['red'], $colors['green'], $colors['blue'] );// Transparent color
		imagecolortransparent( $bg, $transparent_color );// Make color transparent
		
		// Send new image to browser
		imagepng( $bg, $target_full_path );
		imagedestroy( $bg );
	}
	
	// --------------------------------------------------------------------

	/** 
	* http://stackoverflow.com/questions/1201798/use-php-to-convert-png-to-jpg-with-compression
	* http://ellislab.com/codeigniter/user-guide/libraries/image_lib.html
	*/
	public function save_as_jpg( $source_image, $new_image, $quality = 80 )
	{
		// Gather image information
		$image_info = $this->get_image_info($source_image);
		$type = $image_info['type'];
		
		// Create image memory from source
		$src_img = $this->imagecreatefrom($source_image, $image_info);
		
		// Fill transparent png background with white before converting to jpeg
		if ( $type == 'png' )
		{
			// Create destination image memory
			$tmp_img = imagecreatetruecolor($image_info['width'], $image_info['height']);
			// Set background to white
			imagefill($tmp_img, 0, 0, imagecolorallocate($tmp_img, 255, 255, 255));
			imagealphablending($tmp_img, true);
			// Copy transparent png onto white background
			imagecopy($tmp_img, $src_img, 0, 0, 0, 0, $image_info['width'], $image_info['height']);
			// Swap around the temporary image as the new source image
			imagedestroy($src_img);
			$src_img = $tmp_img;
		}
		
		// Save destination image memory as new image
		//$quality = 80; // 0 = worst / smaller file, 100 = better / bigger file 
		$success = imagejpeg($src_img, $new_image, $quality);
		
		// Destroy image memory
		imagedestroy($src_img);
		if ( ! empty($tmp_img) )
		{
			imagedestroy($tmp_img);
		}
		
		// Set the file to 777
		@chmod($new_image, FILE_WRITE_MODE);
		
		return $image_info;
	}
	
	// --------------------------------------------------------------------

	public function convert_image($imagetemp,$imagetype)
	{
		if($imagetype == 'image/pjpeg' || $imagetype == 'image/jpeg')
		{
			$cim1 = imagecreatefromjpeg($imagetemp);
		}
		elseif($imagetype == 'image/x-png' || $imagetype == 'image/png')
		{
			$cim1 = imagecreatefrompng($imagetemp);
			imagealphablending($cim1, false);
			imagesavealpha($cim1, true);
		}
		elseif($imagetype == 'image/gif')
		{
			$cim1 = imagecreatefromgif($imagetemp);
		}
		return $cim1;
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
	public function upload_image( $params = array() )
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
	public function upload_images2( $image_sizes, $file_upload_config )
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
	
	public function fix_exif_orientation( $file )
	{
		$image = $this->rotate_exif_orientation($file);
		if ( $image )
		{
			return $this->imagesaveas($image, $file, 100);
		}
		
		return false;
	}

	// --------------------------------------------------------------------

	public function rotate_exif_orientation( $file, $exif = null )
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
		$src_img = $this->imagecreatefrom($file);
		
		// Modify image resource based on orientation
		switch ( $orientation )
		{
			case 1: // nothing
			break;

			case 2: // horizontal flip
				$src_img = $this->flip($src_img, 1);
			break;
			
			case 3: // 180 rotate left
				$src_img = $this->rotate($src_img, 180);
			break;
			
			case 4: // vertical flip
				$src_img = $this->flip($src_img, 2);
			break;
			
			case 5: // vertical flip + 90 rotate right
				$src_img = $this->flip($src_img, 2);
				$src_img = $this->rotate($src_img, -90);
			break;
			
			case 6: // 90 rotate right
				$src_img = $this->rotate($src_img, -90);
			break;
			
			case 7: // horizontal flip + 90 rotate right
				$src_img = $this->flip($src_img, 1);   
				$src_img = $this->rotate($src_img, -90);
			break;
			
			case 8: // 90 rotate left
				$src_img = $this->rotate($src_img, 90);
			break;
		}
		
		return $src_img;
	}

	// --------------------------------------------------------------------

	public function get_exif( $source_image, $debug = null )
	{
		// Check if file exists
		if ( ! file_exists($source_image) || ! is_file($source_image) )
		{
			return;
		}
		
		$exif = @exif_read_data($source_image, null, true);
		
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

	// --------------------------------------------------------------------
	// Private methods
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
	
}

// --------------------------------------------------------------------

