<?php
/*
http://www.sitepoint.com/list-files-and-directories-with-php/
http://stackoverflow.com/questions/24783862/list-all-the-files-and-folders-in-a-directory-with-php-recursive-function
*/
$realpath = realpath(dirname(__FILE__));
?>

<h1>glob()</h1>

<?php
$glob_files = glob_files($realpath, '*');

echo '<pre>';
print_r($glob_files);
echo '</pre>';

/** 
* Gather files with glob()
* 
* http://php.net/glob
* 
* @param string $path
* @param string $pattern
* @param mixed $flags Flags like GLOB_ONLYDIR and GLOB_BRACE
* @return array
*/
function glob_files ( $path, $pattern = '', $flags = GLOB_BRACE )
{
	// Swap directory separators to Unix style for consistency
	$path = str_replace('\\', '/', $path);
	// Make sure the path has a trailing slash
	$path = rtrim($path, '/') . '/';
	
	$files = (array)glob($path . $pattern, GLOB_BRACE);//'*.{jpg,jpeg,png,gif,JPG,JPEG,PNG,GIF}'
	//sort($files, SORT_REGULAR);
	return $files;
}
?>

<h1>opendir(), readdir() and closedir()</h1>

<?php
$readdir_files = readdir_files($realpath, false);

echo '<pre>';
print_r($readdir_files);
echo '</pre>';

/** 
* Gather files with opendir(), readdir() and closedir()
* 
* http://php.net/glob
* 
* @param string $path
* @param string $pattern
* @param mixed $flags Flags like GLOB_ONLYDIR and GLOB_BRACE
* @return array
*/
function readdir_files ( $path, $recursive = true )
{
	if ( ! is_dir($path) )
	{
		return false;
	}
	
	// Swap directory separators to Unix style for consistency
	$path = str_replace('\\', '/', $path);
	// Make sure the path has a trailing slash
	$path = rtrim($path, '/') . '/';
	
	$data = array(
		'directories' => array(),
		'files' => array(),
	);
	
	if ( $handle = opendir($path) )
	{
		while ( false !== ($entry = readdir($handle)) )
		{
			if ( $entry == '.' || $entry == '..' || is_link($entry) )
			{
				continue;
			}
			
			$file_path = $path . $entry;
			
			if ( is_dir($file_path) )
			{
				$data['directories'][] = $file_path;
				
				if ( $recursive )
				{
					$new_data = readdir_files($file_path);
					$data['directories'] = array_merge($data['directories'], $new_data['directories']);
					$data['files'] = array_merge($data['files'], $new_data['files']);
				}
			}
			elseif ( is_file($file_path) )
			{
				$data['files'][] = $file_path;
			}
		}
		
		closedir($handle);
	}
	
	return $data;
}
?>

<h1>scandir()</h1>

<?php
$scandir_files = scandir_files($realpath, false);

echo '<pre>';
print_r($scandir_files);
echo '</pre>';

/** 
* Gather files with opendir(), readdir() and closedir()
* 
* http://php.net/glob
* 
* @param string $path
* @param string $pattern
* @param mixed $flags Flags like GLOB_ONLYDIR and GLOB_BRACE
* @return array
*/
function scandir_files ( $path, $recursive = true )
{
	if ( ! is_dir($path) )
	{
		return false;
	}
	
	// Swap directory separators to Unix style for consistency
	$path = str_replace('\\', '/', $path);
	// Make sure the path has a trailing slash
	$path = rtrim($path, '/') . '/';
	
	$data = array(
		'directories' => array(),
		'files' => array(),
	);
	
	if ( $entries = scandir($path) )
	{
		foreach ( $entries as $entry )
		{
			if ( $entry == '.' || $entry == '..' || is_link($entry) )
			{
				continue;
			}
			
			$file_path = $path . $entry;
			
			if ( is_dir($file_path) )
			{
				$data['directories'][] = $file_path;
				
				if ( $recursive )
				{
					$new_data = scandir_files($file_path);
					$data['directories'] = array_merge($data['directories'], $new_data['directories']);
					$data['files'] = array_merge($data['files'], $new_data['files']);
				}
			}
			elseif ( is_file($file_path) )
			{
				$data['files'][] = $file_path;
			}
		}
	}
	
	return $data;
}
?>

<h1>SPL Iterators</h1>

<h2>FilesystemIterator</h2>
<?php
$iterator = new FilesystemIterator($realpath);
$data = array(
	'directories' => array(),
	'files' => array(),
);
foreach ( $iterator as $entry )
{
	if ( $entry->isDir() )
	{
		$data['directories'][] = $entry->getFilename();
	}
	elseif ( $entry->isFile() )
	{
		$data['files'][] = $entry->getFilename();
	}
}
echo '<pre>';
print_r($data);
echo '</pre>';
?>

<h2>RegexIterator</h2>
<?php
$iterator = new FilesystemIterator($realpath);
$filter = new RegexIterator($iterator, '/.(t|dat)$/');
$data = array(
	'directories' => array(),
	'files' => array(),
);
foreach ( $filter as $entry )
{
	if ( $entry->isDir() )
	{
		$data['directories'][] = $entry->getFilename();
	}
	elseif ( $entry->isFile() )
	{
		$data['files'][] = $entry->getFilename();
	}
}
echo '<pre>';
print_r($data);
echo '</pre>';
?>

<h2>RecursiveDirectoryIterator</h2>
<?php
// Setting FilesystemIterator will include depth in file spl info
$directory = new RecursiveDirectoryIterator($realpath, RecursiveDirectoryIterator::SKIP_DOTS | FilesystemIterator::KEY_AS_PATHNAME | FilesystemIterator::CURRENT_AS_SELF);
$iterator = new RecursiveIteratorIterator($directory, RecursiveIteratorIterator::SELF_FIRST);
$iterator->setMaxDepth(1);
$data = array(
	'directories' => array(),
	'files' => array(),
);
foreach ( $iterator as $file_pathname => $spl_file_info )
{
	// Normalize directory path
	$file_pathname = str_ireplace('\\', '/', $file_pathname);
	
	if ( $spl_file_info->isDir() )
	{
		$data['directories'][] = $file_pathname;
	}
	elseif ( $spl_file_info->isFile() )
	{
		$data['files'][] = $file_pathname;
	}
}
echo '<pre>';
print_r($data);
echo '</pre>';

/*
$iterator_files = iterator_recursive($realpath);

echo '<pre>';
print_r($iterator_files);
echo '</pre>';
*/

/**
* Recurse directory contents
* 
* @version 0.0.0
* @param mixed $params An array of parameters or list of arguments
*/
function iterator_recursive ( $params = '' )
{
	// Set default values for missing keys
	$default_params = array(
		'path' => '',
		'path_root' => '',
		'blacklist_files' => '',
		'blacklist_file_extensions' => '',
		'blacklist_directories' => '',
		'datetime_format' => 'Y-m-d H:i:s',
		'max_depth' => -1,
		'directories_only' => false,
		'files_only' => false,
	);
	
	// Get arguments
	$args = func_get_args();
	$num_args = count($args);
	//$args0 = isset($args[0]) ? $args[0] : null;
	// Check for alternate argument patterns
	if ( is_string($params) )
	{
		// Correspond each passed argument with the order of the default parameters
		$params = array();
		$default_param_keys = array_keys($default_params);
		for ( $arg_i = 0; $arg_i < $num_args; $arg_i++ )
		{
			// Stop if there are no more corresponding default parameters
			if ( ! isset($default_param_keys[ $arg_i ]) )
			{
				break;
			}
			
			$params[ $default_param_keys[$arg_i] ] = $args[ $arg_i ];
		}
	}
	
	// Merge default and passed parameters
	$params = array_merge($default_params, $params);
	extract($params);
	
	// Stop if the path does not exist
	if ( ! is_dir($path) )
	{
		return false;
	}
	
	// Normalize arguments
	if ( ! is_array($blacklist_files) )
	{
		$blacklist_files = explode(',', $blacklist_files);
		$blacklist_files = array_filter($blacklist_files);
	}
	
	if ( ! is_array($blacklist_file_extensions) )
	{
		$blacklist_file_extensions = explode(',', $blacklist_file_extensions);
		$blacklist_file_extensions = array_filter($blacklist_file_extensions);
	}
	
	if ( ! is_array($blacklist_directories) )
	{
		$blacklist_directories = explode(',', $blacklist_directories);
		$blacklist_directories = array_filter($blacklist_directories);
	}
	
	// Initialize directory data
	$data = array(
		'files' => array(),
		'directories' => array(),
	);
	
	// If no path root is set, use the path
	if ( strlen($path_root) == 0 )
	{
		$path_root = $path;
	}
	
	// Setting FilesystemIterator will include depth in file spl info
	$directory = new RecursiveDirectoryIterator($path, RecursiveDirectoryIterator::SKIP_DOTS | FilesystemIterator::KEY_AS_PATHNAME | FilesystemIterator::CURRENT_AS_SELF);
	$iterator = new RecursiveIteratorIterator($directory, RecursiveIteratorIterator::SELF_FIRST);
	$iterator->setMaxDepth($max_depth);
	
	foreach ( $iterator as $file_pathname => $spl_file_info )
	{
		// Skip if file is a link
		if ( $spl_file_info->isLink() )
		{
			continue;
		}
		
		// Normalize directory path
		$file_pathname = str_ireplace('\\', '/', $file_pathname);//$spl_file_info->getPathName()
		// Normalize directory path
		$file_path = rtrim( str_ireplace('\\', '/', $spl_file_info->getPath()), '/' ) . '/';
		$file_path_basename = basename($file_path);//$pathinfo = pathinfo($path);
		$file_path_from_root = str_ireplace($path_root, '', $file_path);
		
		$filename = $spl_file_info->getFileName();
		$depth = $iterator->getDepth();
		$permissions = substr(sprintf('%o', $spl_file_info->getPerms()), -4);
		$created_time = $spl_file_info->getCTime();
		$created_datetime = date($datetime_format, $created_time);
		$modified_time = $spl_file_info->getMTime();
		$modified_datetime = date($datetime_format, $created_time);
		
		$data_piece = array(
			'pathname' => $file_pathname,
			'relative_absolute_pathname' => str_ireplace($path, $path_root, $file_pathname),
			'path' => $file_path,
			'relative_absolute_path' => str_ireplace($path, $path_root, $file_path),
			'path_basename' => $file_path_basename,
			'path_from_root' => $file_path_from_root,
			'filename' => $filename,
			'depth' => $depth,
			'depth_filename' => str_repeat(' - ', $depth) . $filename,
			'permissions' => $permissions,
			'created_time' => $created_time,
			'created_datetime' => $created_datetime,
			'modified_time' => $modified_time,
			'modified_datetime' => $modified_datetime,
		);
		
		// If directory
		if ( $spl_file_info->isDir() )
		{
			// Skip if only gathering files
			if ( $files_only )
			{
				continue;
			}
			
			// Skip if blacklisted
			if ( in_array($filename, $blacklist_directories) )
			{
				continue;
			}
			
			$data_piece['path'] .= $filename;
			$data_piece['relative_absolute_path'] .= $filename;
			$data_piece['path_basename'] = $filename;
			$data_piece['path_from_root'] .= $filename;
			$data['directories'][ $file_pathname ] = $data_piece;
		}
		// If file
		else
		{
			// Skip if only gathering directories
			if ( $directories_only )
			{
				continue;
			}
			
			// Skip if blacklisted
			if ( in_array($file_path_basename, $blacklist_directories) )
			{
				continue;
			}
			
			// Skip if blacklisted
			if ( in_array($filename, $blacklist_files) )
			{
				continue;
			}
			
			$file_extension = $spl_file_info->getExtension();
			
			// Skip if blacklisted
			if ( in_array($file_extension, $blacklist_file_extensions) )
			{
				continue;
			}
			
			// Calculate file size from bytes
			$file_size = $spl_file_info->getSize();
			$file_size = bytes_to_string($file_size);
			
			$data_piece['size'] = $file_size;
			$data_piece['extension'] = $file_extension;
			
			$dimensions = @getimagesize($file_pathname);
			if ( $dimensions )
			{
				$data_piece['width'] = $dimensions['0'];
				$data_piece['height'] = $dimensions['1'];
				$data_piece['size_str'] = $dimensions['3'];
				$data_piece['image_type'] = $dimensions['2'];
			}
			
			$data['files'][ $file_pathname ] = $data_piece;
		}
	}
	
	return $data;
}

/**
* Present a size (in bytes) as a human-readable value
* 
* @param int $size Size (in bytes)
* @param int $precision The number of digits after the decimal point
* @return string
*/
function bytes_to_string ( $size, $precision = 2 )
{
	$sizes = array('B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
	$num_sizes = count($sizes);
	
	for ( $size_i = 0; $size > 1000; $size_i++ )
	{
		$size /= 1024;
	}
	
	return number_format($size, $precision, '.', ',') . ( isset($sizes[$size_i]) ? ' ' . $sizes[$size_i] : '' );
}

