<?php
require 'includes/db.php';
require 'includes/auth.php';

// Redirecionamentos
if (isAdmin()) {
    header("Location: admin/convidados/");
    exit();
} elseif (isConvidado()) {
    header("Location: convidado/");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Convite Romântico</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6 text-center">
                <h1 class="mb-4">Bem-vindo ao Sistema de Convites</h1>
                
                <div class="card shadow">
                    <div class="card-body">
                        <h4 class="mb-3">Área de Testes</h4>
                        
                        <div class="d-grid gap-3">
                            <!-- Teste Convidado -->
                            <form action="convidado/index.php" method="post">
                                <input type="hidden" name="nome_completo" value="Ana Silva">
                                <button type="submit" class="btn btn-primary w-100">
                                    Entrar como Convidado
                                </button>
                            </form>
                            
                            <!-- Teste Admin -->
                            <form action="admin/convidados/index.php" method="post">
                                <input type="hidden" name="username" value="admin">
                                <button type="submit" class="btn btn-dark w-100">
                                    Entrar como Administrador
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Verificação do Banco -->
                <div class="mt-4">
                    <?php
                    try {
                        $total = $pdo->query("SELECT COUNT(*) FROM convidados")->fetchColumn();
                        echo "<div class='alert alert-success'>✅ Banco conectado! Convidados: $total</div>";
                    } catch (PDOException $e) {
                        echo "<div class='alert alert-danger'>❌ Erro no banco: " . $e->getMessage() . "</div>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>