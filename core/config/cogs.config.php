<?php
/**
 * Debug on?
 * Turns on all PHP errors and framework information
 * Default: true
 */
define('DEBUG_MODE', true);


/**
 * What's the basepath for the application?
 */
define('BASE_PATH', getcwd());


/**
 * Where is the core stored?
 */
define('CORE_DIR', BASE_PATH . '/core');


/**
 * Where is the vault that stores:
 * Models, Controllers, Views, Plugins, Backups
 */
define('VAULT_DIR', BASE_PATH . '/vault');

define('MODELS_DIR',		VAULT_DIR . '/models');
define('CONTROLLERS_DIR',	VAULT_DIR . '/controllers');
define('VIEWS_DIR',			VAULT_DIR . '/views');
define('PLUGINS_DIR',		VAULT_DIR . '/plugins');
define('BACKUPS_DIR',		VAULT_DIR . '/backups');


/**
 * Where will uploaded files be stored?
 */
define('UPLOAD_DIR', BASE_PATH . '/assets');


/**
 * Are you using a database?
 * Default: true
 */
define('USING_DB', false);


/**
 * Database credentials and configuration
 * DB_TYPE may be mysqli, sqlite3, or mysql
 */
define('DB_TYPE',	'mysqli');
define('DB_SERVER',	'localhost');
define('DB_LOGIN',	'root');
define('DB_PASS',	'root');
define('DB_NAME',	'miguel');


/**
 * Where are the native mysql programs located?
 * This allows you to backup and restore the database
 * Default: /usr/bin
 */
define('MYSQL_PATH', '/usr/bin');


/**
 * Default controller to load if one cannot be found
 *
 * Must be a class name
 */
define('DEFAULT_CONTROLLER', 'Server_404');


/**
 * Root controller to load if ther are no URI requests
 *
 * Must be a class name
 */
define('ROOT_CONTROLLER', 'Home');


/**
 * Define master view
 */
define('MASTER_VIEW', 'Master_View');

/* End of cogs.config.php */