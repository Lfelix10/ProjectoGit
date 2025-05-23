<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verifica se é convidado
function isConvidado() {
    return isset($_SESSION['convidado_id']);
}

// Verifica se é admin
function isAdmin() {
    return isset($_SESSION['usuario_id']) && $_SESSION['tipo_usuario'] === 'admin';
}

// Redireciona não-autenticados
function verificarAutenticacao() {
    if (!isConvidado() && !isAdmin()) {
        header("Location: login.php");
        exit();
    }
}
?>