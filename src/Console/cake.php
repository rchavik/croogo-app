#!/usr/bin/php -q
<?php
/**
 * Command-line code generation utility to automate programmer chores.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2011, Cake Software Foundation, Inc.
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Console
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

include dirname(__DIR__) . '/Config/bootstrap.php';

$ds = DIRECTORY_SEPARATOR;
$appDir = dirname(dirname(__FILE__));
$vendorDir = $appDir . $ds . 'vendor' . $ds;
$root = dirname($appDir);

if (in_array('test', $argv) && in_array('croogo', $argv) && !defined('TESTS')) {
	$key = array_keys($argv, 'croogo');
	$argv[current($key)] = 'app';
	define('TESTS', $vendorDir . 'croogo' . $ds . 'croogo' . $ds . 'Test' . $ds);
}

exit(Cake\Console\ShellDispatcher::run($argv));
