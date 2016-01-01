<?php
$config['autoload'] = array(
	'config' => array(
		'path' => INCLUDESPATH . 'config/',
		'filenames' => 'site',
	),
	'data' => array(
		'path' => INCLUDESPATH . 'data/',
		'filenames' => '',
	),
	'external_classes' => array(
		'path' => ROOTPATH . '../../php/classes/',
		'filenames' => '',
	),
	'external_functions' => array(
		'path' => ROOTPATH . '../../php/functions/',
		'filenames' => 'file,form,request,url',
	),
	'functions' => array(
		'path' => INCLUDESPATH . 'php/functions/',
		'filenames' => 'site',
	),
);

