<?php
require_once dirname(__FILE__) . '\.\functions.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $fname = $_POST['fname'];
    $sname = $_POST['sname'];
    $dob = $_POST['dob'];
    $total = $_POST['totalScore'];

    $responseArray = [];
    foreach ($_POST['que'] as $question_id => $response) {
        $responseArray[] = [
            'question_id' => $question_id,
            'response' => $response
        ];
    }

    $responses = json_encode($responseArray);

    try {
        addPatientAndResponses($fname, $sname, $dob, $total, $responses);
        echo json_encode(['status' => 'success', 'message' => 'Patient and responses added successfully']);
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => 'Error adding patient and responses: ' . $e->getMessage()]);
    }

    exit();
}