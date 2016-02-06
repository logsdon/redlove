<?php
$config['autoload'] = array(
	'config' => array(
		'path' => INCLUDES_PATH . 'config/',
		// The environment config file is loaded before autoload
		'filenames' => 'site',
	),
	'data' => array(
		'path' => INCLUDES_PATH . 'data/',
		'filenames' => '',
	),
	'external_classes' => array(
		'path' => REDLOVE_PATH . 'php/classes/',
		'filenames' => '',
	),
	'external_functions' => array(
		'path' => REDLOVE_PATH . 'php/functions/',
		'filenames' => 'file,form,request,url',
	),
	'functions' => array(
		'path' => INCLUDES_PATH . 'php/functions/',
		'filenames' => 'site',
	),
);

