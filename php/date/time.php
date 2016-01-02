<?php


$the_date = strtotime('2010-01-19 00:00:00');
echo($the_date . "<br />");
echo(date_default_timezone_get() . "<br />");
echo(date('Y-m-dTG:i:sz', $the_date) . "<br />");
echo(gmdate('Y-m-dTG:i:sz', $the_date) . "<br />");
echo strtotime("now"), "\n";
echo strtotime("now UTC"), "\n";
echo '<hr>';

$now = time();
$local_timestamp = date('Y-m-d H:i:s', $now);
$utc_timestamp = gmdate('Y-m-d H:i:s', $now);
echo($now . "<br />");

echo '<hr><h3>' . date('T') . '</h3>';
echo($local_timestamp . "<br />");
echo(date('Y-m-d T G:i:sz') . "<br />");
echo(date('Y-m-d T G:i:sz', $now) . "<br />");
echo(date('Y-m-d T G:i:sz', strtotime($local_timestamp)) . "<br />");
echo(date('Y-m-d T G:i:sz', strtotime($utc_timestamp . ' UTC')) . "<br />");

echo '<hr><h3>UTC</h3>';
echo($utc_timestamp . "<br />");
echo(gmdate('Y-m-d T G:i:sz', $now) . "<br />");
echo(gmdate('Y-m-d T G:i:sz') . "<br />");
echo(gmdate('Y-m-d T G:i:sz', strtotime($local_timestamp)) . "<br />");
echo(gmdate('Y-m-d T G:i:sz', strtotime($utc_timestamp . ' UTC')) . "<br />");


$items = array(
	array(
		'start_datetime' => '2015-01-01 00:00:00',
		'stop_datetime' => '2015-07-01 00:00:00',
		'promotion_begins_on' => 'April 1st, 2015 and ends at 11:59 P.M. on June 30th, 2015',
		'eligible_entries_on' => 'January 5th, 2015',
		'prize_retail_value' => '$750',
		'reward_up_to' => '$750',
	),
	array(
		'start_datetime' => '2015-07-01 00:00:00',
		'stop_datetime' => '2015-10-01 00:00:00',
		'promotion_begins_on' => 'July 1st, 2015 and ends at 11:59 P.M. on September 30th, 2015',
		'eligible_entries_on' => 'October 5th, 2015',
		'prize_retail_value' => '$500',
		'reward_up_to' => '$500',
	),
	array(
		'start_datetime' => '2015-10-01 00:00:00',
		'stop_datetime' => '',
		'promotion_begins_on' => 'October 1st, 2015 and ends at 11:59 P.M. on December 31st, 2015',
		'eligible_entries_on' => 'January 5th, 2016',
		'prize_retail_value' => '$500',
		'reward_up_to' => '$500',
	),
);

// Find the current item
$now = isset($_REQUEST['now']) ? strtotime($_REQUEST['now'] . ' America/New_York') : time();
foreach ( $items as $row )
{
	// Stop if the item is current
	if (
		(
			isset($row['start_datetime'][0]) &&
			strtotime($row['start_datetime'] . ' America/New_York') <= $now
		)
		&&
		(
			! isset($row['start_datetime'][0]) ||
			strtotime($row['stop_datetime'] . ' America/New_York') > $now
		)
	)
	{
		break;
	}
}



// Midnight examples

echo date('Y-m-d H:i:s', strtotime('2011-12-31 00:00:00')) .'<br />';

echo date('Y-m-d H:i:s', strtotime('2012-01-01 00:00:00')) .'<br />';

echo date('Y-m-d H:i:s', mktime(23, 59, 59, 12, 31, 2011)) .'<br />';

echo date('Y-m-d H:i:s', mktime(0, 0, 0, 12, 31 + 1, 2011)) .'<br />';

echo date('Y-m-d H:i:s', mktime(0, 0, 0 - 1, 1, 1, 2012)) .'<br />';




$entry_time = strtotime('2012-01-01 00:00:00' . ' UTC');
$local_date = date('M jS, Y \a\t\ g:ia T', $entry_time);




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
		if ( ! $to_tz )
		{
			$to_tz = date('T');
		}
		
		$time_object = new DateTime($date_time, new DateTimeZone($from_tz));
		$time_object->setTimezone(new DateTimeZone($to_tz));
		return $time_object->format('U');//'Y-m-d H:i:s'
	}
}

// ------------------------------------------------------------------------
