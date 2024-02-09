<?php
require 'utils.php';

// Remove the query string from the requested URI if present
$requestedRoute = explode('?', $_SERVER['REQUEST_URI'])[0];
$method = $_SERVER['REQUEST_METHOD'];

debug_to_console($requestedRoute);

switch ($requestedRoute) {
    case '/secret/':
        require 'pages/login.php';
        break;
    case '/secret/cadastro':
        require 'pages/cadastro.php';
        break;
    case '/secret/dashboard':
        require 'pages/dashboard.php';
        break;
    default:
        header("HTTP/1.0 404 Not Found");
        require 'pages/404.php'; // Exibe sua página 404 personalizada
        break;
}