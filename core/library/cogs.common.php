<?php
/**
 * Recursive find file
 */
function find_file($directory, $wanted)
{
	if ( ! is_dir($directory))
	{
		return false;
	}
	else
	{
		$handle = dir($directory);
		while (false !== ($content = $handle->read()))
		{
			$path = $directory . '/' . $content;
			
			if (is_dir($path) && $content != '.' && $content != '..')
			{
				$found = find_file($path, $wanted);
			}
			elseif ($content == $wanted)
			{
				return $path;
			}
			
			if (isset($found) && $found !== false)
			{
				break;
			}
		}
		$handle->close();
	}
	
	if (isset($found) && $found !== false)
	{
		return $found;
	}
	
	return false;
}

/**
 * Recursive include
 */
function include_directory($directory, $type=null)
{
	if ( ! is_dir($directory))
	{
		return false;
	}
	else
	{
		$handle = opendir($directory);
		$directories = array();
		
		/**
		 * Include top level files before descending into directory tree
		 */
		while (false !== ($file = readdir($handle)))
		{
			$path = $directory . '/' . $file;
			
			/**
			 * Hide dotted directory navigation and system files with a leading
			 * period
			 */
			if ($file != '.' && $file != '..' && $file[0] != '.')
			{
				$path_info = pathinfo($path);
				
				if (is_file($path) && $path_info['extension'] == 'php')
				{
					if ( ! empty($type) && stristr($path, $type) !== false)
					{
						include_once $path;
					}
					elseif (empty($type) && stristr($path, 'view') === false)
					{
						include_once $path;
					}
				}
				elseif (is_dir($path) && $path_info['filename'][0] != '_')
				{
					$directories[] = $path;
				}
				
			}
			
		}
		
		foreach ($directories as $path)
		{
			include_directory($path, $type);
		}
		
		closedir($handle);
	}
	
	return true;
}

/* End cogs.common.php */