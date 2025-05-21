<!-- Formulário após clicar no link do e-mail -->
<?php $token = $_GET['token'] ?? ''; ?>
<form method="POST" action="password_reset.php">
    <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
    <input type="password" name="nova_senha" placeholder="Nova senha (mínimo 8 caracteres)" required>
    <button type="submit" name="redefinir_senha">Salvar</button>
</form>

<?php
if (strlen($_POST['nova_senha']) < 8) {
    die("A senha deve ter pelo menos 8 caracteres!");
}
?>