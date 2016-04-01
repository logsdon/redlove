<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* This class overrides native Router functionality
*
* @package CodeIgniter
* @subpackage Logsdon
* @category Libraries
* @author Joshua Logsdon <joshua@joshualogsdon.com>
* @copyright Copyright (c) 2015, Joshua Logsdon (http://joshualogsdon.com/)
* @license http://opensource.org/licenses/MIT MIT License
* @link http://joshualogsdon.com
* @filesource
* @since Version 0.0.0
* @version 0.0.0
*/

/**
* Router class override
*
* @package CodeIgniter
* @subpackage Logsdon
* @author Joshua Logsdon <joshua@joshualogsdon.com>
* @link
*/
class MY_Router extends CI_Router {

	// --------------------------------------------------------------------

	/**
	 * Set request route
	 *
	 * Takes an array of URI segments as input and sets the class/method
	 * to be called.
	 *
	 * @used-by	CI_Router::_parse_routes()
	 * @param	array	$segments	URI segments
	 */
	protected function _set_request($segments = array())
	{
		$segments = $this->_validate_request($segments);
		// If we don't have any segments left - try the default controller;
		// WARNING: Directories get shifted out of the segments array!
		if (empty($segments))
		{
			$this->_set_default_controller();
			return;
		}

		if ($this->translate_uri_dashes === TRUE)
		{
			$segments[0] = str_replace('-', '_', $segments[0]);
			if (isset($segments[1]))
			{
				$segments[1] = str_replace('-', '_', $segments[1]);
			}
		}

		// LOGSDON: If a custom catchall_controller route and file exists, use it and pass all rsegments, ideally caught and used in its _remap method
		if ( 
			! empty($this->routes['catchall_controller']) && 
			! file_exists(APPPATH.'controllers/'.$this->directory.$segments[0].'.php') 
		)
		{
			$this->set_class($this->routes['catchall_controller']);
			$this->set_method($segments[0]);
			$this->uri->rsegments = $segments;
			return;
		}

		$this->set_class($segments[0]);
		if (isset($segments[1]))
		{
			$this->set_method($segments[1]);
		}
		else
		{
			$segments[1] = 'index';
		}

		array_unshift($segments, NULL);
		unset($segments[0]);
		$this->uri->rsegments = $segments;
	}

	// --------------------------------------------------------------------

}
