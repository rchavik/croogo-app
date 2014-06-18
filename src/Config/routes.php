<?php

use Cake\Core\App;
use Cake\Core\Configure;
use Cake\Routing\Router;

use Croogo\Croogo\CroogoRouter;

Configure::write('Routing.prefixes', array('admin'));

CroogoRouter::routes();
Router::parseExtensions('json', 'rss');
CroogoRouter::localize();
require CAKE . 'Config' . DS . 'routes.php';
