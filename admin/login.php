<?php include('../includes/auth.php'); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Login - Painel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card shadow">
                    <div class="card-body">
                        <h4 class="card-title text-center">Acesso Restrito</h4>
                        <form method="POST">
                            <div class="mb-3">
                                <input type="text" name="username" class="form-control" placeholder="Usuário" required>
                            </div>
                            <div class="mb-3">
                                <input type="password" name="senha" class="form-control" placeholder="Senha" required>
                            </div>
                            <button type="submit" name="login_usuario" class="btn btn-primary w-100">Entrar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>