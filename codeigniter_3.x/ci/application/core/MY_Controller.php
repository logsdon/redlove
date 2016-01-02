<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* This class provides a set of base Controller classes to be utilized with user authentication
*
* @package CodeIgniter
* @subpackage Logsdon
* @category Libraries
* @author Joshua Logsdon <joshua@joshualogsdon.com>
* @copyright Copyright (c) 2015, Joshua Logsdon (http://joshualogsdon.com/)
* @license http://opensource.org/licenses/MIT MIT License
* @link http://joshualogsdon.com
* @filesource
* @since Version 1.0.0
* @version 1.0.0
*/

/**
* Public controller class
* 
* This controller is the root and accessible to anyone.
* 
* @package CodeIgniter
* @subpackage Logsdon
* @author Joshua Logsdon <joshua@joshualogsdon.com>
* @link
*/
class Public_controller extends CI_Controller
{
	// --------------------------------------------------------------------
	// Public properties
	// --------------------------------------------------------------------
	
	/**
	* The admin theme
	* 
	* @var string
	*/
	public $admin_theme;
	
	/**
	* The admin theme path
	* 
	* @var string
	*/
	public $admin_theme_path;
	
	/**
	* The admin theme url
	* 
	* @var string
	*/
	public $admin_theme_url;
	
	/**
	* The admin themes path
	* 
	* @var string
	*/
	public $admin_themes_path;
	
	/**
	* Class data
	*
	* @var array
	*/
	public $data;
	
	/**
	* The site theme
	* 
	* @var string
	*/
	public $site_theme;
	
	/**
	* The site theme path
	* 
	* @var string
	*/
	public $site_theme_path;
	
	/**
	* The site theme url
	* 
	* @var string
	*/
	public $site_theme_url;
	
	/**
	* The site themes path
	* 
	* @var string
	*/
	public $site_themes_path;
	
	/**
	* Main HTML site title to be combined with a page title.
	* 
	* @var string
	*/
	public $site_title = '';
	
	/**
	* URI path to controller 
	*
	* @var string
	*/
	public $uri_path;
	
	// --------------------------------------------------------------------
	// Public methods
	// --------------------------------------------------------------------
	
	/**
	* Class constructor
	*/
	public function __construct ()
	{
		parent::__construct();// Call parent constructor before it is overridden
		
		// If in development, show page profiler information
		if ( ENVIRONMENT == 'development' )
		{
			$this->output->enable_profiler(true);
		}
		
		// Basically, autoload
		$this->load->helper(array('form', 'url'));
		
		// Load admin config and set template
		$this->config->load('application/admin_settings', true);
		$this->admin_themes_path = $this->config->item('themes_path', 'application/admin_settings');
		$this->admin_theme = $this->config->item('theme', 'application/admin_settings');
		$this->admin_theme_path = $this->admin_themes_path . $this->admin_theme;
		$this->admin_theme_path = isset($this->admin_theme_path[0]) ? $this->admin_theme_path	. '/' : '';
		$this->admin_theme_url = base_url() . $this->admin_theme_path;
		
		// Load site config and set template
		$this->config->load('application/site_settings', true);
		$this->site_themes_path = $this->config->item('themes_path', 'application/site_settings');
		$this->site_theme = $this->config->item('theme', 'application/site_settings');
		$this->site_theme_path = $this->site_themes_path . $this->site_theme;
		$this->site_theme_path = isset($this->site_theme_path[0]) ? $this->site_theme_path	. '/' : '';
		$this->site_theme_url = base_url() . $this->site_theme_path;
		
		log_message('info', __CLASS__ . ' class initialized.');
	}
	
	// --------------------------------------------------------------------
	
}

// --------------------------------------------------------------------

/**
* Authenticated controller class
* 
* This controller is used when requiring user authentication.
* 
* @package CodeIgniter
* @subpackage Logsdon
* @author Joshua Logsdon <joshua@joshualogsdon.com>
* @link
*/
class Auth_controller extends Public_controller
{
	// --------------------------------------------------------------------
	// Public methods
	// --------------------------------------------------------------------
	
	/**
	* Class constructor
	*/
	public function __construct ()
	{
		parent::__construct();// Call parent constructor first
		log_message('info', __CLASS__ . ' class initialized.');
		
		// Load the authentication library
		$this->load->library('application/auth');
		
		// If user IS NOT logged in, enforce logging in
		if ( ! $this->auth->valid() )
		{
			// Give end response if request type detected, e.g. AJAX
			$this->load->library('utility/request');
			$response = '<p>Your session is no longer valid. Please log in and try again.</p>';
			$this->request->response($response, 'html');
			
			// Redirect to the default controller:
			redirect();
			
		}
	}
	
	// --------------------------------------------------------------------
	
}

// --------------------------------------------------------------------

/**
* Admin controller class
* 
* This controller is used when requiring Admin access.
* 
* @package CodeIgniter
* @subpackage Logsdon
* @author Joshua Logsdon <joshua@joshualogsdon.com>
* @link
*/
class Admin_controller extends Public_controller//Auth_controller
{
	// --------------------------------------------------------------------
	// Public properties
	// --------------------------------------------------------------------
	
	/**
	* Default model to use in common actions
	* 
	* @var string
	*/
	public $default_model = '';
	
	/**
	* Default model id to use in common actions
	* 
	* @var string
	*/
	public $default_model_id_field = '';
	
	/**
	* Default model id to use in common actions
	* 
	* @var string
	*/
	public $default_model_parent_id_field;
	
	/**
	* Special data filters for records, driven by querystrings
	*
	* @var array
	*/
	public $filters = array();
	
	/**
	* Noun to use for feedback
	* 
	* @var string
	*/
	public $item_noun = '';
	
	/**
	* Unique page identifier
	* 
	* @var string
	*/
	public $page_alias = '';
	
	/**
	* Default HTML page title
	* 
	* @var string
	*/
	public $page_title = '';
	
	/**
	* Page index uri
	* 
	* @var string
	*/
	public $page_uri = '';
	
	// --------------------------------------------------------------------
	// Private properties
	// --------------------------------------------------------------------
	
	/**
	* Check access to urls
	* http://codeigniter.com/forums/viewthread/143969/
	* 
	* @var string
	*/
	protected $allowed_uris = array(
		'admin',
		'admin/home/login',
	);
	
	// --------------------------------------------------------------------
	// Public methods
	// --------------------------------------------------------------------
	
	/**
	* Class constructor
	*/
	public function __construct ()
	{
		parent::__construct();// Call parent constructor first
		
		// If this is an admin section request, store the attempted_uri
		if ( $this->uri->segment(1) == 'admin' )
		{
			// Store the attempted uri to access
			$this->load->library('session');
			$this->session->set_userdata('attempted_uri', REQUEST_URI);
		}
		
		// Check for allowed uri, including if rerouted to admin
		$rerouted_uri = trim('admin/' . implode('/', $this->uri->rsegment_array()), '/');
		if ( ! in_array($rerouted_uri, $this->allowed_uris) )
		{
			// Load the authentication library
			$this->load->library('application/auth');
			
			// If user IS NOT logged in, enforce logging in
			if (
				! $this->auth->valid(array(
					'user_type' => 'admin',
				))
			)
			{
				// Give end response if request type detected, e.g. AJAX
				$this->load->library('utility/request');
				$response = '<p>Your session is no longer valid. Please log in and try again.</p>';
				$this->request->response($response, 'html');
				
				// Redirect to the default controller:
				redirect();
				
			}
			
			// Restrict access
			// If user DOES NOT have sufficient rights to be an admin, kick them out
			if (
				! $this->auth->valid_level(array(
					'user_type' => 'admin',
					'compare_type' => '>=',
					'level' => 200,
				))
			)
			{
				/*
				header('HTTP/1.0 404 Not Found');
				exit;
				*/
				// Log them
				$this->auth->logout();
				redirect();
			}
		}
		
		// Load common files
		$this->load->library('utility/notify');
		$this->lang->load('admin', 'english');
		$this->site_title = $this->lang->line('admin__site_title');
		
		log_message('info', __CLASS__ . ' class initialized.');
	}
	
	// --------------------------------------------------------------------
	
	/**
	* Default method
	*/
	public function index()
	{
		// Get arguments
		$args = func_get_args();
		
		// Forward on processing
		return call_user_func_array(array(&$this, 'records'), $args);
	}
	
	// --------------------------------------------------------------------
	
	/**
	* Delete item
	* 
	* @param string|int|array $item_ids A list of item ids to delete
	*/
	public function delete( $item_id )
	{
		// CSRF check
		$this->load->library('utility/csrf');
		
		// Check access
		if ( method_exists($this, '_check_access') )
		{
			call_user_func_array(array(&$this, '_check_access'), $args);
		}
		
		// Delete and redirect
		$this->_delete($item_id);
		$this->_redirect($this->page_uri . '/records');
	}
	
	// --------------------------------------------------------------------
	
	/**
	* Handle delete submission
	* 
	* @param string|int|array $item_ids A list of item ids to delete
	* @return bool
	*/
	public function _delete( $item_ids )
	{
		$success = false;
		$num_affected = 0;
		
		// Turn string into array
		if ( ! is_array($item_ids) )
		{
			$item_ids = explode(',', $item_ids);
			$item_ids = array_map('trim', $item_ids);
		}
		
		$this->load->model($this->default_model);
		
		// Delete each item
		foreach ( $item_ids as $item_id )
		{
			$success = ( $item_id > 0 );
			
			if ( $success )
			{
				$params = array(
					'where' => array(
						$this->default_model_id_field => $item_id,
					),
				);
				$success = $this->{$this->default_model}->delete($params);
				
				// Clear relations
				
				if ( $success )
				{
					$num_affected++;
				}
			}
		}
		
		if ( $num_affected > 0 )
		{
			$this->notify->add('The ' . $this->item_noun . ' was deleted.', $success);
		}
		else
		{
			$this->notify->add('The ' . $this->item_noun . ' could not be deleted.', $success);
		}
		
		// Clear cache
		
		return $success;
	}
	
	// --------------------------------------------------------------------
	
	/**
	* Edit record
	*/
	public function edit()
	{
		// Get arguments
		$args = func_get_args();
		
		// Check for return_url
		$return_url = rawurldecode($this->input->get_post('return_url', true));
		if ( isset($return_url[0]) )
		{
			$this->session->set_userdata('admin__last_records_uri', $return_url);
		}
		
		// Forward on processing
		return call_user_func_array(array(&$this, 'add'), $args);
	}
	
	// --------------------------------------------------------------------
	
	/** 
	* Handle item update field value
	* 
	* @param array $allowed_fields The allowed fields
	* @param string $field The database field
	* @param int $item_id The item id
	* @param int|string $new_value The new value
	*/
	public function _update_value( $allowed_fields, $field, $item_id, $new_value = '' )
	{
		// CSRF check
		$this->load->library('utility/csrf');
		
		$return_value = array();
		$return_message = array();
		$success = false;
		
		// Check allowed fields
		if ( isset($allowed_fields[$field]) )
		{
			$field = ( $allowed_fields[$field] === '' ) ? $field : $allowed_fields[$field];
			
			// Update record
			$this->load->model($this->default_model);
			$params = array(
				'data' => array(
					$field => $new_value,
				),
				'where' => array(
					$this->default_model_id_field => $item_id,
				),
				'limit' => 1,
			);
			$query = $this->{$this->default_model}->update($params);
			$success = $query;
		}
		
		if ( ! $success )
		{
			$return_message[] = 'The ' . $this->item_noun . ' could not be updated. Please try again.';
		}
		else
		{
			$return_message[] = 'The ' . $this->item_noun . ' was updated.';
			$return_value['new_value'] = $new_value ? 0 : 1;
		}
		
		$return_data = array(
			'code' => $success, 
			'value' => $return_value,
			'message' => $return_message,
		);
		
		// ----------------------------------------
		// Give end response if request type detected, e.g. AJAX
		$this->load->library('utility/request');
		$this->request->response($return_data, 'json');
		// ----------------------------------------
		
		// Set notifications
		$this->notify->add($return_data);
		
		// Go back to the previous url
		$redirect = ! empty($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : site_url($this->page_uri);
		redirect($redirect);
	}
	
	// --------------------------------------------------------------------
	
	/** 
	* Handle redirect
	* 
	* @param string $redirect Optional redirect url
	*/
	public function _redirect( $redirect = '' )
	{
		// If there is a previous url, go to it
		$admin__last_records_uri = $this->session->userdata('admin__last_records_uri');
		if ( $admin__last_records_uri )
		{
			redirect($admin__last_records_uri);//redirect($_SERVER['HTTP_REFERER']);
		}
		else
		{
			redirect($redirect);
		}
	}
	
	// --------------------------------------------------------------------
	
	/**
	* Default method
	*/
	public function _process_querystring_data ( $additional_allowed_orders = array() )
	{
		$where_data = array();
		$order_data = array();
		
		// Querystring data
		$this->load->library('utility/display_filter');
		// Ordering
		$this->load->model($this->default_model);
		$table_fields = array_keys($this->{$this->default_model}->tables['default']['fields']);
		$allowed_qvar_orders = array_combine($table_fields, $table_fields);//querystring field => database field
		$allowed_qvar_orders['item_id'] = $this->default_model_id_field;
		if ( ! empty($additional_allowed_orders) )
		{
			$allowed_qvar_orders = array_merge($allowed_qvar_orders, $additional_allowed_orders);
		}
		$qstring['order'] = $this->display_filter->update_order_from_querystring('order', $allowed_qvar_orders, $order_data);
		
		// Everything but paging
		$qstring['exc_page'] = $this->display_filter->get_querystring_vars(array(
			'blacklist' => 'page',
			'build' => true,
			'final' => true,
		));
		$qstring['exc_page_search'] = $this->display_filter->get_querystring_vars(array(
			'blacklist' => 'page,q,date_range,date_range_start,date_range_stop',
			'build' => true,
			'final' => true,
		));
		$qstring['vars_exc_page_search'] = $this->display_filter->get_querystring_vars(array(
			'blacklist' => 'page,q,date_range,date_range_start,date_range_stop',
			'decode' => true,
		));
		
		// Get search keywords
		$qstring['q'] = $this->display_filter->get_querystring_var('q');
		$qstring['q'] = $qstring['q'] ? $qstring['q'] : null;
		
		// Get search date range
		$qstring['date_range'] = $this->display_filter->get_querystring_var('date_range');
		$qstring['date_range'] = $qstring['date_range'] ? $qstring['date_range'] : null;
		if ( isset($qstring['date_range'][0]) )
		{
			$qstring['date_range_start'] = $this->display_filter->get_querystring_var('date_range_start');
			$qstring['date_range_start'] = $qstring['date_range_start'] ? $qstring['date_range_start'] : null;
			$qstring['date_range_stop'] = $this->display_filter->get_querystring_var('date_range_stop');
			$qstring['date_range_stop'] = $qstring['date_range_stop'] ? $qstring['date_range_stop'] : null;
			
			if ( strlen($qstring['date_range_start']) <= 10 )
			{
				$qstring['date_range_start'] = $qstring['date_range_start'] . ' 00:00:00';
			}
			
			if ( strlen($qstring['date_range_stop']) <= 10 )
			{
				$qstring['date_range_stop'] = $qstring['date_range_stop'] . ' 23:59:59';
			}
		}
		
		// Set data for querystring ordering
		$qstring['used'] = ( $qstring['order'] || isset($qstring['q']) );
		$qstring['rev_orders'] = $this->display_filter->get_querystring_reverse_orders('order', $allowed_qvar_orders, $order_data);
		
		// If filter passed
		$filters_applied = array();
		foreach ( $this->filters as $filter_key => $filter )
		{
			$value = $this->data ? $this->data[$filter_key] : null;
			if ( $value !== null )
			{
				$database_field = isset($filter['database_field']) ? $filter['database_field'] : $filter_key;
				$title_prefix = isset($filter['title_prefix']) ? $filter['title_prefix'] : '';
				$where_data[$database_field] = $value;
				
				$filters_applied[$filter_key] = array_merge($filter, array(
					'title' => $title_prefix . ucwords($value),
					'value' => $value,
				));
			}
		}
		
		// Check for querystring data to use
		if ( isset($qstring['q']) )
		{
			$where_data['*'] = $qstring['q'];
		}
		
		if ( ! empty($qstring['date_range']) )
		{
			$where_data['date_field_between'] = implode(',', array(
				$qstring['date_range'],
				$qstring['date_range_start'],
				$qstring['date_range_stop'],
			));
		}
		
		return array(
			'allowed_qvar_orders' => $allowed_qvar_orders,
			'qstring' => $qstring,
			'filters_applied' => $filters_applied,
			'where_data' => $where_data,
			'order_data' => $order_data,
		);
	}
	
	// --------------------------------------------------------------------
	
}

// --------------------------------------------------------------------

