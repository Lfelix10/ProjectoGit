<?php 
session_start();
include('../includes/auth.php'); // Verifica se é autor
include('../includes/db.php');

// Dados para gráficos
$total_visualizacoes = $pdo->query("SELECT COUNT(*) FROM logs WHERE acao = 'visualizou_convite'")->fetchColumn();
$total_confirmacoes = $pdo->query("SELECT COUNT(*) FROM convidados WHERE presenca = TRUE")->fetchColumn();
?>

<!DOCTYPE html>
<html>
<head>
  <title>Painel do Autor</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/css/adminlte.min.css">
  <!-- Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="hold-transition sidebar-mini">
  <div class="wrapper">
    <!-- Conteúdo -->
    <div class="content-wrapper">
      <section class="content">
        <div class="row">
          <div class="col-md-6">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Estatísticas</h3>
              </div>
              <div class="card-body">
                <canvas id="myChart"></canvas>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
  </div>

  <script>
    const ctx = document.getElementById('myChart').getContext('2d');
    new Chart(ctx, {
      type: 'pie',
      data: {
        labels: ['Visualizações', 'Confirmações'],
        datasets: [{
          data: [<?= $total_visualizacoes ?>, <?= $total_confirmacoes ?>],
          backgroundColor: ['#36a2eb', '#ff6384']
        }]
      }
    });
  </script>
</body>
</html>