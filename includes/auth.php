<?php
session_start();
include('db.php');

// Função para verificar login de convidado
function verificarLoginConvidado() {
    if (!isset($_SESSION['convidado_id'])) {
        header("Location: ../login.php");
        exit();
    }
}

// Função para verificar login de admin/autor
function verificarLoginUsuario() {
    if (!isset($_SESSION['usuario_id'])) {
        header("Location: ../admin/login.php");
        exit();
    }
}

// Função para verificar se é admin
function isAdmin() {
    return isset($_SESSION['tipo_usuario']) && $_SESSION['tipo_usuario'] === 'admin';
}

// Função para verificar se é autor
function isAutor() {
    return isset($_SESSION['tipo_usuario']) && $_SESSION['tipo_usuario'] === 'autor';
}

// Autenticação de usuários (admin/autor)
if (isset($_POST['login_usuario'])) {
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE username = ?");
    $stmt->execute([$_POST['username']]);
    $usuario = $stmt->fetch();

    if ($usuario && password_verify($_POST['senha'], $usuario['senha_hash'])) {
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['tipo_usuario'] = $usuario['tipo'];
        header("Location: ../admin/index.php");
    } else {
        echo "Usuário ou senha inválidos!";
    }
}
