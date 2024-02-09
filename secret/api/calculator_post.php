<?php
include('../config.php');
session_start(); // Assegure-se de iniciar a sessão para acessar $_SESSION

// Mapeamentos para próxima e última página
$nextPageMap = [
    'start' => 'quest_one',
    'quest_one' => 'quest_two',
    'quest_two' => [true => 'resignation_one', false => 'vacation_one'], // Lógica condicional
    'resignation_one' => 'resignation_result',
    'resignation_result' => 'vacation_one',
    'vacation_one' => 'sale',
    'sale' => 'vacation_result',
    'vacation_result' => 'end'
];

$lastPageMap = [
    'start' => 'start',
    'quest_one' => 'start',
    'quest_two' => 'quest_one',
    'resignation_one' => 'quest_two',
    'resignation_result' => 'resignation_one',
    'vacation_one' => 'resignation_result',
    'sale' => 'vacation_one',
    'vacation_result' => 'sale'
];

function getNextPage($currentStep, $isResignation = null)
{
    global $nextPageMap;
    if ($currentStep == 'quest_two' && $isResignation !== null) {
        return $nextPageMap[$currentStep][$isResignation];
    }
    return $nextPageMap[$currentStep] ?? null;
}

function getLastPage($currentStep)
{
    global $lastPageMap;
    return $lastPageMap[$currentStep] ?? null;
}

function executeQuery($sql, $params = [], $returnId = false)
{
    global $conexao;
    $stmt = $conexao->prepare($sql);
    if ($params) {
        $stmt->bind_param(str_repeat("s", count($params)), ...$params);
    }
    if ($stmt->execute()) {
        return $returnId ? $conexao->insert_id : true;
    }
    return false;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $step = $_POST['step'] ?? 'start';
    $isResignation = $_POST['is_resignation'] ?? null;
    $params = []; // Parâmetros para prepared statement

    switch ($step) {
        case 'start':
            $sql = "INSERT INTO calculadora (user_id) VALUES (?)";
            $params = [$_SESSION['user_id'] ?? '16'];
            break;
        case 'quest_one':
            $sql = "UPDATE calculadora SET salary = ? WHERE id = ?";
            $params = [$_POST['salary'], $_POST['id']];
            $_SESSION['salary'] = $_POST['salary'];
            break;
        case 'quest_two':
            $_POST['is_resignation'] = $_POST['is_resignation'] === 'true';
            $sql = "UPDATE calculadora SET is_resignation = ? WHERE id = ?";
            $params = [$_POST['is_resignation'], $_POST['id']];
            $_SESSION['is_resignation'] = $_POST['is_resignation'];
            break;
        case 'vacation_one':
            $sql = "UPDATE calculadora SET vacation_start_date = ?, vacation_end_date = ? WHERE id = ?";
            $params = [$_POST['vacation_start_date'], $_POST['vacation_end_date'], $_POST['id']];
            $_SESSION['vacation_start_date'] = $_POST['vacation_start_date'];
            $_SESSION['vacation_end_date'] = $_POST['vacation_end_date'];
            break;
        case 'sale':
            $_POST['is_sale_vacation'] = $_POST['is_sale_vacation'] === 'true';
            $sql = "UPDATE calculadora SET is_sale_vacation = ? WHERE id = ?";
            $params = [$_POST['is_sale_vacation'], $_POST['id']];
            $_SESSION['is_sale_vacation'] = $_POST['is_sale_vacation'];
            break;
        case 'resignation_one':
            $sql = "UPDATE calculadora SET work_start_date = ?, work_end_date = ? WHERE id = ?";
            $params = [$_POST['work_start_date'], $_POST['work_end_date'], $_POST['id']];
            $_SESSION['work_start_date'] = $_POST['work_start_date'];
            $_SESSION['work_end_date'] = $_POST['work_end_date'];
            break;
        case 'resignation_result':
        case 'vacation_result':
            $sql = "UPDATE calculadora SET result = ? WHERE id = ?";
            $params = [$_POST['result'], $_POST['id']];
            $_SESSION['result'] = $_POST['result'];
            break;
        default:
            respondJSON(['error' => 'Invalid step provided'], 400);
            exit;
    }

    try {
        $id = executeQuery($sql, $params, $step === 'start');
        if ($id !== false) {
            $next = getNextPage($step, filter_var($isResignation, FILTER_VALIDATE_BOOLEAN));
            $id = $id === true ? $_POST['id'] : $id;
            respondJSON(['step' => $next, 'id' => $id]);
        } else {
            $last = getLastPage($step);
            respondJSON(['step' => $last, 'id' => $_POST['id'], 'message' => $conexao->error], 400);
        }
    } catch (Exception $e) {
        respondJSON(['error' => $e->getMessage()], 400);
    }
}

function respondJSON($data, $status = 200)
{
    header('Content-Type: application/json');
    http_response_code($status);
    echo json_encode($data);
    exit;
}
