<?php

require_once '../app/core/Router.php';
require_once '../app/models/Model.php';
require_once '../app/controllers/Controller.php';
require_once '../app/controllers/MainController.php';
require_once '../app/controllers/UserController.php';
require_once '../app/controllers/PostController.php';
require_once '../app/controllers/FeaturesController.php'; 
require_once '../app/models/User.php';
require_once '../app/models/Post.php'; 
require_once '../app/models/Budget.php'; 
require_once '../app/core/database.php';

try {
    $pdo = new PDO("mysql:host=localhost;dbname=finance_tracker", "root", "root", [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
    error_log("Database connection successful!");
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

$env = parse_ini_file('../.env');

define('DBNAME', $env['DBNAME'] ?? 'finance_tracker');
define('DBHOST', $env['DBHOST'] ?? 'localhost');
define('DBUSER', $env['DBUSER'] ?? 'root');
define('DBPASS', $env['DBPASS'] ?? 'root');
