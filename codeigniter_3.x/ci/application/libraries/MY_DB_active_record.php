<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* This class override enhances Active Record.
* 
* @author	Joshua Logsdon
* @email	joshua@joshualogsdon.com
* @filename	MY_DB_active_record.php
* @title	Active Record library override
* @url		http://www.joshualogsdon.com
* @version	1.0
*/
class MY_DB_active_record extends CI_DB_active_record
{
	/**
	 * Join
	 *
	 * Generates the JOIN portion of the query
	 *
	 * @access	public
	 * @param	string
	 * @param	string	the join condition
	 * @param	string	the type of join
	 * @return	object
	 */
	function join( $table, $cond, $type = '', $escape = TRUE )
	{
		if ( $type != '' )
		{
			$type = strtoupper(trim($type));

			if ( ! in_array($type, array('LEFT', 'RIGHT', 'OUTER', 'INNER', 'LEFT OUTER', 'RIGHT OUTER')) )
			{
				$type = '';
			}
			else
			{
				$type .= ' ';
			}
		}

		// Extract any aliases that might exist.  We use this information
		// in the _protect_identifiers to know whether to add a table prefix 
		$this->_track_aliases($table);

		// Strip apart the condition and protect the identifiers
		if ( preg_match('/([\w\.]+)([\W\s]+)(.+)/', $cond, $match) )
		{
			$match[1] = ($escape ? $this->_protect_identifiers($match[1]) : $match[1]);
			$match[3] = ($escape ? $this->_protect_identifiers($match[3]) : $match[3]);
		
			$cond = $match[1] . $match[2] . $match[3];		
		}
		
		// Assemble the JOIN statement
		$join = $type . 'JOIN ' . $this->_protect_identifiers($table, TRUE, NULL, FALSE) . ' ON ' . $cond;

		$this->ar_join[] = $join;
		if ($this->ar_caching === TRUE)
		{
			$this->ar_cache_join[] = $join;
			$this->ar_cache_exists[] = 'join';
		}

		return $this;
	}

	// --------------------------------------------------------------------

}

/* End of file DB_active_rec.php */
/* Location: ./system/database/DB_active_rec.php */