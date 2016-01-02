<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Create CAPTCHA
 *
 * @access	public
 * @param	array	array of data for the CAPTCHA
 * @param	string	path to create the image in
 * @param	string	URL to the CAPTCHA image folder
 * @param	string	server path to font
 * @return	string

CONTROLLER - Create CAPTCHA
// Setup CAPTCHA if necessary
$this->load->helper('captcha');
if ( ! isset($data) || $data['code'] !== TRUE )
{
	$captcha_params = array(
		'word' => create_safe_captcha_word(),
		'img_path' => ROOTPATH . 'images/captcha/',
		'img_url' => base_url() . 'images/captcha/',
		'font_path' => APPPATH . 'fonts/VeraSe.ttf',
		'img_width' => '100',
		'img_height' => '30',
		'expiration' => 7200,
	);
	$captcha = create_captcha( $captcha_params );
	save_captcha($captcha);
	$view_vars['captcha'] = $captcha;
}

CONTROLLER - Validate CAPTCHA
// Check CAPTCHA
$this->load->helper('captcha');
if ( ! valid_captcha($this->input->post('c_word', TRUE)) )
{
	$valid = FALSE;
	$feedback[] = 'The CAPTCHA word in the image is incorrect. Please try again.';
}

VIEW
Enter shown text: <div style="display: inline-block; vertical-align: top;"><input type="text" name="c_word" value="" /><br /><?php echo $captcha['image']; ?></div>

 */
if ( ! function_exists('create_captcha'))
{
	function create_captcha($data = '', $img_path = '', $img_url = '', $font_path = '')
	{
		$defaults = array('word' => '', 'img_path' => '', 'img_url' => '', 'img_width' => '150', 'img_height' => '30', 'font_path' => '', 'expiration' => 7200);

		foreach ($defaults as $key => $val)
		{
			if ( ! is_array($data))
			{
				if ( ! isset(${$key}) OR ${$key} == '')
				{
					${$key} = $val;
				}
			}
			else
			{
				${$key} = ( ! isset($data[$key])) ? $val : $data[$key];
			}
		}

		if ($img_path == '' OR $img_url == '')
		{
			return FALSE;
		}

		if ( ! @is_dir($img_path))
		{
			return FALSE;
		}

		if ( ! is_writable($img_path))
		{
			return FALSE;
		}

		if ( ! extension_loaded('gd'))
		{
			return FALSE;
		}

		// -----------------------------------
		// Remove old images
		// -----------------------------------

		list($usec, $sec) = explode(" ", microtime());
		$now = ((float)$usec + (float)$sec);

		$current_dir = @opendir($img_path);

		while($filename = @readdir($current_dir))
		{
			if ($filename != "." and $filename != ".." and $filename != "index.html")
			{
				$name = str_replace(".jpg", "", $filename);

				if (($name + $expiration) < $now)
				{
					@unlink($img_path.$filename);
				}
			}
		}

		@closedir($current_dir);

		// -----------------------------------
		// Do we have a "word" yet?
		// -----------------------------------

	   if ($word == '')
	   {
			$pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

			$str = '';
			for ($i = 0; $i < 8; $i++)
			{
				$str .= substr($pool, mt_rand(0, strlen($pool) -1), 1);
			}

			$word = $str;
	   }

		// -----------------------------------
		// Determine angle and position
		// -----------------------------------

		$length	= strlen($word);
		$angle	= ($length >= 6) ? rand(-($length-6), ($length-6)) : 0;
		$x_axis	= rand(6, (360/$length)-16);
		$y_axis = ($angle >= 0 ) ? rand($img_height, $img_width) : rand(6, $img_height);

		// -----------------------------------
		// Create image
		// -----------------------------------

		// PHP.net recommends imagecreatetruecolor(), but it isn't always available
		if (function_exists('imagecreatetruecolor'))
		{
			$im = imagecreatetruecolor($img_width, $img_height);
		}
		else
		{
			$im = imagecreate($img_width, $img_height);
		}

		// -----------------------------------
		//  Assign colors
		// -----------------------------------

		$bg_color		= imagecolorallocate ($im, 255, 255, 255);
		$border_color	= imagecolorallocate ($im, 153, 102, 102);
		$text_color		= imagecolorallocate ($im, 204, 153, 153);
		$grid_color		= imagecolorallocate($im, 255, 182, 182);
		$shadow_color	= imagecolorallocate($im, 255, 240, 240);

		// -----------------------------------
		//  Create the rectangle
		// -----------------------------------

		ImageFilledRectangle($im, 0, 0, $img_width, $img_height, $bg_color);

		// -----------------------------------
		//  Create the spiral pattern
		// -----------------------------------

		$theta		= 1;
		$thetac		= 7;
		$radius		= 16;
		$circles	= 20;
		$points		= 32;

		for ($i = 0; $i < ($circles * $points) - 1; $i++)
		{
			$theta = $theta + $thetac;
			$rad = $radius * ($i / $points );
			$x = ($rad * cos($theta)) + $x_axis;
			$y = ($rad * sin($theta)) + $y_axis;
			$theta = $theta + $thetac;
			$rad1 = $radius * (($i + 1) / $points);
			$x1 = ($rad1 * cos($theta)) + $x_axis;
			$y1 = ($rad1 * sin($theta )) + $y_axis;
			imageline($im, $x, $y, $x1, $y1, $grid_color);
			$theta = $theta - $thetac;
		}

		// -----------------------------------
		//  Write the text
		// -----------------------------------

		$use_font = ($font_path != '' AND file_exists($font_path) AND function_exists('imagettftext')) ? TRUE : FALSE;

		if ($use_font == FALSE)
		{
			$font_size = 5;
			//$x = rand(0, $img_width/($length/3));
			$x = rand(0, ($img_width - ($font_size*4)));
			$y = 0;
		}
		else
		{
			$font_size	= 16;
			$x = rand(0, $img_width/($length/1.5));
			$y = $font_size+2;
		}

		for ($i = 0; $i < strlen($word); $i++)
		{
			if ($use_font == FALSE)
			{
				$y = rand(0 , $img_height/2);
				imagestring($im, $font_size, $x, $y, substr($word, $i, 1), $text_color);
				$x += ($font_size*2);
			}
			else
			{
				$y = rand($img_height/2, $img_height-3);
				imagettftext($im, $font_size, $angle, $x, $y, $text_color, $font_path, substr($word, $i, 1));
				$x += $font_size;
			}
		}


		// -----------------------------------
		//  Create the border
		// -----------------------------------

		imagerectangle($im, 0, 0, $img_width-1, $img_height-1, $border_color);

		// -----------------------------------
		//  Generate the image
		// -----------------------------------

		$img_name = $now.'.jpg';

		ImageJPEG($im, $img_path.$img_name);

		$img = "<img src=\"$img_url$img_name\" width=\"$img_width\" height=\"$img_height\" style=\"border:0;\" alt=\" \" />";

		ImageDestroy($im);

		return array('word' => $word, 'time' => $now, 'image' => $img);
	}
}

// ------------------------------------------------------------------------

/**
 * Save CAPTCHA
 *
 * @access public
 * @param array array of data for the CAPTCHA
 */
if (! function_exists('save_captcha'))
{
	function save_captcha( $captcha )
	{
		$CI =& get_instance();
		$CI->load->database();
		
		$data = array(
			'captcha_time' => $captcha['time'],
			'ip_address' => $CI->input->ip_address(),
			'word' => $captcha['word'],
		);
		
		$query = $CI->db->insert_string('ci_captcha', $data);
		$CI->db->query($query);
	}
}

// ------------------------------------------------------------------------

/**
 * Check CAPTCHA is valid
 *
 * @access public
 * @param string submitted CAPTCHA word to check
 * @param string Time-To-Live for the CAPTCHA in seconds
 * @return bool
 */
if (! function_exists('valid_captcha'))
{
	function valid_captcha( $word, $ttl = 7200 )
	{
		$CI =& get_instance();
		$CI->load->database();
		
		// First, delete old captchas
		$expiration = time() - $ttl;
		$sql = trim('
			DELETE 
			FROM 
				ci_captcha 
			WHERE 
				captcha_time < ' . $expiration . ' 
		');
		$CI->db->query($sql);

		// Then see if a captcha exists:
		$sql = trim('
			SELECT 
				COUNT(*) AS count 
			FROM 
				ci_captcha 
			WHERE 
				word = ? AND 
				ip_address = ? AND 
				captcha_time > ?
		');
		$binds = array($word, $CI->input->ip_address(), $expiration);
		$query = $CI->db->query($sql, $binds);
		$row = $query->unbuffered_row();
		$query->free_result();
		return ( $row->count > 0 );
	}
}

// ------------------------------------------------------------------------

/**
 * Check safe CAPTCHA word
 *
 * @access public
 * @param int word length
 * @return string
 */
if (! function_exists('create_safe_captcha_word'))
{
	function create_safe_captcha_word( $length = 3 )
	{
		$pool = '23456789ABCDEFGHKLMNPQRSTUVWXYZ';
		$chars_length = strlen($pool);
		$word = '';
		
		for ( $i = 0; $i < $length; $i++ )
		{
			$word .= $pool[ mt_rand(0, $chars_length - 1) ];
			//$word .= substr($pool, mt_rand(0, $chars_length -1), 1);
		}
		
		return $word;
	}
}

