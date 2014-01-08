<?php
class Cogs_Router
{
	/**
	 * Construct the object
	 */
	public function __construct() {}
	
	/**
	 * Parse requests from URI and provide an ordered list to find controllers
	 * Last request first: e.g. /3/2/1/ checks for 1 first
	 * Upon finding a controller, instantiate it
	 * If none are found, instantiate default controller
	 */
	public function find_controller()
	{
		$requests = Cogs_URI::uri_requested_controllers();
		
		if ( ! empty($requests) && is_array($requests))
		{
			$requests = array_reverse($requests);
		}

		if (empty($requests))
		{
			return Cogs::controller(ROOT_CONTROLLER);
		}
		else
		{
			foreach ($requests as $request)
			{
				if (class_exists($request))
				{
					return Cogs::controller($request);
				}
			}
		}
		
		return Cogs::controller(DEFAULT_CONTROLLER);
	}
}

/* End of Cogs_Router class */