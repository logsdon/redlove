<?php
$config['environment']['is_development'] = (
	in_array(
		$_SERVER['HTTP_HOST'],
		array(
			'127.0.0.1',
			'127.0.0.1:80',
			'127.0.0.1:443',
			'localhost',
			'192.168.2.170',
			'75.187.126.199',
			'10.181.247.145',
			'65.31.24.109',
		)
	)
);
var_dump($_SERVER['HTTP_HOST']);
$config['environment']['is_testing'] = (
	! $config['environment']['is_development'] &&
	(
		strpos($_SERVER['REQUEST_URI'], '/42connect/') === 0 ||
		strpos($_SERVER['REQUEST_URI'], '/alpha/') === 0 ||
		strpos($_SERVER['SERVER_NAME'], 'alpha.') === 0 ||
		strpos($_SERVER['REQUEST_URI'], '/beta/') === 0 ||
		strpos($_SERVER['SERVER_NAME'], 'beta.') === 0 ||
		strpos($_SERVER['SERVER_NAME'], '42cdev.com') !== false  ||
		strpos($_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'], 'joshualogsdon.com/client') !== false
	)
);

$config['environment']['is_production'] = (
	! $config['environment']['is_development'] &&
	! $config['environment']['is_testing']
);

if ( $config['environment']['is_development'] )
{
	$config['environment']['redlove']['num_dirs_from_root_path'] = 3;
}
elseif ( $config['environment']['is_testing'] )
{
	$config['environment']['redlove']['num_dirs_from_root_path'] = 2;
}
else
{
	$config['environment']['redlove']['num_dirs_from_root_path'] = 0;
}
