<?php

use Firebase\JWT\JWT;

$JWTSECRET = 'a1b2c3d4e5f6g7h8i9j0';

function debug_to_console($data)
{
    if (is_array($data) || is_object($data)) {
        $data = json_encode($data);
    }
    echo "<script>console.log('Debug Objects: " . addslashes($data) . "');</script>";
}

function alert($data)
{
    // Ensure special characters are properly escaped for JavaScript
    $dataEscaped = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    echo "<script>alert('$dataEscaped');</script>";
}
function check_login($jwt)
{
    global $JWTSECRET;

    if ($jwt == null) {
        return false;
    }

    try {
        // Decodifica o JWT usando a chave secreta global
        $decoded = JWT::decode($jwt, $JWTSECRET);

        // Verifica se o token expirou
        if (isset($decoded->exp) && $decoded->exp < time()) {
            return false;
        }

        return true;
    } catch (Exception $e) {
        // Em caso de erro na decodificação (token inválido, expirado, etc.), retorna falso
        return false;
    }
}
