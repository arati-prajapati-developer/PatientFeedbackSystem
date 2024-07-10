<?php 

require 'vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Database variable
$serverName = $_ENV['DB_SERVER'];
$dbName = $_ENV['DB_NAME'];
$username = $_ENV['DB_USERNAME'];
$password = $_ENV['DB_PASSWORD'];


$getBaseUrl = getBaseUrl();

// JavaScript and other cdn path
$jqueryPath = $getBaseUrl . '/assets/js/jquery-3.7.1.min.js';
$toastPath = $getBaseUrl . '/assets/js/toast.script.js';
$bootstrapPath = $getBaseUrl . '/assets/js/bootstrap.bundle.min.js';
$indexPath = $getBaseUrl . '/assets/js/index.js';
$datatablePath = $getBaseUrl . '/assets/js/jquery.dataTables.js';

// CSS and other cdn path
$toastCssPath = $getBaseUrl . '/assets/css/toast.style.min.css';
$bootstrapCssPath = $getBaseUrl . '/assets/css/bootstrap.min.css';
$indexCssPath = $getBaseUrl . '/assets/css/index.css';
$datatableCssPath = $getBaseUrl . '/assets/css/jquery.dataTables.css';

$conn = dbConnection();

function dbConnection(){
    global $serverName, $dbName, $username, $password;
    try {
        $connection = [
            "Database" => $dbName,
            "Uid" => $username,
            "PWD" => $password
        ];

        $conn = sqlsrv_connect($serverName,$connection);
        if(!$conn){
            die(print_r(sqlsrv_errors(),true));
        }
        return $conn;
    } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
        exit;
    }
}

function getBaseUrl() {
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    $hostName = $_SERVER['HTTP_HOST'];
    $path = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
    return $protocol . $hostName . $path;
}