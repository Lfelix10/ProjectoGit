// admin/convidados.php

<?php
$stmt = $pdo->query("SELECT nome_completo, presenca FROM convidados");
while ($row = $stmt->fetch()) {
    echo "<tr><td>{$row['nome_completo']}</td><td>".($row['presenca'] ? '✅' : '❌')."</td></tr>";
}