<?php
include('includes/db.php');
$stmt = $pdo->query("SELECT nome_completo FROM convidados");
echo "<h3>Convidados cadastrados:</h3>";
foreach ($stmt->fetchAll() as $row) {
    echo "<p>" . htmlspecialchars($row['nome_completo']) . "</p>";
}
