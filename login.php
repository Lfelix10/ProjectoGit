<?php
require 'includes/auth.php';

// Login para convidados
if (isset($_POST['login_convidado'])) {
    $stmt = $pdo->prepare("SELECT id FROM convidados WHERE nome_completo = ?");
    $stmt->execute([$_POST['nome_completo']]);
    if ($stmt->rowCount() > 0) {
        $_SESSION['convidado_id'] = $stmt->fetch()['id'];
        header("Location: /convidado");
    }
}

// Login para admin/autor
if (isset($_POST['login_admin'])) {
    $stmt = $pdo->prepare("SELECT id, tipo FROM usuarios WHERE username = ? AND senha_hash = ?");
    $stmt->execute([$_POST['username'], password_verify($_POST['senha'], $senha_hash)]);
    if ($stmt->rowCount() > 0) {
        $usuario = $stmt->fetch();
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['tipo_usuario'] = $usuario['tipo'];
        header("Location: /admin");
    }
}
?>

<!-- Formulário de Login (switch entre convidado/admin) -->
<h2>Acesso Convidado</h2>
<form method="POST">
    <input type="text" name="nome_completo" placeholder="Nome completo" required>
    <button type="submit" name="login_convidado">Entrar</button>
</form>

<h2>Acesso Admin/Autor</h2>
<form method="POST">
    <input type="text" name="username" placeholder="Usuário" required>
    <input type="password" name="senha" placeholder="Senha" required>
    <button type="submit" name="login_admin">Entrar</button>
</form>