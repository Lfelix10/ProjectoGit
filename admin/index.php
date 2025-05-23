<?php 
session_start();
require_once '../includes/auth.php'; // Verifica se é admin
include('../includes/db.php');

// Lista convidados
$stmt = $pdo->query("SELECT * FROM convidados");
$convidados = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
  <title>Painel Admin</title>
  <!-- AdminLTE CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini">
  <div class="wrapper">
    <!-- Navbar -->
    <?php include('../includes/header.php'); ?>

    <!-- Sidebar -->
    <?php include('includes/sidebar.php'); ?>

    <!-- Conteúdo -->
    <div class="content-wrapper">
      <section class="content">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Lista de Convidados</h3>
          </div>
          <div class="card-body">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>Nome</th>
                  <th>Confirmou Presença?</th>
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
                  </td>
                </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
      </section>
    </div>
  </div>
  <!-- AdminLTE JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/js/adminlte.min.js"></script>
</body>
</html>