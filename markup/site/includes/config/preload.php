<?php
$config['preload'] = array(
	'base_config' => array(
		'path' => INCLUDES_PATH . 'config/',
		// The environment config file is loaded before autoload
		'filenames' => 'environment,session,site',
	),
);

