<?php

/*

$p__menu = array();
$p__menu['menu'] = array(
	
	array (
		'uri' => 'visitors',
		'title' => 'Visitors Center',
		'attributes' => '',
		'uris' => array(),
		'submenu' => array(
			
			array (
				'uri' => 'visitors/what-to-expect',
				'title' => 'What to Expect',
				'attributes' => '',
				'uris' => array(),
				'submenu' => array(),
			),
			
		),
	),
	
);

$p__menu['menu_ref'] = array();
create_menu_ref( $p__menu['menu_ref'], $p__menu['menu'] );
	
*/

if ( ! function_exists('create_menu_ref') )
{
	function create_menu_ref( & $menu_arr_ref, & $menu_arr )
	{
		// For each menu item on this layer
		for ( $i = 0; $i < count($menu_arr); $i++ )
		{
			// Create ref from uri
			$menu_arr_ref[ trim($menu_arr[$i]['uri'], '/') ] =& $menu_arr[$i];
			
			// If a further level from this layer
			if ( is_array($menu_arr[$i]['submenu']) && count($menu_arr[$i]['submenu']) > 0 )
			{
				// Create parent ref on next layer submenu items
				for ( $submenu_i = 0; $submenu_i < count($menu_arr[$i]['submenu']); $submenu_i++ )
				{
					$menu_arr[$i]['submenu'][$submenu_i]['parent'] =& $menu_arr[$i];
				}
				
				// Create refs for next level
				create_menu_ref( $menu_arr_ref, $menu_arr[$i]['submenu'] );
			}
		}
	}
}

// --------------------------------------------------------------------

if ( ! function_exists('show_breadcrumb') )
{
	function show_breadcrumb( $separator = ' > ', $attributes = '', $start_crumb = '', $start_crumb_uri = '' )
	{
		global $p__menu;
		
		$bcs = array();
		
		if ( $start_crumb )
		{
			$bcs[] = '<a href="' . site_url($start_crumb_uri) . '"' . $attributes . '>' . $start_crumb . '</a>';
		}
		
		if ( isset($p__menu['menu_ref'][PAGE]) )
		{
			$tmp =& $p__menu['menu_ref'][PAGE]['parent'];
			$tmp_bc = '';
			while ( is_array($tmp) )
			{
				array_unshift($bcs, '<a href="' . site_url($tmp['uri']) . '"' . $attributes . '>' . $tmp['title'] . '</a>');
				$tmp =& $tmp['parent'];
			}
			
			$bcs[] = '<a href="' . site_url($p__menu['menu_ref'][PAGE]['uri']) . '"' . $attributes . '>' . $p__menu['menu_ref'][PAGE]['title'] . '</a>';
		}
		
		$bc = '<div class="breadcrumbs">' . implode($separator, $bcs) . '</div>';
		return $bc;
	}
}

/*
output_breadcrumbs(PAGE, $p__menu['menu']);

function output_breadcrumbs($uri, $menu)
{
	$trail = find_breadcrumb($uri, $menu);
	$num_crumbs = count($trail);
	$index = 0;
	if ( isset($trail) && $num_crumbs > 0 )
	{
		foreach ( $trail as $crumb )
		{
		?>
		<a href="<?php echo site_url($crumb['uri']); ?>"><?php echo $crumb['title']; ?></a>
		<?php
			$index++;
			if ( $index != $num_crumbs )
			{
			?>
			<span>&gt;</span>
			<?php
			}//end if last crumb
		}//end foreach crumb
	}//end if trail
}

function find_breadcrumb( $uri, $menu, $level = 0, & $trail = array(), & $found = FALSE )
{
	if ( isset($menu) && count($menu) > 0 )
	{
		foreach ( $menu as $item )
		{
			if ( ! $found )
			{
				// Clear out current level and above
				array_splice($trail, $level);
				// Replace current level
				$trail[$level] = array(
					'uri' => $item['uri'],
					'title' => $item['title'],
				);
				
				// If this item is the current one, we can stop
				if ( $uri == $item['uri']  )
				{
					$found = TRUE;
					break;
				}//end if found
				
				// If there are subitems, go deeper
				if ( isset($item['submenu']) && count($item['submenu']) > 0 )
				{
					call_user_func(__FUNCTION__, $uri, $item['submenu'], $level + 1, & $trail, & $found);
				}//end if recursive
				
			}//end if not found
		}//end for each menu item
	}//end if menu
	
	return $trail;
}
*/
// --------------------------------------------------------------------

if ( ! function_exists('output_menu') )
{
function output_menu( & $params, $cur_level = 0 )
{
	// Set default values for missing keys
	$default_params = array(
		'menu' => '',//array(),
		'start_level' => 0,
		'max_level' => 3,
		'level_indicator' => '',
		'only_expand' => '',//array(),
		'opening_tags' => true,
		'only_expand_nested' => false,
		'blacklist' => '',//array(),
	);
	$params = array_merge($default_params, $params);
	
	//extract($params);
	
	if ( $cur_level > $params['max_level'] )
	{
		return;
	}
	
	// If only show certain uris
	if ( $params['blacklist'] && ! is_array($params['blacklist']) )
	{
		$params['blacklist'] = array_map('trim', explode(',', $params['blacklist']));
	}
	// If only expanding certain uris
	if ( $params['only_expand'] && ! is_array($params['only_expand']) )
	{
		$params['only_expand'] = array_map('trim', explode(',', $params['only_expand']));
	}
	
	if ( isset($params['menu']['uri']) )
	{
		$params['menu'] =array($params['menu']);
	}
	
	$menu =& $params['menu'];
	$num_menu = count($menu);
?>
	
	<ul>
	
	<?php
	foreach ( $menu as $menu_item )
	{
		$uri = $menu_item['uri'];
		$url = site_url($uri);
		$class = ( page_is($uri) ? 'active ' : '' );
		$prepend = ( page_is($uri, TRUE) ) ? '<span style="font: inherit; font-size: 14px; line-height: 0; display: inline; color: inherit;">&rsaquo;</span> ' : '';
		$level_indicator = str_repeat($params['level_indicator'], $cur_level);
		
		// If only show certain uris
		if ( $params['blacklist'] && in_array($uri, $params['blacklist']) )
		{
			continue;
		}
	?>
	
		<li class="<?php echo $class; ?>">
			<a href="<?php echo $url; ?>" class="<?php echo $class; ?>"><?php echo $level_indicator . $menu_item['title']; ?></a>
			
			<?php
			if ( is_array($menu_item['submenu']) && count($menu_item['submenu']) > 0 )
			{
				// If only expanding certain uris
				if ( $params['only_expand'] && ! in_array($uri, $params['only_expand']) )
				{
					continue;
				}
				// Only expand nested pages
				elseif ( $params['only_expand_nested'] && strpos(PAGE, $uri) !== 0 )
				{
					continue;
				}
				
				$params['menu'] =& $menu_item['submenu'];
				call_user_func(__FUNCTION__, $params, $cur_level + 1);
			}
			?>
			
		</li>
	
	<?php
	}
	unset($menu_item);
	?>
	
	</ul>

<?php
}
}

/*
function output_menu2( $menu, $level = 0 )
{
	if ( isset($menu) && count($menu) > 0 )
	{
	?>
	<ul>
		<?php
		foreach ( $menu as $item )
		{
		?>
			<li>
				<?php
				$level_indicator = str_repeat('&middot;', $level);
				$level_indicator = ( $level_indicator ? $level_indicator . ' ' : $level_indicator );
				echo $level_indicator;
				?>
				<a href="<?php echo site_url($item['uri']); ?>"><?php echo $item['title']; ?></a>
				<?php
				if ( isset($item['submenu']) && count($item['submenu']) > 0 )
				{
					call_user_func(__FUNCTION__, $item['submenu'], $level + 1);
				}
				?>
			</li>
		<?php
		}
		?>
	</ul>
	<?php
	}//end if submenu
}
*/

// --------------------------------------------------------------------

if ( ! function_exists('create_page_title') )
{
	function create_page_title( & $menu_ref, $uri, $addition = '' )
	{
		$title = '';
		
		if ( isset($menu_ref[$uri]) )
		{
			$title = $menu_ref[$uri]['title'];
		}
		
		return $title . $addition;
	}
}

// --------------------------------------------------------------------

if ( ! function_exists('create_page_description') )
{
	function create_page_description( & $menu_ref, $uri, $description = '' )
	{
		if ( isset($menu_ref[$uri]) && isset($menu_ref[$uri]['description']) )
		{
			$description = $menu_ref[$uri]['description'];
		}
		
		return $description;
	}
}

// --------------------------------------------------------------------

if ( ! function_exists('create_page_keywords') )
{
	function create_page_keywords( & $menu_ref, $uri, $keywords = '' )
	{
		if ( isset($menu_ref[$uri]) && isset($menu_ref[$uri]['keywords']) )
		{
			$keywords = $menu_ref[$uri]['keywords'];
		}
		
		return $keywords;
	}
}

// --------------------------------------------------------------------
