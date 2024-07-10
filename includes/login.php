<?php
require_once dirname(__FILE__) . '\.\functions.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    try {
        $response = login($email, $password);
        if($response == 1){
            $_SESSION['admin_logged_in'] = true;
            echo json_encode(['status' => 'success', 'message' => 'Login successfully.']);
        }else{
            echo json_encode(['status' => 'error', 'message' => 'Please enter a correct email and password']);
        }
        
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => 'Error, something is wrong: ' . $e->getMessage()]);
    }
    exit();
}

