<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/** 
* http://snippets.dzone.com/posts/show/1310
* 
* @access public
* @method string get_age($str_date) returns an integer age in years
* @param string $str_date The Y-m-d string date
* @return string The age in years
*/
if (! function_exists('get_age'))
{
	function get_age( $str_date )
	{
		$dob_time = strtotime($str_date . ' UTC');
		$sec_alive = time() - $dob_time;
		return floor($sec_alive / 31556926);// 31556926 seconds in a year, 1 year = 365.242199 days
		/*
		list($Y,$m,$d) = explode('-', $str_date);
		$years = date('Y') - $Y;
		
		if ( date('md') < $m . $d )
		{
			$years--;
		}
		
		return $years;
		*/
	}
}

// ------------------------------------------------------------------------

/** 
* 
*/
if (! function_exists('show_ago'))
{
	function show_ago( $str_date )
	{
		$time = is_numeric($str_date) ? (int)$str_date : strtotime($str_date . ' UTC');
		//$date_format = ($time && time() - $time > 86400) ? '\o\n m-d-Y h:i a' : '\a\t H:i a';// If past 24 hours
		/*$date_format = ($time && date('Y-m-d', $time) != date('Y-m-d')) ? '\o\n m-d-Y h:i a' : '\a\t H:i a';// If past 24 hours
		$time = ($time) ? date($date_format, $time) : '';*/
		
		if ( $time )
		{
			$seconds_minute = 60;
			$seconds_hour = 60 * $seconds_minute;
			$seconds_day = 24 * $seconds_hour;
			$seconds_week = 7 * $seconds_day;
			$seconds_year = 365.25 * $seconds_day;
			$seconds_month = $seconds_year / 12;
			
			$diff = time() - $time;
			$seconds = $diff;
			$minutes = $seconds / $seconds_minute;
			$hours = $seconds / $seconds_hour;
			$days = $seconds / $seconds_day;
			$weeks = $seconds / $seconds_week;
			$months = $seconds / $seconds_month;
			$years = $seconds / $seconds_year;
			
			$amount = 0;
			$modulo = 0;
			$modulo_tolerance = 0.2;
			$noun = '';
			$adverb = 'about';
			$phrase = '';
			
			if ( $years >= 1 )
			{
				$amount = round($years);
				$modulo = $years - floor($years);
				$noun = 'year';
			}
			elseif ( $months >= 1 )
			{
				$amount = round($months);
				$modulo = $months - floor($months);
				$noun = 'month';
			}
			elseif ( $weeks >= 1 )
			{
				$amount = round($weeks);
				$modulo = $weeks - floor($weeks);
				$noun = 'week';
			}
			elseif ( $days >= 1 )
			{
				$amount = round($days);
				$modulo = $days - floor($days);
				$noun = 'day';
			}
			elseif ( $hours >= 1 )
			{
				$amount = round($hours);
				$modulo = $hours - floor($hours);
				$noun = 'hour';
			}
			elseif ( $minutes >= 1 )
			{
				$amount = round($minutes);
				$modulo = $minutes - floor($minutes);
				$noun = 'minute';
				
				if ( $minutes > 30 )
				{
					$phrase = 'about an hour ago';
				}
			}
			elseif ( $seconds > 0 )
			{
				$amount = round($seconds);
				$noun = 'second';
				
				if ( $seconds > 30 )
				{
					$phrase = 'about a minute ago';
				}
				else
				{
					$phrase = 'just now';
				}
			}
			
			if ( strlen($phrase) == 0 )
			{
				$adverb = ( $modulo <= $modulo_tolerance || $modulo >= 1 -$modulo_tolerance ) ? '' : $adverb;
				$pluralize = ( $amount == 1 ) ? '' : 's';
				$noun .= $pluralize;
				$phrase = $adverb . ' ' . $amount . ' ' . $noun . ' ago';
			}
			
			$phrase = trim($phrase);
			
			return $phrase;
		}
	}
}

// ------------------------------------------------------------------------

/** 
* 
*/
if (! function_exists('show_duration'))
{
	function show_duration( $str_date )
	{
		$time = is_numeric($str_date) ? (int)$str_date : strtotime($str_date . ' UTC');
		//$date_format = ($time && time() - $time > 86400) ? '\o\n m-d-Y h:i a' : '\a\t H:i a';// If past 24 hours
		/*$date_format = ($time && date('Y-m-d', $time) != date('Y-m-d')) ? '\o\n m-d-Y h:i a' : '\a\t H:i a';// If past 24 hours
		$time = ($time) ? date($date_format, $time) : '';*/
		
		if ( $time )
		{
			// If in the current day
			if ( gmdate('Y-m-d', $time) == gmdate('Y-m-d') )
			{
				$diff = time() - $time;
				$minutes = round($diff / (60));
				$hours = round($diff / (60*60));
				if ( $minutes < 60 )
				{
					return ($minutes <= 1 ? 'a minute' : $minutes . ' minutes') . ' ago';
				}
				else
				{
					return 'about ' . ($hours <= 1 ? 'an hour' : $hours . ' hours') . ' ago';
				}
			}
			else
			{
				return date('\o\n m-d-Y h:i a', $time);
			}
		}
	}
}

// ------------------------------------------------------------------------

/** 
* http://stackoverflow.com/questions/8273804/convert-seconds-into-days-hours-minutes-seconds-in-php
* http://snippetsofcode.wordpress.com/2012/08/25/php-function-to-convert-seconds-into-human-readable-format-months-days-hours-minutes/
*/
if (! function_exists('seconds2human'))
{
	function seconds2human( $ss )
	{
		$s = $ss % 60;
		$m = floor(($ss % 3600) / 60);
		$h = floor(($ss % 86400) / 3600);
		$d = floor(($ss % 2592000) / 86400);
		$M = floor($ss / 2592000);
		
		$str_arr = array();
		
		if ( $M > 0 )
		{
			$M_label = $M == 1 ? 'month' : 'months';
			$str_arr[] = $M . ' ' . $M_label;
		}
		
		if ( $d > 0 )
		{
			$d_label = $d == 1 ? 'day' : 'days';
			$str_arr[] = $d . ' ' . $d_label;
		}
		
		if ( $h > 0 )
		{
			$h_label = $h == 1 ? 'hour' : 'hours';
			$str_arr[] = $h . ' ' . $h_label;
		}
		
		if ( $m > 0 )
		{
			$m_label = $m == 1 ? 'minute' : 'minutes';
			$str_arr[] = $m . ' ' . $m_label;
		}
		
		if ( $s > 0 )
		{
			$s_label = $s == 1 ? 'second' : 'seconds';
			$str_arr[] = $s . ' ' . $s_label;
		}

		return implode(', ', $str_arr);
	}
}

// ------------------------------------------------------------------------

/** 
* 
*/
if (! function_exists('process_seconds'))
{
	function process_seconds( $secs )
	{
		$minutes = $secs / 60;
		// Seconds decimal remainder
		$seconds_remainder = $minutes - (int)$minutes;// ($secs % 60) / 60;
		$seconds = round($seconds_remainder * 60, 3);
		$minutes = (int)$minutes;
		
		$str = $minutes . ' minute' . ($minutes != 1 ? 's' : '') . ' and ' . $seconds . ' second' . ($seconds != 1 ? 's' : '');
		return $str;
	}
}

// ------------------------------------------------------------------------

/** 
* 
*/
if (! function_exists('convert_timezone'))
{
	function convert_timezone( $date_time, $from_tz = 'UTC', $to_tz = '' )
	{
		// If timezone not passed, use server's
		if ( ! $to_tz )
		{
			$to_tz = date('T');
		}
		
		try
		{
			$time_object = new DateTime($date_time, new DateTimeZone($from_tz));
			$time_object->setTimezone(new DateTimeZone($to_tz));
			return $time_object->format('U');//'Y-m-d H:i:s'
		}
		catch ( Exception $error )
		{
			return '';
		}
	}
}

// ------------------------------------------------------------------------

