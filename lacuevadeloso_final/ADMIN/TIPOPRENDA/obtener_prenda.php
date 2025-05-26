<?php
include 'config.php';

$result = $conexion->query("SELECT id, nombre FROM tipos_prenda ORDER BY id ASC");
$prendas = [];

while ($row = $result->fetch_assoc()) {
    $prendas[] = $row;
}

header('Content-Type: application/json');
echo json_encode($prendas);

$conexion->close();
?>
