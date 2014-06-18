<?php

require __DIR__ . '/paths.php';

if (file_exists(APP . 'vendor/autoload.php')) {
	require APP . 'vendor/autoload.php';
	spl_autoload_unregister(array('App', 'load'));
	spl_autoload_register(array('App', 'load'), true, true);
} else {
	require CAKE . 'Core/ClassLoader.php';
	$loader = new \Cake\Core\ClassLoader();
	$loader->register();
	$loader->addNamespace('Cake', CAKE);
	$loader->addNamespace('App', APP);
	$loader->addNamespace('Croogo', ROOT . '/vendor/croogo/croogo/');
}

require CAKE . 'bootstrap.php';

use Cake\Cache\Cache;
use Cake\Configure\Engine\PhpConfig;
use Cake\Console\ConsoleErrorHandler;
use Cake\Core\App;
use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Datasource\ConnectionManager;
use Cake\Error\ErrorHandler;
use Cake\Log\Log;
use Cake\Network\Email\Email;
use Cake\Network\Request;
use Cake\Routing\DispatcherFactory;
use Cake\Utility\Inflector;

try {
	Configure::config('default', new PhpConfig());
	Configure::load('croogo.php', 'default', false);
} catch (\Exception $e) {
	die('Unable to load Config/croogo.php. Create it by copying Config/croogo.default.php to Config/croogo.php.');
}

Cache::config(Configure::consume('Cache'));
Log::config(Configure::consume('Log'));

/**
 * Register application error and exception handlers.
 */
$isCli = php_sapi_name() === 'cli';
if ($isCli) {
	(new ConsoleErrorHandler(Configure::consume('Error')))->register();
} else {
	(new ErrorHandler(Configure::consume('Error')))->register();
}

// Include the CLI bootstrap overrides.
if ($isCli) {
	require __DIR__ . '/bootstrap_cli.php';
}

Plugin::load('Croogo', array(
	'namespace' => '\Croogo',
	'bootstrap' => true,
	'autoload' => true,
	'classBase' => false,
));

DispatcherFactory::add('Asset');
DispatcherFactory::add('Cache');
DispatcherFactory::add('Routing');
DispatcherFactory::add('ControllerFactory');
