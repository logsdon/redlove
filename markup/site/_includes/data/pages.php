<?php
/**
*

PAGES
This is one option for tracking pages and structure on the site.
For ease of use and readability, page URIs can get maintained here.
Then the variables can be used in navigation, breadcrumbs, and other areas.

*/

// Example 1
$p__home = '';
$p__featured = 'featured';
$p__news = 'news';
$p__about = 'about';

// Example 2
$p__site = array(
	$p__home = '',
	$p__featured = 'featured',
	$p__news = 'news',
	$p__about = 'about',
);

// Example 3
$p__menu = array();
$p__menu['menu'] = array(

	array (
		'uri' => '',
		'title' => 'Home',
		'attributes' => '',
		'uris' => array('index'),
		'submenu' => array(
		
			array (
				'uri' => 'blog',
				'title' => 'Blog',
				'attributes' => '',
				'uris' => array(),
				'submenu' => array(
					
					array (
						'uri' => 'blog/category-1',
						'title' => 'Category 1',
						'attributes' => '',
						'uris' => array(),
						'submenu' => array(),
					),
					
					array (
						'uri' => 'blog/category-2',
						'title' => 'Category 2',
						'attributes' => '',
						'uris' => array(),
						'submenu' => array(),
					),
					
					array (
						'uri' => 'blog/category-3',
						'title' => 'Category 3',
						'attributes' => '',
						'uris' => array(),
						'submenu' => array(),
					),
					
				),
			),
			
			array (
				'uri' => 'about',
				'title' => 'About',
				'attributes' => '',
				'uris' => array(),
				'submenu' => array(
					
					array (
						'uri' => 'about/our-story',
						'title' => 'Our Story',
						'attributes' => '',
						'uris' => array(),
						'submenu' => array(),
					),
					
					array (
						'uri' => 'about/contact-us',
						'title' => 'Contact Us',
						'attributes' => '',
						'uris' => array(),
						'submenu' => array(),
					),
					
				),
			),
			
			array (
				'uri' => 'search',
				'title' => 'Search',
				'attributes' => '',
				'uris' => array(''),
				'submenu' => array(),
			),
			
			array (
				'uri' => 'sitemap',
				'title' => 'Sitemap',
				'attributes' => '',
				'uris' => array(''),
				'submenu' => array(),
			),
			
		),
		
	),
	
	array (
		'uri' => '404',
		'title' => '404 Error',
		'attributes' => '',
		'uris' => array(''),
		'submenu' => array(),
	),
	
);

$p__menu['menu_ref'] = array();
create_menu_ref($p__menu['menu_ref'], $p__menu['menu']);

