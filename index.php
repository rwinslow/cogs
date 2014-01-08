<?php
/**
 * Load configuration file
 */
include './core/config/cogs.config.php';

/**
 * Turn on all errors if debugging
 */
if (DEBUG_MODE === true) error_reporting(0);

/**
 * Load dependencies
 */
include CORE_DIR . '/library/cogs.debug.php';
include CORE_DIR . '/library/cogs.common.php';
include CORE_DIR . '/library/cogs.sqlbridge.class.php';
include CORE_DIR . '/library/cogs.cogs.class.php';
include CORE_DIR . '/library/cogs.uri.class.php';
include CORE_DIR . '/library/cogs.router.class.php';
include CORE_DIR . '/library/cogs.model.class.php';
include CORE_DIR . '/library/cogs.controller.class.php';

if (DEBUG_MODE) debug_vars('Loaded dependencies');

/**
 * Initialize database handle and give it to the global Cogs object
 */
if (USING_DB)
{
	$_db = new SQL_Bridge(DB_SERVER, DB_LOGIN, DB_PASS, DB_NAME, DB_TYPE);
	Cogs::init_db($_db);
	if (DEBUG_MODE) debug_vars('Initialized database successfully');
}

/**
 * Load plugin and user models
 */
include_directory(PLUGINS_DIR, 'model');
include_directory(MODELS_DIR, 'model');
if (DEBUG_MODE) debug_vars('Loaded all models');

/**
 * Load plugin and user controllers
 */
include_directory(PLUGINS_DIR, 'controller');
include_directory(CONTROLLERS_DIR, 'controller');
if (DEBUG_MODE) debug_vars('Loaded all controllers');

/**
 * Load the rest of the from the plugins
 */
include_directory(PLUGINS_DIR);
if (DEBUG_MODE) debug_vars('Loaded other plugin files');

/**
 * Define master template for views to be injected into
 */
Cogs::master(MASTER_VIEW);
if (DEBUG_MODE) debug_vars('Defined master template');
if (DEBUG_MODE) debug_vars('Master: ' . Cogs::$master);

/**
 * Determine correct controller to access based on URI requests
 */
if ( ! empty($_GET['uri']))
{
	Cogs_URI::$raw_uri = $_GET['uri'];
	if (DEBUG_MODE) debug_vars(Cogs_URI::$raw_uri);
}
$controller = Cogs_Router::find_controller();
if (DEBUG_MODE) debug_vars('Successfully set controller from URI');
if (DEBUG_MODE) debug_vars($controller);

/**
 * Run the controller's index method if it exists
 */
if (method_exists($controller, 'index'))
{
    $controller->index();
    if (DEBUG_MODE) debug_vars('Successfully ran controller');
}

/**
 * Close database connection
 */
if (USING_DB)
{
	$_db->close();
}

/* End index.php */