<?php
// Bootstrap the framework DO NOT edit this
require COREPATH.'bootstrap.php';

\Autoloader::add_classes(array(
	// Add classes you want to override here
	// Example: 'View' => APPPATH.'classes/view.php',
	'Auth_Login_OrmAuth' => APPPATH.'classes/auth/login/ormauth.php',
));

// Register the autoloader
\Autoloader::register();

/**
 * Your environment.  Can be set to any of the following:
 *
 * Fuel::DEVELOPMENT
 * Fuel::TEST
 * Fuel::STAGING
 * Fuel::PRODUCTION
 */
\Fuel::$env = \Arr::get($_SERVER, 'FUEL_ENV', \Arr::get($_ENV, 'FUEL_ENV', \Fuel::DEVELOPMENT));

// Initialize the framework with the config file.
\Fuel::init('config.php');

// Execute bootstrap for each auto loaded module.
foreach(Module::loaded() as $module => $path) {
	if(File::exists($path. "bootstrap.php")){
		include_once($path. "bootstrap.php");
	}
}

\Model_Notification::scrub();

// Set time-zone
date_default_timezone_set('Europe/Amsterdam');

