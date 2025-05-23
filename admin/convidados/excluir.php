<?php
$_SESSION['csrf_token'] = bin2hex(random_bytes(32));
require '../includes/auth.php';
require '../includes/db.php';

$id = $_GET['id'] ?? null;
if ($id) {
    $pdo->prepare("DELETE FROM convidados WHERE id = ?")->execute([$id]);
    // Opcional: Registrar ação nos logs
    $pdo->prepare("INSERT INTO logs (usuario_id, acao) VALUES (?, 'removeu_convidado')")
        ->execute([$_SESSION['usuario_id']]);
}

header("Location: ../convidados/index.php");