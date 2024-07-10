<?php
require_once dirname(__FILE__) . '\..\config.php';

//get all patient responses
function fetchAllPatients() {
    global $conn;

    $sql = "{CALL sp_getPatients}";

    $stmt = sqlsrv_query($conn, $sql);
    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    $allPatients = [];
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $allPatients[] = $row;
    }
    sqlsrv_free_stmt($stmt);
    return $allPatients;
}

//create or add patient responses
function addPatientAndResponses($fname, $surname, $dob, $total, $responses) {
    global $conn;

    $sql = "{CALL sp_createPatientAndResponses (?, ?, ?, ?,?)}";
    $paramerter = array(
        array($fname, SQLSRV_PARAM_IN),
        array($surname, SQLSRV_PARAM_IN),
        array($dob, SQLSRV_PARAM_IN),
        array($total, SQLSRV_PARAM_IN),
        array($responses, SQLSRV_PARAM_IN)
    );

    $statementExecute = sqlsrv_query($conn, $sql, $paramerter);

    if ($statementExecute === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    sqlsrv_free_stmt($statementExecute);
}

//update patient responses
function updatePatientAndResponses($id, $fname, $surname, $dob, $total, $responses){
    global $conn;

    $responsesJson = json_encode($responses);

    $sql = "{CALL sp_updatePatientAndResponses (?, ?, ?, ?, ?, ?)}";

    $parameters = array(
        array($id, SQLSRV_PARAM_IN),
        array($fname, SQLSRV_PARAM_IN),
        array($surname, SQLSRV_PARAM_IN),
        array($dob, SQLSRV_PARAM_IN),
        array($total, SQLSRV_PARAM_IN),
        array($responsesJson, SQLSRV_PARAM_IN),
    );

    $statementExecute = sqlsrv_query($conn, $sql, $parameters);

    if ($statementExecute === false) {
        $error = print_r(sqlsrv_errors(), true);
        echo json_encode(['status' => 'error', 'message' => "Error updating patient and responses: $error"]);
        die();
    }
    
    sqlsrv_free_stmt($statementExecute);
}

//delete patient responses
function deletePatient($id) {
    global $conn;

    $sql = "{CALL sp_deletePatient (?)}";
    $params = array(
        array($id, SQLSRV_PARAM_IN)
    );

    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        $error = sqlsrv_errors();
        $response = array('status' => 'error', 'message' => 'Failed to delete form: ' . $error[0]['message']);
        echo json_encode($response);
        die();
    }

    sqlsrv_free_stmt($stmt);
}

//get patient record by id
function getPatientRecord($id){
    global $conn;
    $sqlQuery = "{CALL sp_getPatientById(?)}";
    $params = array($id);
    $stmt = sqlsrv_query($conn, $sqlQuery, $params);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    $patientDetails = array();
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $patientDetails[] = $row;
    }
    return $patientDetails;
}

//admin login authentication
function login($username, $password) {
    global $conn;

    $sql = "{CALL sp_CheckAdminLogin (?, ?)}";
    $params = array(
        array($username, SQLSRV_PARAM_IN),
        array($password, SQLSRV_PARAM_IN)
    );

    $stmt = sqlsrv_query($conn, $sql, $params);
    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    $admin = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
    if ($admin['Result'] > 0) {
        return true;
    } else {
        return false;
    }
}

function fetchQuestions() {
    global $conn;

    $sql = "{CALL sp_GetQuestions}";

    $stmt = sqlsrv_query($conn, $sql);
    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    $questions = [];
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $questions[] = $row;
    }
    sqlsrv_free_stmt($stmt);
    return $questions;
}

// count age from the date of birth
function countAge($dob){
    $currentDate = new DateTime();
    $diff = $currentDate->diff($dob);
    $age = $diff->y;
    return $age;
}

?>