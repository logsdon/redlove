<?php

// --------------------------------------------------------------------

if ( ! function_exists('output_code') )
{
	/**
	* 
	*/
	function output_code ( $code, $full = true )
	{
		if ( $full )
		{
?>
<div class="redlove_code-example">
<span class="redlove_code-example_toggle"></span>
<div class="redlove_code-example_liner">
<?php
	$delimiter_begin = '{{';
	$delimiter_end = '}}';
	$delimiter_begin = '<\?php';
	$delimiter_end = '\?>';
	
	$new_code = $code;
	/*
	// http://www.regexr.com/3a1bt
	// Parse through possible shortcodes indiscriminately, e.g. [shortcode attribute="value"] or [shortcode]Test[/shortcode]
	// |\[([\w\d\-_]+)([^\]]*)\](?:(.*)(\[/\1\]))?|is
	$pattern = $delimiter_begin . '([\w\d\-_]+)([^' . $delimiter_end . ']*)' . $delimiter_end;
	$pattern .= '(?:(.*)(' . $delimiter_begin . '/\1' . $delimiter_end . '))?';
	*/
	$pattern = $delimiter_begin . '([\w\d\-_]+)[^' . $delimiter_end . ']*' . $delimiter_end;
	$pattern = $delimiter_begin . '([^' . $delimiter_end . ']*)' . $delimiter_end;
	$has_matches = preg_match_all('|' . $pattern . '|is', $new_code, $matches,  PREG_SET_ORDER);
	$matched_patterns = array();
	foreach ( $matches as $match )
	{
		$matched_pattern = $match[0];
		$matched_result = $match[1];
		
		if ( in_array($matched_pattern, $matched_patterns) )
		{
			continue;
		}
		$matched_patterns[] = $matched_pattern;
		
		$result = $matched_pattern;
		if ( function_exists($matched_result) )
		{
			$args = array();
			$result = call_user_func_array($matched_result, $args);
		}
		else
		{
			// This is unsafe and is only intended for internal demo/example code use
			ob_start();
			$result = eval($matched_result);
			$output = ob_get_contents();
			ob_end_clean();
			$result = isset($result) ? $result : $output;
		}
		$new_code = str_ireplace($matched_pattern, $result, $new_code);
	}
	echo $new_code;
?>
</div>
</div>
<hr class="default w60 center">
<?php
		}
		else
		{
?>
<?php echo $code; ?>
<div class="redlove_code-example redlove_code-example-shown">
<span class="redlove_code-example_toggle"></span>
<div class="redlove_code-example_liner">
 <pre><?php echo htmlentities(trim($code)); ?></pre>
</div>
</div>
<hr class="default w60 center">
<?php
		}
		
		return;
?>
<div class="columns">
	<div class="column w100">
		<?php echo $code; ?>
	</div>
	<div class="column w100">
		<pre class="code" style="max-height: 20em; overflow-y: auto;"><?php echo htmlentities($code); ?></pre>
	</div>
</div>
<?php
	}
}

// --------------------------------------------------------------------

if ( ! function_exists('hex2rgb') )
{
	/**
	* Convert hexidecimal to rgb
	* http://bavotasan.com/2011/convert-hex-color-to-rgb-using-php/
	*/
	function hex2rgb ( $hex, $glue = null )
	{
		$hex = str_replace('#', '', $hex);

		if ( strlen($hex) == 3 )
		{
			$r = hexdec(substr($hex, 0, 1) . substr($hex, 0, 1));
			$g = hexdec(substr($hex, 1, 1) . substr($hex, 1, 1));
			$b = hexdec(substr($hex, 2, 1) . substr($hex, 2, 1));
		}
		else
		{
			$r = hexdec(substr($hex, 0, 2));
			$g = hexdec(substr($hex, 2, 2));
			$b = hexdec(substr($hex, 4, 2));
		}
		
		$rgb = array($r, $g, $b);
		
		// Return rgb string with separator or an array of values
		return isset($glue) ? implode($glue, $rgb) : $rgb;
	}
}

if ( ! function_exists('rgb2hex') )
{
	/**
	* Convert rgb to hexidecimal
	* http://bavotasan.com/2011/convert-hex-color-to-rgb-using-php/
	*/
	function rgb2hex ( $rgb, $prefix = '#' )
	{
		$hex = $prefix;
		$hex .= str_pad(dechex($rgb[0]), 2, '0', STR_PAD_LEFT);
		$hex .= str_pad(dechex($rgb[1]), 2, '0', STR_PAD_LEFT);
		$hex .= str_pad(dechex($rgb[2]), 2, '0', STR_PAD_LEFT);
		
		// Return the prefixed hex value
		return $hex;
	}
}

// --------------------------------------------------------------------

/**
* Wrap applicable content with paragraph tags
*
* @access public
* @param mixed $tags
* @return int Database insert id on success.
* @return bool FALSE on failure.
*/
if ( ! function_exists('wpautop') )
{
	/**
	 * Replaces double line-breaks with paragraph elements.
	 *
	 * A group of regex replaces used to identify text formatted with newlines and
	 * replace double line-breaks with HTML paragraph tags. The remaining line-breaks
	 * after conversion become <<br />> tags, unless $br is set to '0' or 'false'.
	 *
	 * @since 0.71
	 *
	 * @param string $pee The text which has to be formatted.
	 * @param bool   $br  Optional. If set, this will convert all remaining line-breaks
	 *                    after paragraphing. Default true.
	 * @return string Text which has been converted into correct paragraph tags.
	 */
	function wpautop( $pee, $br = true )
	{
		$pre_tags = array();

		if ( trim($pee) === '' )
			return '';

		// Just to make things a little easier, pad the end.
		$pee = $pee . "\n";

		/*
		 * Pre tags shouldn't be touched by autop.
		 * Replace pre tags with placeholders and bring them back after autop.
		 */
		if ( strpos($pee, '<pre') !== false ) {
			$pee_parts = explode( '</pre>', $pee );
			$last_pee = array_pop($pee_parts);
			$pee = '';
			$i = 0;

			foreach ( $pee_parts as $pee_part ) {
				$start = strpos($pee_part, '<pre');

				// Malformed html?
				if ( $start === false ) {
					$pee .= $pee_part;
					continue;
				}

				$name = "<pre wp-pre-tag-$i></pre>";
				$pre_tags[$name] = substr( $pee_part, $start ) . '</pre>';

				$pee .= substr( $pee_part, 0, $start ) . $name;
				$i++;
			}

			$pee .= $last_pee;
		}
		// Change multiple <br>s into two line breaks, which will turn into paragraphs.
		$pee = preg_replace('|<br />\s*<br />|', "\n\n", $pee);

		$allblocks = '(?:table|thead|tfoot|caption|col|colgroup|tbody|tr|td|th|div|dl|dd|dt|ul|ol|li|pre|form|map|area|blockquote|address|math|style|p|h[1-6]|hr|fieldset|legend|section|article|aside|hgroup|header|footer|nav|figure|figcaption|details|menu|summary)';

		// Add a single line break above block-level opening tags.
		$pee = preg_replace('!(<' . $allblocks . '[^>]*>)!', "\n$1", $pee);

		// Add a double line break below block-level closing tags.
		$pee = preg_replace('!(</' . $allblocks . '>)!', "$1\n\n", $pee);

		// Standardize newline characters to "\n".
		$pee = str_replace(array("\r\n", "\r"), "\n", $pee); 

		// Collapse line breaks before and after <option> elements so they don't get autop'd.
		if ( strpos( $pee, '<option' ) !== false ) {
			$pee = preg_replace( '|\s*<option|', '<option', $pee );
			$pee = preg_replace( '|</option>\s*|', '</option>', $pee );
		}

		/*
		 * Collapse line breaks inside <object> elements, before <param> and <embed> elements
		 * so they don't get autop'd.
		 */
		if ( strpos( $pee, '</object>' ) !== false ) {
			$pee = preg_replace( '|(<object[^>]*>)\s*|', '$1', $pee );
			$pee = preg_replace( '|\s*</object>|', '</object>', $pee );
			$pee = preg_replace( '%\s*(</?(?:param|embed)[^>]*>)\s*%', '$1', $pee );
		}

		/*
		 * Collapse line breaks inside <audio> and <video> elements,
		 * before and after <source> and <track> elements.
		 */
		if ( strpos( $pee, '<source' ) !== false || strpos( $pee, '<track' ) !== false ) {
			$pee = preg_replace( '%([<\[](?:audio|video)[^>\]]*[>\]])\s*%', '$1', $pee );
			$pee = preg_replace( '%\s*([<\[]/(?:audio|video)[>\]])%', '$1', $pee );
			$pee = preg_replace( '%\s*(<(?:source|track)[^>]*>)\s*%', '$1', $pee );
		}

		// Remove more than two contiguous line breaks.
		$pee = preg_replace("/\n\n+/", "\n\n", $pee);

		// Split up the contents into an array of strings, separated by double line breaks.
		$pees = preg_split('/\n\s*\n/', $pee, -1, PREG_SPLIT_NO_EMPTY);

		// Reset $pee prior to rebuilding.
		$pee = '';

		// Rebuild the content as a string, wrapping every bit with a <p>.
		foreach ( $pees as $tinkle ) {
			$pee .= '<p>' . trim($tinkle, "\n") . "</p>\n";
		}

		// Under certain strange conditions it could create a P of entirely whitespace.
		$pee = preg_replace('|<p>\s*</p>|', '', $pee); 

		// Add a closing <p> inside <div>, <address>, or <form> tag if missing.
		$pee = preg_replace('!<p>([^<]+)</(div|address|form)>!', "<p>$1</p></$2>", $pee);
		
		// If an opening or closing block element tag is wrapped in a <p>, unwrap it.
		$pee = preg_replace('!<p>\s*(</?' . $allblocks . '[^>]*>)\s*</p>!', "$1", $pee); 
		
		// In some cases <li> may get wrapped in <p>, fix them.
		$pee = preg_replace("|<p>(<li.+?)</p>|", "$1", $pee); 
		
		// If a <blockquote> is wrapped with a <p>, move it inside the <blockquote>.
		$pee = preg_replace('|<p><blockquote([^>]*)>|i', "<blockquote$1><p>", $pee);
		$pee = str_replace('</blockquote></p>', '</p></blockquote>', $pee);
		
		// If an opening or closing block element tag is preceded by an opening <p> tag, remove it.
		$pee = preg_replace('!<p>\s*(</?' . $allblocks . '[^>]*>)!', "$1", $pee);
		
		// If an opening or closing block element tag is followed by a closing <p> tag, remove it.
		$pee = preg_replace('!(</?' . $allblocks . '[^>]*>)\s*</p>!', "$1", $pee);

		// Optionally insert line breaks.
		if ( $br ) {
			// Replace newlines that shouldn't be touched with a placeholder.
			$pee = preg_replace_callback('/<(script|style).*?<\/\\1>/s', '_autop_newline_preservation_helper', $pee);

			// Replace any new line characters that aren't preceded by a <br /> with a <br />.
			$pee = preg_replace('|(?<!<br />)\s*\n|', "<br />\n", $pee); 

			// Replace newline placeholders with newlines.
			$pee = str_replace('<WPPreserveNewline />', "\n", $pee);
		}

		// If a <br /> tag is after an opening or closing block tag, remove it.
		$pee = preg_replace('!(</?' . $allblocks . '[^>]*>)\s*<br />!', "$1", $pee);
		
		// If a <br /> tag is before a subset of opening or closing block tags, remove it.
		$pee = preg_replace('!<br />(\s*</?(?:p|li|div|dl|dd|dt|th|pre|td|ul|ol)[^>]*>)!', '$1', $pee);
		$pee = preg_replace( "|\n</p>$|", '</p>', $pee );

		// Replace placeholder <pre> tags with their original content.
		if ( !empty($pre_tags) )
			$pee = str_replace(array_keys($pre_tags), array_values($pre_tags), $pee);

		return fix_autop($pee);//return $pee;
	}
	
	/**
	 * Newline preservation help function for wpautop
	 *
	 * @since 3.1.0
	 * @access private
	 *
	 * @param array $matches preg_replace_callback matches array
	 * @return string
	 */
	function _autop_newline_preservation_helper( $matches )
	{
		return str_replace("\n", "<WPPreserveNewline />", $matches[0]);
	}
	
	// http://kendsnyder.com/simple-and-effective-fix-for-the-wordpress-wpautop-madness/
	function fix_autop( $content )
	{
		$html = trim($content);
		if ( $html === '' ) {
			return '';	
		}
		$blocktags = 'address|article|aside|audio|blockquote|canvas|caption|center|col|del|dd|div|dl|fieldset|figcaption|figure|footer|form|frame|frameset|h1|h2|h3|h4|h5|h6|header|hgroup|iframe|ins|li|nav|noframes|noscript|object|ol|output|pre|script|section|table|tbody|td|tfoot|thead|th|tr|ul|video';
		$html = preg_replace('~<p>\s*<('.$blocktags.')\b~i', '<$1', $html);
		$html = preg_replace('~</('.$blocktags.')>\s*</p>~i', '</$1>', $html);
		
		// Remove pees around comments
		$html = preg_replace('~<p>\s*(<!--)~i', '$1', $html);
		$html = preg_replace('~(-->)\s*</p>~i', '$1', $html);
		
		return $html;
	}
}

// --------------------------------------------------------------------

