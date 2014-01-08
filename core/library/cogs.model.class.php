<?php
class Cogs_Model
{
	/**
	 * Database handler reference
	 */
	protected static $db;

	/**
	 * Construct the object
	 */
	function __construct() {}
	
	/**
	 * Provide method to change models database reference to a new database
	 */
	function set_db(&$db)
	{	
		$this->db = $db;   
	}

}

/* End Cogs_Model class */