<?php

require __DIR__ . '/paths.php';

if (file_exists(APP . 'Vendor/autoload.php')) {
	require APP . 'Vendor/autoload.php';
	spl_autoload_unregister(array('App', 'load'));
	spl_autoload_register(array('App', 'load'), true, true);
} else {
	require CAKE . 'Core/ClassLoader.php';
	$loader = new \Cake\Core\ClassLoader();
	$loader->register();
	$loader->addNamespace('Cake', CAKE);
	$loader->addNamespace('App', APP);
	$loader->addNamespace('Croogo', 'Vendor/croogo/croogo/');
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
use Cake\Utility\Inflector;

try {
	Configure::config('default', new PhpConfig());
	Configure::load('croogo.php', 'default', false);
} catch (\Exception $e) {
}

Configure::write('Dispatcher.filters', array(
	'AssetDispatcher',
	'CacheDispatcher'
));

/*
CakeLog::config('debug', array(
	'engine' => 'File',
	'types' => array('notice', 'info', 'debug'),
	'file' => 'debug',
));
CakeLog::config('error', array(
	'engine' => 'File',
	'types' => array('warning', 'error', 'critical', 'alert', 'emergency'),
	'file' => 'error',
));
*/

\Cake\Core\Plugin::load('Croogo', array('bootstrap' => true));
