<?php
require_once dirname(__FILE__) . '\.\functions.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    try {
        deletePatient($id);
        echo json_encode(['status' => 'success', 'message' => 'Record deleted successfully']);
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => 'Error, something is wrong: ' . $e->getMessage()]);
    }
    exit();
}