<?php
// Require common functionality
if ( ! defined('ENVIRONMENT') )
{
	require_once('_includes/common.php');
}

// Check access key
check_access();

$process_data = process();

