<?php
session_start();

// if post clear session
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION = array();
    session_destroy();
    header('Content-Type: application/json');
    http_response_code(200);
    echo json_encode(array('status' => 'success'));
} else {
    header('Content-Type: application/json');
    http_response_code(400);
    json_encode(array('status' => 'error', 'message' => 'Invalid request method'));
    echo json_encode(array('status' => 'error', 'message' => 'Invalid request method'));
}