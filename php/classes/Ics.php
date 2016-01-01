<?php
/**
* Create ICS file
*
* @package RedLove
* @subpackage PHP
* @category Classes
* @author Joshua Logsdon <joshua@joshualogsdon.com>
* @author Various from CodeIgniter to Internet
* @copyright Copyright (c) 2015, Joshua Logsdon (http://joshualogsdon.com/)
* @license http://opensource.org/licenses/MIT MIT License
* @link https://github.com/logsdon/redlove
* @link http://redlove.org
* @version 0.0.0
* 
* Resources: 
* https://gist.github.com/jakebellacera/635416
* 
* Usage: 
* 

require_once('Ics.php');
$ICS = new Ics();
$ICS->create(array(
	'date_begin' => $event->begin_datetime,
	'date_end' => $event->end_datetime,
	'address' => '',
	'description' => $event->description,
	'uri' => '',
	'summary' => '',
	'download' => true,
));
exit;

* 
*/
class Ics
{
	// --------------------------------------------------------------------
	// Public methods
	// --------------------------------------------------------------------
	
	/**
	* Class constructor
	*/
	function __construct ()
	{
	}
	
	// --------------------------------------------------------------------
	
	/** 
	* Create an ICS file
	* 
	
// Notes:
// - the UID should be unique to the event, so in this case I'm just using
// uniqid to create a uid, but you could do whatever you'd like.
//
// - iCal requires a date format of "yyyymmddThhiissZ". The "T" and "Z"
// characters are not placeholders, just plain ol' characters. The "T"
// character acts as a delimeter between the date (yyyymmdd) and the time
// (hhiiss), and the "Z" states that the date is in UTC time. Note that if
// you don't want to use UTC time, you must prepend your date-time values
// with a TZID property. See RFC 5545 section 3.3.5
//
// - The Content-Disposition: attachment; header tells the browser to save/open
// the file. The filename param sets the name of the file, so you could set
// it as "my-event-name.ics" or something similar.
//
// - Read up on RFC 5545, the iCalendar specification. There is a lot of helpful
// info in there, such as formatting rules. There are also many more options
// to set, including alarms, invitees, busy status, etc.
//
// https://www.ietf.org/rfc/rfc5545.txt

	* 
	* @access public
	* @param mixed $text This is the actual message text.
	* @param string $type Used to group notifications like "error", "warning", "success", "notice", "info", etc.
	*/
	public function create ( $params = array() )
	{
		// Set default values for missing keys
		$default_params = array(
			'id' => uniqid(),
			'date_begin' => '',// the starting date (in seconds since unix epoch)
			'date_end' => '',// the ending date (in seconds since unix epoch)
			'address' => '',// the event's address
			'description' => '',// text description of the event
			'uri' => '',// the URL of the event (add http://)
			'summary' => '',// text description of the event
			
			'filename' => NULL,// the name of this file for saving (e.g. my-event-name.ics)
			'download' => FALSE,
		);
		$params = array_merge($default_params, $params);
		
		extract($params);
		
		$date_begin = $this->ensure_time($date_begin);
		$date_end = $this->ensure_time($date_end);
		
		$ics = trim('
BEGIN:VCALENDAR
VERSION:2.0
PRODID:-//hacksw/handcal//NONSGML v1.0//EN
CALSCALE:GREGORIAN
BEGIN:VEVENT
DTEND:' . $this->date_to_ics($date_end) . '
UID:' . $this->escape($id) . '
DTSTAMP:' . $this->date_to_ics(time()) . '
LOCATION:' . $this->escape($address) . '
DESCRIPTION:' . $this->escape($description) . '
URL;VALUE=URI:' . $this->escape($uri) . '
SUMMARY:' . $this->escape($summary) . '
DTSTART:' . $this->date_to_ics($date_begin) . '
END:VEVENT
END:VCALENDAR
		');
		
		if ( $download )
		{
			$download_params = array(
				'ics' => $ics,
			);
			
			if ( isset($filename) )
			{
				$download_params['filename'] = $filename;
			}
			
			$this->download($download_params);
		}
		
		return $ics;
	}
	
	// --------------------------------------------------------------------
	
	/** 
	* Date to ICS
	* 
	* Converts a unix timestamp to an ics-friendly format
	* NOTE: "Z" means that this timestamp is a UTC timestamp. If you need
	* to set a locale, remove the "\Z" and modify DTEND, DTSTAMP and DTSTART
	* with TZID properties (see RFC 5545 section 3.3.5 for info)
	* 
	* Also note that we are using "g" instead of "H" because iCalendar's Time format
	* requires 24-hour time (see RFC 5545 section 3.3.12 for info).
	* 
	* @access public
	* @param int
	* @return string
	*/
	public function download ( $params = array() )
	{
		// Set default values for missing keys
		$default_params = array(
			'ics' => '',
			'filename' => 'new-calendar-event.ics',// the name of this file for saving (e.g. my-event-name.ics)
		);
		$params = array_merge($default_params, $params);
		
		extract($params);
		
		// Clear cache
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');// Date in the past
		header('Expires: -1', FALSE);// IE6
		header('Last-Modified: '. gmdate('D, d M Y H:i:s') .' GMT');
		header('If-Modified-Since: Sat, 1 Jan 2000 00:00:00 GMT');
		header('Cache-Control: no-store, no-cache, must-revalidate');// HTTP/1.1
		header('Cache-Control: post-check=0, pre-check=0, max-age=0', FALSE);// HTTP/1.1
		header('Pragma: no-cache');// HTTP/1.0 && IE6
		
		// Set the correct headers for this file
		header('Content-Type: text/calendar; charset=utf-8');
		header('Content-Disposition: attachment; filename=' . $filename);
		
		// Echo out the ics file's contents
		exit($ics);
	}
	
	// --------------------------------------------------------------------
	
	/** 
	* Date to ICS
	* 
	* Converts a unix timestamp to an ics-friendly format
	* NOTE: "Z" means that this timestamp is a UTC timestamp. If you need
	* to set a locale, remove the "\Z" and modify DTEND, DTSTAMP and DTSTART
	* with TZID properties (see RFC 5545 section 3.3.5 for info)
	* 
	* Also note that we are using "g" instead of "H" because iCalendar's Time format
	* requires 24-hour time (see RFC 5545 section 3.3.12 for info).
	* 
	* @access public
	* @param int
	* @return string
	*/
	public function date_to_ics ( $time )
	{
		$time = $this->ensure_time($time);
		return gmdate('Ymd\THis\Z', $time);//Ymd\Tdis\Z
	}
	
	// --------------------------------------------------------------------
	
	/** 
	* Escapes a string of characters
	* 
	* @access public
	* @param string
	* @return string
	*/
	public function ensure_time ( $time )
	{
		if ( ! is_int($time) )
		{
			$time = strtotime($time);
		}
		
		return $time;
	}
	
	// --------------------------------------------------------------------
	
	/** 
	* Escapes a string of characters
	* 
	* @access public
	* @param string
	* @return string
	*/
	public function escape ( $string )
	{
		return preg_replace('/([\,;])/', '\\\$1', $string);
	}
	
	// --------------------------------------------------------------------
	
}

