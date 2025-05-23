<?php
$_SESSION['csrf_token'] = bin2hex(random_bytes(32));
define('ADMIN_ROOT', dirname(__DIR__));
require ADMIN_ROOT . '/templates/header.php';
require __DIR__ . '/../../bootstrap.php';  // Carrega primeiro as configurações
require INCLUDES_PATH . '/auth.php';
require INCLUDES_PATH . '/db.php';

// Busca todos os convidados
$stmt = $pdo->query("SELECT * FROM convidados ORDER BY nome_completo");
$convidados = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Gerenciar Convidados</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php require __DIR__ . '/../templates/header.php'; ?>

    <div class="container mt-5">
        <h2>Lista de Convidados</h2>
        <a href="adicionar.php" class="btn btn-success mb-3">+ Adicionar</a>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Confirmou?</th>
                    <th>Pode Baixar?</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($convidados as $c): ?>
                <tr>
                    <td><?= htmlspecialchars($c['nome_completo']) ?></td>
                    <td><?= $c['presenca'] ? '✅ Sim' : '❌ Não' ?></td>
                    <td><?= $c['pode_baixar'] ? '✅ Sim' : '❌ Não' ?></td>
                    <td>
                        <a href="editar.php?id=<?= $c['id'] ?>" class="btn btn-sm btn-primary">Editar</a>
                        <a href="excluir.php?id=<?= $c['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza?')">Excluir</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <?php require __DIR__ . '/../templates/footer.php'; ?>
</body>
</html>

<?php ADMIN_ROOT . '/templates/footer.php';?>