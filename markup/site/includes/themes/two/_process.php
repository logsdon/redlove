<?php
// Require common functionality
if ( ! defined('ENVIRONMENT') )
{
	require_once(str_repeat('../', 3) . 'includes/common.php');
}

// Check access key
//check_access();

$process_data = process();

