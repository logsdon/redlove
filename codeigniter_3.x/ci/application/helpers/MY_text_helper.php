<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// ------------------------------------------------------------------------

/**
* Capitalizes non-stopwords.
*
* @access public
* @param string $text
* @return string
*/
if ( ! function_exists('proper_case'))
{
	function proper_case(
		$string,
		$excluded_string = 'with when and or a an the from to on as of in at for will',
		$upper_string = 'llc aaa po p.o.'
	)
	{
		//$word_delimiters = " `~!@#$%^&*()-_=+[{]}\|;:',<.>/?'";
		$words = explode(' ', strtolower($string));
		$num_words = count($words);
		$excluded_words = explode(' ', strtolower($excluded_string));
		$upper_words = explode(' ', strtolower($upper_string));
		
		$new_string = '';
		$iteration = 0;
		
		foreach ( $words as $word )
		{
			// If should be excluded and is not the first or last word, keep lower case
			if (
				in_array($word, $excluded_words) && 
				$iteration != 0 && 
				$iteration != $num_words - 1
			)
			{
				$new_string .= $word;
			}
			// If should be upper case, make upper case
			elseif ( in_array($word, $upper_words) )
			{
				$new_string .= strtoupper($word);
			}
			// Else capitalize
			else
			{
				$new_string .= ucwords($word);
			}
			
			$new_string .= ' ';
			$iteration++;
		}
		
		return trim($new_string);
	}
}

// ------------------------------------------------------------------------

/**
* Cut text off or show default text if blank.
*
* @access public
* @param string $text
* @param int $length
* @param string $append
* @param string $default_text
* @return string
*/
if ( ! function_exists('truncate_text'))
{
	function truncate_text( $text, $length, $append = '', $default_text = '' )
	{
		$new_text = substr($text, 0, $length);
		$new_text .= (strlen($text) > $length ? $append : '');
		$new_text .= (strlen($new_text) <= 0 ? $default_text : '');
		return $new_text;
	}
}

// ------------------------------------------------------------------------

/**
* Insert a break or "soft" hyphen (&#173; or &shy;) in long words.
* http://www.the-art-of-web.com/php/truncate/
* http://codeigniter.com/wiki/word_limiter_closing_tags/
*
* @access public
* @param string $text
* @param int $limit
* @param string $break
* @return string
*/
if ( ! function_exists('limit_word_length'))
{
	function limit_word_length( $text, $limit = 24, $break = '&#173;' )
	{
		$text = preg_replace('/(\w{' . $limit . '})/', '$1' . $break, $text);
		return $text;
	}
}

// ------------------------------------------------------------------------

/**
* 
*
* @access public
* @param string $text
* @param int $word_limit
* @return string
*/
if ( ! function_exists('wrap_text'))
{
	function wrap_text( $text, $default_text = '(Blank)', $word_limit = 20, $word_wrap = 40 )
	{
		$text = trim($text);
		$text = ( strlen($text) > 0 ) ? $text : $default_text;
		$text = word_limiter(strip_tags($text), $word_limit);
		//$text = html_entity_decode($text);
		$text = wordwrap($text, $word_wrap, "\n", true);
		//$text = htmlentities($text, ENT_COMPAT, 'UTF-8');
		$text = nl2br($text);
		return $text;
	}
}

// ------------------------------------------------------------------------

/**
* Convert newlines to <li> tags.
*
* @access public
* @param string $text
* @param int $attributes
* @param string $newline
* @return string
*/
if ( ! function_exists('nl2li'))
{
	function nl2li( $text, $attributes = '', $newline = "\n" )
	{
		if ( strlen($attributes) > 0 )
		{
			$attributes .= ' ';
		}
		
		$new_text = '';
		$items = explode( $newline, $text );
		foreach ( $items as $item )
		{
			$new_text .= '<li' . $attributes . '>' . trim($item) . '</li>' . $newline;
		}
		return $new_text;
	}
}

// ------------------------------------------------------------------------

/**
* Convert newlines to line breaks and then coupled line breaks to paragraphs.
*
* @access public
* @param string $text
* @return string
*/
if ( ! function_exists('nl2p'))
{
	function nl2p( $text )
	{
		$text = nl2br($text);
		$text = preg_replace('#(<br />\s*){2}#', '</p><p>', $text);
		$text = str_replace('<p></p>', '<p>&nbsp;</p>', $text);
		
		if ( strpos($text, '<p>', 0) !== 0 )
		{
			$text = '<p>' . $text . '</p>';
		}
		
		return $text;
	}
}

// ------------------------------------------------------------------------

/**
* http://us.php.net/nl2br
* Turns two or more consecutive newlines (separated by possible white space) into a <p>...</p>.
* 
* Pass result to regular nl2br() to add <br/> to remaining nl's, eg,
* 
* echo nl2br(nls2p("Paragraph1\n\nParagraph2\n line1\n line2\n"));
* 
* result:
* <p>Paragraph1</p>
* <p>Paragraph2<br/>
* line1<br/>
* line2<br/></p> 
*/
if ( ! function_exists('nls2p'))
{
	function nls2p( $str )
	{
		return str_replace('<p></p>', '', '<p>'
		. preg_replace('#([\r\n]\s*?[\r\n]){2,}#', '</p>$0<p>', $str)
		. '</p>');
	}
}

// ------------------------------------------------------------------------

/**
* Convert BR tags to newlines and carriage returns.
* http://php.net/manual/en/function.nl2br.php
*
* @param string The string to convert
* @return string The converted string
*/
if ( ! function_exists('br2nl'))
{
	function br2nl( $string )
	{
		return preg_replace('/\<br(\s*)?\/?\>/i', PHP_EOL, $string);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('random_string2'))
{
	/**
	* Create random number, string, or password.
	* 
	* @access public
	* @param string $type The type of random to generate.
	* @param integer $length The password length.
	* @param bool $seed Whether or not to seed the PHP random generator.
	* @return string
	*/
	function random_string2( $type = 'encrypt', $length = 8, $seed = FALSE )
	{
		/*
http://keepass.info/help/base/pwgenerator.html
a 	Lower-Case Alphanumeric 	abcdefghijklmnopqrstuvwxyz 0123456789
A 	Mixed-Case Alphanumeric 	ABCDEFGHIJKLMNOPQRSTUVWXYZ abcdefghijklmnopqrstuvwxyz 0123456789
U 	Upper-Case Alphanumeric 	ABCDEFGHIJKLMNOPQRSTUVWXYZ 0123456789
d 	Digit 	0123456789
h 	Lower-Case Hex Character 	0123456789 abcdef
H 	Upper-Case Hex Character 	0123456789 ABCDEF
l 	Lower-Case Letter 	abcdefghijklmnopqrstuvwxyz
L 	Mixed-Case Letter 	ABCDEFGHIJKLMNOPQRSTUVWXYZ abcdefghijklmnopqrstuvwxyz
u 	Upper-Case Letter 	ABCDEFGHIJKLMNOPQRSTUVWXYZ
v 	Lower-Case Vowel 	aeiou
V 	Mixed-Case Vowel 	AEIOU aeiou
Z 	Upper-Case Vowel 	AEIOU
c 	Lower-Case Consonant 	bcdfghjklmnpqrstvwxyz
C 	Mixed-Case Consonant 	BCDFGHJKLMNPQRSTVWXYZ bcdfghjklmnpqrstvwxyz
z 	Upper-Case Consonant 	BCDFGHJKLMNPQRSTVWXYZ
p 	Punctuation 	,.;:
b 	Bracket 	()[]{}<>
s 	Printable 7-Bit Special Character 	!"#$%&'()*+,-./:;<=>?@[\]^_`{|}~
S 	Printable 7-Bit ASCII 	A-Z, a-z, 0-9, !"#$%&'()*+,-./:;<=>?@[\]^_`{|}~
x 	High ANSI 	From '~' to U255 (excluding U255).
\ 	Escape (Fixed Char) 	Use following character as is.
{n} 	Escape (Repeat) 	Repeat the previous character n times.
[...] 	Custom Char Set 	Define a custom character set.
		*/
		if ( $seed === TRUE )
		{
			mt_srand();
		}
		
		switch ( $type )
		{
			case 'basic' :
				return mt_rand();
				break;
			
			case 'unique' :
				return md5(uniqid(mt_rand()));
				break;
				
			case 'md5' :
			case 'sha1' :
			case 'encrypt' :
			{
				$unique_string = uniqid(mt_rand(), TRUE);
				$string = '';
				
				switch ( $type )
				{
					case 'md5' :
						$string = md5($unique_string);
						break;
					case 'sha1' :
					case 'encrypt' :
						$string = sha1($unique_string);
						break;
				}//end sub-switch
				
				return $string;
				break;
			}
			default :
			{
				switch ( $type )
				{
					case 'alpha' :
						$pool = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
						break;
					case 'alnum' :
						$pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
						break;
					case 'numeric' :
						$pool = '0123456789';
						break;
					case 'nonzero' :
						$pool = '123456789';
						break;
					case 'url' :
						$pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';//-_
						break;
					case 'password' :
						// Note: The letter l (lowercase L) and the number 1 have been removed from the 
						// possible options as they are commonly mistaken for each other.
						$pool = '234567890abcdefghijkmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
						break;
					case 'captcha' :
						// Note: The letter l (lowercase L) and the number 1 have been removed from the 
						// possible options as they are commonly mistaken for each other.
						// Same for the letter o and the number 0, and the letters i.
						$pool = '23456789abcdefghjkmnpqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ';
						break;
					default :
						$pool = $type;
						break;
				}//end sub-switch
				
				$chars_length = strlen($pool);
				$string = '';
				
				for ( $i = 0; $i < $length; $i++ )
				{
					$string .= $pool[ mt_rand(0, $chars_length - 1) ];
					//$string .= substr($pool, mt_rand(0, $chars_length - 1), 1);
				}
				
				return $string;
				break;
			}
			break;
		}//end type switch
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('generate_salt_hash'))
{
	/**
	* Create a sha1 hash string.
	* http://phpsec.org/articles/2005/password-hashing.html
	* 
	* @access public
	* @param string $text The text to encrypt.
	* @param string $salt The text to combine as the salt.
	* @param integer $salt_length The length of the salt to use.
	* @return string
	*/
	function generate_salt_hash( $text, $salt = '', $salt_length = 40, $salt_addon = TRUE )
	{
		if ( $salt == '' )
		{
			$salt = substr( md5(uniqid(rand(), TRUE)), 0, $salt_length );
		}
		else
		{
			$salt = substr($salt, 0, $salt_length);
		}
		
		// Salt placement could be iterative, in different areas, 
		// hashed off other unchanging data like a creation date vs. stored in a "salt" column, etc.
		$salted_text = sha1($salt . $text);
		
		if ( $salt_addon !== FALSE )
		{
			$salted_text = $salt . $salted_text;
		}
		
		return $salted_text;
	}
	
}

// --------------------------------------------------------------------

