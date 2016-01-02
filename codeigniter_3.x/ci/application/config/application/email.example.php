<?php
$config['email'] = array(
	'log' => false,
	
	'smtp_debug' => 0,
	'smtp_auth' => false,
	'smtp_secure' => null,
	'smtp_host' => null,
	'smtp_port' => null,
	'smtp_username' => null,
	'smtp_password' => null,
	
	'test' => false,
);

if ( ENVIRONMENT == 'development' )
{
	$config['email']['test'] = true;
}
elseif ( ENVIRONMENT == 'testing' )
{
	$config['email']['smtp_auth'] = true;
	$config['email']['smtp_host'] = 'smtp.example.com';
	$config['email']['smtp_port'] = 0;
	$config['email']['smtp_username'] = '';
	$config['email']['smtp_password'] = '';
}
elseif ( ENVIRONMENT == 'production' )
{
	$config['email']['smtp_auth'] = true;
	$config['email']['smtp_host'] = 'smtp.example.com';
	$config['email']['smtp_port'] = 0;
	$config['email']['smtp_username'] = '';
	$config['email']['smtp_password'] = '';
}

