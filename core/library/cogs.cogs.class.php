<?php
class Cogs
{
	
	/**
	 * Database handler reference
	 */
	public static $db;
	
	/**
	 * Catalogs of loaded models, controllers, view, and master template
	 */
	public static $models = array();
	public static $controllers = array();
	public static $view;
	public static $master;

	/**
	 * Construct the object
	 */
	public function __construct() {}	
	
	/**
	 * Connect database reference to global database object
	 */
	public function init_db(&$db)
	{
		self::$db = $db;
	}
	
	/**
	 * Build an instance of the desired model, add to loaded model catalog, and
	 * give it a reference to the database object
	 */
	public function model($model)
	{
		self::$models[] = $model;
		$object = new $model();

		if ( ! empty(self::$db))
		{
			$object->set_db(self::$db);
		}
		
		return $object;
	}

	/**
	 * Build an instance of the desired controller, add to loaded controller
	 * catalog
	 */
	public function controller($controller)
	{
		self::$controllers[] = $controller;
		$object = new $controller();	
		return $object;
	}
	
	/**
	 * Set desired view or views for injection into master
	 */
	public function view($views)
	{
		if ( ! is_array($views))
		{
			$views = array($views);
		}
		
		foreach ($views as $key => $name)
		{
			$file = $name . '.php';

			if (false !== ($path = find_file(VIEWS_DIR, $file)))
			{
				self::$view[$key] = $path;
			}
			elseif (false !== ($path = find_file(PLUGINS_DIR, $file)))
			{
				self::$view[$key] = $path;
			}
			elseif (DEBUG_MODE)
			{
				debug_vars('Unable to find view: ' . $file);
			}
		}

		if (count(self::$view) == 1)
		{
			self::$view = self::$view[$key];
		}

		return true;
	}

	/**
	 * Set desired master to accept individual views
	 */	
	public function master($master)
	{
		$master .= '.php';

		if (false !== ($path = find_file(VIEWS_DIR, $master)))
		{
			self::$master = $path;
		}
		elseif (false !== ($path = find_file(PLUGINS_DIR, $master)))
		{
			self::$master = $path;
		}
		elseif (DEBUG_MODE)
		{
			debug_vars('Unable to find master: ' . $master);
		}

		return true;
	}
	
	/**
	 * Render full page by injecting view into master, and create variables
	 * for views to use
	 */
	public function render($vars = null)
	{
		if ( ! empty($vars))
		{
			foreach ($vars as $key => $value)
			{
				$$key = $value;
			}
		}
		
		include self::$master;
		return true;
	}
	
}

/* End of Cogs class */