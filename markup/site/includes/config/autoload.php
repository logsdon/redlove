<?php
$config['autoload'] = array(
	'config' => array(
		'path' => INCLUDESPATH . 'config/',
		// The environment config file is loaded before autoload
		'filenames' => 'site',
	),
	'data' => array(
		'path' => INCLUDESPATH . 'data/',
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
		'path' => INCLUDESPATH . 'php/functions/',
		'filenames' => 'site',
	),
);

