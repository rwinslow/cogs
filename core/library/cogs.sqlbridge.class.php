<?php
// -----------------------------------------------------------------------------
// SQL Database Bridge
// Written by Rich Winslow
// rich@richwinslow.com
// -----------------------------------------------------------------------------

class SQL_Bridge
{

	var $link;		// Variable as connection
	var $server;	// Server name or location
	var $database;	// Database name
	var $login;		// Database login
	var $pass;		// Database password
	var $db_type;	// Database type (e.g. mysql, mysqli, sqlite3)
	
	public function __construct($server,
								$login,
								$pass,
								$database,
								$db_type = 'mysqli')
	{
		$this->server = $server;
		$this->database = $database;
		$this->login = $login;
		$this->pass = $pass;
		$this->db_type = $db_type;
		
		// Construct link object based on type and connect to database
		switch ($this->db_type)
		{
			case 'sqlite3':
				$this->link = new SQLite3($this->server);
				break;
				
			case 'mysqli':
				$this->link = new mysqli($this->server,
										 $this->login,
										 $this->pass,
										 $this->database)
							  or die('Problem: ' . mysqli_error());
				break;

			default:
				$this->link = mysql_connect($this->server,
											$this->login,
											$this->pass);
				
				if (!$this->link)
				{
					die('Could not connect: ' . mysql_error());
				}
				
				$this->dblink = mysql_select_db($this->database)
								or die('No database: ' . mysql_error());
				break;
		}

		return true;
	}
	
	private function surround($array, $wall, $separator)
	{
		return $wall . implode($wall . $separator . $wall, $array) . $wall;
	}
	
	/**
	 * Retrieve all object properties and their values in separate, symmetric
	 * arrays
	 *
	 * Values that are arrays are serialized
	 */
	private function get_field_values($object, $table = null, $schema = null)
	{
		$fields = array();
		$values = array();
		
		foreach (get_object_vars($object) as $var => $value)
		{
			// Make sure to skip database handle
			if ($var != 'db')
			{
				// Ensure mapping of variable names to corresponding field
				if (isset($schema[$var]))
				{
					$fields[] = $schema[$var];
				} 
				else
				{
					$fields[] = $var;
				}
				
				// Maintain coupling of information if a variable is empty
				if (!empty($value))
				{
					if (is_array($value))
					{
						$value = serialize($value);
					}
				
					$values[] = '\'' . self::escape_string($value) . '\'';
				}
				else
				{
					$values[] = '\'\'';
				}
			}
		}
		
		return array('fields' => $fields, 'values' => $values);	
	}
	
	private function get_table($object, $table=null)
	{
		if (empty($table))
		{
			$table = get_class($object);
		}
		
		return $table;
	}
	
	private function join_arrays_to_string($left,
										   $right,
										   $separator=null,
										   $join=null)
	{
		$string = array();
		
		// Default equals as separator
		if (empty($separator))
		{
			$separator = '=';
		}
		
		// Default comma as join
		if (empty($join))
		{
			$join = ',';
		}
		
		if (count($left) != count($right))
		{
			echo 'Error: Left(' . count($left) . ') and right(' . count($right)
				 . ') array lengths do not match!';
			
			return false;
		}
		else
		{
			for ($i=0; $i<count($left); $i++)
			{
				$string[] = $left[$i] . $separator . $right[$i];
			}
			
			$string = implode($join, $string);
		}
		
		return $string;
	}
	
	public function close()
	{
		if ($this->link)
		{
			switch ($this->db_type)
			{
				case 'sqlite3':
					$this->link->close();
					break;

				case 'mysqli':
					$this->link->close();
					break;

				default:
					mysql_close($this->link);
					break;
			}
			return true;
		}
		return false;
	}
	
	public function run_query($query)
	{
		switch ($this->db_type)
		{
			case 'sqlite3':
				$run = $this->link->query($query);
				break;
				
			case 'mysqli':
				$run = $this->link->query($query) or die(mysqli_error($this->link));
				break;
				
			default:
				$run = mysql_query($query) or die(mysql_error());
				break;
		}
		
		return $run;
	}
	
	public function num_rows($table)
	{
		$results = $this->get_rows('SELECT COUNT(*) FROM ' . $table);
		return array_shift($results);
	}
	
	public function show_tables()
	{
		// Retrieves all contents from query and places them in $array
		$results = $this->get_rows('SHOW TABLES');
		foreach ($results as $row)
		{
			$array[] = $row[0];
		}

		return $array;
	}
	
	public function get_rows($query)
	{
		$info = array();
		$results = $this->run_query($query);
		switch ($this->db_type)
		{
			case 'sqlite3':
				while ($row = $results->fetchArray(SQLITE3_NUM))
				{
					$info[] = $row;
				}
				break;
			
			case 'mysqli':
				while ($row = $results->fetch_row())
				{
					$info[] = $row;
				}
				break;
			
			default:
				while ($result = mysql_fetch_row($query))
				{
					$info[] = $result;
				}
		}
		
		// Unserialize information
		foreach ($info as $key => $row)
		{
			foreach ($row as $field => $value)
			{
				if (@unserialize($value))
				{
					$info[$key][$field] = unserialize($value);
				}
			}
		}
		
		return $info;
	}
	
	public function get_associative($query)
	{
		$info = array();
		$results = $this->run_query($query);
		switch ($this->db_type)
		{
			case 'sqlite3':
				while ($row = $results->fetchArray(SQLITE3_ASSOC))
				{
					$info[] = $row;
				}
				break;
			
			case 'mysqli':
				while ($row = $results->fetch_assoc())
				{
					$info[] = $row;
				}
				break;
			
			default:
				while ($result = mysql_fetch_assoc($query))
				{
					$info[] = $result;
				}
		}

		// Unserialize information
		foreach ($info as $key => $row)
		{
			foreach ($row as $field => $value)
			{
				if (@unserialize($value))
				{
					$info[$key][$field] = unserialize($value);
				}
			}
		}
		
		return $info;
	}
	
	public function escape_string($query)
	{
		switch ($this->db_type)
		{
			case 'sqlite3':
				return $this->link->escapeString($query);
				break;
				
			case 'mysqli':
				return $this->link->real_escape_string($query);
				break;
				
			default:
				return $this->link->mysql_real_escape_string($query);
				break;
		}
	}
	
	public function insert($object, $table = null, $schema = null)
	{
		// Get table from object class if not given
		$table = $this->get_table($object, $table);
		
		// Get all object fields and values and separate into variables
		$vars = $this->get_field_values($object, $table, $schema);
		$fields = $vars['fields'];
		$values = $vars['values'];
		
		$query = 'INSERT INTO ' . $table
				 . ' (' . implode(', ', $fields) . ') '
				 . 'VALUES (' . implode(', ', $values) . ')';
		
		if ($this->run_query($query))
		{
			return true;
		}
		
		return false;
	}
	
	public function update($object, $keys, $table = null, $schema = null)
	{
		// Get table from object class if not given
		$table = $this->get_table($object, $table);
		
		// Get all object fields and values and separate into variables
		$vars = $this->get_field_values($object, $table, $schema);
		$fields = $vars['fields'];
		$values = $vars['values'];

		foreach ($keys as $key => $value)
		{
			if (!empty($schema))
			{
				$key = $schema[$key];
			}
			
			$where[] = $key . '=' . '\'' . $value . '\'';
		}
		
		$where = implode(' AND ', $where);
		
		$query = 'UPDATE ' . $table
				 . ' SET ' .
				 $this->join_arrays_to_string($fields, $values, '=', ', ')
				 . ' WHERE ' . $where;
		
		if ($this->run_query($query))
		{
			return true;
		}
		
		return false;
	}
	
	public function delete($object, $keys, $table = null, $schema = null)
	{
		// Get table from object class if not given
		$table = $this->get_table($object, $table);
		
		foreach ($keys as $key => $value)
		{
			if (!empty($schema))
			{
				$key = $schema[$key];
			}
			
			$where[] = $key . '=' . '\'' . $value . '\'';
		}
		
		$where = implode(' AND ', $where);
		
		$query = 'DELETE FROM ' . $table
				 . ' WHERE ' . $where;
		
		if ($this->run_query($query))
		{
			return true;
		}
		
		return false;
	}
	
}

/* End SQL_Bridge class */