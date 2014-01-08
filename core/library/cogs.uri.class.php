<?php
class Cogs_URI
{
	/**
	 * Raw URI, unparsed
	 */
	public static $raw_uri = null;

	/**
	 * URI catalog of requests
	 */
	public static $requests = array();
	
	/**
	 * Construct the object
	 */
	public function __construct() { }
	
	/**
	 * Parse the URI into individual requests and return an ordered array of
	 * said requests
	 */
	public function parse_uri()
	{
		$raw_uri = explode('/', self::$raw_uri);
		$uri = null;
		
		if ( ! empty($raw_uri))
		{
			foreach ($raw_uri as $element)
			{
				if ( ! empty($element))
				{
					$uri[] = $element;
				}
			}
		}

		self::$requests = $uri;
		return $uri;
	}
	
	/**
	 * Parse the URI into individual requests and change each to Upper_Case for
	 * calling the correct controller
	 */
	public function uri_requested_controllers()
	{
		$controllers = self::parse_uri();
		for ($i = count($controllers)-1; $i > -1; $i--)
		{
			$controllers[$i] = self::controller_string($controllers[$i]);   
		}
		
		if (empty($controllers))
		{
			return null;
		}
		
		return $controllers;
	}
	
	/**
	 * Change a string controller format and replace non-alphanumeric characters
	 * with underscores
	 */
	public function controller_string($string)
	{
		$pattern = '@[^a-zA-Z0-9_]@';
		$replace = '_';
		$string = preg_replace($pattern, $replace, $string);
		$string = ucwords($string);
		return $string;
	}
}

/* End of Cogs_URI class */