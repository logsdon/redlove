<?php
$config['session'] = array(
	'use' => true,
);

// Start the native PHP session
if ( $config['session']['use'] && ! function_exists('get_instance') && ! session_id() )
{
	session_start();
}

