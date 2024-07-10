<?php
require_once dirname(__FILE__) . '\.\functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id = $_POST['id'];
    $fname = $_POST['fname'];
    $sname = $_POST['sname'];
    $dob = $_POST['dob'];
    $total = $_POST['totalScore'];

    $responseArray = [];
    foreach ($_POST['que'] as $question_id => $response) {
        $responseArray[] = [
            'response_id' => $question_id,
            'response' => $response
        ];
    }
    try {
        updatePatientAndResponses($id, $fname, $sname, $dob, $total, $responseArray);
        echo json_encode(['status' => 'success', 'message' => 'Patient updated successfully']);
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => 'Error adding patient and responses: ' . $e->getMessage()]);
    }
    exit();
}