<?php
$config['environment']['is_development'] = (
	in_array(
		$_SERVER['HTTP_HOST'], 
		array(
			'127.0.0.1',
			'localhost',
			// Other local IPs
		)
	)
);

$config['environment']['is_testing'] = (
	! $config['environment']['is_development'] && 
	(
		strpos($_SERVER['REQUEST_URI'], '/alpha/') === 0 || 
		strpos($_SERVER['SERVER_NAME'], 'alpha.') === 0 || 
		strpos($_SERVER['REQUEST_URI'], '/beta/') === 0 || 
		strpos($_SERVER['SERVER_NAME'], 'beta.') === 0 || 
		strpos($_SERVER['SERVER_NAME'], 'example.com') !== false  || 
		strpos($_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'], 'example.com/test') !== false 
	)
);

$config['environment']['is_production'] = (
	! $config['environment']['is_development'] && 
	! $config['environment']['is_testing']
);

