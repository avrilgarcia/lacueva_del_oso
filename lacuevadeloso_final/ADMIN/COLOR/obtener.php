<?php
include 'config.php';

$result = $conexion->query("SELECT id, nombre FROM colores ORDER BY id ASC");
$colores = [];

while ($row = $result->fetch_assoc()) {
    $colores[] = $row;
}

header('Content-Type: application/json');
echo json_encode($colores);

$conexion->close();
?>
