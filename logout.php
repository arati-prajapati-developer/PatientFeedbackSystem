<?php
require dirname(__FILE__) . '\.\config.php';
session_start();
session_destroy();
$loginPath = getBaseUrl() . '/login.php';
header("Location: $loginPath");
exit();
?>
