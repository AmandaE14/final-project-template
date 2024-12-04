<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

define('BASE_PATH', realpath(dirname(__FILE__) . '/..'));

require BASE_PATH . '/app/core/setup.php';

use app\core\Router;

$router = new Router('/final-project-template/public/');