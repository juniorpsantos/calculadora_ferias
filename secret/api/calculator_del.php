<?php
include('../config.php');
session_start(); // Garante que a sessão esteja iniciada para acessar $_SESSION, se necessário

function executeDeleteQuery($id) {
    global $conexao;
    $sql = "DELETE FROM calculadora WHERE id = ?";
    $stmt = $conexao->prepare($sql);
    if (!$stmt) {
        return ['success' => false, 'error' => $conexao->error];
    }
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        return ['success' => true];
    } else {
        return ['success' => false, 'error' => $stmt->error];
    }
}

function respondJSON($data) {
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}

// Certifique-se de que o método de requisição seja POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $id = $_POST['id'];
    if (!$id) {
        respondJSON(['success' => false, 'error' => 'ID is required']);
    }

    // Executa a query de delete
    $result = executeDeleteQuery($id);

    // Responde com o resultado
    if ($result['success']) {
        respondJSON(['success' => true, 'message' => 'Item deleted successfully']);
    } else {
        respondJSON(['success' => false, 'error' => $result['error']]);
    }
} else {
    respondJSON(['success' => false, 'error' => 'Invalid request method']);
}
