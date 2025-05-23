<?php
$_SESSION['csrf_token'] = bin2hex(random_bytes(32));
require '../../includes/auth.php';
require '../../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome_completo']);
    $podeBaixar = isset($_POST['pode_baixar']) ? 1 : 0;

    $stmt = $pdo->prepare("INSERT INTO convidados (nome_completo, pode_baixar) VALUES (?, ?)");
    if ($stmt->execute([$nome, $podeBaixar])) {
        header("Location: index.php?sucesso=1");
        exit();
    }
}
?>

<!-- Formulário HTML -->
<form method="POST" class="container mt-5">
    <h2>Adicionar Convidado</h2>
    
    <div class="mb-3">
        <label class="form-label">Nome Completo</label>
        <input type="text" name="nome_completo" class="form-control" required>
    </div>

    <div class="mb-3 form-check">
        <input type="checkbox" name="pode_baixar" class="form-check-input" checked>
        <label class="form-check-label">Pode baixar arquivos?</label>
    </div>

    <button type="submit" class="btn btn-primary">Salvar</button>
</form>