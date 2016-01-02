<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* Remove stop words.
* http://urbanoalvarez.es/blog/2008/04/04/bad-words-list/
*
* @access public
* @param string $text
* @param int $length
* @param string $append
* @param string $default_text
* @return string
*/
if ( ! function_exists('check_stop_words'))
{
	function check_stop_words( $text, $stopwords_file )
	{
		// Stop if no stopwords file
		if ( ! file_exists($stopwords_file) )
		{
			return;
		}
		
		// Clean up words
		$words = explode(' ', strtolower($text));
		$words = array_map('trim', $words);
		$words = array_diff($words, array(''));
		
		// Stop if no words
		if ( empty($words) )
		{
			return;
		}
		
		// Get stopwords
		$stopwords = explode("\n", file_get_contents($stopwords_file));
		$stopwords = array_map('trim', $stopwords);
		$stopwords = array_map('strtolower', $stopwords);
		/*
		$stopwords = array_unique($stopwords, SORT_STRING);
		asort($stopwords, SORT_STRING);
		echo implode("\n", $stopwords);
		*/
		
		// Get the stopwords found
		return array_unique(array_values(array_intersect($stopwords, $words)));
		
		// Get the words that are not stopwords
		return array_values(array_diff($words, $stopwords));
	}
}

// ------------------------------------------------------------------------

/**
* Remove stop words.
* http://urbanoalvarez.es/blog/2008/04/04/bad-words-list/
*
* @access public
* @param string $text
* @param int $length
* @param string $append
* @param string $default_text
* @return string
*/
if ( ! function_exists('remove_stop_words'))
{
	function remove_stop_words( $words, $stopwords_file )
	{
		if ( file_exists($stopwords_file) )
		{
			$words = array_map('strtolower', array_diff($words, array('')));
			$stopwords = explode("\r\n", file_get_contents($stopwords_file));
			return array_values(array_diff($words, $stopwords));
		}
	}
}

// ------------------------------------------------------------------------

/**
* Remove stop words.
*
* @access public
* @param string $text
* @param int $attributes
* @param string $newline
* @return string
*/
if ( ! function_exists('remove_stop_words2'))
{
	function remove_stop_words2( $term, $stopwords_file )
	{
		//load list of common words
		$common = file($stopwords_file);
		$total = count($common);
		
		for ( $x = 0; $x <= $total; $x++ )
		{
			$common[$x] = trim(strtolower($common[$x]));
		}
		
		//make array of search terms        
		$_terms = explode(' ', $term);
		
		foreach ($_terms as $line)
		{
			
/*Another way to pattern through for words
$pattern = '/' . rtrim($stopword_value) . '/';
if (preg_match($pattern, $fieldvalue)) {
header("Location: http://www.monikaa.uni.cc/banneduser.htm");
exit;
}
*/
			if ( in_array(strtolower(trim($line)), $common) )
			{
				$remove_key = array_search( $line, $this->_terms );
				unset($_terms[$remove_key]);
			}
			else
			{
				$clean_term .= ' '. $line;
			}
		}
		return $clean_term;
	}
}

// --------------------------------------------------------------------

