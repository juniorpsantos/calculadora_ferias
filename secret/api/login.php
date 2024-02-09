<?php
require_once '../vendor/autoload.php'; 
require '../utils.php';
use Firebase\JWT\JWT; // Importa a classe JWT
use Firebase\JWT\Key; // Importa a classe Key para a verificação do token
include_once('../config.php');


if (!empty($_POST) && !empty($_POST['email']) && !empty($_POST['senha'])) {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Preparar e executar a consulta
    $stmt = $conexao->prepare('SELECT * FROM usuarios WHERE email = ?');
    $stmt->bind_param('s', $email);
    if (!$stmt->execute()) {
        echo "Erro ao executar a consulta!";
        header('Location: /secret?error=database_error');
        exit;
    }

    $result = $stmt->get_result();
    $usuario = $result->fetch_assoc();

    // Verificar a senha
    if ($usuario && password_verify($senha, $usuario['senha'])) {
        // Iniciar a sessão e armazenar informações do usuário
        session_start();
        $_SESSION['user_id'] = $usuario['id'];
        $_SESSION['user_email'] = $usuario['email'];

        // Payload do token
        $payload = [
            'iss' => 'seu_issuer_aqui', // Emissor do token
            'aud' => 'seu_audience_aqui', // Audiência do token
            'iat' => time(), // Timestamp de quando o token foi emitido
            'exp' => time() + (60 * 60), // Expiração do token (1 hora a partir de agora)
            'data' => [ // Dados personalizados
                'user_id' => $usuario['id'],
                'user_email' => $usuario['email'],
            ],
        ];

        // Gerar o token
        $jwt = JWT::encode($payload, $JWTSECRET, 'HS256');

        // Armazenar o JWT na sessão ou redirecionar o usuário com o token
        $_SESSION['jwt'] = $jwt;
        $_SESSION['user_id'] = $usuario['id'];
        $_SESSION['user_name'] = $usuario['nome'];

        // Redirecionar para a página desejada
        header('Location: /secret/dashboard');
        exit;
    } else {
        // Credenciais inválidas
        echo "Credenciais inválidas!";
        header('Location: /secret?error=invalid_credentials');
        exit;
    }
} else {
    // Sem credenciais fornecidas
    echo "Credenciais não fornecidas!";
    header('Location: /secret?error=missing_credentials');
    exit;
}